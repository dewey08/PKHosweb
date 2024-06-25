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
use App\Models\D_fdh; 
use App\Models\D_apiwalkin_ins;  
use App\Models\D_apiwalkin_adp;
use App\Models\D_apiwalkin_aer;
use App\Models\D_apiwalkin_orf;
use App\Models\D_apiwalkin_odx;
use App\Models\D_apiwalkin_cht;
use App\Models\D_apiwalkin_cha;
use App\Models\D_apiwalkin_oop;
use App\Models\D_claim; 
use App\Models\D_apiwalkin_dru;
use App\Models\D_apiwalkin_idx;
use App\Models\D_apiwalkin_iop;
use App\Models\D_apiwalkin_ipd;
use App\Models\D_apiwalkin_pat;
use App\Models\D_apiwalkin_opd;
use App\Models\D_walkin;
use App\Models\D_walkin_drug;
use App\Models\D_apiwalkin_irf;
use App\Models\D_walkin_report;

use App\Models\Fdh_ins;
use App\Models\Fdh_pat;
use App\Models\Fdh_opd;
use App\Models\Fdh_orf;
use App\Models\Fdh_odx;
use App\Models\Fdh_cht;
use App\Models\Fdh_cha;
use App\Models\Fdh_oop; 
use App\Models\Fdh_adp;
use App\Models\Fdh_dru;
use App\Models\Fdh_idx;
use App\Models\Fdh_iop;
use App\Models\Fdh_ipd;
use App\Models\Fdh_aer;
use App\Models\Fdh_irf;
use App\Models\Fdh_lvd;
use App\Models\D_ofc_401;
use App\Models\D_dru_out;
use App\Models\D_ofc_repexcel;
use App\Models\Fdh_sesion;
use App\Models\D_ucep24_main;
use App\Models\D_ucep24;

use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr;   
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;

use Mail;
use Illuminate\Support\Facades\Storage;
  
 
date_default_timezone_set("Asia/Bangkok");

