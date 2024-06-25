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
use App\Models\Dapi_lgo_ins;
use App\Models\Dapi_lgo_dru;
use App\Models\Dapi_lgo_pat;
use App\Models\Dapi_lgo_opd;
use App\Models\Dapi_lgo_orf;
use App\Models\Dapi_lgo_odx;
use App\Models\Dapi_lgo_oop;
use App\Models\Dapi_lgo_ipd;
use App\Models\Dapi_lgo_irf;
use App\Models\Dapi_lgo_idx;
use App\Models\Dapi_lgo_iop;
use App\Models\Dapi_lgo_cht; 
use App\Models\Dapi_lgo_cha;
use App\Models\Dapi_lgo_aer;   
use App\Models\Dapi_lgo_adp;
use App\Models\Dapi_lgo_ldv;
use App\Models\Book_type;
use App\Models\Book_import_fam;
use App\Models\Book_signature;
use App\Models\Bookrep;
use App\Models\Book_objective;
use App\Models\Book_senddep;
use App\Models\Book_senddep_sub;
use App\Models\Book_send_person;
use App\Models\Book_sendteam;
use App\Models\Bookrepdelete;
use App\Models\Car_status;
use App\Models\Car_index;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;  
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\D_dru_out;

use App\Models\Acc_1102050102_106;
use App\Models\D_12001;
use App\Models\D_ins;
use App\Models\D_pat;
use App\Models\D_opd;
use App\Models\D_orf;
use App\Models\D_odx;
use App\Models\D_cht;
use App\Models\D_cha;
use App\Models\D_oop;
use App\Models\D_claim;
use App\Models\D_adp;
use App\Models\D_dru;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_aer;
use App\Models\D_irf;
use App\Models\D_lgo_801;
use App\Models\D_ucep24_main;
use App\Models\D_ucep24;
use App\Models\Acc_ucep24; 
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr; 
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
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;
use App\Models\D_claim_db_hipdata_code;

class Lgo801Controller extends Controller
{ 
    public function lgo_801(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate == '') {  
            
        } else {
                $iduser = Auth::user()->id;
                D_lgo_801::truncate(); 
                D_dru_out::truncate();
                $data_main_ = DB::connection('mysql2')->select(' 
                    SELECT v.vn,o.an,v.cid,v.hn,concat(pt.pname,pt.fname," ",pt.lname) ptname
                        ,v.vstdate,v.pttype 
                        ,rd.amount AS price_lgo,v.income,ptt.hipdata_code  
                        FROM vn_stat v
                        LEFT OUTER JOIN patient pt ON v.hn=pt.hn
                        LEFT OUTER JOIN ovstdiag ov ON v.vn=ov.vn
                        LEFT OUTER JOIN ovst o ON v.vn=o.vn
                        LEFT OUTER JOIN opdscreen op ON v.vn = op.vn
                        LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype 
                        LEFT OUTER JOIN rcpt_debt rd ON v.vn=rd.vn 
                        LEFT OUTER JOIN ipt i on i.vn = v.vn 
                        WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        AND v.pttype in ("L1","L2","L3","L4","l5","l6") 
                        AND v.uc_money >"0"
                        AND o.an is null
                        AND v.pdx <> ""
                        GROUP BY v.vn;  
                ');   
                // AND v.pttype not in ("OF","FO")               
                foreach ($data_main_ as $key => $value) {    
                    D_lgo_801::insert([
                            'vn'                 => $value->vn,
                            'hn'                 => $value->hn,
                            'an'                 => $value->an, 
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate, 
                            'price_lgo'          => $value->income, 
                        ]);
                    $check = D_claim::where('vn',$value->vn)->count();
                    if ($check > 0) {
                        # code...
                    } else {
                        D_claim::insert([
                            'vn'                => $value->vn,
                            'hn'                => $value->hn,
                            'an'                => $value->an,
                            'cid'               => $value->cid,
                            'pttype'            => $value->pttype,
                            'ptname'            => $value->ptname,
                            'vstdate'           => $value->vstdate,
                            'hipdata_code'      => $value->hipdata_code,
                            // 'qty'               => $value->qty,
                            'sum_price'          => $value->income,
                            'type'              => 'OPD',
                            'nhso_adp_code'     => 'LGO_801',
                            'claimdate'         => $date, 
                            'userid'            => $iduser, 
                        ]);
                    }  

               
                    $data_dru_ = DB::connection('mysql2')->select('
                        SELECT vv.hcode HCODE ,v.hn HN ,v.an AN ,vv.spclty CLINIC ,vv.cid PERSON_ID ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
                            ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,v.qty AMOUNT ,round(v.unitprice,2) DRUGPRIC
                            ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                            ,oo.presc_reason DRUGREMARK ,oo.nhso_authorize_code PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                            ,"" TOTAL ,"" as SIGCODE ,"" as SIGTEXT ,""  PROVIDER,v.vstdate
                            FROM opitemrece v
                            LEFT OUTER JOIN drugitems d on d.icode = v.icode
                            LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                            LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode                
                        WHERE v.vn IN("'.$value->vn.'")
                        AND d.did is not null 
                        GROUP BY v.vn,did

                        UNION all

                        SELECT pt.hcode HCODE ,v.hn HN ,v.an AN ,v1.spclty CLINIC ,pt.cid PERSON_ID ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                            ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,sum(v.qty) AMOUNT ,round(v.unitprice,2) DRUGPRIC
                            ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                            ,oo.presc_reason DRUGREMARK ,oo.nhso_authorize_code PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                            ,"" TOTAL,"" as SIGCODE,"" as SIGTEXT,""  PROVIDER,v.vstdate
                            FROM opitemrece v
                            LEFT OUTER JOIN drugitems d on d.icode = v.icode
                            LEFT OUTER JOIN patient pt  on v.hn = pt.hn
                            INNER JOIN ipt v1 on v1.an = v.an
                            LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode                 
                        WHERE v1.vn IN("'.$value->vn.'")
                        AND d.did is not null AND v.qty<>"0"
                        GROUP BY v.an,d.icode,USE_STATUS;              
                    ');
            
                    foreach ($data_dru_ as $va_14) {
                        
                        D_dru_out::insert([ 
                            'vstdate'        => $va_14->vstdate, 
                            'HN'             => $va_14->HN, 
                            'PERSON_ID'      => $va_14->PERSON_ID, 
                            'DID'            => $va_14->DID,
                            'DIDNAME'        => $va_14->DIDNAME, 
                            'AMOUNT'         => $va_14->AMOUNT,
                            'DRUGPRIC'       => $va_14->DRUGPRIC,
                            'DRUGCOST'       => $va_14->DRUGCOST,
                            'DIDSTD'         => $va_14->DIDSTD,
                            'UNIT'           => $va_14->UNIT,
                            'UNIT_PACK'      => $va_14->UNIT_PACK,
                            'SEQ'            => $va_14->SEQ,
                            'DRUGREMARK'     => $va_14->DRUGREMARK,
                            'PA_NO'          => $va_14->PA_NO 
                        ]);
                    } 
                    
                   
                    
                }

                // $data_maindb_ = DB::connection('mysql2')->select(' 
                //         SELECT count(distinct v.vn) as vn
                //         ,count(distinct o.an) as an,day(v.vstdate) as days,o.vstdate,ptt.hipdata_code
                //           ,month(v.vstdate) as months,year(v.vstdate) as year,SUM(v.income) as income
                //         FROM hos.vn_stat v
                //         LEFT OUTER JOIN hos.patient pt ON v.hn=pt.hn
                //         LEFT OUTER JOIN hos.ovstdiag ov ON v.vn=ov.vn
                //         LEFT OUTER JOIN hos.ovst o ON v.vn=o.vn
                //         LEFT OUTER JOIN hos.opdscreen op ON v.vn = op.vn
                //         LEFT OUTER JOIN hos.pttype ptt ON v.pttype=ptt.pttype 
                //         LEFT OUTER JOIN hos.rcpt_debt rd ON v.vn=rd.vn
                //         LEFT OUTER JOIN hos.hpc11_ktb_approval hh on hh.pid = pt.cid and hh.transaction_date = v.vstdate 
                //         LEFT OUTER JOIN hos.ipt i on i.vn = v.vn
                        
                //         WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //         AND v.pttype in ("L1","L2","L3","L4","L5")  
                //         and v.uc_money >"0"
                //         AND o.an is null
                //         AND v.pdx <> ""
                //         GROUP BY days; 
                // ');  
                // foreach ($data_maindb_ as $key => $val2) {  
                //     $data_max_ = D_claim_db_hipdata_code::where('vstdate',$val2->vstdate)->where('hipdata_code',$val2->hipdata_code)->count();
                //     if ($data_max_ >0) {
                //         # code...
                //     } else {
                //         D_claim_db_hipdata_code::insert([ 
                //             'vstdate'            => $val2->vstdate, 
                //             'mo'                 => $val2->months,
                //             'ye'                 => $val2->year,
                //             'vn'                 => $val2->vn, 
                //             'an'                 => $val2->an,
                //             'income_vn'          => $val2->income, 
                //             'hipdata_code'       => $val2->hipdata_code  
                //         ]);
                //     }
                // }
                               
        }

        $data['d_lgo_801'] = DB::connection('mysql')->select('SELECT * from d_lgo_801');  
        $data['data_opd'] = DB::connection('mysql')->select('SELECT * from d_opd WHERE d_anaconda_id ="LGO_801"'); 
        $data['data_orf'] = DB::connection('mysql')->select('SELECT * from d_orf WHERE d_anaconda_id ="LGO_801"'); 
        $data['data_oop'] = DB::connection('mysql')->select('SELECT * from d_oop WHERE d_anaconda_id ="LGO_801"');
        $data['data_odx'] = DB::connection('mysql')->select('SELECT * from d_odx WHERE d_anaconda_id ="LGO_801"');
        $data['data_idx'] = DB::connection('mysql')->select('SELECT * from d_idx WHERE d_anaconda_id ="LGO_801"');
        $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from d_ipd WHERE d_anaconda_id ="LGO_801"');
        $data['data_irf'] = DB::connection('mysql')->select('SELECT * from d_irf WHERE d_anaconda_id ="LGO_801"');
        $data['data_aer'] = DB::connection('mysql')->select('SELECT * from d_aer WHERE d_anaconda_id ="LGO_801"');
        $data['data_iop'] = DB::connection('mysql')->select('SELECT * from d_iop WHERE d_anaconda_id ="LGO_801"');
        $data['data_adp'] = DB::connection('mysql')->select('SELECT * from d_adp WHERE d_anaconda_id ="LGO_801"');
        $data['data_pat'] = DB::connection('mysql')->select('SELECT * from d_pat WHERE d_anaconda_id ="LGO_801"');
        $data['data_cht'] = DB::connection('mysql')->select('SELECT * from d_cht WHERE d_anaconda_id ="LGO_801"');
        $data['data_cha'] = DB::connection('mysql')->select('SELECT * from d_cha WHERE d_anaconda_id ="LGO_801"');
        $data['data_ins'] = DB::connection('mysql')->select('SELECT * from d_ins WHERE d_anaconda_id ="LGO_801"');
        $data['data_dru'] = DB::connection('mysql')->select('SELECT * from d_dru WHERE d_anaconda_id ="LGO_801"');

        return view('lgo.lgo_801',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }
    public function lgo_801_process_old(Request $request)
    { 
        $data_vn_1 = DB::connection('mysql')->select('SELECT vn,an from pkbackoffice.d_lgo_801');
        $iduser = Auth::user()->id; 
        D_opd::where('d_anaconda_id','=','LGO_801')->delete();
        D_orf::where('d_anaconda_id','=','LGO_801')->delete();
        D_oop::where('d_anaconda_id','=','LGO_801')->delete();
        D_odx::where('d_anaconda_id','=','LGO_801')->delete();
        D_idx::where('d_anaconda_id','=','LGO_801')->delete();
        D_ipd::where('d_anaconda_id','=','LGO_801')->delete();
        D_irf::where('d_anaconda_id','=','LGO_801')->delete();
        D_aer::where('d_anaconda_id','=','LGO_801')->delete();
        D_iop::where('d_anaconda_id','=','LGO_801')->delete();
        D_adp::where('d_anaconda_id','=','LGO_801')->delete();   
        D_dru::where('d_anaconda_id','=','LGO_801')->delete();   
        D_pat::where('d_anaconda_id','=','LGO_801')->delete();
        D_cht::where('d_anaconda_id','=','LGO_801')->delete();
        D_cha::where('d_anaconda_id','=','LGO_801')->delete();
        D_ins::where('d_anaconda_id','=','LGO_801')->delete();
        // D_opd::truncate();
        // D_orf::truncate();
        // D_oop::truncate();
        // D_odx::truncate();
        // D_idx::truncate();
        // D_ipd::truncate();
        // D_irf::truncate();
        // D_aer::truncate();
        // D_iop::truncate();
        // D_adp::truncate();  
        // D_dru::truncate();   
        // D_pat::truncate();
        // D_cht::truncate();
        // D_cha::truncate();
        // D_ins::truncate();

         foreach ($data_vn_1 as $key => $va1) {
                //D_ins OK
                $data_ins_ = DB::connection('mysql2')->select('
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
                    
                    ,c.claimcode PERMITNO
                    ,"" DOCNO
                    ,"" OWNRPID 
                    ,"" OWNRNAME
                    ,i.an AN
                    ,v.vn SEQ
                    ,"" SUBINSCL 
                    ,"" RELINSCL
                    ,"2" HTYPE
                    from vn_stat v
                    LEFT JOIN pttype p on p.pttype = v.pttype
                    LEFT JOIN ipt i on i.vn = v.vn 
                    LEFT JOIN pttype pp on pp.pttype = i.pttype
                    left join ipt_pttype ap on ap.an = i.an
                    left join visit_pttype vp on vp.vn = v.vn
                    LEFT JOIN rcpt_debt r on r.vn = v.vn
                    left join patient px on px.hn = v.hn 
                    LEFT OUTER JOIN pkbackoffice.check_authen c On c.cid = v.cid AND c.vstdate = v.vstdate
                    WHERE v.vn IN("'.$va1->vn.'")   
                ');
                // ,ifnull(if(i.an is null,vp.claim_code or vp.auth_code,ap.claim_code),r.sss_approval_code) PERMITNO
                foreach ($data_ins_ as $va17) {
                    D_ins::insert([
                        'HN'                => $va17->HN,
                        'INSCL'             => $va17->INSCL,
                        'SUBTYPE'           => $va17->SUBTYPE,
                        'CID'               => $va17->CID,
                        'DATEIN'            => $va17->DATEIN, 
                        'DATEEXP'           => $va17->DATEEXP,
                        'HOSPMAIN'          => $va17->HOSPMAIN, 
                        'HOSPSUB'           => $va17->HOSPSUB,
                        'GOVCODE'           => $va17->GOVCODE,
                        'GOVNAME'           => $va17->GOVNAME,
                        'PERMITNO'          => $va17->PERMITNO,
                        'DOCNO'             => $va17->DOCNO,
                        'OWNRPID'           => $va17->OWNRPID,
                        'OWNRNAME'          => $va17->OWNRNAME,
                        'AN'                => $va17->AN,
                        'SEQ'               => $va17->SEQ,
                        'SUBINSCL'          => $va17->SUBINSCL,
                        'RELINSCL'          => $va17->RELINSCL,
                        'HTYPE'             => $va17->HTYPE,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_pat OK
                $data_pat_ = DB::connection('mysql2')->select('
                    SELECT v.hcode HCODE
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
                        from vn_stat v
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN ipt i on i.vn = v.vn 
                        LEFT JOIN patient pt on pt.hn = v.hn 
                        WHERE v.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_pat_ as $va14) {
                    D_pat::insert([
                        'HCODE'              => $va14->HCODE,
                        'HN'                 => $va14->HN,
                        'CHANGWAT'           => $va14->CHANGWAT,
                        'AMPHUR'             => $va14->AMPHUR,
                        'DOB'                => $va14->DOB,
                        'SEX'                => $va14->SEX,
                        'MARRIAGE'           => $va14->MARRIAGE,
                        'OCCUPA'             => $va14->OCCUPA,
                        'NATION'             => $va14->NATION,
                        'PERSON_ID'          => $va14->PERSON_ID,
                        'NAMEPAT'            => $va14->NAMEPAT,
                        'TITLE'              => $va14->TITLE,
                        'FNAME'              => $va14->FNAME,
                        'LNAME'              => $va14->LNAME,
                        'IDTYPE'             => $va14->IDTYPE,
                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 'LGO_801'
                    ]);
                }
                //D_opd OK
                $data_opd = DB::connection('mysql2')->select('
                        SELECT  v.hn HN
                        ,v.spclty CLINIC
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD
                        ,v.vn SEQ
                        ,"1" UUC ,"" DETAIL,""BTEMP,""SBP,""DBP,""PR,""RR,""OPTYPE,""TYPEIN,""TYPEOUT
                        from hos.vn_stat v
                        LEFT OUTER JOIN hos.ovst o on o.vn = v.vn
                        LEFT OUTER JOIN hos.pttype p on p.pttype = v.pttype
                        LEFT OUTER JOIN hos.ipt i on i.vn = v.vn
                        LEFT OUTER JOIN hos.patient pt on pt.hn = v.hn
                        WHERE v.vn IN("'.$va1->vn.'")                  
                '); 
                foreach ($data_opd as $val3) {       
                    D_opd::insert([
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
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_orf _OK
                $data_orf_ = DB::connection('mysql2')->select('
                        SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,v.spclty CLINIC
                        ,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                        ,"0100" REFERTYPE
                        ,v.vn SEQ ,"" REFERDATE
                        from hos.vn_stat v 
                        LEFT OUTER JOIN hos.referin r1 on r1.vn = v.vn
                        LEFT OUTER JOIN hos.referout r2 on r2.vn = v.vn
                        WHERE v.vn IN("'.$va1->vn.'") 
                        and (r1.vn is not null or r2.vn is not null);
                ');                
                foreach ($data_orf_ as $va4) {       
                    D_orf::insert([
                        'HN'                => $va4->HN,
                        'CLINIC'            => $va4->CLINIC,
                        'DATEOPD'           => $va4->DATEOPD,
                        'REFER'             => $va4->REFER,
                        'SEQ'               => $va4->SEQ,
                        'REFERTYPE'         => $va4->REFERTYPE, 
                        'REFERDATE'         => $va4->REFERDATE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                 // D_odx OK
                 $data_odx_ = DB::connection('mysql2')->select('
                        SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                        ,v.spclty CLINIC

                        ,CASE 
                        WHEN o.diagtype = "1" THEN o.icd10
                        WHEN o.diagtype = "2" THEN o.icd10
                        WHEN o.diagtype = "3" THEN o.icd10
                        WHEN o.diagtype = "4" THEN o.icd10
                        WHEN o.diagtype = "5" THEN o.icd10
                        ELSE v.main_pdx
                        END as DIAG

                        ,o.diagtype DXTYPE
                        ,CASE 
                        WHEN d.licenseno IS NULL THEN ""
                        WHEN d.licenseno LIKE "-%" THEN "ว69577"
                        WHEN d.licenseno LIKE "พ%" THEN "ว33980" 
                        ELSE "ว33985" 
                        END as DRDX
                        ,v.cid PERSON_ID
                        ,v.vn SEQ 
                        from ovstdiag o 
                        LEFT OUTER JOIN icd9cm1 i on i.code = o.icd10
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        LEFT OUTER JOIN vn_stat v on v.vn = o.vn
                        WHERE o.vn IN("'.$va1->vn.'")
                        GROUP BY v.vn,o.diagtype 
                ');
                // SELECT v.hn HN
                //         ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                //         ,v.spclty CLINIC
                //         ,o.icd10 DIAG
                //         ,o.diagtype DXTYPE
                //         ,CASE 
                //         WHEN d.licenseno IS NULL THEN ""
                //         WHEN d.licenseno LIKE "-%" THEN "ว69577"
                //         WHEN d.licenseno LIKE "พ%" THEN "ว33980" 
                //         ELSE "ว33985" 
                //         END as DRDX
                //         ,v.cid PERSON_ID
                //         ,v.vn SEQ 
                //         from vn_stat v
                //         LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                //         LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                //         LEFT OUTER JOIN icd101 i on i.code = o.icd10
                //         WHERE v.vn IN("'.$va1->vn.'")
                //         GROUP BY v.vn,o.diagtype 
                foreach ($data_odx_ as $va5) { 
                    D_odx::insert([
                        'HN'                => $va5->HN,
                        'CLINIC'            => $va5->CLINIC,
                        'DATEDX'            => $va5->DATEDX,
                        'DIAG'              => $va5->DIAG,
                        'DXTYPE'            => $va5->DXTYPE,
                        'DRDX'              => $va5->DRDX,
                        'PERSON_ID'         => $va5->PERSON_ID, 
                        'SEQ'               => $va5->SEQ, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                    
                }
                 //D_oop OK
                 $data_oop_ = DB::connection('mysql2')->select('
                        SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,v.spclty CLINIC
                        ,o.icd10 OPER 
                        ,CASE 
                        WHEN d.licenseno IS NULL THEN "ว33980"
                        WHEN d.licenseno LIKE "-%" THEN "ว69577"
                        WHEN d.licenseno LIKE "พ%" THEN "ว33985" 
                        ELSE "ว33985" 
                        END as DROPID
                        ,pt.cid PERSON_ID
                        ,v.vn SEQ ,""SERVPRICE
                        from hos.vn_stat v
                        LEFT OUTER JOIN hos.ovstdiag o on o.vn = v.vn
                        LEFT OUTER JOIN hos.patient pt on v.hn=pt.hn
                        LEFT OUTER JOIN hos.doctor d on d.`code` = o.doctor
                        LEFT OUTER JOIN hos.icd9cm1 i on i.code = o.icd10
                        WHERE v.vn IN("'.$va1->vn.'")
                        AND substring(o.icd10,1,1) in ("0","1","2","3","4","5","6","7","8","9")
                        GROUP BY v.vn
                ');
                foreach ($data_oop_ as $va6) { 
                    D_oop::insert([
                        'HN'                => $va6->HN,
                        'CLINIC'            => $va6->CLINIC,
                        'DATEOPD'           => $va6->DATEOPD,
                        'OPER'              => $va6->OPER,
                        'DROPID'            => $va6->DROPID,
                        'PERSON_ID'         => $va6->PERSON_ID, 
                        'SEQ'               => $va6->SEQ, 
                        'SERVPRICE'         => $va6->SERVPRICE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                    
                }
                //D_ipd OK
                $data_ipd_ = DB::connection('mysql2')->select('
                        SELECT a.hn HN,a.an AN
                        ,DATE_FORMAT(o.regdate,"%Y%m%d") DATEADM
                        ,Time_format(o.regtime,"%H%i") TIMEADM
                        ,DATE_FORMAT(o.dchdate,"%Y%m%d") DATEDSC
                        ,Time_format(o.dchtime,"%H%i")  TIMEDSC
                        ,right(o.dchstts,1) DISCHS
                        ,right(o.dchtype,1) DISCHT
                        ,o.ward WARDDSC,o.spclty DEPT
                        ,format(o.bw/1000,3) ADM_W
                        ,"1" UUC ,"I" SVCTYPE 
                        FROM hos.an_stat a
                        LEFT OUTER JOIN hos.ipt o on o.an = a.an
                        LEFT OUTER JOIN hos.pttype p on p.pttype = a.pttype
                        LEFT OUTER JOIN hos.patient pt on pt.hn = a.hn 
                        WHERE  o.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_ipd_ as $va13) {     
                    D_ipd::insert([
                        'AN'                => $va13->AN,
                        'HN'                => $va13->HN,
                        'DATEADM'           => $va13->DATEADM,
                        'TIMEADM'           => $va13->TIMEADM,
                        'DATEDSC'           => $va13->DATEDSC,
                        'TIMEDSC'           => $va13->TIMEDSC,
                        'DISCHS'            => $va13->DISCHS,
                        'DISCHT'            => $va13->DISCHT, 
                        'DEPT'              => $va13->DEPT, 
                        'ADM_W'             => $va13->ADM_W, 
                        'UUC'               => $va13->UUC, 
                        'SVCTYPE'           => $va13->SVCTYPE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                
                 //D_irf OK
                 $data_irf_ = DB::connection('mysql2')->select('
                    SELECT a.an AN
                        ,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER
                        ,"0100" REFERTYPE 
                        FROM hos.an_stat a
                        LEFT OUTER JOIN hos.referout o on o.vn =a.an
                        LEFT OUTER JOIN hos.referin oo on oo.vn =a.an
                        LEFT OUTER JOIN hos.ipt ip on ip.an = a.an 
                        WHERE ip.vn IN("'.$va1->vn.'")  
                        and (a.an in(select vn from hos.referin where vn = oo.vn) or a.an in(select vn from hos.referout where vn = o.vn)); 
                ');
                foreach ($data_irf_ as $va12) {
                    D_irf::insert([
                        'AN'                 => $va12->AN,
                        'REFER'              => $va12->REFER,
                        'REFERTYPE'          => $va12->REFERTYPE,
                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 'LGO_801',
                    ]);                     
                }                 
                //D_idx OK 
                $data_idx_ = DB::connection('mysql2')->select('
                    SELECT v.an AN,o.icd10 DIAG
                        ,o.diagtype DXTYPE 
                        ,CASE 
                        WHEN d.licenseno IS NULL THEN ""
                        WHEN d.licenseno LIKE "-%" THEN "ว69577"
                        WHEN d.licenseno LIKE "พ%" THEN "ว33980" 
                        ELSE "ว33985" 
                        END as DRDX
                        from an_stat v
                        LEFT OUTER JOIN iptdiag o on o.an = v.an
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        LEFT OUTER JOIN ipt ip on ip.an = v.an
                        INNER JOIN icd101 i on i.code = o.icd10
                        WHERE ip.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_idx_ as $va7) { 
                    D_idx::insert([
                        'AN'                => $va7->AN,  
                        'DIAG'              => $va7->DIAG,
                        'DXTYPE'            => $va7->DXTYPE,
                        'DRDX'              => $va7->DRDX, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                            
                }
                //D_iop OK
                $data_iop_ = DB::connection('mysql2')->select('
                    SELECT v.an AN
                    ,o.icd9 OPER
                    ,o.oper_type as OPTYPE 
                    ,CASE 
                    WHEN d.licenseno IS NULL THEN ""
                    WHEN d.licenseno LIKE "-%" THEN "ว69577"
                    WHEN d.licenseno LIKE "พ%" THEN "ว33985" 
                    ELSE "ว33985" 
                    END as DROPID
                    ,DATE_FORMAT(o.opdate,"%Y%m%d") DATEIN
                    ,Time_format(o.optime,"%H%i") TIMEIN
                    ,DATE_FORMAT(o.enddate,"%Y%m%d") DATEOUT
                    ,Time_format(o.endtime,"%H%i") TIMEOUT
                    FROM an_stat v
                    LEFT OUTER JOIN iptoprt o on o.an = v.an
                    LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                    INNER JOIN icd9cm1 i on i.code = o.icd9
                    LEFT OUTER JOIN ipt ip on ip.an = v.an
                    WHERE ip.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_iop_ as $va9) {
                    D_iop::insert([
                        'AN'                => $va9->AN,
                        'OPER'              => $va9->OPER,
                        'OPTYPE'            => $va9->OPTYPE,
                        'DROPID'            => $va9->DROPID,
                        'DATEIN'            => $va9->DATEIN,
                        'TIMEIN'            => $va9->TIMEIN,
                        'DATEOUT'           => $va9->DATEOUT,
                        'TIMEOUT'           => $va9->TIMEOUT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_cht OK
                $data_cht_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                    ,v.an AN
                    ,DATE_FORMAT(if(a.an is null,v.vstdate,a.dchdate),"%Y%m%d") DATE
                    ,round(if(a.an is null,vv.income,a.income),2) TOTAL
                    ,round(if(a.an is null,vv.paid_money,a.paid_money),2) PAID
                    ,if(vv.paid_money >"0" or a.paid_money >"0","10",pt.pcode) PTTYPE
                    ,pp.cid PERSON_ID 
                    ,v.vn SEQ,""OPD_MEMO,""INVOICE_NO,""INVOICE_LT
                    from ovst v
                    LEFT JOIN vn_stat vv on vv.vn = v.vn
                    LEFT JOIN an_stat a on a.an = v.an
                    LEFT JOIN patient pp on pp.hn = v.hn
                    LEFT JOIN pttype pt on pt.pttype = vv.pttype or pt.pttype=a.pttype
                    LEFT JOIN pttype p on p.pttype = a.pttype 
                    WHERE v.vn IN("'.$va1->vn.'")  
                    
                ');
                foreach ($data_cht_ as $va15) {
                    D_cht::insert([
                        'HN'                => $va15->HN,
                        'AN'                => $va15->AN,
                        'DATE'              => $va15->DATE,
                        'TOTAL'             => $va15->TOTAL,
                        'PAID'              => $va15->PAID,
                        'PTTYPE'            => $va15->PTTYPE,
                        'PERSON_ID'         => $va15->PERSON_ID,
                        'SEQ'               => $va15->SEQ,
                        'OPD_MEMO'          => $va15->OPD_MEMO,
                        'INVOICE_NO'        => $va15->INVOICE_NO,
                        'INVOICE_LT'        => $va15->INVOICE_LT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_cha OK
                $data_cha_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                        ,if(v1.an is null,"",v1.an) AN 
                        ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                        ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                        ,round(sum(v.sum_price),2) AMOUNT
                        ,p.cid PERSON_ID 
                        ,ifnull(v.vn,v.an) SEQ
                        from opitemrece v
                        LEFT JOIN vn_stat vv on vv.vn = v.vn
                        LEFT JOIN patient p on p.hn = v.hn
                        LEFT JOIN ipt v1 on v1.an = v.an
                        LEFT JOIN income i on v.income=i.income
                        LEFT JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                        LEFT JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id  
                        WHERE v.vn IN("'.$va1->vn.'") 
                        group by v.vn,CHRGITEM
                        union all
                        SELECT v.hn HN
                        ,v1.an AN 
                        ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                        ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                        ,round(sum(v.sum_price),2) AMOUNT
                        ,p.cid PERSON_ID 
                        ,ifnull(v.vn,v.an) SEQ
                        from opitemrece v
                        LEFT JOIN vn_stat vv on vv.vn = v.vn
                        LEFT JOIN patient p on p.hn = v.hn
                        LEFT JOIN ipt v1 on v1.an = v.an
                        LEFT JOIN income i on v.income=i.income
                        LEFT JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                        LEFT JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id 
                        WHERE v1.vn IN("'.$va1->vn.'")  
                        group by v.an,CHRGITEM; 
                ');
                foreach ($data_cha_ as $va16) {
                    D_cha::insert([
                        'HN'                => $va16->HN,
                        'AN'                => $va16->AN,
                        'DATE'              => $va16->DATE,
                        'CHRGITEM'          => $va16->CHRGITEM,
                        'AMOUNT'            => $va16->AMOUNT, 
                        'PERSON_ID'         => $va16->PERSON_ID,
                        'SEQ'               => $va16->SEQ, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                } 
                 //D_aer OK
                $data_aer_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                        ,i.an AN
                        ,v.vstdate DATEOPD
                        ,c.claimcode AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI
                        ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ
                        ,"" AESTATUS,"" DALERT,"" TALERT
                        from vn_stat v
                        LEFT OUTER JOIN ipt i on i.vn = v.vn
                        LEFT OUTER JOIN visit_pttype vv on vv.vn = v.vn
                        LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                        LEFT OUTER JOIN pkbackoffice.check_authen c On c.cid = v.cid AND c.vstdate = v.vstdate
                        WHERE v.vn IN("'.$va1->vn.'") and i.an is null
                        GROUP BY v.vn
                        union all
                        SELECT v.hn HN
                        ,v.an AN
                        ,v.dchdate DATEOPD
                        ,c.claimcode AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI
                        ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,"" SEQ
                        ,"" AESTATUS,"" DALERT,"" TALERT
                         from an_stat v
                        LEFT OUTER JOIN ipt_pttype vv on vv.an = v.an
                        LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype 
                        LEFT OUTER JOIN ipt i on i.an =v.an
                        LEFT OUTER JOIN vn_stat vs on vs.vn =v.vn
                        LEFT OUTER JOIN pkbackoffice.check_authen c On c.cid = vs.cid AND c.vstdate = vs.vstdate
                        WHERE v.an IN("'.$va1->an.'")
                        group by v.an; 
                ');
                foreach ($data_aer_ as $va8) {
                    D_aer::insert([
                        'HN'                => $va8->HN,
                        'AN'                => $va8->AN,
                        'DATEOPD'           => $va8->DATEOPD,
                        'AUTHAE'            => $va8->AUTHAE,
                        'AEDATE'            => $va8->AEDATE,
                        'AETIME'            => $va8->AETIME,
                        'AETYPE'            => $va8->AETYPE,
                        'REFER_NO'          => $va8->REFER_NO,
                        'REFMAINI'          => $va8->REFMAINI,
                        'IREFTYPE'          => $va8->IREFTYPE,
                        'REFMAINO'          => $va8->REFMAINO,
                        'OREFTYPE'          => $va8->OREFTYPE,
                        'UCAE'              => $va8->UCAE,
                        'SEQ'               => $va8->SEQ,
                        'AESTATUS'          => $va8->AESTATUS,
                        'DALERT'            => $va8->DALERT,
                        'TALERT'            => $va8->TALERT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                 
                //D_adp
                $data_adp_ = DB::connection('mysql2')->select('
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER
                        ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,icode ,vstdate
                        from
                        (SELECT v.hn HN
                        ,if(v.an is null,"",v.an) AN
                        ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
                        ,n.nhso_adp_type_id TYPE
                        ,n.nhso_adp_code CODE 
                        ,sum(v.QTY) QTY
                        ,round(v.unitprice,2) RATE
                        ,if(v.an is null,v.vn,"") SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC
                        ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,v.icode,v.vstdate
                        from hos.opitemrece v
                        JOIN hos.s_drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                        LEFT JOIN hos.income ic ON ic.income = n.income
                        left join hos.ipt i on i.an = v.an
                        AND i.an is not NULL 
                        WHERE i.vn IN("'.$va1->vn.'")
                        GROUP BY i.vn,n.nhso_adp_code,rate) a 
                        GROUP BY an,CODE,rate
                        UNION
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER
                        ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,icode ,vstdate
                        from
                        (SELECT v.hn HN
                        ,if(v.an is null,"",v.an) AN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,n.nhso_adp_type_id TYPE
                        ,n.nhso_adp_code CODE 
                        ,sum(v.QTY) QTY
                        ,round(v.unitprice,2) RATE
                        ,if(v.an is null,v.vn,"") SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER
                        ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,v.icode,v.vstdate
                        from hos.opitemrece v
                        JOIN hos.s_drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                        LEFT JOIN hos.income ic ON ic.income = n.income
                        left join hos.vn_stat vv on vv.vn = v.vn
                        WHERE vv.vn IN("'.$va1->vn.'")
                        AND v.an is NULL
                        GROUP BY vv.vn,n.nhso_adp_code,rate) b 
                        GROUP BY seq,CODE,rate;
                '); 
                foreach ($data_adp_ as $va10) {
                    d_adp::insert([
                        'HN'                   => $va10->HN,
                        'AN'                   => $va10->AN,
                        'DATEOPD'              => $va10->DATEOPD,
                        'TYPE'                 => $va10->TYPE,
                        'CODE'                 => $va10->CODE,
                        'QTY'                  => $va10->QTY,
                        'RATE'                 => $va10->RATE,
                        'SEQ'                  => $va10->SEQ,
                        'CAGCODE'              => $va10->CAGCODE,
                        'DOSE'                 => $va10->DOSE,
                        'CA_TYPE'              => $va10->CA_TYPE,
                        'SERIALNO'             => $va10->SERIALNO,
                        'TOTCOPAY'             => $va10->TOTCOPAY,
                        'USE_STATUS'           => $va10->USE_STATUS,
                        'TOTAL'                => $va10->TOTAL,
                        'QTYDAY'               => $va10->QTYDAY,
                        'TMLTCODE'             => $va10->TMLTCODE,
                        'STATUS1'              => $va10->STATUS1,
                        'BI'                   => $va10->BI,
                        'CLINIC'               => $va10->CLINIC,
                        'ITEMSRC'              => $va10->ITEMSRC,
                        'PROVIDER'             => $va10->PROVIDER,
                        'GRAVIDA'              => $va10->GRAVIDA,
                        'GA_WEEK'              => $va10->GA_WEEK,
                        'DCIP'                 => $va10->DCIP,
                        'LMP'                  => $va10->LMP,
                        'SP_ITEM'              => $va10->SP_ITEM,
                        'icode'                => $va10->icode,
                        'vstdate'              => $va10->vstdate,
                        'user_id'              => $iduser,
                        'd_anaconda_id'        => 'LGO_801'
                    ]);
                } 
                 //D_dru OK
                 $data_dru_ = DB::connection('mysql2')->select('
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
                        ,"" TOTAL,""SIGCODE,"" SIGTEXT,""  PROVIDER,v.vstdate
                        FROM opitemrece v
                        LEFT OUTER JOIN drugitems d on d.icode = v.icode
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
                
                    WHERE v.vn IN("'.$va1->vn.'")
                    AND d.did is not null 
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
                        ,v.vn SEQ
                        ,oo.presc_reason DRUGREMARK
                        ,"" PA_NO
                        ,"" TOTCOPAY
                        ,if(v.item_type="H","2","1") USE_STATUS
                        ,"" TOTAL,""SIGCODE,"" SIGTEXT,""  PROVIDER,v.vstdate
                        FROM opitemrece v
                        LEFT OUTER JOIN drugitems d on d.icode = v.icode
                        LEFT OUTER JOIN patient pt  on v.hn = pt.hn
                        INNER JOIN ipt v1 on v1.an = v.an
                        LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
                
                    WHERE v1.vn IN("'.$va1->vn.'")
                    AND d.did is not null AND v.qty<>"0"
                    GROUP BY v.an,d.icode,USE_STATUS;              
                ');
              
                foreach ($data_dru_ as $va11) {
                    D_dru::insert([ 
                        'HN'             => $va11->HN,
                        'CLINIC'         => $va11->CLINIC,
                        'HCODE'          => $va11->HCODE,
                        'AN'             => $va11->AN,
                        'PERSON_ID'      => $va11->PERSON_ID,
                        'DATE_SERV'      => $va11->DATE_SERV,
                        'DID'            => $va11->DID,
                        'DIDNAME'        => $va11->DIDNAME, 
                        'AMOUNT'         => $va11->AMOUNT,
                        'DRUGPRIC'       => $va11->DRUGPRIC,
                        'DRUGCOST'       => $va11->DRUGCOST,
                        'DIDSTD'         => $va11->DIDSTD,
                        'UNIT'           => $va11->UNIT,
                        'UNIT_PACK'      => $va11->UNIT_PACK,
                        'SEQ'            => $va11->SEQ,
                        'DRUGREMARK'     => $va11->DRUGREMARK,
                        'PA_NO'          => $va11->PA_NO,
                        'TOTCOPAY'       => $va11->TOTCOPAY,
                        // 'TOTCOPAY'       => '01',
                        'USE_STATUS'     => $va11->USE_STATUS,
                        'TOTAL'          => $va11->TOTAL,  
                        // 'TOTAL'          => '01',
                        'SIGCODE'        => $va11->SIGCODE,                      
                        'SIGTEXT'        => $va11->SIGTEXT,
                        'PROVIDER'       => $va11->PROVIDER,
                        'vstdate'        => $va11->vstdate,   
                        'user_id'        => $iduser,
                        'd_anaconda_id'  => 'LGO_801'
                    ]);
                } 
                
                 
                 
              
         }
         
         D_adp::where('CODE','=','XXXXXX')->delete();
         // return back();
         return response()->json([
             'status'    => '200'
         ]);
    }
    public function lgo_801_process(Request $request)
    { 
        $data_vn_1 = DB::connection('mysql')->select('SELECT vn,an from d_lgo_801');
        $iduser = Auth::user()->id; 
        // D_opd::where('d_anaconda_id','=','LGO_801')->delete();
        // D_orf::where('d_anaconda_id','=','LGO_801')->delete();
        // D_oop::where('d_anaconda_id','=','LGO_801')->delete();
        // D_odx::where('d_anaconda_id','=','LGO_801')->delete();
        // D_idx::where('d_anaconda_id','=','LGO_801')->delete();
        // D_ipd::where('d_anaconda_id','=','LGO_801')->delete();
        // D_irf::where('d_anaconda_id','=','LGO_801')->delete();
        // D_aer::where('d_anaconda_id','=','LGO_801')->delete();
        // D_iop::where('d_anaconda_id','=','LGO_801')->delete();
        // D_adp::where('d_anaconda_id','=','LGO_801')->delete();   
        // D_dru::where('d_anaconda_id','=','LGO_801')->delete();   
        // D_pat::where('d_anaconda_id','=','LGO_801')->delete();
        // D_cht::where('d_anaconda_id','=','LGO_801')->delete();
        // D_cha::where('d_anaconda_id','=','LGO_801')->delete();
        // D_ins::where('d_anaconda_id','=','LGO_801')->delete();
        D_opd::truncate();
        D_orf::truncate();
        D_oop::truncate();
        D_odx::truncate();
        D_idx::truncate();
        D_ipd::truncate();
        D_irf::truncate();
        D_aer::truncate();
        D_iop::truncate();
        D_adp::truncate();  
        D_dru::truncate();   
        D_pat::truncate();
        D_cht::truncate();
        D_cha::truncate();
        D_ins::truncate();

         foreach ($data_vn_1 as $key => $va1) {
                //D_ins OK
                $data_ins_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                    ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE,v.cid CID
                    ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date), "%Y%m%d") DATEIN
                    ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date), "%Y%m%d") DATEEXP
                    ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB,"" GOVCODE ,"" GOVNAME
                    ,ifnull(if(i.an is null,vp.claim_code or vp.auth_code,ap.claim_code),r.sss_approval_code) PERMITNO
                    ,"" DOCNO ,"" OWNRPID,"" OWNRNAME ,i.an AN ,v.vn SEQ ,"" SUBINSCL,"" RELINSCL,"2" HTYPE
                    FROM vn_stat v
                    LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                    LEFT OUTER JOIN ipt i on i.vn = v.vn 
                    LEFT OUTER JOIN pttype pp on pp.pttype = i.pttype
                    LEFT OUTER JOIN ipt_pttype ap on ap.an = i.an
                    LEFT OUTER JOIN visit_pttype vp on vp.vn = v.vn
                    LEFT OUTER JOIN rcpt_debt r on r.vn = v.vn
                    LEFT OUTER JOIN patient px on px.hn = v.hn                
                    WHERE v.vn IN("'.$va1->vn.'")   
                ');
                // ,c.claimcode PERMITNO
                // ,ifnull(if(i.an is null,vp.claim_code or vp.auth_code,ap.claim_code),r.sss_approval_code) PERMITNO
                foreach ($data_ins_ as $va_01) {
                    D_ins::insert([
                        'HN'                => $va_01->HN,
                        'INSCL'             => $va_01->INSCL,
                        'SUBTYPE'           => $va_01->SUBTYPE,
                        'CID'               => $va_01->CID,
                        'DATEIN'            => $va_01->DATEIN, 
                        'DATEEXP'           => $va_01->DATEEXP,
                        'HOSPMAIN'          => $va_01->HOSPMAIN, 
                        'HOSPSUB'           => $va_01->HOSPSUB,
                        'GOVCODE'           => $va_01->GOVCODE,
                        'GOVNAME'           => $va_01->GOVNAME,
                        'PERMITNO'          => $va_01->PERMITNO,
                        'DOCNO'             => $va_01->DOCNO,
                        'OWNRPID'           => $va_01->OWNRPID,
                        'OWNRNAME'          => $va_01->OWNRNAME,
                        'AN'                => $va_01->AN,
                        'SEQ'               => $va_01->SEQ,
                        'SUBINSCL'          => $va_01->SUBINSCL,
                        'RELINSCL'          => $va_01->RELINSCL,
                        'HTYPE'             => $va_01->HTYPE,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_pat OK
                $data_pat_ = DB::connection('mysql2')->select('
                    SELECT v.hcode HCODE,v.hn HN
                    ,pt.chwpart CHANGWAT,pt.amppart AMPHUR,DATE_FORMAT(pt.birthday,"%Y%m%d") DOB
                    ,pt.sex SEX,pt.marrystatus MARRIAGE ,pt.occupation OCCUPA,lpad(pt.nationality,3,0) NATION,pt.cid PERSON_ID
                    ,concat(pt.fname," ",pt.lname,",",pt.pname) NAMEPAT,pt.pname TITLE,pt.fname FNAME,pt.lname LNAME,"1" IDTYPE
                    from vn_stat v
                    LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                    LEFT OUTER JOIN ipt i on i.vn = v.vn 
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn 
                    WHERE v.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_pat_ as $va_02) {
                    D_pat::insert([
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
                        'd_anaconda_id'      => 'LGO_801'
                    ]);
                }
                //D_opd OK
                $data_opd = DB::connection('mysql')->select('
                        SELECT  v.hn HN
                        ,v.spclty CLINIC
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD
                        ,v.vn SEQ
                        ,"1" UUC ,"" DETAIL,""BTEMP,""SBP,""DBP,""PR,""RR,""OPTYPE,""TYPEIN,""TYPEOUT
                        from hos.vn_stat v
                        LEFT OUTER JOIN hos.ovst o on o.vn = v.vn
                        LEFT OUTER JOIN hos.pttype p on p.pttype = v.pttype
                        LEFT OUTER JOIN hos.ipt i on i.vn = v.vn
                        LEFT OUTER JOIN hos.patient pt on pt.hn = v.hn
                        WHERE v.vn IN("'.$va1->vn.'")                  
                '); 
                foreach ($data_opd as $val3) {       
                    D_opd::insert([
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
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_orf _OK
                $data_orf_ = DB::connection('mysql2')->select('
                        SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,v.spclty CLINIC,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                        ,"0100" REFERTYPE,v.vn SEQ,"" REFERDATE
                        FROM vn_stat v
                        LEFT OUTER JOIN ovst o on o.vn = v.vn
                        LEFT OUTER JOIN referin r1 on r1.vn = v.vn 
                        LEFT OUTER JOIN referout r2 on r2.vn = v.vn
                        WHERE v.vn IN("'.$va1->vn.'") 
                        AND (r1.vn is not null or r2.vn is not null);
                ');                
                foreach ($data_orf_ as $va_03) {       
                    D_orf::insert([
                        'HN'                => $va_03->HN,
                        'CLINIC'            => $va_03->CLINIC,
                        'DATEOPD'           => $va_03->DATEOPD,
                        'REFER'             => $va_03->REFER,
                        'SEQ'               => $va_03->SEQ,
                        'REFERTYPE'         => $va_03->REFERTYPE, 
                        'REFERDATE'         => $va_03->REFERDATE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                 // D_odx OK
                 $data_odx_ = DB::connection('mysql2')->select('
                        SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEDX,v.spclty as CLINIC,o.icd10 as DIAG,o.diagtype as DXTYPE
                        ,if(d.licenseno="","-99999",d.licenseno) as DRDX,v.cid as PERSON_ID ,v.vn as SEQ
                        FROM vn_stat v
                        LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        INNER JOIN icd101 i on i.code = o.icd10
                        WHERE v.vn IN("'.$va1->vn.'") 
                ');
                // WHEN o.diagtype = "2" THEN o.icd10
                // GROUP BY o.diagtype,v.vn
                // AND o.diagtype ="1"
                foreach ($data_odx_ as $va_04) { 
                    D_odx::insert([
                        'HN'                => $va_04->HN,
                        'CLINIC'            => $va_04->CLINIC,
                        'DATEDX'            => $va_04->DATEDX,
                        'DIAG'              => $va_04->DIAG,
                        'DXTYPE'            => $va_04->DXTYPE,
                        'DRDX'              => $va_04->DRDX,
                        'PERSON_ID'         => $va_04->PERSON_ID, 
                        'SEQ'               => $va_04->SEQ, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                    
                }
                 //D_oop OK
                 $data_oop_ = DB::connection('mysql2')->select('
                        SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEOPD,v.spclty as CLINIC,o.icd10 as OPER
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
                    D_oop::insert([
                        'HN'                => $va_05->HN,
                        'CLINIC'            => $va_05->CLINIC,
                        'DATEOPD'           => $va_05->DATEOPD,
                        'OPER'              => $va_05->OPER,
                        'DROPID'            => $va_05->DROPID,
                        'PERSON_ID'         => $va_05->PERSON_ID, 
                        'SEQ'               => $va_05->SEQ, 
                        'SERVPRICE'         => $va_05->SERVPRICE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                    
                }
                //D_ipd OK
                $data_ipd_ = DB::connection('mysql2')->select('
                        SELECT a.hn HN,a.an AN,DATE_FORMAT(i.regdate,"%Y%m%d") DATEADM,Time_format(i.regtime,"%H%i") TIMEADM
                        ,DATE_FORMAT(i.dchdate,"%Y%m%d") DATEDSC,Time_format(i.dchtime,"%H%i")  TIMEDSC,right(i.dchstts,1) DISCHS
                        ,right(i.dchtype,1) DISCHT,i.ward WARDDSC,i.spclty DEPT,format(i.bw/1000,3) ADM_W,"1" UUC ,"I" SVCTYPE 
                        FROM an_stat a
                        LEFT OUTER JOIN ipt i on i.an = a.an
                        LEFT OUTER JOIN pttype p on p.pttype = a.pttype
                        LEFT OUTER JOIN patient pt on pt.hn = a.hn
                        WHERE  i.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_ipd_ as $va_06) {     
                    D_ipd::insert([
                        'AN'                => $va_06->AN,
                        'HN'                => $va_06->HN,
                        'DATEADM'           => $va_06->DATEADM,
                        'TIMEADM'           => $va_06->TIMEADM,
                        'DATEDSC'           => $va_06->DATEDSC,
                        'TIMEDSC'           => $va_06->TIMEDSC,
                        'DISCHS'            => $va_06->DISCHS,
                        'DISCHT'            => $va_06->DISCHT, 
                        'DEPT'              => $va_06->DEPT, 
                        'ADM_W'             => $va_06->ADM_W, 
                        'UUC'               => $va_06->UUC, 
                        'SVCTYPE'           => $va_06->SVCTYPE, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                
                 //D_irf OK
                 $data_irf_ = DB::connection('mysql2')->select('
                        SELECT a.an AN,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER,"0100" REFERTYPE
                        FROM an_stat a
                        LEFT OUTER JOIN ipt ip on ip.an = a.an
                        LEFT OUTER JOIN referout o on o.vn = a.an
                        LEFT OUTER JOIN referin oo on oo.vn = a.an
                        WHERE ip.vn IN("'.$va1->vn.'")  
                        AND (a.an in(SELECT vn FROM referin WHERE vn = oo.vn) or a.an in(SELECT vn FROM referout WHERE vn = o.vn));
                ');
                foreach ($data_irf_ as $va_07) {
                    D_irf::insert([
                        'AN'                 => $va_07->AN,
                        'REFER'              => $va_07->REFER,
                        'REFERTYPE'          => $va_07->REFERTYPE,
                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 'LGO_801',
                    ]);                     
                }                 
                //D_idx OK 
                $data_idx_ = DB::connection('mysql2')->select('
                        SELECT v.an AN,o.icd10 DIAG,o.diagtype DXTYPE,if(d.licenseno="","-99999",d.licenseno) DRDX
                        FROM an_stat v
                        LEFT OUTER JOIN iptdiag o on o.an = v.an
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        LEFT OUTER JOIN ipt ip on ip.an = v.an
                        INNER JOIN icd101 i on i.code = o.icd10
                        WHERE ip.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_idx_ as $va_08) { 
                    D_idx::insert([
                        'AN'                => $va_08->AN,  
                        'DIAG'              => $va_08->DIAG,
                        'DXTYPE'            => $va_08->DXTYPE,
                        'DRDX'              => $va_08->DRDX, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                            
                }
                //D_iop OK
                $data_iop_ = DB::connection('mysql2')->select('
                        SELECT a.an AN,o.icd9 OPER,o.oper_type as OPTYPE,if(d.licenseno="","-99999",d.licenseno) DROPID,DATE_FORMAT(o.opdate,"%Y%m%d") DATEIN,Time_format(o.optime,"%H%i") TIMEIN
                        ,DATE_FORMAT(o.enddate,"%Y%m%d") DATEOUT,Time_format(o.endtime,"%H%i") TIMEOUT
                        FROM an_stat a
                        LEFT OUTER JOIN iptoprt o on o.an = a.an
                        LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                        INNER JOIN icd9cm1 i on i.code = o.icd9
                        LEFT OUTER JOIN ipt ip on ip.an = a.an
                        WHERE ip.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_iop_ as $va_09) {
                    D_iop::insert([
                        'AN'                => $va_09->AN,
                        'OPER'              => $va_09->OPER,
                        'OPTYPE'            => $va_09->OPTYPE,
                        'DROPID'            => $va_09->DROPID,
                        'DATEIN'            => $va_09->DATEIN,
                        'TIMEIN'            => $va_09->TIMEIN,
                        'DATEOUT'           => $va_09->DATEOUT,
                        'TIMEOUT'           => $va_09->TIMEOUT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_cht OK
                $data_cht_ = DB::connection('mysql2')->select('
                    SELECT o.hn HN,o.an AN,DATE_FORMAT(if(a.an is null,o.vstdate,a.dchdate),"%Y%m%d") DATE,round(if(a.an is null,vv.income,a.income),2) TOTAL,""OPD_MEMO,""INVOICE_NO,""INVOICE_LT
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
                    D_cht::insert([
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
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                }
                //D_cha OK
                $data_cha_ = DB::connection('mysql2')->select('
                        SELECT v.hn HN,if(v1.an is null,"",v1.an) AN ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
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
                    D_cha::insert([
                        'HN'                => $va_11->HN,
                        'AN'                => $va_11->AN,
                        'DATE'              => $va_11->DATE,
                        'CHRGITEM'          => $va_11->CHRGITEM,
                        'AMOUNT'            => $va_11->AMOUNT, 
                        'PERSON_ID'         => $va_11->PERSON_ID,
                        'SEQ'               => $va_11->SEQ, 
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                } 
                 //D_aer OK
                $data_aer_ = DB::connection('mysql2')->select('
                        SELECT v.hn HN ,i.an AN ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD 
                        ,c.claimcode AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                        FROM vn_stat v
                        LEFT OUTER JOIN ipt i on i.vn = v.vn
                        LEFT OUTER JOIN ovst o on o.vn = v.vn
                        LEFT OUTER JOIN visit_pttype vv on vv.vn = v.vn
                        LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                        LEFT OUTER JOIN pkbackoffice.check_authen c On c.cid = v.cid AND c.vstdate = v.vstdate
                        WHERE v.vn IN("'.$va1->vn.'") and i.an is null
                        AND i.an is null
                        GROUP BY v.vn
                         UNION ALL
                        SELECT a.hn HN,a.an AN,DATE_FORMAT(vs.vstdate,"%Y%m%d") DATEOPD,c.claimcode AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,"" SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                        FROM an_stat a
                        LEFT OUTER JOIN ipt_pttype vv on vv.an = a.an
                        LEFT OUTER JOIN pttype pt on pt.pttype =a.pttype  
                        LEFT OUTER JOIN vn_stat vs on vs.vn =a.vn
                        LEFT OUTER JOIN pkbackoffice.check_authen c On c.cid = vs.cid AND c.vstdate = vs.vstdate
                        WHERE a.vn IN("'.$va1->vn.'")
                        GROUP BY a.an;
                ');
                foreach ($data_aer_ as $va_12) {
                    D_aer::insert([
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
                        'SEQ'               => $va_12->SEQ,
                        'AESTATUS'          => $va_12->AESTATUS,
                        'DALERT'            => $va_12->DALERT,
                        'TALERT'            => $va_12->TALERT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'LGO_801'
                    ]);
                } 
                //D_adp
                $data_adp_ = DB::connection('mysql2')->select(' 
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,icode ,vstdate
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC
                            ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,v.icode,v.vstdate
                            FROM opitemrece v
                            JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null 
                            LEFT OUTER JOIN ipt i on i.an = v.an
                            AND i.an is not NULL 
                            WHERE i.vn IN("'.$va1->vn.'")
                            GROUP BY i.vn,n.nhso_adp_code,rate) a 
                            GROUP BY an,CODE,rate

                            UNION

                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                            ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,icode ,vstdate
                            FROM
                            (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                            ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,v.icode,v.vstdate
                            FROM opitemrece v
                            JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null 
                            LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                            WHERE vv.vn IN("'.$va1->vn.'")
                            AND v.an is NULL
                            GROUP BY vv.vn,n.nhso_adp_code,rate) b 
                            GROUP BY seq,CODE,rate;
                '); 
                // ,n.nhso_adp_type_id TYPE
                // ,ic.drg_chrgitem_id TYPE
                foreach ($data_adp_ as $va_13) {
                    d_adp::insert([
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
                        'd_anaconda_id'        => 'LGO_801'
                    ]);
                } 
                 //D_dru OK
                 $data_dru_ = DB::connection('mysql2')->select('
                    SELECT vv.hcode HCODE ,v.hn HN ,v.an AN ,vv.spclty CLINIC ,vv.cid PERSON_ID ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
                        ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,v.qty AMOUNT ,round(v.unitprice,2) DRUGPRIC
                        ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                        ,oo.presc_reason DRUGREMARK ,oo.nhso_authorize_code PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                        ,"" TOTAL ,"" as SIGCODE ,"" as SIGTEXT ,""  PROVIDER,v.vstdate
                        FROM opitemrece v
                        LEFT OUTER JOIN drugitems d on d.icode = v.icode
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode                
                    WHERE v.vn IN("'.$va1->vn.'")
                    AND d.did is not null 
                    GROUP BY v.vn,did

                    UNION all

                    SELECT pt.hcode HCODE ,v.hn HN ,v.an AN ,v1.spclty CLINIC ,pt.cid PERSON_ID ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                        ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,sum(v.qty) AMOUNT ,round(v.unitprice,2) DRUGPRIC
                        ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                        ,oo.presc_reason DRUGREMARK ,oo.nhso_authorize_code PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                        ,"" TOTAL,"" as SIGCODE,"" as SIGTEXT,""  PROVIDER,v.vstdate
                        FROM opitemrece v
                        LEFT OUTER JOIN drugitems d on d.icode = v.icode
                        LEFT OUTER JOIN patient pt  on v.hn = pt.hn
                        INNER JOIN ipt v1 on v1.an = v.an
                        LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode                 
                    WHERE v1.vn IN("'.$va1->vn.'")
                    AND d.did is not null AND v.qty<>"0"
                    GROUP BY v.an,d.icode,USE_STATUS;              
                ');
                // ,d.sks_drug_code as SIGCODE
                // ,d.sks_dfs_text as SIGTEXT
                foreach ($data_dru_ as $va_14) {
                    D_dru::insert([ 
                        'HN'             => $va_14->HN,
                        'CLINIC'         => $va_14->CLINIC,
                        'HCODE'          => $va_14->HCODE,
                        'AN'             => $va_14->AN,
                        'PERSON_ID'      => $va_14->PERSON_ID,
                        'DATE_SERV'      => $va_14->DATE_SERV,
                        'DID'            => $va_14->DID,
                        'DIDNAME'        => $va_14->DIDNAME, 
                        'AMOUNT'         => $va_14->AMOUNT,
                        'DRUGPRIC'       => $va_14->DRUGPRIC,
                        'DRUGCOST'       => $va_14->DRUGCOST,
                        'DIDSTD'         => $va_14->DIDSTD,
                        'UNIT'           => $va_14->UNIT,
                        'UNIT_PACK'      => $va_14->UNIT_PACK,
                        'SEQ'            => $va_14->SEQ,
                        'DRUGREMARK'     => $va_14->DRUGREMARK,
                        'PA_NO'          => $va_14->PA_NO,
                        'TOTCOPAY'       => $va_14->TOTCOPAY,
                        // 'TOTCOPAY'       => '01',
                        'USE_STATUS'     => $va_14->USE_STATUS,
                        'TOTAL'          => $va_14->TOTAL,  
                        // 'TOTAL'          => '01',
                        'SIGCODE'        => $va_14->SIGCODE,                      
                        'SIGTEXT'        => $va_14->SIGTEXT,
                        'PROVIDER'       => $va_14->PROVIDER,
                        'vstdate'        => $va_14->vstdate,   
                        'user_id'        => $iduser,
                        'd_anaconda_id'  => 'LGO_801'
                    ]);
                } 
                 
         }
         
         D_adp::where('CODE','=','XXXXXX')->delete();
         // return back();
         return response()->json([
             'status'    => '200'
         ]);
    }
    public function lgo_801_export(Request $request)
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
        $folder='lgo_'.$sss_date_now_preg.'-'.$sss_time_now_preg;

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
        $ins = DB::connection('mysql')->select('
            SELECT * from d_ins where d_anaconda_id = "LGO_801"
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
        $iop = DB::connection('mysql')->select('
            SELECT * from d_iop where d_anaconda_id = "LGO_801"
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
        $opd_head3 = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        fwrite($objFopen_opd3, $opd_head3);
        $adp = DB::connection('mysql')->select('
            SELECT * from d_adp where d_anaconda_id = "LGO_801"
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
            $c23 = $value3->GRAVIDA;
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
        $aer = DB::connection('mysql')->select('
            SELECT * from d_aer where d_anaconda_id = "LGO_801"
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
        $cha = DB::connection('mysql')->select('
            SELECT * from d_cha where d_anaconda_id = "LGO_801"
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
        $cht = DB::connection('mysql')->select('
            SELECT * from d_cht where d_anaconda_id = "LGO_801"
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
        $opd_head7 = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGTYPE|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER';
        fwrite($objFopen_opd7, $opd_head7);
        $dru = DB::connection('mysql')->select('
            SELECT * from d_dru where d_anaconda_id = "LGO_801"
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
            $g23 = $value7->SIGTEXT;      
            $strText7="\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g16."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23;
            $ansitxt_pat7 = iconv('UTF-8', 'TIS-620', $strText7);
            fwrite($objFopen_opd7, $ansitxt_pat7);
        }
        fclose($objFopen_opd7);

        //idx.txt
        $file_d_idx = "Export/".$folder."/IDX.txt";
        $objFopen_opd8 = fopen($file_d_idx, 'w');
        $opd_head8 = 'AN|DIAG|DXTYPE|DRDX';
        fwrite($objFopen_opd8, $opd_head8);
        $idx = DB::connection('mysql')->select('
            SELECT * from d_idx where d_anaconda_id = "LGO_801"
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
        $pat = DB::connection('mysql')->select('
            SELECT * from d_pat where d_anaconda_id = "LGO_801"
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
        $ipd = DB::connection('mysql')->select('
            SELECT * from d_ipd where d_anaconda_id = "LGO_801"
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
        $irf = DB::connection('mysql')->select('
            SELECT * from d_irf where d_anaconda_id = "LGO_801"
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
        $lvd = DB::connection('mysql')->select('
            SELECT * from d_lvd where d_anaconda_id = "LGO_801"
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
        $odx = DB::connection('mysql')->select('
            SELECT * from d_odx where d_anaconda_id = "LGO_801"
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
        $oop = DB::connection('mysql')->select('
            SELECT * from d_oop where d_anaconda_id = "LGO_801"
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
        $opd = DB::connection('mysql')->select('
            SELECT * from d_opd where d_anaconda_id = "LGO_801"
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
        $orf = DB::connection('mysql')->select('
            SELECT * from d_orf where d_anaconda_id = "LGO_801"
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
                    return redirect()->route('claim.LGO_801');                    
                }
        }


            return redirect()->route('claim.LGO_801');

    }

    public function lgo_801_main(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();  
        $data['d_claim']   = DB::connection('mysql')->select('
            SELECT d.vn,d.hn,d.an,d.cid,d.ptname,d.vstdate,d.pttype,d.sum_price,s.rep_a,s.tranid_c,s.price1_k,s.income_ad,s.pp_gep_ae,s.claim_true_af,s.claim_false_ag,s.cash_money_ah
            ,s.pay_ai,s.IPCS_ao,s.IPCS_ORS_ap,s.OPCS_aq,s.PACS_ar,s.INSTCS_as,s.OTCS_at,s.PP_au,s.DRUG_av
            FROM d_claim d
            LEFT OUTER JOIN d_ofc_rep s ON s.hn_d = d.hn AND s.vstdate_i = d.vstdate
            WHERE d.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            ORDER BY s.tranid_c DESC
        '); 


        return view('lgo.lgo_801_main',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }
    public function lgo_801_check(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['datashow'] = DB::connection('mysql')->select('SELECT * from d_dru_out WHERE DRUGREMARK IS NOT NULL');

        return view('lgo.lgo_801_check',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }
    public function lgo_801_export_api(Request $request)
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
        $folder='LGO_'.$sss_date_now_preg.'-'.$sss_time_now_preg;

         mkdir ('Export/'.$folder, 0777, true);  //Web
        //  mkdir ('C:Export/'.$folder, 0777, true); //localhost

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        //1 ins.txt
        $file_d_ins = "Export/".$folder."/INS.txt";
        // $objFopen_ins = fopen($file_d_ins, 'w');
        $objFopen_ins_utf = fopen($file_d_ins, 'w');
        $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // fwrite($objFopen_ins, $opd_head);
        fwrite($objFopen_ins_utf, $opd_head);
        $ins = DB::connection('mysql')->select('
            SELECT * from d_ins where d_anaconda_id = "LGO_801"
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
            $str_ins="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19;
            // $ansitxt_ins = iconv('UTF-8', 'TIS-620', $str_ins);
            $ansitxt_ins_utf = iconv('UTF-8', 'UTF-8', $str_ins);
            // fwrite($objFopen_ins, $ansitxt_ins);
            fwrite($objFopen_ins_utf, $ansitxt_ins_utf);
        }
        // fclose($objFopen_ins);
        fclose($objFopen_ins_utf);
        Dapi_lgo_ins::truncate();
        $fread_file_ins = fread(fopen($file_d_ins,"r"),filesize($file_d_ins));
        $fread_file_ins_endcode = base64_encode($fread_file_ins);
        $read_file_ins_size = filesize($file_d_ins);

        // dd( $fread_file_ins);
        Dapi_lgo_ins::insert([
            'blobName'   =>  'INS.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_ins_endcode,
            'size'       =>   $read_file_ins_size,
            'encoding'   =>  'UTF-8'
        ]);

        //2 pat.txt
        $file_d_pat = "Export/".$folder."/PAT.txt";
        // $objFopen_pat = fopen($file_d_pat, 'w');
        $objFopen_pat_utf = fopen($file_d_pat, 'w');
        $opd_head_pat = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        // fwrite($objFopen_pat, $opd_head_pat);
        fwrite($objFopen_pat_utf, $opd_head_pat);
        $pat = DB::connection('mysql')->select('
            SELECT * from d_pat where d_anaconda_id = "LGO_801"
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
            $str_pat="\n".$i1."|".$i2."|".$i3."|".$i4."|".$i5."|".$i6."|".$i7."|".$i8."|".$i9."|".$i10."|".$i11."|".$i12."|".$i13."|".$i14."|".$i15;
            // $ansitxt_pat = iconv('UTF-8', 'TIS-620', $str_pat);
            $ansitxt_pat_utf = iconv('UTF-8', 'UTF-8', $str_pat);
            // fwrite($objFopen_pat, $ansitxt_pat);
            fwrite($objFopen_pat_utf, $ansitxt_pat_utf);
        }
        // fclose($objFopen_pat);
        fclose($objFopen_pat_utf);
        Dapi_lgo_pat::truncate();
        $fread_file_pat = fread(fopen($file_d_pat,"r"),filesize($file_d_pat));
        $fread_file_pat_endcode = base64_encode($fread_file_pat);
        $read_file_pat_size = filesize($file_d_pat);
        Dapi_lgo_pat::insert([
            'blobName'   =>  'PAT.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_pat_endcode,
            'size'       =>   $read_file_pat_size,
            'encoding'   =>  'UTF-8'
        ]);

        //3 opd.txt
        $file_d_opd = "Export/".$folder."/OPD.txt";
        // $objFopen_opd = fopen($file_d_opd, 'w');
        $objFopen_opd_utf = fopen($file_d_opd, 'w');
        $opd_head_opd = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
        // fwrite($objFopen_opd, $opd_head_opd);
        fwrite($objFopen_opd_utf, $opd_head_opd);
        $opd = DB::connection('mysql')->select('
            SELECT * from d_opd where d_anaconda_id = "LGO_801"
        ');
        foreach ($opd as $key => $value15) {
            $o1 = $value15->HN;
            $o2 = $value15->CLINIC;
            $o3 = $value15->DATEOPD; 
            $o4 = $value15->TIMEOPD; 
            $o5 = $value15->SEQ; 
            $o6 = $value15->UUC;  
            $str_opd="\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6;
            // $ansitxt_opd = iconv('UTF-8', 'TIS-620', $str_opd);
            $ansitxt_opd_utf = iconv('UTF-8', 'UTF-8', $str_opd);
            // fwrite($objFopen_opd, $ansitxt_opd);
            fwrite($objFopen_opd_utf, $ansitxt_opd_utf);
        }
        // fclose($objFopen_opd);
        fclose($objFopen_opd_utf);
        Dapi_lgo_opd::truncate();
        $fread_file_opd = fread(fopen($file_d_opd,"r"),filesize($file_d_opd));
        $fread_file_opd_endcode = base64_encode($fread_file_opd);
        $read_file_opd_size = filesize($file_d_opd);
        Dapi_lgo_opd::insert([
            'blobName'   =>  'OPD.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_opd_endcode,
            'size'       =>   $read_file_opd_size,
            'encoding'   =>  'UTF-8'
        ]);

        //4 orf.txt
        $file_d_orf = "Export/".$folder."/ORF.txt";
        // $objFopen_orf = fopen($file_d_orf, 'w');
        $objFopen_orf_utf = fopen($file_d_orf, 'w');
        $opd_head_orf = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ';
        // fwrite($objFopen_orf, $opd_head_orf);
        fwrite($objFopen_orf_utf, $opd_head_orf);
        $orf = DB::connection('mysql')->select('
            SELECT * from d_orf where d_anaconda_id = "LGO_801"
        ');
        foreach ($orf as $key => $value16) {
            $p1 = $value16->HN;
            $p2 = $value16->DATEOPD;
            $p3 = $value16->CLINIC; 
            $p4 = $value16->REFER; 
            $p5 = $value16->REFERTYPE; 
            $p6 = $value16->SEQ;  
            $str_orf="\n".$p1."|".$p2."|".$p3."|".$p4."|".$p5."|".$p6;
            // $ansitxt_orf = iconv('UTF-8', 'TIS-620', $str_orf);
            $ansitxt_orf_utf = iconv('UTF-8', 'UTF-8', $str_orf);
            // fwrite($objFopen_orf, $ansitxt_orf);
            fwrite($objFopen_orf_utf, $ansitxt_orf_utf);
        }
        // fclose($objFopen_orf);
        fclose($objFopen_orf_utf);
        Dapi_lgo_orf::truncate();
        $fread_file_orf = fread(fopen($file_d_orf,"r"),filesize($file_d_orf));
        $fread_file_orf_endcode = base64_encode($fread_file_orf);
        $read_file_orf_size = filesize($file_d_orf);
        Dapi_lgo_orf::insert([
            'blobName'   =>  'ORF.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_orf_endcode,
            'size'       =>   $read_file_orf_size,
            'encoding'   =>  'UTF-8'
        ]);

        //5 odx.txt
        $file_d_odx = "Export/".$folder."/ODX.txt";
        // $objFopen_odx = fopen($file_d_odx, 'w');
        $objFopen_odx_utf = fopen($file_d_odx, 'w');
        $opd_head_odx = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        // fwrite($objFopen_odx, $opd_head_odx);
        fwrite($objFopen_odx_utf, $opd_head_odx);
        $odx = DB::connection('mysql')->select('
            SELECT * from d_odx where d_anaconda_id = "LGO_801"
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
            $str_odx="\n".$m1."|".$m2."|".$m3."|".$m4."|".$m5."|".$m6."|".$m7."|".$m8;
            // $ansitxt_odx = iconv('UTF-8', 'TIS-620', $str_odx);
            $ansitxt_odx_utf = iconv('UTF-8', 'UTF-8', $str_odx);
            // fwrite($objFopen_odx, $ansitxt_odx);
            fwrite($objFopen_odx_utf, $ansitxt_odx_utf);
        }
        // fclose($objFopen_odx);
        fclose($objFopen_odx_utf);
        Dapi_lgo_odx::truncate();
        $fread_file_odx = fread(fopen($file_d_odx,"r"),filesize($file_d_odx));
        $fread_file_odx_endcode = base64_encode($fread_file_odx);
        $read_file_odx_size = filesize($file_d_odx);
        Dapi_lgo_odx::insert([
            'blobName'   =>  'ODX.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_odx_endcode,
            'size'       =>   $read_file_odx_size,
            'encoding'   =>  'UTF-8'
        ]);

        //6 oop.txt
        $file_d_oop = "Export/".$folder."/OOP.txt";
        // $objFopen_oop = fopen($file_d_oop, 'w');
        $objFopen_oop_utf = fopen($file_d_oop, 'w');
        $opd_head_oop = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ';
        // fwrite($objFopen_oop, $opd_head_oop);
        fwrite($objFopen_oop_utf, $opd_head_oop);
        $oop = DB::connection('mysql')->select('
            SELECT * from d_oop where d_anaconda_id = "LGO_801"
        ');
        foreach ($oop as $key => $value14) {
            $n1 = $value14->HN;
            $n2 = $value14->DATEOPD;
            $n3 = $value14->CLINIC; 
            $n4 = $value14->OPER; 
            $n5 = $value14->DROPID; 
            $n6 = $value14->PERSON_ID; 
            $n7 = $value14->SEQ;  
            $str_oop="\n".$n1."|".$n2."|".$n3."|".$n4."|".$n5."|".$n6."|".$n7;
            // $ansitxt_oop = iconv('UTF-8', 'TIS-620', $str_oop);
            $ansitxt_oop_utf = iconv('UTF-8', 'UTF-8', $str_oop);
            // fwrite($objFopen_oop, $ansitxt_oop);
            fwrite($objFopen_oop_utf, $ansitxt_oop_utf);
        }
        // fclose($objFopen_oop);
        fclose($objFopen_oop_utf);
        Dapi_lgo_oop::truncate();
        $fread_file_oop = fread(fopen($file_d_oop,"r"),filesize($file_d_oop));
        $fread_file_oop_endcode = base64_encode($fread_file_oop);
        $read_file_oop_size = filesize($file_d_oop);
        Dapi_lgo_oop::insert([
            'blobName'   =>  'OOP.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_oop_endcode,
            'size'       =>   $read_file_oop_size,
            'encoding'   =>  'UTF-8'
        ]);

        //7 ipd.txt
        $file_d_ipd = "Export/".$folder."/IPD.txt";
        // $objFopen_ipd = fopen($file_d_ipd, 'w');
        $objFopen_ipd_utf = fopen($file_d_ipd, 'w');
        $opd_head_ipd = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
        // fwrite($objFopen_ipd, $opd_head_ipd);
        fwrite($objFopen_ipd_utf, $opd_head_ipd);
        $ipd = DB::connection('mysql')->select('
            SELECT * from d_ipd where d_anaconda_id = "LGO_801"
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
            $str_ipd="\n".$j1."|".$j2."|".$j3."|".$j4."|".$j5."|".$j6."|".$j7."|".$j8."|".$j9."|".$j10."|".$j11."|".$j12."|".$j13;
            // $ansitxt_ipd = iconv('UTF-8', 'TIS-620', $str_ipd);
            $ansitxt_ipd_utf = iconv('UTF-8', 'UTF-8', $str_ipd);
            // fwrite($objFopen_ipd, $ansitxt_ipd);
            fwrite($objFopen_ipd_utf, $ansitxt_ipd_utf);
        }
        // fclose($objFopen_ipd);
        fclose($objFopen_ipd_utf);
        Dapi_lgo_ipd::truncate();
        $fread_file_ipd = fread(fopen($file_d_ipd,"r"),filesize($file_d_ipd));
        $fread_file_ipd_endcode = base64_encode($fread_file_ipd);
        $read_file_ipd_size = filesize($file_d_ipd);
        Dapi_lgo_ipd::insert([
            'blobName'   =>  'IPD.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_ipd_endcode,
            'size'       =>   $read_file_ipd_size,
            'encoding'   =>  'UTF-8'
        ]);

        //8 irf.txt
        $file_d_irf = "Export/".$folder."/IRF.txt";
        // $objFopen_irf = fopen($file_d_irf, 'w');
        $objFopen_irf_utf = fopen($file_d_irf, 'w');
        $opd_head_irf = 'AN|REFER|REFERTYPE';
        // fwrite($objFopen_irf, $opd_head_irf);
        fwrite($objFopen_irf_utf, $opd_head_irf);
        $irf = DB::connection('mysql')->select('
            SELECT * from d_irf where d_anaconda_id = "LGO_801"
        ');
        foreach ($irf as $key => $value11) {
            $k1 = $value11->AN;
            $k2 = $value11->REFER;
            $k3 = $value11->REFERTYPE; 
            $str_irf="\n".$k1."|".$k2."|".$k3;
            // $ansitxt_irf = iconv('UTF-8', 'TIS-620', $str_irf);
            $ansitxt_irf_utf = iconv('UTF-8', 'UTF-8', $str_irf);
            // fwrite($objFopen_irf, $ansitxt_irf);
            fwrite($objFopen_irf_utf, $ansitxt_irf_utf);
        }
        // fclose($objFopen_irf);
        fclose($objFopen_irf_utf);
        Dapi_lgo_irf::truncate();
        $fread_file_irf = fread(fopen($file_d_irf,"r"),filesize($file_d_irf));
        $fread_file_irf_endcode = base64_encode($fread_file_irf);
        $read_file_irf_size = filesize($file_d_irf);
        Dapi_lgo_irf::insert([
            'blobName'   =>  'IRF.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_irf_endcode,
            'size'       =>   $read_file_irf_size,
            'encoding'   =>  'UTF-8'
        ]);

        //9 idx.txt
        $file_d_idx = "Export/".$folder."/IDX.txt";
        // $objFopen_idx = fopen($file_d_idx, 'w');
        $objFopen_idx_utf = fopen($file_d_idx, 'w');
        $opd_head_idx = 'AN|DIAG|DXTYPE|DRDX';
        // fwrite($objFopen_idx, $opd_head_idx);
        fwrite($objFopen_idx_utf, $opd_head_idx);
        $idx = DB::connection('mysql')->select('
            SELECT * from d_idx where d_anaconda_id = "LGO_801"
        ');
        foreach ($idx as $key => $value8) {
            $h1 = $value8->AN;
            $h2 = $value8->DIAG;
            $h3 = $value8->DXTYPE;
            $h4 = $value8->DRDX; 
            $str_idx="\n".$h1."|".$h2."|".$h3."|".$h4;
            // $ansitxt_idx = iconv('UTF-8', 'TIS-620', $str_idx);
            $ansitxt_idx_utf = iconv('UTF-8', 'UTF-8', $str_idx);
            // fwrite($objFopen_idx, $ansitxt_idx);
            fwrite($objFopen_idx_utf, $ansitxt_idx_utf);
        }
        // fclose($objFopen_idx);
        fclose($objFopen_idx_utf);
        Dapi_lgo_idx::truncate();
        $fread_file_idx = fread(fopen($file_d_idx,"r"),filesize($file_d_idx));
        $fread_file_idx_endcode = base64_encode($fread_file_idx);
        $read_file_idx_size = filesize($file_d_idx);
        Dapi_lgo_idx::insert([
            'blobName'   =>  'IDX.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_idx_endcode,
            'size'       =>   $read_file_idx_size,
            'encoding'   =>  'UTF-8'
        ]);
                   
        //10 iop.txt
        $file_d_iop = "Export/".$folder."/IOP.txt";
        // $objFopen_iop = fopen($file_d_iop, 'w');
        $objFopen_iop_utf = fopen($file_d_iop, 'w');
        $opd_head_iop = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
        // fwrite($objFopen_iop, $opd_head_iop);
        fwrite($objFopen_iop_utf, $opd_head_iop);
        $iop = DB::connection('mysql')->select('
            SELECT * from d_iop where d_anaconda_id = "LGO_801"
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
           
            $str_iop="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8;
            // $ansitxt_iop = iconv('UTF-8', 'TIS-620', $str_iop);
            $ansitxt_iop_utf = iconv('UTF-8', 'UTF-8', $str_iop);
            // fwrite($objFopen_iop, $ansitxt_iop);
            fwrite($objFopen_iop_utf, $ansitxt_iop_utf);
        }
        // fclose($objFopen_iop);
        fclose($objFopen_iop_utf);
        Dapi_lgo_iop::truncate();
        $fread_file_iop = fread(fopen($file_d_iop,"r"),filesize($file_d_iop));
        $fread_file_iop_endcode = base64_encode($fread_file_iop);
        $read_file_iop_size = filesize($file_d_iop);
        Dapi_lgo_iop::insert([
            'blobName'   =>  'IOP.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_iop_endcode,
            'size'       =>   $read_file_iop_size,
            'encoding'   =>  'UTF-8'
        ]);

        //11 cht.txt
        $file_d_cht = "Export/".$folder."/CHT.txt";
        // $objFopen_cht = fopen($file_d_cht, 'w');
        $objFopen_cht_utf = fopen($file_d_cht, 'w');
        $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ';
        // fwrite($objFopen_cht, $opd_head_cht);
        fwrite($objFopen_cht_utf, $opd_head_cht);
        $cht = DB::connection('mysql')->select('
            SELECT * from d_cht where d_anaconda_id = "LGO_801"
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
            $str_cht="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8;
            // $ansitxt_cht = iconv('UTF-8', 'TIS-620', $str_cht);
            $ansitxt_cht_utf = iconv('UTF-8', 'UTF-8', $str_cht);
            // fwrite($objFopen_cht, $ansitxt_cht);
            fwrite($objFopen_cht_utf, $ansitxt_cht_utf);
        }
        // fclose($objFopen_cht);
        fclose($objFopen_cht_utf);
        Dapi_lgo_cht::truncate();
        $fread_file_cht = fread(fopen($file_d_cht,"r"),filesize($file_d_cht));
        $fread_file_cht_endcode = base64_encode($fread_file_cht);
        $read_file_cht_size = filesize($file_d_cht);
        Dapi_lgo_cht::insert([
            'blobName'   =>  'CHT.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_cht_endcode,
            'size'       =>   $read_file_cht_size,
            'encoding'   =>  'UTF-8'
        ]);
               
        //12 cha.txt
        $file_d_cha = "Export/".$folder."/CHA.txt";
        // $objFopen_cha = fopen($file_d_cha, 'w');
        $objFopen_cha_utf = fopen($file_d_cha, 'w');
        $opd_head_cha = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
        // fwrite($objFopen_cha, $opd_head_cha);
        fwrite($objFopen_cha_utf, $opd_head_cha);
        $cha = DB::connection('mysql')->select('
            SELECT * from d_cha where d_anaconda_id = "LGO_801"
        ');
        foreach ($cha as $key => $value5) {
            $e1 = $value5->HN;
            $e2 = $value5->AN;
            $e3 = $value5->DATE;
            $e4 = $value5->CHRGITEM;
            $e5 = $value5->AMOUNT;
            $e6 = $value5->PERSON_ID;
            $e7 = $value5->SEQ; 
            $str_cha="\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7;
            // $ansitxt_cha = iconv('UTF-8', 'TIS-620', $str_cha);
            $ansitxt_cha_utf = iconv('UTF-8', 'UTF-8', $str_cha);
            // fwrite($objFopen_cha, $ansitxt_cha);
            fwrite($objFopen_cha_utf, $ansitxt_cha_utf);
        }
        // fclose($objFopen_cha);
        fclose($objFopen_cha_utf);
        Dapi_lgo_cha::truncate();
        $fread_file_cha = fread(fopen($file_d_cha,"r"),filesize($file_d_cha));
        $fread_file_cha_endcode = base64_encode($fread_file_cha);
        $read_file_cha_size = filesize($file_d_cha);
        Dapi_lgo_cha::insert([
            'blobName'   =>  'CHA.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_cha_endcode,
            'size'       =>   $read_file_cha_size,
            'encoding'   =>  'UTF-8'
        ]);

         //13 aer.txt
         $file_d_aer = "Export/".$folder."/AER.txt";
        //  $objFopen_aer = fopen($file_d_aer, 'w');
         $objFopen_aer_utf = fopen($file_d_aer, 'w');
         $opd_head_aer = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
        //  fwrite($objFopen_aer, $opd_head_aer);
        fwrite($objFopen_aer_utf, $opd_head_aer);
        $aer = DB::connection('mysql')->select('
             SELECT * from d_aer where d_anaconda_id = "LGO_801"
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
             $str_aer="\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|".$d15."|".$d16."|".$d17."|".$d18;
            //  $ansitxt_aer = iconv('UTF-8', 'TIS-620', $str_aer);
             $ansitxt_aer_utf = iconv('UTF-8', 'UTF-8', $str_aer);
            //  fwrite($objFopen_aer, $ansitxt_aer);
             fwrite($objFopen_aer_utf, $ansitxt_aer_utf);
         }
        //  fclose($objFopen_aer);
         fclose($objFopen_aer_utf);
         Dapi_lgo_aer::truncate();
         $fread_file_aer = fread(fopen($file_d_aer,"r"),filesize($file_d_aer));
         $fread_file_aer_endcode = base64_encode($fread_file_aer);
         $read_file_aer_size = filesize($file_d_aer);
         Dapi_lgo_aer::insert([
             'blobName'   =>  'AER.txt',
             'blobType'   =>  'text/plain',
             'blob'       =>   $fread_file_aer_endcode,
             'size'       =>   $read_file_aer_size,
             'encoding'   =>  'UTF-8'
         ]);
                   
        //14 adp.txt
        $file_d_adp = "Export/".$folder."/ADP.txt";
        // $objFopen_adp = fopen($file_d_adp, 'w');
        $objFopen_adp_utf = fopen($file_d_adp, 'w');
        $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        // fwrite($objFopen_adp, $opd_head_adp);
        fwrite($objFopen_adp_utf, $opd_head_adp);
        $adp = DB::connection('mysql')->select('
            SELECT * from d_adp where d_anaconda_id = "LGO_801"
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
            $c23 = $value3->GRAVIDA;
            $c24 = $value3->GA_WEEK;
            $c25 = $value3->DCIP;
            $c26 = $value3->LMP;
            $c27 = $value3->SP_ITEM;           
            $str_adp="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;
            // $ansitxt_adp = iconv('UTF-8', 'TIS-620', $str_adp);
            $ansitxt_adp_utf = iconv('UTF-8', 'UTF-8', $str_adp);
            // fwrite($objFopen_adp, $ansitxt_adp);
            fwrite($objFopen_adp_utf, $ansitxt_adp_utf);
        }
        // fclose($objFopen_adp);
        fclose($objFopen_adp_utf);
        Dapi_lgo_adp::truncate();
        $fread_file_adp = fread(fopen($file_d_adp,"r"),filesize($file_d_adp));
        $fread_file_adp_endcode = base64_encode($fread_file_adp);
        $read_file_adp_size = filesize($file_d_adp);
        Dapi_lgo_adp::insert([
            'blobName'   =>  'ADP.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_adp_endcode,
            'size'       =>   $read_file_adp_size,
            'encoding'   =>  'UTF-8'
        ]);
        
         //15 lvd.txt
         $file_d_lvd = "Export/".$folder."/LVD.txt";
        //  $objFopen_lvd = fopen($file_d_lvd, 'w');
         $objFopen_lvd_utf = fopen($file_d_lvd, 'w');
         $opd_head_lvd = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
        //  fwrite($objFopen_lvd, $opd_head_lvd);
         fwrite($objFopen_lvd_utf, $opd_head_lvd);
         $lvd = DB::connection('mysql')->select('
             SELECT * from d_lvd where d_anaconda_id = "LGO_801"
         ');
         foreach ($lvd as $key => $value12) {
             $L1 = $value12->SEQLVD;
             $L2 = $value12->AN;
             $L3 = $value12->DATEOUT; 
             $L4 = $value12->TIMEOUT; 
             $L5 = $value12->DATEIN; 
             $L6 = $value12->TIMEIN; 
             $L7 = $value12->QTYDAY; 
             $str_lvd="\n".$L1."|".$L2."|".$L3."|".$L4."|".$L5."|".$L6."|".$L7;
            //  $ansitxt_lvd = iconv('UTF-8', 'TIS-620', $str_lvd);
             $ansitxt_lvd_utf = iconv('UTF-8', 'UTF-8', $str_lvd);
            //  fwrite($objFopen_lvd, $ansitxt_lvd);
             fwrite($objFopen_lvd_utf, $ansitxt_lvd_utf);
         }
        //  fclose($objFopen_lvd);
         fclose($objFopen_lvd_utf);
         Dapi_lgo_ldv::truncate();
         $fread_file_lvd = fread(fopen($file_d_lvd,"r"),filesize($file_d_lvd));
         $fread_file_lvd_endcode = base64_encode($fread_file_lvd);
         $read_file_lvd_size = filesize($file_d_lvd);
         Dapi_lgo_ldv::insert([
             'blobName'   =>  'LDV.txt',
             'blobType'   =>  'text/plain',
             'blob'       =>   $fread_file_lvd_endcode,
             'size'       =>   $read_file_lvd_size,
             'encoding'   =>  'UTF-8'
         ]);
 
        //16 dru.txt
        $file_d_dru = "Export/".$folder."/DRU.txt";
        // $objFopen_dru = fopen($file_d_dru, 'w');
        $objFopen_dru_utf = fopen($file_d_dru, 'w');
        $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        // fwrite($objFopen_dru, $opd_head_dru);
        fwrite($objFopen_dru_utf, $opd_head_dru);
        $dru = DB::connection('mysql')->select('
            SELECT * from d_dru where d_anaconda_id = "UCEP24"
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
            // $g16 = $value7->DRUGTYPE;
            $g17 = $value7->DRUGREMARK;
            $g18 = $value7->PA_NO;
            $g19 = $value7->TOTCOPAY;
            $g20 = $value7->USE_STATUS;
            $g21 = $value7->TOTAL;
            $g22 = $value7->SIGCODE;
            $g23 = $value7->SIGTEXT;  
            $g24 = $value7->PROVIDER; 
            $g25 = $value7->SP_ITEM;      
            $str_dru="\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23."|".$g24."|".$g25;
            // $ansitxt_dru = iconv('UTF-8', 'TIS-620', $str_dru);
            $ansitxt_dru_utf = iconv('UTF-8', 'UTF-8', $str_dru);
            // fwrite($objFopen_dru, $ansitxt_dru);
            fwrite($objFopen_dru_utf, $ansitxt_dru_utf);
        }
        // fclose($objFopen_dru);
        fclose($objFopen_dru_utf);
        Dapi_lgo_dru::truncate();
        $fread_file_dru = fread(fopen($file_d_dru,"r"),filesize($file_d_dru));
        $fread_file_dru_endcode = base64_encode($fread_file_dru);
        $read_file_dru_size = filesize($file_d_dru);
        Dapi_lgo_dru::insert([
            'blobName'   =>  'DRU.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_dru_endcode,
            'size'       =>   $read_file_dru_size,
            'encoding'   =>  'UTF-8'
        ]);

         //17 lab.txt
         $file_d_lab = "Export/".$folder."/LAB.txt";
         $objFopen_lab = fopen($file_d_lab, 'w');
         $opd_head_lab = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
         fwrite($objFopen_lab, $opd_head_lab);
         fclose($objFopen_lab);
  
            return response()->json([
                'status'    => '200'
            ]);
    }
    public function lgo_801_send_api(Request $request)
    {  
        $iduser = Auth::user()->id;
        $data_token_ = DB::connection('mysql')->select(' SELECT * FROM api_neweclaim WHERE user_id = "'.$iduser.'"');  
        foreach ($data_token_ as $key => $val_to) {
            $username     = $val_to->api_neweclaim_user;
            $password     = $val_to->api_neweclaim_pass;
            $token        = $val_to->api_neweclaim_token;
        } 
        // dd($token);
          
        $data_table = array("dapi_lgo_ins","dapi_lgo_pat","dapi_lgo_opd","dapi_lgo_orf","dapi_lgo_odx","dapi_lgo_oop","dapi_lgo_ipd","dapi_lgo_irf","dapi_lgo_idx","dapi_lgo_iop","dapi_lgo_cht","dapi_lgo_cha","dapi_lgo_aer","dapi_lgo_adp","dapi_lgo_ldv","dapi_lgo_dru");
        
        foreach ($data_table as $key => $val_t) {        
                $data_all_ = DB::connection('mysql')->select('
                SELECT * FROM '.$val_t.'
                ');                
                foreach ($data_all_ as $val_field) {
                    $blob[] = $val_field->blob;
                    $size[] = $val_field->size;                     
                 }     
            }
 
            // dd($blob[5]);
            $ch = curl_init();
            $Data_send = [
                "fileType" => "txt",
                "maininscl" => "LGO",
                "importDup" => true, //นำเข้าซ้ำ กรณีพบข้อมูลยังไม่ส่งเบิกชดเชย 
                "assignToMe" => true,  //กำหนดข้อมูลให้แสดงผลเฉพาะผู้นำเข้าเท่านั้น
                "dataTypes" => ["OP","IP"],
                "opRefer" => false, 
                    "file" => [ 
                        "ins" => [
                            "blobName"  => "INS.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[0],
                            "size"      => $size[0],
                            "encoding"  => "UTF-8"
                        ]
                        ,"pat" => [
                            "blobName"  => "PAT.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[1],
                            "size"      => $size[1],
                            "encoding"  => "UTF-8"
                        ]
                        ,"opd" => [
                            "blobName"  => "OPD.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[2],
                            "size"      => $size[2],
                            "encoding"  => "UTF-8"
                        ] 
                        ,"orf" => [
                            "blobName"  => "ORF.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[3],
                            "size"      => $size[3],
                            "encoding"  => "UTF-8"
                        ]
                        ,"odx" => [
                            "blobName"  => "ODX.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[4],
                            "size"      => $size[4],
                            "encoding"  => "UTF-8"
                        ]  
                        ,"oop" => [
                            "blobName"  => "OOP.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[5],
                            "size"      => $size[5],
                            "encoding"  => "UTF-8"
                        ]
                        ,"ipd" => [
                            "blobName"  => "IPD.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[6],
                            "size"      => $size[6],
                            "encoding"  => "UTF-8"
                        ]
                        ,"irf" => [
                            "blobName"  => "IRF.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[7],
                            "size"      => $size[7],
                            "encoding"  => "UTF-8"
                        ]
                        ,"idx" => [
                            "blobName"  => "IDX.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[8],
                            "size"      => $size[8],
                            "encoding"  => "UTF-8"
                        ]
                        ,"iop" => [
                            "blobName"  => "IOP.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[9],
                            "size"      => $size[9],
                            "encoding"  => "UTF-8"
                        ]
                        ,"cht" => [
                            "blobName"  => "CHT.txt",
                            "blobType"  => "text",
                            "blob"      => $blob[10],
                            "size"      => $size[10],
                            "encoding"  => "UTF-8"
                        ]
                        ,"cha" => [
                            "blobName"  => "CHA.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[11],
                            "size"      => $size[11],
                            "encoding"  => "UTF-8"
                        ]
                        ,"aer" => [
                            "blobName"  => "AER.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[12],
                            "size"      => $size[12],
                            "encoding"  => "UTF-8"
                        ]
                        ,"adp" => [
                            "blobName"  => "ADP.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[13],
                            "size"      => $size[13],
                            "encoding"  => "UTF-8"
                        ]
                        ,"lvd" => [
                            "blobName"  => "LVD.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[14],
                            "size"      => $size[14],
                            "encoding"  => "UTF-8"
                        ]
                        ,"dru" => [
                            "blobName" => "DRU.txt",
                            "blobType" => "text/plain",
                            "blob"     => $blob[15],
                            "size"     => $size[15],
                            "encoding" => "UTF-8"
                        ]                        
                        ,"lab" => null
                    ] 
            ];        
            // dd($Data_send);
            $headers_send  = [
                'Authorization : Bearer '.$token,
                'Content-Type: application/json',            
                'User-Agent:<platform>/<version><10978>'
                    
            ];

            curl_setopt($ch, CURLOPT_URL,"https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Data_send, JSON_UNESCAPED_SLASHES));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_send);
  
            $server_output     = curl_exec ($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            $content = $server_output;
            $result = json_decode($content, true);
            
            #echo "<BR>";
            @$status = $result['status'];
            #echo "<BR>";
            @$message = $result['message'];
            #echo "<BR>";
           
        
        return response()->json([
            'status'    => '200'
        ]);
    }
 
}