class Fdh_Ucep24Controller extends Controller
{  
    public function ucep24_main(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate == '') {              
        } else {
                $iduser = Auth::user()->id; 
                // D_ucep24_main::truncate();
                Fdh_sesion::where('d_anaconda_id','=','UCEP24')->delete(); 
                D_ucep24::truncate();
                $data_main_ = DB::connection('mysql2')->select('   
                        SELECT i.vn,o.an,o.hn,pt.cid,i.pttype,CONCAT(pt.pname,pt.fname," ",pt.lname) ptname,o.vstdate,i.dchdate,p.hipdata_code,o.qty,o.sum_price,i1.icd10 as DIAG
                        ,aa.paid_money,aa.income-aa.rcpt_money-aa.discount_money as debit
                        FROM ipt i
                        LEFT JOIN an_stat aa on aa.an = i.an 
                        LEFT JOIN opitemrece o on i.an = o.an 
                        LEFT JOIN ovst a on a.an = o.an
                        left JOIN er_regist e on e.vn = i.vn
                        LEFT JOIN ipt_pttype ii on ii.an = i.an
                        LEFT JOIN pttype p on p.pttype = ii.pttype 
                        LEFT JOIN s_drugitems n on n.icode = o.icode
                        LEFT JOIN patient pt on pt.hn = i.hn 
                        LEFT OUTER JOIN iptdiag i1 on i1.an= i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and o.an is not null
                        and o.paidst ="02"
                        and p.hipdata_code ="ucs" 
                        and e.er_emergency_level_id in("1","2")  
                         AND o.qty <> 0                     
                        group BY i.an
                        ORDER BY i.an;
                ');  
                // AND i1.icd10 <> ""               
                foreach ($data_main_ as $key => $value2) { 
                    $check_wa = D_fdh::where('an',$value2->an)->where('projectcode','UCEP24')->count(); 
                    if ($check_wa > 0) { 
                        D_fdh::where('an',$value2->an)->where('projectcode','UCEP24')->update([  
                            'icd10'          => $value2->DIAG, 
                            'debit'          => $value2->debit,  
                            'paid_money'     => $value2->paid_money,
                            // 'cc'             => $value2->cc
                        ]);
                    } else { 
                        D_fdh::insert([
                            'vn'           => $value2->vn,
                            'hn'           => $value2->hn,
                            'an'           => $value2->an, 
                            'cid'          => $value2->cid,
                            'pttype'       => $value2->pttype,                           
                            'ptname'       => $value2->ptname,
                            'vstdate'      => $value2->vstdate, 
                            'dchdate'      => $value2->dchdate, 
                            'paid_money'   => $value2->paid_money,
                            'projectcode'  => 'UCEP24', 
                            'icd10'        => $value2->DIAG, 
                            'debit'        => $value2->debit
                        ]);
                    }       
 
                }   
                $data_date_one = DB::connection('mysql')->select('SELECT vn,an,hn,vstdate,dchdate FROM d_fdh WHERE vstdate IS NOT NULL GROUP BY an'); 
                foreach ($data_date_one as $key => $v_opitem_one) {
                    $opitem = DB::connection('mysql2')->select('
                        SELECT i.vn,o.an,o.hn,pp.cid,concat(pp.pname,pp.fname," ",pp.lname) ptname,o.rxdate,o.rxtime,i.dchdate,s.icode,s.name as namelist,s.strength,s.units ,o.qty,o.unitprice,o.sum_price,o.paidst,pt.pttype,pt.hipdata_code   
                            FROM opitemrece o  
                            LEFT OUTER JOIN ipt i on i.an = o.an 
                            LEFT OUTER JOIN patient pp on pp.hn = o.hn
                            LEFT OUTER JOIN s_drugitems s on s.icode = o.icode  
                            LEFT OUTER JOIN paidst p on p.paidst = o.paidst  
                            LEFT OUTER JOIN pttype pt on pt.pttype = o.pttype  
                            WHERE o.an = "'.$v_opitem_one->an.'" 
                            AND o.rxdate = "'.$v_opitem_one->vstdate.'" 
                            ORDER BY o.rxdate,o.rxtime
                    ');
                    foreach ($opitem as $key => $v_item) {                     
                        D_ucep24::insert([
                            'vn'                => $v_item->vn,
                            'hn'                => $v_item->hn,
                            'an'                => $v_item->an, 
                            'cid'               => $v_item->cid,
                            'ptname'            => $v_item->ptname,
                            'pttype'            => $v_item->pttype,
                            'hipdata_code'      => $v_item->hipdata_code,
                            'vstdate'           => $v_item->rxdate,
                            'rxdate'            => $v_item->rxdate,
                            'dchdate'           => $v_item->dchdate, 
                            'icode'             => $v_item->icode, 
                            'name'              => $v_item->namelist,
                            'qty'               => $v_item->qty,
                            'unitprice'         => $v_item->unitprice,
                            'sum_price'         => $v_item->sum_price, 
                            'user_id'           => Auth::user()->id 
                        ]);
                    } 
                }
                
                // $data_authen_    = DB::connection('mysql')->select('SELECT hncode,cid,vstdate,claimcode FROM check_authen WHERE vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" '); 
                // foreach ($data_authen_ as $key => $v_up) {
                //     D_fdh::where('cid',$v_up->cid)->where('vstdate',$v_up->vstdate)->update([ 
                //         'authen'   => $v_up->claimcode,  
                //     ]);
                // } 
                $s_date_now = date("Y-m-d");
                $s_time_now = date("H:i:s");

                #ตัดขีด, ตัด : ออก
                $pattern_date = '/-/i';
                $s_date_now_preg = preg_replace($pattern_date, '', $s_date_now);
                $pattern_time = '/:/i';
                $s_time_now_preg = preg_replace($pattern_time, '', $s_time_now);
                #ตัดขีด, ตัด : ออก
                $folder_name='UCEP24_'.$s_date_now_preg.'_'.$s_time_now_preg;
                 

                Fdh_sesion::insert([
                    'folder_name'      => $folder_name,
                    'd_anaconda_id'    => 'UCEP24',
                    'date_save'        => $s_date_now,
                    'time_save'        => $s_time_now,
                    'userid'           => $iduser  
                ]);
        }              
        
            // $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE active ="N" AND projectcode ="UCEP24" AND icd10 IS NOT NULL ORDER BY vn ASC');
            $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE active ="N" AND projectcode ="UCEP24" ORDER BY an ASC');
            $data['d_ucep24_main'] = DB::connection('mysql')->select('SELECT * from d_ucep24_main WHERE active ="N" ORDER BY vn ASC');  
            $data['data_opd'] = DB::connection('mysql')->select('SELECT * from fdh_opd WHERE d_anaconda_id ="UCEP24"'); 
            $data['data_orf'] = DB::connection('mysql')->select('SELECT * from fdh_orf WHERE d_anaconda_id ="UCEP24"'); 
            $data['data_oop'] = DB::connection('mysql')->select('SELECT * from fdh_oop WHERE d_anaconda_id ="UCEP24"');
            $data['data_odx'] = DB::connection('mysql')->select('SELECT * from fdh_odx WHERE d_anaconda_id ="UCEP24"');
            $data['data_idx'] = DB::connection('mysql')->select('SELECT * from fdh_idx WHERE d_anaconda_id ="UCEP24"');
            $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from fdh_ipd WHERE d_anaconda_id ="UCEP24"');
            $data['data_irf'] = DB::connection('mysql')->select('SELECT * from fdh_irf WHERE d_anaconda_id ="UCEP24"');
            $data['data_aer'] = DB::connection('mysql')->select('SELECT * from fdh_aer WHERE d_anaconda_id ="UCEP24"');
            $data['data_iop'] = DB::connection('mysql')->select('SELECT * from fdh_iop WHERE d_anaconda_id ="UCEP24"');
            $data['data_adp'] = DB::connection('mysql')->select('SELECT * from fdh_adp WHERE d_anaconda_id ="UCEP24"');
            $data['data_pat'] = DB::connection('mysql')->select('SELECT * from fdh_pat WHERE d_anaconda_id ="UCEP24"');
            $data['data_cht'] = DB::connection('mysql')->select('SELECT * from fdh_cht WHERE d_anaconda_id ="UCEP24"');
            $data['data_cha'] = DB::connection('mysql')->select('SELECT * from fdh_cha WHERE d_anaconda_id ="UCEP24"');
            $data['data_ins'] = DB::connection('mysql')->select('SELECT * from fdh_ins WHERE d_anaconda_id ="UCEP24"');
            $data['data_dru'] = DB::connection('mysql')->select('SELECT * from fdh_dru WHERE d_anaconda_id ="UCEP24"');
           
        return view('ucs.ucep24_main',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }    
    public function ucep24_main_process(Request $request)
    {  
        Fdh_ins::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_pat::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_opd::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_orf::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_odx::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_oop::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_ipd::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_irf::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_idx::where('d_anaconda_id','=','UCEP24')->delete(); 
        Fdh_iop::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_cht::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_cha::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_aer::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_adp::where('d_anaconda_id','=','UCEP24')->delete();
        Fdh_dru::where('d_anaconda_id','=','UCEP24')->delete();            
        Fdh_lvd::where('d_anaconda_id','=','UCEP24')->delete();           
        
        $id = $request->ids;
        $iduser = Auth::user()->id;
        // $data_vn_1 = D_ucep24_main::whereIn('d_ucep24_main_id',explode(",",$id))->get();
        $data_vn_1 = D_fdh::whereIn('d_fdh_id',explode(",",$id))->get(); 
         foreach ($data_vn_1 as $key => $va1) {
                
                //D_ins OK
                $data_ins_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN
                    ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE,v.cid CID,v.hcode AS HCODE
                    ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date), "%Y%m%d") DATEIN
                    ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date), "%Y%m%d") DATEEXP
                    ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB,"" GOVCODE ,"" GOVNAME
                    ,ifnull(if(i.an is null,r.sss_approval_code,ap.claim_code),ca.claimcode) PERMITNO
                    ,"" DOCNO ,"" OWNRPID,"" OWNNAME ,i.an AN ,v.vn SEQ ,"" SUBINSCL,"" RELINSCL
                    ,"" HTYPE
                    FROM vn_stat v
                    LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                    LEFT OUTER JOIN ipt i on i.vn = v.vn 
                    LEFT OUTER JOIN pttype pp on pp.pttype = i.pttype
                    LEFT OUTER JOIN ipt_pttype ap on ap.an = i.an
                    LEFT OUTER JOIN visit_pttype vp on vp.vn = v.vn
                    LEFT OUTER JOIN rcpt_debt r on r.vn = v.vn
                    LEFT OUTER JOIN patient px on px.hn = v.hn     
                    LEFT OUTER JOIN check_authen_hos ca on ca.vn = v.vn               
                    WHERE v.vn IN("'.$va1->vn.'")  
                    GROUP BY v.vn 
                ');
                // ,"2" HTYPE
                foreach ($data_ins_ as $va_01) {
                    Fdh_ins::insert([
                        'HN'                => $va_01->HN,
                        'INSCL'             => $va_01->INSCL,
                        'SUBTYPE'           => $va_01->SUBTYPE,
                        'CID'               => $va_01->CID, 
                        'HCODE'             => $va_01->HCODE,   
                        'DATEEXP'           => $va_01->DATEEXP,
                        'HOSPMAIN'          => $va_01->HOSPMAIN, 
                        'HOSPSUB'           => $va_01->HOSPSUB,
                        'GOVCODE'           => $va_01->GOVCODE,
                        'GOVNAME'           => $va_01->GOVNAME,
                        'PERMITNO'          => $va_01->PERMITNO,
                        'DOCNO'             => $va_01->DOCNO,
                        'OWNRPID'           => $va_01->OWNRPID,
                        'OWNNAME'           => $va_01->OWNNAME,
                        'AN'                => $va_01->AN,
                        'SEQ'               => $va_01->SEQ,
                        'SUBINSCL'          => $va_01->SUBINSCL,
                        'RELINSCL'          => $va_01->RELINSCL,
                        'HTYPE'             => $va_01->HTYPE,

                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                //D_pat OK
                $data_pat_ = DB::connection('mysql2')->select(
                    'SELECT v.hcode HCODE,v.hn HN
                    ,pt.chwpart CHANGWAT,pt.amppart AMPHUR,DATE_FORMAT(pt.birthday,"%Y%m%d") DOB
                    ,pt.sex SEX,pt.marrystatus MARRIAGE ,pt.occupation OCCUPA,lpad(pt.nationality,3,0) NATION,pt.cid PERSON_ID
                    ,concat(pt.fname," ",pt.lname,",",pt.pname) NAMEPAT
                    ,pt.pname TITLE,pt.fname FNAME,pt.lname LNAME,"1" IDTYPE
                    FROM vn_stat v
                    LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                    LEFT OUTER JOIN ipt i on i.vn = v.vn 
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn 
                    WHERE v.vn IN("'.$va1->vn.'")
                    GROUP BY v.hn
                ');
                foreach ($data_pat_ as $va_02) {
                    $check_hn = Fdh_pat::where('hn',$va_02->HN)->where('d_anaconda_id','=','UCEP24')->count();
                    if ($check_hn > 0) { 
                    } else {
                        Fdh_pat::insert([
                            'HCODE'              => $va_02->HCODE,
                            'HN'                 => $va_02->HN,
                            'CHANGWAT'           => $va_02->CHANGWAT,
                            'AMPHUR'             => $va_02->AMPHUR,
                            'DOB'                => $va_02->DOB,
                            'SEX'                => $va_02->SEX,
                            'MARRIAGE'           => $va_02->MARRIAGE,
                            'OCCUPA'             => $va_02->OCCUPA,
                            'NATION'             => $va_02->NATION,
                            'PERSON_ID'          => $va_02->PERSON_ID,
                            'NAMEPAT'            => $va_02->NAMEPAT,
                            'TITLE'              => $va_02->TITLE,
                            'FNAME'              => $va_02->FNAME,
                            'LNAME'              => $va_02->LNAME,
                            'IDTYPE'             => $va_02->IDTYPE,
        
                            'user_id'            => $iduser,
                            'd_anaconda_id'      => 'UCEP24'
                        ]);
                    }
                    
                } 
                 
                //D_opd OK
                $data_opd = DB::connection('mysql2')->select(
                    'SELECT  v.hn HN,v.spclty CLINIC,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD,v.vn SEQ
                        ,"1" UUC ,oc.cc DETAIL,oc.temperature as BTEMP,oc.bps as SBP,oc.bpd as DBP,oc.pulse as PR,oc.rr as RR
                        ,""OPTYPE
                        ,ot.export_code as TYPEIN,st.export_code as TYPEOUT
                        FROM ovst o
                        LEFT OUTER JOIN vn_stat v on o.vn = v.vn 
                        LEFT OUTER JOIN opdscreen oc  on oc.vn = o.vn 
                        LEFT OUTER JOIN pttype p on p.pttype = v.pttype 
                        LEFT OUTER JOIN patient pt on pt.hn = v.hn
                        LEFT OUTER JOIN ovstist ot on ot.ovstist = o.ovstist  
                        LEFT OUTER JOIN ovstost st on st.ovstost = o.ovstost  
                        WHERE o.vn IN("'.$va1->vn.'") 
                        GROUP BY o.vn         
                '); 
                // oc.cc
                foreach ($data_opd as $val3) {       
                    Fdh_opd::insert([
                        'HN'                => $val3->HN,
                        'CLINIC'            => $val3->CLINIC,
                        'DATEOPD'           => $val3->DATEOPD,
                        'TIMEOPD'           => $val3->TIMEOPD,
                        'SEQ'               => $val3->SEQ,
                        'UUC'               => $val3->UUC, 
                        'DETAIL'            => $val3->DETAIL, 
                        'BTEMP'             => $val3->BTEMP, 
                        'SBP'               => $val3->SBP, 
                        'DBP'               => $val3->DBP, 
                        'PR'                => $val3->PR, 
                        'RR'                => $val3->RR, 
                        'OPTYPE'            => $val3->OPTYPE, 
                        'TYPEIN'            => $val3->TYPEIN, 
                        'TYPEOUT'           => $val3->TYPEOUT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }

                //D_orf _OK
                $data_orf_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,v.spclty CLINIC,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                    ,"0100" REFERTYPE,v.vn SEQ                        
                    ,ifnull(DATE_FORMAT(r1.refer_date,"%Y%m%d"),DATE_FORMAT(r2.refer_date,"%Y%m%d")) as REFERDATE
                    FROM vn_stat v
                    LEFT OUTER JOIN ovst o on o.vn = v.vn
                    LEFT OUTER JOIN referin r1 on r1.vn = v.vn 
                    LEFT OUTER JOIN referout r2 on r2.vn = v.vn
                    WHERE v.vn IN("'.$va1->vn.'") 
                    AND (r1.vn is not null or r2.vn is not null);
                '); 
                // ,r1.refer_date as REFERDATE               
                foreach ($data_orf_ as $va_03) {       
                    Fdh_orf::insert([
                        'HN'                => $va_03->HN,
                        'DATEOPD'           => $va_03->DATEOPD,
                        'CLINIC'            => $va_03->CLINIC, 
                        'REFER'             => $va_03->REFER,
                        'REFERTYPE'         => $va_03->REFERTYPE, 
                        'SEQ'               => $va_03->SEQ, 
                        'REFERDATE'         => $va_03->REFERDATE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                 // D_odx OK
                 $data_odx_ = DB::connection('mysql2')->select(
                    'SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEDX,v.spclty as CLINIC,o.icd10 as DIAG,o.diagtype as DXTYPE
                    ,if(d.licenseno="","-99999",d.licenseno) as DRDX,v.cid as PERSON_ID ,v.vn as SEQ
                    FROM vn_stat v
                    LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                    LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                    INNER JOIN icd101 i on i.code = o.icd10
                    WHERE v.vn IN("'.$va1->vn.'") 
                    GROUP BY v.vn,o.diagtype
                ');
                // INNER JOIN icd101 i on i.code = o.icd10
                foreach ($data_odx_ as $va_04) { 
                    Fdh_odx::insert([
                        'HN'                => $va_04->HN,
                        'DATEDX'            => $va_04->DATEDX,
                        'CLINIC'            => $va_04->CLINIC, 
                        'DIAG'              => $va_04->DIAG,
                        'DXTYPE'            => $va_04->DXTYPE,
                        'DRDX'              => $va_04->DRDX,
                        'PERSON_ID'         => $va_04->PERSON_ID, 
                        'SEQ'               => $va_04->SEQ, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                    
                }
                 //D_oop OK
                 $data_oop_ = DB::connection('mysql2')->select(
                    'SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEOPD,v.spclty as CLINIC,o.icd10 as OPER
                        ,if(d.licenseno="","-99999",d.licenseno) as DROPID,pt.cid as PERSON_ID ,v.vn as SEQ ,""SERVPRICE
                        FROM vn_stat v
                        LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                        LEFT OUTER JOIN patient pt on v.hn=pt.hn
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        INNER JOIN icd9cm1 i on i.code = o.icd10
                        WHERE v.vn IN("'.$va1->vn.'")
                        AND substring(o.icd10,1,1) in ("0","1","2","3","4","5","6","7","8","9") 
                ');
                foreach ($data_oop_ as $va_05) { 
                    Fdh_oop::insert([
                        'HN'                => $va_05->HN,
                        'DATEOPD'           => $va_05->DATEOPD,
                        'CLINIC'            => $va_05->CLINIC, 
                        'OPER'              => $va_05->OPER,
                        'DROPID'            => $va_05->DROPID,
                        'PERSON_ID'         => $va_05->PERSON_ID, 
                        'SEQ'               => $va_05->SEQ, 
                        'SERVPRICE'         => $va_05->SERVPRICE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                    
                }
                //D_ipd OK
                $data_ipd_ = DB::connection('mysql2')->select(
                    'SELECT a.hn HN,a.an AN,DATE_FORMAT(i.regdate,"%Y%m%d") DATEADM,Time_format(i.regtime,"%H%i") TIMEADM
                    ,DATE_FORMAT(i.dchdate,"%Y%m%d") DATEDSC,Time_format(i.dchtime,"%H%i")  TIMEDSC,right(i.dchstts,1) DISCHS
                    ,right(i.dchtype,1) DISCHT,i.ward WARDDSC,i.spclty DEPT,format(i.bw/1000,3) ADM_W,"1" UUC ,"I" SVCTYPE 
                    FROM an_stat a
                    LEFT OUTER JOIN ipt i on i.an = a.an
                    LEFT OUTER JOIN pttype p on p.pttype = a.pttype
                    LEFT OUTER JOIN patient pt on pt.hn = a.hn
                    WHERE i.vn IN("'.$va1->vn.'")
                    GROUP BY a.an
                ');
                foreach ($data_ipd_ as $va_06) {     
                    Fdh_ipd::insert([
                        'HN'                => $va_06->HN,
                        'AN'                => $va_06->AN,                       
                        'DATEADM'           => $va_06->DATEADM,
                        'TIMEADM'           => $va_06->TIMEADM,
                        'DATEDSC'           => $va_06->DATEDSC,
                        'TIMEDSC'           => $va_06->TIMEDSC,
                        'DISCHS'            => $va_06->DISCHS,
                        'DISCHT'            => $va_06->DISCHT, 
                        'WARDDSC'           => $va_06->WARDDSC, 
                        'DEPT'              => $va_06->DEPT, 
                        'ADM_W'             => $va_06->ADM_W, 
                        'UUC'               => $va_06->UUC, 
                        'SVCTYPE'           => $va_06->SVCTYPE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                
                //D_irf OK
                $data_irf_ = DB::connection('mysql2')->select(
                    'SELECT a.an AN,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER,"0100" REFERTYPE
                        FROM an_stat a
                        LEFT OUTER JOIN ipt ip on ip.an = a.an
                        LEFT OUTER JOIN referout o on o.vn = a.an
                        LEFT OUTER JOIN referin oo on oo.vn = a.an
                        WHERE ip.vn IN("'.$va1->vn.'")  
                        AND (a.an in(SELECT vn FROM referin WHERE vn = oo.vn) or a.an in(SELECT vn FROM referout WHERE vn = o.vn));
                ');
                foreach ($data_irf_ as $va_07) {
                    Fdh_irf::insert([
                        'AN'                 => $va_07->AN,
                        'REFER'              => $va_07->REFER,
                        'REFERTYPE'          => $va_07->REFERTYPE,
                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 'UCEP24',
                    ]);                     
                }                 
                //D_idx OK 
                $data_idx_ = DB::connection('mysql2')->select(
                     'SELECT v.an AN,o.icd10 DIAG,o.diagtype DXTYPE,if(d.licenseno="","-99999",d.licenseno) DRDX
                        FROM an_stat v
                        LEFT OUTER JOIN iptdiag o on o.an = v.an
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        LEFT OUTER JOIN ipt ip on ip.an = v.an
                        INNER JOIN icd101 i on i.code = o.icd10
                        WHERE ip.vn IN("'.$va1->vn.'")
                       
                ');
                // LEFT OUTER JOIN ipt ip on ip.an = v.an
                // INNER JOIN icd101 i on i.code = o.icd10
                // GROUP BY ip.an,o.diagtype
                foreach ($data_idx_ as $va_08) { 
                    Fdh_idx::insert([
                        'AN'                => $va_08->AN,  
                        'DIAG'              => $va_08->DIAG,
                        'DXTYPE'            => $va_08->DXTYPE,
                        'DRDX'              => $va_08->DRDX, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                            
                }
                //D_iop OK
                $data_iop_ = DB::connection('mysql2')->select(
                    'SELECT a.an AN,o.icd9 OPER,o.oper_type as OPTYPE,if(d.licenseno="","-99999",d.licenseno) DROPID,DATE_FORMAT(o.opdate,"%Y%m%d") DATEIN,Time_format(o.optime,"%H%i") TIMEIN
                        ,DATE_FORMAT(o.enddate,"%Y%m%d") DATEOUT,Time_format(o.endtime,"%H%i") TIMEOUT
                        FROM an_stat a
                        LEFT OUTER JOIN iptoprt o on o.an = a.an
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        INNER JOIN icd9cm1 i on i.code = o.icd9
                        LEFT OUTER JOIN ipt ip on ip.an = a.an
                        WHERE ip.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_iop_ as $va_09) {
                    Fdh_iop::insert([
                        'AN'                => $va_09->AN,
                        'OPER'              => $va_09->OPER,
                        'OPTYPE'            => $va_09->OPTYPE,
                        'DROPID'            => $va_09->DROPID,
                        'DATEIN'            => $va_09->DATEIN,
                        'TIMEIN'            => $va_09->TIMEIN,
                        'DATEOUT'           => $va_09->DATEOUT,
                        'TIMEOUT'           => $va_09->TIMEOUT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                //D_cht OK
                $data_cht_ = DB::connection('mysql2')->select(
                    'SELECT o.hn HN,o.an AN,DATE_FORMAT(if(a.an is null,o.vstdate,a.dchdate),"%Y%m%d") DATE,round(if(a.an is null,vv.income,a.income),2) TOTAL,""OPD_MEMO,""INVOICE_NO,""INVOICE_LT
                    ,round(if(a.an is null,vv.paid_money,a.paid_money),2) PAID,if(vv.paid_money >"0" or a.paid_money >"0","10",pt.pcode) PTTYPE,pp.cid PERSON_ID ,o.vn SEQ
                    FROM ovst o
                    LEFT OUTER JOIN vn_stat vv on vv.vn = o.vn
                    LEFT OUTER JOIN an_stat a on a.an = o.an
                    LEFT OUTER JOIN patient pp on pp.hn = o.hn
                    LEFT OUTER JOIN pttype pt on pt.pttype = vv.pttype or pt.pttype=a.pttype
                    LEFT OUTER JOIN pttype p on p.pttype = a.pttype 
                    WHERE o.vn IN("'.$va1->vn.'")                     
                ');
                foreach ($data_cht_ as $va_10) {
                    Fdh_cht::insert([
                        'HN'                => $va_10->HN,
                        'AN'                => $va_10->AN,
                        'DATE'              => $va_10->DATE,
                        'TOTAL'             => $va_10->TOTAL,
                        'PAID'              => $va_10->PAID,
                        'PTTYPE'            => $va_10->PTTYPE,
                        'PERSON_ID'         => $va_10->PERSON_ID,
                        'SEQ'               => $va_10->SEQ,
                        'OPD_MEMO'          => $va_10->OPD_MEMO,
                        'INVOICE_NO'        => $va_10->INVOICE_NO,
                        'INVOICE_LT'        => $va_10->INVOICE_LT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                //D_cha OK
                $data_cha_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN,if(v1.an is null,"",v1.an) AN ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                        ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM,round(sum(v.sum_price),2) AMOUNT,p.cid PERSON_ID ,ifnull(v.vn,v.an) SEQ
                        FROM opitemrece v
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        LEFT OUTER JOIN patient p on p.hn = v.hn
                        LEFT OUTER JOIN ipt v1 on v1.an = v.an
                        LEFT OUTER JOIN income i on v.income=i.income
                        LEFT OUTER JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                        LEFT OUTER JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id
                        WHERE v.vn IN("'.$va1->vn.'") 
                        GROUP BY v.vn,CHRGITEM

                        UNION ALL

                        SELECT v.hn HN,ip.an AN ,if(ip.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(ip.dchdate,"%Y%m%d")) DATE
                        ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM,round(sum(v.sum_price),2) AMOUNT,p.cid PERSON_ID ,ifnull(v.vn,v.an) SEQ
                        FROM opitemrece v
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        LEFT OUTER JOIN patient p on p.hn = v.hn
                        LEFT OUTER JOIN ipt ip on ip.an = v.an
                        LEFT OUTER JOIN income i on v.income=i.income
                        LEFT OUTER JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                        LEFT OUTER JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id 
                        WHERE ip.vn IN("'.$va1->vn.'")  
                        GROUP BY v.an,CHRGITEM; 
                ');
                foreach ($data_cha_ as $va_11) {
                    Fdh_cha::insert([
                        'HN'                => $va_11->HN,
                        'AN'                => $va_11->AN,
                        'DATE'              => $va_11->DATE,
                        'CHRGITEM'          => $va_11->CHRGITEM,
                        'AMOUNT'            => $va_11->AMOUNT, 
                        'PERSON_ID'         => $va_11->PERSON_ID,
                        'SEQ'               => $va_11->SEQ, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                } 
                 //D_aer OK
                $data_aer_ = DB::connection('mysql2')->select(
                    'SELECT v.hn HN ,i.an AN ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,cs.claimcode AUTHAE 
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                        FROM vn_stat v
                        LEFT OUTER JOIN ipt i on i.vn = v.vn
                        LEFT OUTER JOIN ovst o on o.vn = v.vn
                        LEFT OUTER JOIN visit_pttype vv on vv.vn = v.vn
                        LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                        LEFT OUTER JOIN check_authen_hos cs on cs.vn = v.vn                        
                        WHERE v.vn IN("'.$va1->vn.'") and i.an is null
                        AND i.an is null
                        GROUP BY v.vn
                         UNION ALL
                        SELECT a.hn HN,a.an AN,DATE_FORMAT(vs.vstdate,"%Y%m%d") DATEOPD,cs.claimcode AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,"" SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                        FROM an_stat a
                        LEFT OUTER JOIN ipt_pttype vv on vv.an = a.an
                        LEFT OUTER JOIN pttype pt on pt.pttype =a.pttype  
                        LEFT OUTER JOIN vn_stat vs on vs.vn =a.vn
                        LEFT OUTER JOIN check_authen_hos cs on cs.vn = vs.vn
                        WHERE a.vn IN("'.$va1->vn.'")
                        GROUP BY a.an
                ');
                foreach ($data_aer_ as $va_12) {
                    Fdh_aer::insert([
                        'HN'                => $va_12->HN,
                        'AN'                => $va_12->AN,
                        'DATEOPD'           => $va_12->DATEOPD,
                        'AUTHAE'            => $va_12->AUTHAE,
                        'AEDATE'            => $va_12->AEDATE,
                        'AETIME'            => $va_12->AETIME,
                        'AETYPE'            => $va_12->AETYPE,
                        'REFER_NO'          => $va_12->REFER_NO,
                        'REFMAINI'          => $va_12->REFMAINI,
                        'IREFTYPE'          => $va_12->IREFTYPE,
                        'REFMAINO'          => $va_12->REFMAINO,
                        'OREFTYPE'          => $va_12->OREFTYPE,
                        'UCAE'              => $va_12->UCAE,
                        'EMTYPE'            => $va_12->EMTYPE,
                        'SEQ'               => $va_12->SEQ,
                        'AESTATUS'          => $va_12->AESTATUS,
                        'DALERT'            => $va_12->DALERT,
                        'TALERT'            => $va_12->TALERT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                } 
                //D_adp
                $data_adp_ = DB::connection('mysql2')->select( 
                        'SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP ,"01"SP_ITEM,icode ,vstdate
                        FROM
                        (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE 

                        ,(SELECT sum(qty) from pkbackoffice.d_ucep24 where an = v.an and icode = v.icode) as QTY 
                        ,(SELECT sum(sum_price) from pkbackoffice.d_ucep24 where an = v.an and icode = v.icode) as RATE
                        
                        ,if(v.an is null,v.vn,"") SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC
                        ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP ,""SP_ITEM,v.icode,v.vstdate
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null 
                        LEFT OUTER JOIN ipt i on i.an = v.an
                        inner join pkbackoffice.d_ucep24 u on u.icode = v.icode
                  
                        WHERE i.vn IN("'.$va1->vn.'")
                        AND i.an is not NULL 
                        AND (SELECT sum(sum_price) from pkbackoffice.d_ucep24 where an = v.an and icode = v.icode) > 0
                        GROUP BY i.vn,n.nhso_adp_code,rate) a 
                        GROUP BY an,CODE,rate

                        UNION

                    SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,"01"SP_ITEM,icode ,vstdate
                        FROM
                        (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE                          
                       
                        ,(SELECT sum(qty) from pkbackoffice.d_ucep24 where an = v.an and icode = v.icode) as QTY 
                        ,(SELECT sum(sum_price) from pkbackoffice.d_ucep24 where an = v.an and icode = v.icode) as RATE
                        
                        ,if(v.an is null,v.vn,"") SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,DATE_FORMAT("0000-00-00","%Y%m%d") LMP,""SP_ITEM,v.icode,v.vstdate
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null 
                        inner join pkbackoffice.d_ucep24 u on u.icode = v.icode
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        WHERE vv.vn IN("'.$va1->vn.'")
                        AND v.an is NULL
                        AND (SELECT sum(sum_price) from pkbackoffice.d_ucep24 where an = v.an and icode = v.icode) > 0 
                        GROUP BY vv.vn,n.nhso_adp_code,rate) b 
                        GROUP BY seq,CODE,rate;
                ');                 
                foreach ($data_adp_ as $va_13) {
                    Fdh_adp::insert([
                        'HN'                   => $va_13->HN,
                        'AN'                   => $va_13->AN,
                        'DATEOPD'              => $va_13->DATEOPD,
                        'TYPE'                 => $va_13->TYPE,
                        'CODE'                 => $va_13->CODE,
                        'QTY'                  => $va_13->QTY,
                        'RATE'                 => $va_13->RATE,
                        'SEQ'                  => $va_13->SEQ,
                        'CAGCODE'              => $va_13->CAGCODE,
                        'DOSE'                 => $va_13->DOSE,
                        'CA_TYPE'              => $va_13->CA_TYPE,
                        'SERIALNO'             => $va_13->SERIALNO,
                        'TOTCOPAY'             => $va_13->TOTCOPAY,
                        'USE_STATUS'           => $va_13->USE_STATUS,
                        'TOTAL'                => $va_13->TOTAL,
                        'QTYDAY'               => $va_13->QTYDAY,
                        'TMLTCODE'             => $va_13->TMLTCODE,
                        'STATUS1'              => $va_13->STATUS1,
                        'BI'                   => $va_13->BI,
                        'CLINIC'               => $va_13->CLINIC,
                        'ITEMSRC'              => $va_13->ITEMSRC,
                        'PROVIDER'             => $va_13->PROVIDER,
                        'GRAVIDA'              => $va_13->GRAVIDA,
                        'GA_WEEK'              => $va_13->GA_WEEK,
                        'DCIP'                 => $va_13->DCIP,
                        'LMP'                  => $va_13->LMP,
                        'SP_ITEM'              => $va_13->SP_ITEM,
                        'icode'                => $va_13->icode,
                        'vstdate'              => $va_13->vstdate,
                        'user_id'              => $iduser,
                        'd_anaconda_id'        => 'UCEP24'
                    ]);
                } 
                //D_dru OK
                $data_dru_ = DB::connection('mysql2')->select(
                    'SELECT vv.hcode HCODE ,v.hn HN ,v.an AN ,vv.spclty CLINIC ,vv.cid PERSON_ID ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
                    ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,v.qty AMOUNT ,round(v.unitprice,2) DRUGPRICE
                    ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                    ,oo.presc_reason DRUGREMARK ,"" PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                    ,"" TOTAL ,"" as SIGCODE ,"" as SIGTEXT ,"" PROVIDER,v.vstdate
                    FROM opitemrece v
                    LEFT OUTER JOIN drugitems d on d.icode = v.icode
                    LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                    LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode  
                    LEFT OUTER JOIN drugitems_ned_reason dn on dn.icode = v.icode               
                    WHERE v.vn IN("'.$va1->vn.'")
                    AND d.did is not null 
                    GROUP BY v.vn,did

                    UNION all

                    SELECT pt.hcode HCODE ,v.hn HN ,v.an AN ,v1.spclty CLINIC ,pt.cid PERSON_ID ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                    ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,sum(v.qty) AMOUNT ,round(v.unitprice,2) DRUGPRICE
                    ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                    ,oo.presc_reason DRUGREMARK ,"" PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                    ,"" TOTAL,"" as SIGCODE,"" as SIGTEXT,""  PROVIDER,v.vstdate
                    FROM opitemrece v
                    LEFT OUTER JOIN drugitems d on d.icode = v.icode
                    LEFT OUTER JOIN patient pt  on v.hn = pt.hn
                    INNER JOIN ipt v1 on v1.an = v.an
                    LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
                    LEFT OUTER JOIN drugitems_ned_reason dn on dn.icode = v.icode               
                    WHERE v1.vn IN("'.$va1->vn.'")
                    AND d.did is not null AND v.qty<>"0"
                    GROUP BY v.an,d.icode,USE_STATUS;   
                ');
               
                foreach ($data_dru_ as $va_14) {
                    Fdh_dru::insert([ 
                        'HCODE'          => $va_14->HCODE,
                        'HN'             => $va_14->HN,
                        'AN'             => $va_14->AN,
                        'CLINIC'         => $va_14->CLINIC, 
                        'PERSON_ID'      => $va_14->PERSON_ID,
                        'DATE_SERV'      => $va_14->DATE_SERV,
                        'DID'            => $va_14->DID,
                        'DIDNAME'        => $va_14->DIDNAME, 
                        'AMOUNT'         => $va_14->AMOUNT,
                        'DRUGPRICE'      => $va_14->DRUGPRICE,
                        'DRUGCOST'       => $va_14->DRUGCOST,
                        'DIDSTD'         => $va_14->DIDSTD,
                        'UNIT'           => $va_14->UNIT,
                        'UNIT_PACK'      => $va_14->UNIT_PACK,
                        'SEQ'            => $va_14->SEQ,
                        'DRUGREMARK'     => $va_14->DRUGREMARK,
                        'PA_NO'          => $va_14->PA_NO,
                        'TOTCOPAY'       => $va_14->TOTCOPAY, 
                        'USE_STATUS'     => $va_14->USE_STATUS,
                        'TOTAL'          => $va_14->TOTAL,   
                        'SIGCODE'        => $va_14->SIGCODE,                      
                        'SIGTEXT'        => $va_14->SIGTEXT,
                        'PROVIDER'       => $va_14->PROVIDER,
                        'vstdate'        => $va_14->vstdate,   
                        'user_id'        => $iduser,
                        'd_anaconda_id'  => 'UCEP24'
                    ]);
                } 
 
         }
        // $data_ = DB::connection('mysql')->select('SELECT vn,an,hn,DATE_FORMAT(vstdate,"%Y%m%d") as vstdate,dchdate,icode,qty FROM d_ucep24'); 
        // $iduser = Auth::user()->id;
        // foreach ($data_ as $key => $val) {   
        //     Fdh_dru::where('AN',$val->an)->where('DID',$val->icode)->where('d_anaconda_id',"UCEP24") 
        //     ->update([
        //         'SP_ITEM'     => '01',
        //         'AMOUNT'      => $val->qty
        //     ]);  
           
        // }
             
        // Fdh_adp::where('SP_ITEM','=','')->where('d_anaconda_id',"UCEP24")->delete();
        // Fdh_adp::where('QTY','=',['',null])->where('SP_ITEM','=','01')->where('d_anaconda_id',"UCEP24")->delete();
        // Fdh_dru::where('SP_ITEM','=',null)->where('d_anaconda_id',"UCEP24")->delete();
        Fdh_adp::where('CODE','=','XXXXXX')->delete();
        Fdh_dru::whereIn('DID',[1550027, 1650087,1590016,1500101,1590018,1660100,1640078,1640058,1640076])->delete();
        // D_ucep24_main::whereIn('d_ucep24_main_id',explode(",",$id))
        // ->update([
        //     'active' => 'Y'
        // ]);
        D_fdh::whereIn('d_fdh_id',explode(",",$id))
        ->update([
            'active' => 'Y'
        ]);

        return response()->json([
             'status'    => '200'
        ]);
    }
    public function ucep24_main_update(Request $request)
    {   
            // $data_ = DB::connection('mysql')->select('SELECT vn,an,hn,vstdate,dchdate,icode,qty FROM d_ucep24 WHERE an <> "" AND qty > 0'); 
            // foreach ($data_ as $key => $val) {   
            //     Fdh_dru::where('AN',$val->an)->where('DID',$val->icode)->where('d_anaconda_id',"UCEP24") 
            //     ->update([
            //         'SP_ITEM'     => '01',
            //         'AMOUNT'      => $val->qty
            //     ]);                
            // }
            
            $dataucep_ = DB::connection('mysql')->select('SELECT * FROM fdh_adp WHERE AN <> "" AND d_anaconda_id="UCEP24" GROUP BY AN');
            $iduser = Auth::user()->id;
            foreach ($dataucep_ as $key => $value_up) {
                $check = Fdh_adp::where('AN',$value_up->AN)->where('CODE','UCEP24')->where('d_anaconda_id',"UCEP24")->count();
                if ($check > 0) {
                    # code...
                } else {
                    Fdh_adp::insert([
                        'HN'             => $value_up->HN, 
                        'AN'             => $value_up->AN, 
                        'DATEOPD'        => $value_up->DATEOPD,  
                        'TYPE'           => '5', 
                        'CODE'           => 'UCEP24', 
                        'QTY'            => '1', 
                        'RATE'           => '0', 
                        'TOTCOPAY'       => '0', 
                        'TOTAL'          => '0', 
                        'SP_ITEM'        => '01', 
                        'user_id'        => $iduser,
                        'd_anaconda_id'  => 'UCEP24'
                    ]);
                }   
                
                $data_ = DB::connection('mysql')->select('SELECT vn,an,hn,vstdate,dchdate,icode,qty FROM d_ucep24 WHERE an = "'.$value_up->AN.'" AND qty > 0'); 
                foreach ($data_ as $key => $val) {   
                    Fdh_dru::where('AN',$val->an)->where('DID',$val->icode)->where('d_anaconda_id',"UCEP24") 
                    ->update([
                        'SP_ITEM'     => '01',
                        'AMOUNT'      => $val->qty
                    ]);                
                }
            }
            // icode
            Fdh_adp::where('SP_ITEM','=','')->where('d_anaconda_id',"UCEP24")->delete();
            Fdh_adp::where('QTY','=',['',null])->where('SP_ITEM','=','01')->where('d_anaconda_id',"UCEP24")->delete();
            Fdh_dru::where('SP_ITEM','=',null)->where('d_anaconda_id',"UCEP24")->delete();

            return response()->json([
                'status'    => '200'
            ]);
    }
    public function ucep24_main_export(Request $request)
    {
        // $sss_date_now = date("Y-m-d");
        // $sss_time_now = date("H:i:s");

        // #ตัดขีด, ตัด : ออก
        // $pattern_date = '/-/i';
        // $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        // $pattern_time = '/:/i';
        // $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        // #ตัดขีด, ตัด : ออก

         #delete file in folder ทั้งหมด
        $file = new Filesystem;
        $file->cleanDirectory('Export'); //ทั้งหมด
        // $file->cleanDirectory('UCEP_'.$sss_date_now_preg.'-'.$sss_time_now_preg); 
        // $folder='UCEP24_'.$sss_date_now_preg.'-'.$sss_time_now_preg;
        $dataexport_ = DB::connection('mysql')->select('SELECT folder_name from fdh_sesion where d_anaconda_id = "UCEP24"');
        foreach ($dataexport_ as $key => $v_export) {
            $folder_ = $v_export->folder_name;
        }
        $folder = $folder_;

         mkdir ('Export/'.$folder, 0777, true);  //Web
        //  mkdir ('C:Export/'.$folder, 0777, true); //localhost

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"; charset=tis-620″ ;');

        //1 ins.txt
        $file_d_ins = "Export/".$folder."/INS.txt";
        $objFopen_ins = fopen($file_d_ins, 'w'); 
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|HCODE|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        $opd_head = 'HN|INSCL|SUBTYPE|CID|HCODE|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        fwrite($objFopen_ins, $opd_head); 
        $ins = DB::connection('mysql')->select('SELECT * from fdh_ins where d_anaconda_id = "UCEP24"');
        foreach ($ins as $key => $value1) {
            $a1  = $value1->HN;
            $a2  = $value1->INSCL;
            $a3  = $value1->SUBTYPE;
            $a4  = $value1->CID;
            $a5  = $value1->HCODE;
            // $a6  = $value1->DATEIN;
            $a7  = $value1->DATEEXP;
            $a8  = $value1->HOSPMAIN;
            $a9  = $value1->HOSPSUB;
            $a10  = $value1->GOVCODE;
            $a11 = $value1->GOVNAME;
            $a12 = $value1->PERMITNO;
            $a13 = $value1->DOCNO;
            $a14 = $value1->OWNRPID;
            $a15 = $value1->OWNNAME;
            $a16 = $value1->AN;
            $a17 = $value1->SEQ;
            $a18 = $value1->SUBINSCL;
            $a19 = $value1->RELINSCL;
            $a20 = $value1->HTYPE;
            // $str_ins="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19."|".$a20;
            // $str_ins="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19."|".$a20;
            $str_ins ="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19."|".$a20;
            
            $str_ins_10 = preg_replace("/\n/", "\r\n", $str_ins); 
            $str_ins_11 = mb_convert_encoding($str_ins_10, 'UTF-8');   
            fwrite($objFopen_ins, $str_ins_11);  
        }
        fclose($objFopen_ins); 

        //2 pat.txt
        $file_d_pat = "Export/".$folder."/PAT.txt";
        $objFopen_pat = fopen($file_d_pat, 'w'); 
        // $opd_head_pat = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        $opd_head_pat = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        fwrite($objFopen_pat, $opd_head_pat);
        $pat = DB::connection('mysql')->select('SELECT * from fdh_pat where d_anaconda_id = "UCEP24"');
        foreach ($pat as $key => $value2) {
            $i1  = $value2->HCODE;
            $i2  = $value2->HN;
            $i3  = $value2->CHANGWAT;
            $i4  = $value2->AMPHUR;
            $i5  = $value2->DOB;
            $i6  = $value2->SEX;
            $i7  = $value2->MARRIAGE;
            $i8  = $value2->OCCUPA;
            $i9  = $value2->NATION;
            $i10 = $value2->PERSON_ID;
            $i11 = $value2->NAMEPAT;
            $i12 = $value2->TITLE;
            $i13 = $value2->FNAME;
            $i14 = $value2->LNAME;
            $i15 = $value2->IDTYPE;      
            $str_pat ="\n".$i1."|".$i2."|".$i3."|".$i4."|".$i5."|".$i6."|".$i7."|".$i8."|".$i9."|".$i10."|".$i11."|".$i12."|".$i13."|".$i14."|".$i15;
            $str_pat_20 = preg_replace("/\n/", "\r\n", $str_pat); 
            $str_pat_21 = mb_convert_encoding($str_pat_20, 'UTF-8');   
            fwrite($objFopen_pat, $str_pat_21);              
        }
        fclose($objFopen_pat);
        

        //3 opd.txt
        $file_d_opd = "Export/".$folder."/OPD.txt";
        $objFopen_opd = fopen($file_d_opd, 'w');
     
        $opd_head_opd = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC';
        // $opd_head_opd = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
        fwrite($objFopen_opd, $opd_head_opd);
        $opd = DB::connection('mysql')->select('SELECT * from fdh_opd where d_anaconda_id = "UCEP24"');
        foreach ($opd as $key => $value3) {
            $o1 = $value3->HN;
            $o2 = $value3->CLINIC;
            $o3 = $value3->DATEOPD; 
            $o4 = $value3->TIMEOPD; 
            $o5 = $value3->SEQ; 
            $o6 = $value3->UUC; 
            // $o7 = $value3->DETAIL; 
            // $o8 = $value3->BTEMP; 
            // $o9 = $value3->SBP; 
            // $o10 = $value3->DBP; 
            // $o11 = $value3->PR; 
            // $o12 = $value3->RR; 
            // $o13 = $value3->OPTYPE; 
            // $o14 = $value3->TYPEIN;  
            // $o15 = $value3->TYPEOUT;
            $str_opd="\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6; 
            // $str_opd ="\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6."|".$o7."|".$o8."|".$o9."|".$o10."|".$o11."|".$o12."|".$o13."|".$o14."|".$o15;
            $str_opd_30 = preg_replace("/\n/", "\r\n", $str_opd); 
            $str_opd_31 = mb_convert_encoding($str_opd_30, 'UTF-8');   
            fwrite($objFopen_opd, $str_opd_31);  
        }
        fclose($objFopen_opd);
       

        //4 orf.txt
        $file_d_orf = "Export/".$folder."/ORF.txt";
        $objFopen_orf = fopen($file_d_orf, 'w'); 
        $opd_head_orf = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ|REFERDATE';
        fwrite($objFopen_orf, $opd_head_orf);
        $orf = DB::connection('mysql')->select('SELECT * from fdh_orf where d_anaconda_id = "UCEP24"');
        foreach ($orf as $key => $value4) {
            $p1 = $value4->HN;
            $p2 = $value4->DATEOPD;
            $p3 = $value4->CLINIC; 
            $p4 = $value4->REFER; 
            $p5 = $value4->REFERTYPE; 
            $p6 = $value4->SEQ;  
            $p7 = $value4->REFERDATE; 
            $str_orf="\n".$p1."|".$p2."|".$p3."|".$p4."|".$p5."|".$p6."|".$p7;
            $str_orf_40 = preg_replace("/\n/", "\r\n", $str_orf); 
            $str_orf_41 = mb_convert_encoding($str_orf_40, 'UTF-8');   
            fwrite($objFopen_orf, $str_orf_41);   
        }
        fclose($objFopen_orf);        

        //5 odx.txt
        $file_d_odx = "Export/".$folder."/ODX.txt";
        $objFopen_odx = fopen($file_d_odx, 'w'); 
        $opd_head_odx = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        fwrite($objFopen_odx, $opd_head_odx);
        $odx = DB::connection('mysql')->select('SELECT * from fdh_odx where d_anaconda_id = "UCEP24"');
        foreach ($odx as $key => $value5) {
            $m1 = $value5->HN;
            $m2 = $value5->DATEDX;
            $m3 = $value5->CLINIC; 
            $m4 = $value5->DIAG; 
            $m5 = $value5->DXTYPE; 
            $m6 = $value5->DRDX; 
            $m7 = $value5->PERSON_ID; 
            $m8 = $value5->SEQ; 
            $str_odx="\n".$m1."|".$m2."|".$m3."|".$m4."|".$m5."|".$m6."|".$m7."|".$m8;
            $str_odx_50 = preg_replace("/\n/", "\r\n", $str_odx); 
            $str_odx_51 = mb_convert_encoding($str_odx_50, 'UTF-8');   
            fwrite($objFopen_odx, $str_odx_51);  
        }
        fclose($objFopen_odx); 

        //6 oop.txt
        $file_d_oop = "Export/".$folder."/OOP.txt";
        $objFopen_oop = fopen($file_d_oop, 'w'); 
        $opd_head_oop = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ|SERVPRICE';
        fwrite($objFopen_oop, $opd_head_oop);
        $oop = DB::connection('mysql')->select('SELECT * from fdh_oop where d_anaconda_id = "UCEP24"');
        foreach ($oop as $key => $value6) {
            $n1 = $value6->HN;
            $n2 = $value6->DATEOPD;
            $n3 = $value6->CLINIC; 
            $n4 = $value6->OPER; 
            $n5 = $value6->DROPID; 
            $n6 = $value6->PERSON_ID; 
            $n7 = $value6->SEQ; 
            $n8 = $value6->SERVPRICE; 
            $str_oop="\n".$n1."|".$n2."|".$n3."|".$n4."|".$n5."|".$n6."|".$n7."|".$n8; 
            $str_oop_60 = preg_replace("/\n/", "\r\n", $str_oop); 
            $str_oop_61 = mb_convert_encoding($str_oop_60, 'UTF-8');   
            fwrite($objFopen_oop, $str_oop_61); 

        }
        fclose($objFopen_oop); 

        //7 ipd.txt
        $file_d_ipd = "Export/".$folder."/IPD.txt";
        $objFopen_ipd = fopen($file_d_ipd, 'w'); 
        $opd_head_ipd = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
        fwrite($objFopen_ipd, $opd_head_ipd);
        $ipd = DB::connection('mysql')->select('SELECT * from fdh_ipd where d_anaconda_id = "UCEP24"');
        foreach ($ipd as $key => $value7) {
            $j1 = $value7->HN;
            $j2 = $value7->AN;
            $j3 = $value7->DATEADM;
            $j4 = $value7->TIMEADM;
            $j5 = $value7->DATEDSC;
            $j6 = $value7->TIMEDSC;
            $j7 = $value7->DISCHS;
            $j8 = $value7->DISCHT;
            $j9 = $value7->WARDDSC;
            $j10 = $value7->DEPT;
            $j11 = $value7->ADM_W;
            $j12 = $value7->UUC;
            $j13 = $value7->SVCTYPE;    
            $str_ipd="\n".$j1."|".$j2."|".$j3."|".$j4."|".$j5."|".$j6."|".$j7."|".$j8."|".$j9."|".$j10."|".$j11."|".$j12."|".$j13;
            $str_ipd_70 = preg_replace("/\n/", "\r\n", $str_ipd); 
            $str_ipd_71 = mb_convert_encoding($str_ipd_70, 'UTF-8');   
            fwrite($objFopen_ipd, $str_ipd_71); 
        }
        fclose($objFopen_ipd); 

        //8 irf.txt
        $file_d_irf = "Export/".$folder."/IRF.txt";
        $objFopen_irf = fopen($file_d_irf, 'w'); 
        $opd_head_irf = 'AN|REFER|REFERTYPE';
        fwrite($objFopen_irf, $opd_head_irf);
        $irf = DB::connection('mysql')->select('SELECT * from fdh_irf where d_anaconda_id = "UCEP24"');
        foreach ($irf as $key => $value8) {
            $k1 = $value8->AN;
            $k2 = $value8->REFER;
            $k3 = $value8->REFERTYPE; 
            $str_irf="\n".$k1."|".$k2."|".$k3; 
            $str_irf_80 = preg_replace("/\n/", "\r\n", $str_irf); 
            $str_irf_81 = mb_convert_encoding($str_irf_80, 'UTF-8');   
            fwrite($objFopen_irf, $str_irf_81);
        }
        fclose($objFopen_irf); 

        //9 idx.txt
        $file_d_idx = "Export/".$folder."/IDX.txt";
        $objFopen_idx = fopen($file_d_idx, 'w'); 
        $opd_head_idx = 'AN|DIAG|DXTYPE|DRDX';
        fwrite($objFopen_idx, $opd_head_idx);
        $idx = DB::connection('mysql')->select('SELECT * from fdh_idx where d_anaconda_id = "UCEP24"');
        foreach ($idx as $key => $value9) {
            $h1 = $value9->AN;
            $h2 = $value9->DIAG;
            $h3 = $value9->DXTYPE;
            $h4 = $value9->DRDX; 
            $str_idx="\n".$h1."|".$h2."|".$h3."|".$h4; 
            $str_idx_90 = preg_replace("/\n/", "\r\n", $str_idx); 
            $str_idx_91 = mb_convert_encoding($str_idx_90, 'UTF-8');   
            fwrite($objFopen_idx, $str_idx_91);
        }
        fclose($objFopen_idx); 
                   
        //10 iop.txt
        $file_d_iop = "Export/".$folder."/IOP.txt";
        $objFopen_iop = fopen($file_d_iop, 'w'); 
        $opd_head_iop = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
        fwrite($objFopen_iop, $opd_head_iop);
        $iop = DB::connection('mysql')->select('SELECT * from fdh_iop where d_anaconda_id = "UCEP24"');
        foreach ($iop as $key => $value10) {
            $b1 = $value10->AN;
            $b2 = $value10->OPER;
            $b3 = $value10->OPTYPE;
            $b4 = $value10->DROPID;
            $b5 = $value10->DATEIN;
            $b6 = $value10->TIMEIN;
            $b7 = $value10->DATEOUT;
            $b8 = $value10->TIMEOUT;           
            $str_iop="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8; 
            $str_iop_100 = preg_replace("/\n/", "\r\n", $str_iop); 
            $str_iop_101 = mb_convert_encoding($str_iop_100, 'UTF-8');   
            fwrite($objFopen_iop, $str_iop_101);
        }
        fclose($objFopen_iop); 
        
        //11 cht.txt
        $file_d_cht = "Export/".$folder."/CHT.txt";
        $objFopen_cht = fopen($file_d_cht, 'w'); 
        $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ|OPD_MEMO|INVOICE_NO|INVOICE_LT';
        // $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ';
        fwrite($objFopen_cht, $opd_head_cht);
        $cht = DB::connection('mysql')->select('SELECT * from fdh_cht where d_anaconda_id = "UCEP24"');
        foreach ($cht as $key => $value11) {
            $f1 = $value11->HN;
            $f2 = $value11->AN;
            $f3 = $value11->DATE;
            $f4 = $value11->TOTAL;
            $f5 = $value11->PAID;
            $f6 = $value11->PTTYPE;
            $f7 = $value11->PERSON_ID; 
            $f8 = $value11->SEQ;
            $f9 = $value11->OPD_MEMO;
            $f10 = $value11->INVOICE_NO;
            $f11 = $value11->INVOICE_LT;
            $str_cht="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8."|".$f9."|".$f10."|".$f11;
            // $str_cht="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8; 
            $str_cht_11 = preg_replace("/\n/", "\r\n", $str_cht); 
            $str_cht_12 = mb_convert_encoding($str_cht_11, 'UTF-8');   
            fwrite($objFopen_cht, $str_cht_12);
        }
        fclose($objFopen_cht); 

        //12 cha.txt
        $file_d_cha = "Export/".$folder."/CHA.txt";
        $objFopen_cha = fopen($file_d_cha, 'w'); 
        $opd_head_cha = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
        fwrite($objFopen_cha, $opd_head_cha);
        $cha = DB::connection('mysql')->select('SELECT * from fdh_cha where d_anaconda_id = "UCEP24"');
        foreach ($cha as $key => $value12) {
            $e1 = $value12->HN;
            $e2 = $value12->AN;
            $e3 = $value12->DATE;
            $e4 = $value12->CHRGITEM;
            $e5 = $value12->AMOUNT;
            $e6 = $value12->PERSON_ID;
            $e7 = $value12->SEQ; 
            $str_cha="\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7;            
            $str_cha_12 = preg_replace("/\n/", "\r\n", $str_cha); 
            $str_cha_122 = mb_convert_encoding($str_cha_12, 'UTF-8');   
            fwrite($objFopen_cha, $str_cha_122);
        }
        fclose($objFopen_cha); 

         //13 aer.txt
         $file_d_aer = "Export/".$folder."/AER.txt";
         $objFopen_aer = fopen($file_d_aer, 'w'); 
         $opd_head_aer = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
         fwrite($objFopen_aer, $opd_head_aer);
         $aer = DB::connection('mysql')->select('SELECT * from fdh_aer where d_anaconda_id = "UCEP24"');
         foreach ($aer as $key => $value13) {
             $d1 = $value13->HN;
             $d2 = $value13->AN;
             $d3 = $value13->DATEOPD;
             $d4 = $value13->AUTHAE;
             $d5 = $value13->AEDATE;
             $d6 = $value13->AETIME;
             $d7 = $value13->AETYPE;
             $d8 = $value13->REFER_NO;
             $d9 = $value13->REFMAINI;
             $d10 = $value13->IREFTYPE;
             $d11 = $value13->REFMAINO;
             $d12 = $value13->OREFTYPE;
             $d13 = $value13->UCAE;
             $d14 = $value13->EMTYPE;
             $d15 = $value13->SEQ;
             $d16 = $value13->AESTATUS;
             $d17 = $value13->DALERT;
             $d18 = $value13->TALERT;        
             $str_aer="\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|".$d15."|".$d16."|".$d17."|".$d18;
          
            $str_aer_13 = preg_replace("/\n/", "\r\n", $str_aer); 
            $str_aer_132 = mb_convert_encoding($str_aer_13, 'UTF-8');   
            fwrite($objFopen_aer, $str_aer_132);
         }
         fclose($objFopen_aer); 
                   
        //14 adp.txt
        $file_d_adp = "Export/".$folder."/ADP.txt";
        $objFopen_adp = fopen($file_d_adp, 'w'); 
        // $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        // $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        // $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE';
        
        fwrite($objFopen_adp, $opd_head_adp);
        $adp = DB::connection('mysql')->select('SELECT * from fdh_adp where d_anaconda_id = "UCEP24"');
        foreach ($adp as $key => $value14) {
            $c1  = $value14->HN;
            $c2  = $value14->AN;
            $c3  = $value14->DATEOPD;
            $c4  = $value14->TYPE;
            $c5  = $value14->CODE;
            $c6  = $value14->QTY;
            $c7  = $value14->RATE;
            $c8  = $value14->SEQ;
            $c9  = $value14->CAGCODE;
            $c10 = $value14->DOSE;
            $c11 = $value14->CA_TYPE;
            $c12 = $value14->SERIALNO;
            $c13 = $value14->TOTCOPAY;
            $c14 = $value14->USE_STATUS;
            $c15 = $value14->TOTAL;
            $c16 = $value14->QTYDAY;
            $c17 = $value14->TMLTCODE;
            $c18 = $value14->STATUS1;
            $c19 = $value14->BI;
            $c20 = $value14->CLINIC;
            $c21 = $value14->ITEMSRC;
            $c22 = $value14->PROVIDER;
            $c23 = $value14->GRAVIDA;
            $c24 = $value14->GA_WEEK;
            $c25 = $value14->DCIP;
            $c26 = $value14->LMP;
            $c27 = $value14->SP_ITEM;   
            // $str_adp="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17;        
            $str_adp="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;
            // $str_adp="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26;
           
            $str_adp_14 = preg_replace("/\n/", "\r\n", $str_adp); 
            $str_adp_142 = mb_convert_encoding($str_adp_14, 'UTF-8');   
            fwrite($objFopen_adp, $str_adp_142);
        }
        fclose($objFopen_adp); 
        
         //15 lvd.txt
         $file_d_lvd = "Export/".$folder."/LVD.txt";
         $objFopen_lvd = fopen($file_d_lvd, 'w'); 
         $opd_head_lvd = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
         fwrite($objFopen_lvd, $opd_head_lvd);
         $lvd = DB::connection('mysql')->select('SELECT * from fdh_lvd where d_anaconda_id = "UCEP24"');
         foreach ($lvd as $key => $value15) {
             $L1 = $value15->SEQLVD;
             $L2 = $value15->AN;
             $L3 = $value15->DATEOUT; 
             $L4 = $value15->TIMEOUT; 
             $L5 = $value15->DATEIN; 
             $L6 = $value15->TIMEIN; 
             $L7 = $value15->QTYDAY; 
             $str_lvd="\n".$L1."|".$L2."|".$L3."|".$L4."|".$L5."|".$L6."|".$L7;
           
            $str_lvd_15 = preg_replace("/\n/", "\r\n", $str_lvd); 
            $str_lvd_152 = mb_convert_encoding($str_lvd_15, 'UTF-8');   
            fwrite($objFopen_lvd, $str_lvd_152);
         }
         fclose($objFopen_lvd); 
 
        //16 dru.txt
        $file_d_dru = "Export/".$folder."/DRU.txt";
        $objFopen_dru = fopen($file_d_dru, 'w');
        // $objFopen_dru_utf = fopen($file_d_dru, 'w');
        // $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        // $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRICE|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER';
        $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        // $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        fwrite($objFopen_dru, $opd_head_dru);
        // fwrite($objFopen_dru_utf, $opd_head_dru);
        $dru = DB::connection('mysql')->select('SELECT * from fdh_dru where d_anaconda_id = "UCEP24"');
        foreach ($dru as $key => $value16) {
            $g1 = $value16->HCODE;
            $g2 = $value16->HN;
            $g3 = $value16->AN;
            $g4 = $value16->CLINIC;
            $g5 = $value16->PERSON_ID;
            $g6 = $value16->DATE_SERV;
            $g7 = $value16->DID;
            $g8 = $value16->DIDNAME;
            $g9 = $value16->AMOUNT;
            $g10 = $value16->DRUGPRICE;
            $g11 = $value16->DRUGCOST;
            $g12 = $value16->DIDSTD;
            $g13 = $value16->UNIT;
            $g14 = $value16->UNIT_PACK;
            $g15 = $value16->SEQ;
            // $g16 = $value16->DRUGTYPE;
            $g17 = $value16->DRUGREMARK;
            $g18 = $value16->PA_NO;
            $g19 = $value16->TOTCOPAY;
            $g20 = $value16->USE_STATUS;
            $g21 = $value16->TOTAL;
            $g22 = $value16->SIGCODE;
            $g23 = $value16->SIGTEXT;  
            $g24 = $value16->PROVIDER; 
            $g25 = $value16->SP_ITEM;      
            $str_dru="\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23."|".$g24."|".$g25;
            // $ansitxt_dru = iconv('UTF-8', 'UTF-8', $str_dru);
            
            $str_dru_16 = preg_replace("/\n/", "\r\n", $str_dru); 
            $str_dru_162 = mb_convert_encoding($str_dru_16, 'UTF-8');   
            fwrite($objFopen_dru, $str_dru_162);
        }
        fclose($objFopen_dru); 

         //17 lab.txt
        //  $file_d_lab = "Export/".$folder."/LAB.txt";
        //  $objFopen_lab = fopen($file_d_lab, 'w');
        //  $opd_head_lab = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
        //  fwrite($objFopen_lab, $opd_head_lab);
        //  fclose($objFopen_lab);



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
                    unlink($zipcreated);   
                    $files = glob($pathdir . '/*');   
                    foreach($files as $file) {   
                        if(is_file($file)) {      
                            // unlink($file); 
                        } 
                    }                      
                    return redirect()->route('claim.ucep24_main');                    
                }
        } 

            return redirect()->route('claim.ucep24_main');

    }
     
}
