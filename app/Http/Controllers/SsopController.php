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
use App\Models\D_claim;
use App\Models\Stm;
use App\Models\Ssop_session;
use App\Models\Ssop_opdx;
use App\Models\Pang_stamp_temp;
use App\Models\Ssop_token;
use App\Models\Ssop_opservices;
use App\Models\Ssop_dispenseditems;
use App\Models\Ssop_dispensing;
use App\Models\Ssop_billtran;
use App\Models\Ssop_billitems;
use App\Models\D_ssop_main;
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
use App\Models\Ssop_stm_claim;
use Auth;
use ZipArchive;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use League\CommonMark\Delimiter\Delimiter;
use Stevebauman\Location\Facades\Location; 
use SoapClient; 
use SplFileObject;
use Illuminate\Filesystem\Filesystem;
 
 

class SsopController extends Controller
{
    public function ssop(Request $request)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $vn            = $request->VN;
        $data['users'] = User::get();
  
        if ($startdate =='') {
            
        } else { 
            $date = date('Y-m-d');
            $iduser = Auth::user()->id;
            D_ssop_main::truncate(); 
            $data_main_ = DB::connection('mysql2')->select(' 
                SELECT v.hn,v.vn,i.an,v.cid,v.vstdate,v.pttype,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.income,p.hipdata_code 
                from vn_stat v
                LEFT OUTER JOIN ovst o on o.vn = v.vn
                LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                LEFT OUTER JOIN ipt i on i.vn = v.vn 
                LEFT OUTER JOIN patient pt on pt.hn = v.hn
                WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                AND p.pcode ="A7" AND o.an is null
                GROUP BY v.vn; 
                
            ');      
            foreach ($data_main_ as $key => $value) {    
                D_ssop_main::insert([
                        'vn'                 => $value->vn,
                        'hn'                 => $value->hn,
                        'an'                 => $value->an, 
                        'pttype'             => $value->pttype,
                        'vstdate'            => $value->vstdate, 
                        'price_ssop'         => $value->income, 
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
                        'nhso_adp_code'     => 'SSOP',
                        'claimdate'         => $date, 
                        'userid'            => $iduser, 
                    ]);
                }                   
                
            } 
        }
        if ($vn =='') {
            
        } else { 
            $date = date('Y-m-d');
            $iduser = Auth::user()->id;
            D_ssop_main::truncate();
            Ssop_billtran::truncate(); 
            Ssop_billitems::truncate();
            Ssop_dispensing::truncate();
            Ssop_dispenseditems::truncate();
            Ssop_opservices::truncate();
            Ssop_opdx::truncate(); 
            $data_main_ = DB::connection('mysql2')->select(' 
                SELECT v.hn,v.vn,i.an,v.cid,v.vstdate,v.pttype,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.income,p.hipdata_code 
                from vn_stat v
                LEFT OUTER JOIN ovst o on o.vn = v.vn
                LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                LEFT OUTER JOIN ipt i on i.vn = v.vn 
                LEFT OUTER JOIN patient pt on pt.hn = v.hn
                WHERE v.vn = "'.$vn.'"   
            ');      
            foreach ($data_main_ as $key => $value) {    
                D_ssop_main::insert([
                        'vn'                 => $value->vn,
                        'hn'                 => $value->hn,
                        'an'                 => $value->an, 
                        'pttype'             => $value->pttype,
                        'vstdate'            => $value->vstdate, 
                        'price_ssop'         => $value->income, 
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
                        'nhso_adp_code'     => 'SSOP',
                        'claimdate'         => $date, 
                        'userid'            => $iduser, 
                    ]);
                }                   
                
            } 
        }

        $data['d_ssop_main'] = DB::connection('mysql')->select('SELECT * from d_ssop_main');  
        $data['ssop_billtran'] = DB::connection('mysql')->select('SELECT * from ssop_billtran');  
        $data['ssop_billitems'] = DB::connection('mysql')->select('SELECT * from ssop_billitems'); 
        $data['ssop_dispensing'] = DB::connection('mysql')->select('SELECT * from ssop_dispensing'); 
        $data['ssop_dispenseditems'] = DB::connection('mysql')->select('SELECT * from ssop_dispenseditems');
        $data['ssop_opservices'] = DB::connection('mysql')->select('SELECT * from ssop_opservices');
        $data['ssop_opdx'] = DB::connection('mysql')->select('SELECT * from ssop_opdx');
        return view('ssop.ssop',$data,[
            'startdate'            => $startdate,
            'enddate'              => $enddate, 
        ]);
    }
    
    public function ssop_process(Request $request)
    { 
        $data_vn_1 = DB::connection('mysql')->select('SELECT vn,an from d_ssop_main');
        $iduser = Auth::user()->id; 
        // Ssop_billtran::truncate(); 
        // Ssop_billitems::truncate();
        // Ssop_dispensing::truncate();
        // Ssop_dispenseditems::truncate();
        // Ssop_opservices::truncate();
        // Ssop_opdx::truncate();

        foreach ($data_vn_1 as $key => $va1) {
            $ssop_billtran_ = DB::connection('mysql2')->select('  
                SELECT o.vn as Invno,p.hn as HN,o.an,o.vstdate,o.vsttime,o.hcode as Hcode,pt.pttype,v.pdx as Diag,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.sex,v.uc_money
                    ,op.icode,op.qty,op.unitprice,op.income,op.paidst,op.sum_price,CONCAT(p.pname,p.fname," ",p.lname) AS "Name",pt.nhso_code
                    ,d.name as doctorname,d.licenseno
                    ,"01" AS "Station", "" AS "Authencode", CONCAT(o.vstdate,"T",o.vsttime) AS "DTtran","" AS "Billno"
                    , "" AS "MemberNo",v.uc_money AS "Amount","0.00" AS "Paid"
                    ,"" AS "VerCode", "A" AS "Tflag",v.cid AS "Pid"
                    ,o.hospmain AS "HMain", "80" AS "PayPlan"
                    ,v.uc_money AS "ClaimAmt"										
                    ,"" AS "OtherPayplan"
                    ,"0.00" AS "OtherPay" ,o.spclty 
                    FROM ovst o  
                    LEFT OUTER JOIN vn_stat v ON o.vn=v.vn
                    LEFT OUTER JOIN opitemrece op ON o.vn=op.vn          
                    LEFT OUTER JOIN patient p ON o.hn=p.hn   
                    LEFT OUTER JOIN pttype pt on pt.pttype = o.pttype 
                    LEFT OUTER JOIN doctor d on d.code = o.doctor 
                    WHERE o.vn IN("'.$va1->vn.'")
	                GROUP BY o.vn;
            '); 
            foreach ($ssop_billtran_ as $key => $value) {
                Ssop_billtran::insert([
                    'Station'           => $value->Station,
                    'Authencode'        => $value->Authencode,
                    'vstdate'           => $value->vstdate,
                    'DTtran'            => $value->DTtran,
                    'Hcode'             => "10978",
                    'Invno'             => $value->Invno, 
                    'VerCode'           => $value->VerCode, 
                    'Tflag'             => $value->Tflag, 
                    'HMain'             => $value->HMain, 
                    'HN'                => $value->HN, 
                    'Pid'               => $value->Pid, 
                    'Name'              => $value->Name, 
                    'Amount'            => $value->Amount, 
                    'Paid'              => $value->Paid, 
                    'ClaimAmt'          => $value->ClaimAmt, 
                    'PayPlan'           => $value->PayPlan, 
                    'OtherPay'          => $value->OtherPay, 
                    'OtherPayplan'      => $value->OtherPayplan, 
                    'pttype'            => $value->pttype, 
                    'Diag'              => $value->Diag, 
                ]);
                    
            }

            $ssop_billitems_ = DB::connection('mysql2')->select('  
                SELECT op.vn AS "Invno"
                        ,op.vstdate AS "SvDate"
                        , i.income_group AS "BillMuad"
                        , op.icode AS "LCCode"
                        ,ifnull(if(i.income in (03,04),sk.tmt_tmlt,sd.nhso_adp_code),sd.nhso_adp_code) AS STDCode
                        ,sd.name AS "Desc"        
                        ,op.qty AS "QTY"
                        , ROUND(op.unitprice,2) AS "UnitPrice"
                        , ROUND(op.sum_price,2) AS "ChargeAmt"
                        , ROUND(op.unitprice,2) AS "ClaimUP"
                        , ROUND(op.sum_price,2)  AS "ClaimAmount"
                        , op.vn AS "SvRefID"
                        , "OP1" AS "ClaimCat"
                        ,"02" As "paidst"
                        FROM opitemrece op 
                        LEFT OUTER JOIN s_drugitems sd ON sd.icode=op.icode  
                        LEFT OUTER JOIN income i ON i.income=op.income
                        LEFT OUTER JOIN pkbackoffice.ssop_drugcat_labcat sk ON sk.icode=op.icode
                        WHERE op.vn IN("'.$va1->vn.'")
                        AND op.qty <> 0 AND op.unitprice <> 0
                        AND op.paidst="02" 
            ');  
            foreach ($ssop_billitems_ as $key => $value2) {           
                $add2= new Ssop_billitems();
                $add2->Invno       = $value2->Invno ; 
                $add2->SvDate      = $value2->SvDate; 
                $add2->BillMuad    = $value2->BillMuad;
                $add2->LCCode      = $value2->LCCode;
                if ($value2->STDCode == 'XXXXXX') {
                    $add2->STDCode = '';
                } else {
                    $add2->STDCode = $value2->STDCode;
                }                        
                $add2->Desc        = $value2->Desc;
                $add2->QTY         = $value2->QTY;
                $add2->UnitPrice   = $value2->UnitPrice;
                $add2->ChargeAmt   = $value2->ChargeAmt;
                $add2->ClaimUP     = $value2->ClaimUP;
                $add2->ClaimAmount = $value2->ClaimAmount;
                $add2->SvRefID     = $value2->SvRefID;
                $add2->ClaimCat    = $value2->ClaimCat;
                $add2->paidst      = $value2->paidst; 
                $add2->save();
            } 

            $ssop_dispensing_ = DB::connection('mysql2')->select('   
                    SELECT "10978" AS "ProviderID" , o.vn AS "DispID" , o.vn AS "Invno", o.hn AS "HN", v.cid AS "PID"
                    ,CONCAT(o.vstdate,"T",o.vsttime) AS "Prescdt" , CONCAT(o.vstdate,"T",o.vsttime) AS "Dispdt"
                    ,IFNULL( (SELECT licenseno FROM doctor WHERE code=o.doctor) ,"ว64919") AS "Prescb"
                    ,SUM(IF(op.income IN ("03","17","05"),"1","")) AS "Itemcnt"
                    ,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS "ChargeAmt"
                    ,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS "ClaimAmt"
                    ,"0.00" AS "Paid" ,"0.00" AS "OtherPay" , "HP" AS "Reimburser" , "SS" AS "BenefitPlan" , "1" AS "DispeStat" , " " AS "SvID"," " AS "DayCover"				
                    FROM ovst o 
                    LEFT OUTER JOIN vn_stat v ON o.vn=v.vn
                    LEFT OUTER JOIN opitemrece op ON o.vn=op.vn
                    LEFT OUTER JOIN pttype pt on pt.pttype = o.pttype 
                    WHERE op.vn IN("'.$va1->vn.'")
                    AND op.income IN ("03","17","05") 
                    AND op.qty<>0 
                    AND op.paidst="02"
                    AND pt.pttype ="A7"
                    GROUP BY o.vn
            ');  
            foreach ($ssop_dispensing_ as $key => $value3) {           
                    $add3= new Ssop_dispensing();
                    $add3->ProviderID     = $value3->ProviderID ; 
                    $add3->DispID         = $value3->DispID; 
                    $add3->Invno          = $value3->Invno;
                    $add3->HN             = $value3->HN;
                    $add3->PID            = $value3->PID;
                    $add3->Prescdt        = $value3->Prescdt;
                    $add3->Dispdt         = $value3->Dispdt;
                    $add3->Prescb         = $value3->Prescb;
                    $add3->Itemcnt        = $value3->Itemcnt;
                    $add3->ChargeAmt      = $value3->ChargeAmt;
                    $add3->ClaimAmt       = $value3->ClaimAmt;
                    $add3->Paid           = $value3->Paid;
                    $add3->OtherPay       = $value3->OtherPay;
                    $add3->Reimburser     = $value3->Reimburser; 
                    $add3->BenefitPlan    = $value3->BenefitPlan; 
                    $add3->DispeStat      = $value3->DispeStat; 
                    $add3->SvID           = $value3->SvID; 
                    $add3->DayCover       = $value3->DayCover; 
                    $add3->save();
            } 

            $ssop_dispenseditems_ = DB::connection('mysql2')->select(' 
                    SELECT  o.vn AS "DispID", IF(di.icode<>"",di.sks_product_category_id, di.sks_product_category_id) AS "PrdCat"
                    ,op.icode AS "HospDrgID", IF(di.sks_drug_code!="",di.sks_drug_code,"") AS "DrgID" 
                    ,di.name AS "dfsText", di.units AS "Packsize"
                    ,IF(op.sp_use!="",op.sp_use,op.drugusage) AS "sigCode"
                    ,IF(op.sp_use!=""
                    ,(SELECT CONCAT( ifnull(name1,""), ifnull(name2,""), ifnull(name3,"") ) FROM sp_use where sp_use=op.sp_use )
                    ,(SELECT CONCAT( ifnull(name1,""), ifnull(name2,""), ifnull(name3,"") ) FROM drugusage WHERE drugusage=op.drugusage )
                    ) AS "sigText"
                    , op.qty AS "Quantity", ROUND(op.unitprice,2) AS "UnitPrice", ROUND(op.sum_price,2) AS "ChargeAmt", ROUND(op.unitprice,2) AS "ReimbPrice", ROUND(op.sum_price,2) AS 					"ReimbAmt","" AS "PrdSeCode"
                    ,"OD" AS "Claimcont", "OP1" AS "ClaimCat"              
                    ,"02" AS "paidst"
                    FROM ovst o  
                    LEFT JOIN opitemrece op ON o.vn=op.vn
                    LEFT JOIN pttype pt on pt.pttype = o.pttype 
                    LEFT JOIN s_drugitems di ON di.icode=op.icode
                    WHERE o.vn IN("'.$va1->vn.'")
                    AND op.income IN ("03","17","05") 
                    AND op.qty<>0 
                    AND op.paidst="02"
                    AND pt.pttype ="A7"   
            ');
            foreach ($ssop_dispenseditems_ as $key => $value4) {           
                $add4= new Ssop_dispenseditems();
                $add4->DispID         = $value4->DispID ; 
                $add4->PrdCat         = $value4->PrdCat; 
                $add4->HospDrgID      = $value4->HospDrgID;
                $add4->DrgID          = $value4->DrgID;
                $add4->dfsText        = $value4->dfsText;
                
    
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
                
                $add4->Quantity      = $value4->Quantity;
                $add4->UnitPrice     = $value4->UnitPrice;
                $add4->ChargeAmt     = $value4->ChargeAmt;
                $add4->ReimbPrice    = $value4->ReimbPrice;
                $add4->ReimbAmt      = $value4->ReimbAmt;
                $add4->PrdSeCode     = $value4->PrdSeCode; 
                $add4->Claimcont     = $value4->Claimcont; 
                $add4->ClaimCat      = $value4->ClaimCat; 
                $add4->paidst        = $value4->paidst;  
                $add4->save();
            } 

            $ssop_opservices_ = DB::connection('mysql2')->select('   
                SELECT o.vn AS "Invno", o.vn AS "SvID", "EC" AS "Class", "10978" AS "Hcode", o.hn AS "HN", v.cid AS "PID"
                ,"1" AS "CareAccount", "01" AS "TypeServ", "1" AS "TypeIn", "1" AS "TypeOut", "" AS "DTAppoint"
                ,CASE  
                WHEN d.licenseno LIKE "-%" THEN "ว71021"
                WHEN d.licenseno LIKE "พท%" THEN d.licenseno
                WHEN d.licenseno LIKE "พ%" THEN "ว34064"  
                ELSE "ว64919" 
                END as SvPID

                ,IF(o.spclty NOT IN ("01","02","03","04","05","06","07","08","09","10","11","12"),"99",o.spclty) AS "Clinic"
                , CONCAT(o.vstdate,"T",o.vsttime) AS "BegDT", CONCAT(o.vstdate,"T",o.vsttime) AS "EndDT"
                ,op.icode as LcCode
                ,ifnull(case  
                when inc.income in (02) then sd.nhso_adp_code
                when inc.income in (03,04) then dd.billcode 
                when inc.income in (06,07) then sd.nhso_adp_code
                else sd.nhso_adp_code end,"") CSCode
                , "" AS "CodeSet"
                ,ifnull(case  
                when inc.income in (03,04) then dd.tmt_tmlt
                when inc.income in (06,07) then dd.tmt_tmlt
                else "" end,"") STDCode

                , "0.00" AS "SvCharge", "Y" AS "Completion", "" AS "SvTxCode", "OP1" AS "ClaimCat"
                FROM ovst o  
                LEFT OUTER JOIN vn_stat v ON o.vn=v.vn
                LEFT OUTER JOIN ovstdiag ov on ov.vn = v.vn
                LEFT OUTER JOIN doctor d on d.`code` = ov.doctor
                left outer join opitemrece op on op.vn=o.vn
                LEFT OUTER JOIN income inc on inc.income=op.income
                LEFT OUTER JOIN s_drugitems sd on op.icode=sd.icode
                LEFT OUTER JOIN pkbackoffice.ssop_drugcat_labcat dd on dd.icode=op.icode
                WHERE o.vn IN("'.$va1->vn.'")
                AND v.pttype ="A7"
                GROUP BY o.vn
                
            ');  
        
            foreach ($ssop_opservices_ as $key => $value5) {           
                $add5= new Ssop_opservices();
                $add5->Invno       = $value5->Invno ; 
                $add5->SvID        = $value5->SvID; 
                $add5->Class       = $value5->Class;
                $add5->Hcode       = $value5->Hcode;
                $add5->HN          = $value5->HN; 
                $add5->PID         = $value5->PID;
                $add5->CareAccount = $value5->CareAccount;
                $add5->TypeServ    = $value5->TypeServ;
                $add5->TypeIn      = $value5->TypeIn;
                $add5->TypeOut     = $value5->TypeOut;
                $add5->DTAppoint   = $value5->DTAppoint; 
                $add5->SvPID       = $value5->SvPID; 
                $add5->Clinic      = $value5->Clinic; 
                $add5->BegDT       = $value5->BegDT;
                $add5->EndDT       = $value5->EndDT;
                $add5->LcCode      = $value5->LcCode;
                $add5->CodeSet     = $value5->CodeSet;
                $add5->STDCode     = $value5->STDCode;
                $add5->SvCharge    = $value5->SvCharge;
                $add5->Completion  = $value5->Completion;
                $add5->SvTxCode    = $value5->SvTxCode;
                $add5->ClaimCat    = $value5->ClaimCat;  
                $add5->save();
            } 

            $ssop_opdx_ = DB::connection('mysql2')->select('   
                SELECT "EC" AS "Class", o.vn AS "SvID", od.diagtype AS "SL", "IT" AS "CodeSet" 
                ,IF(od.icd10 like "M%", SUBSTR(od.icd10,1,4) ,IF(od.icd10 like "Z%", SUBSTR(od.icd10,1,4) ,od.icd10)) as code
                ," " as "Desc"

                FROM ovst o 
               
                LEFT JOIN ovstdiag od ON o.vn=od.vn
                WHERE o.vn IN("'.$va1->vn.'")
                AND od.icd10 NOT BETWEEN "0000" AND "9999"            
            '); 
            // Ssop_opdx::truncate();
            foreach ($ssop_opdx_ as $key => $valueop) {           
                $addop= new Ssop_opdx();
                $addop->Class     = $valueop->Class ; 
                $addop->SvID      = $valueop->SvID; 
                $addop->SL        = $valueop->SL;
                $addop->CodeSet   = $valueop->CodeSet;
                $addop->code      = $valueop->code; 
                $addop->Desc      = $valueop->Desc; 
                $addop->save();
            } 

        }

        return response()->json([
            'status'    => '200'
        ]);
    }
    
    
    public function ssop_prescb_update(Request $request)
    {
        // $ssop_dispensing = DB::connection('mysql7')->select('   
        //     SELECT * FROM ssop_dispensing   
        // ');  
        $id = $request->ids; 
        Ssop_dispensing::whereIn('ssop_dispensing_id',explode(",",$id)) 
                    ->update([   
                        'Prescb'  => 'ว64919'
                    ]); 
        return response()->json([
            'status'     => '200' 
        ]); 
    }
    public function ssop_svpid_update(Request $request)
    {
        $id = $request->ids2; 
        Ssop_opservices::whereIn('ssop_opservices_id',explode(",",$id)) 
                    ->update([   
                        'SvPID'  => 'ว64919'
                    ]);
        return response()->json([
            'status'     => '200' 
        ]);
        // return redirect()->route('claim.ssop'); 
    }
     
    
    public function ssop_export(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
        $ip = $request->ip(); 
        // dd($datestart);
        $sss_date_now = date("Y-m-d");
        $sss_time_now = date("H:i:s");
        $sesid_status = 'new'; #ส่งค่าสำหรับเงื่อนไขการบันทึกsession
           #delete file in folder ทั้งหมด
           $file = new Filesystem;
           $file->cleanDirectory('Export_ssop'); //ทั้งหมด

        #sessionid เป็นค่าว่าง แสดงว่ายังไม่เคยส่งออก ต้องสร้างไอดีใหม่ จาก max+1
        $maxid = Ssop_session::max('ssop_session_no');
        $ssop_session_no = $maxid+1;  

        // dd($ssop_session_no);
        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        #ตัดขีด, ตัด : ออก
     
        $folder='10978_SSOPBIL_'.$ssop_session_no.'_01_'.$sss_date_now_preg.'-'.$sss_time_now_preg;
        // dd($folder);
        $add = new Ssop_session();
        $add->ssop_session_no = $ssop_session_no;
        $add->ssop_session_date = $sss_date_now;
        $add->ssop_session_time = $sss_time_now;
        $add->ssop_session_filename = $folder;
        $add->ssop_session_ststus = "Send";
        $add->save();

        mkdir ('Export_ssop/'.$folder, 0777, true);
   
        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        $file_name = "/BillTran".$sss_time_now_preg.".txt";
        // SELECT COUNT(*) from claim_ssop
        $ssop_count = DB::connection('mysql')->select('      
            SELECT COUNT(*) as Invno             
            FROM ssop_billtran            
        '); 
        foreach ($ssop_count as $key => $valuecount) {
            $count = $valuecount->Invno;
        }

        $file_pat = "Export_ssop/".$folder."/BillTran".$sss_date_now_preg.".txt";     
        $objFopen_opd = fopen($file_pat, 'w');

        $file_pat2 = "Export_ssop/".$folder."/BillDisp".$sss_date_now_preg.".txt";     
        $objFopen_opd2 = fopen($file_pat2, 'w');

        $file_pat3 = "Export_ssop/".$folder."/OPServices".$sss_date_now_preg.".txt";     
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

        $ssop_Billtran = DB::connection('mysql')->select('   
            SELECT * from ssop_billtran            
        ');

        foreach ($ssop_Billtran as $key => $value2) {
            $b1 = $value2->Station; 
            $b3 = $value2->DTtran;
            $b4 = $value2->Hcode;
            $b5 = $value2->Invno; 
            $b7 = $value2->HN; 
            $b9 = $value2->Amount;
            $b10 = $value2->Paid;
            // $b11 = $value2->B11;
            $b12 = $value2->Tflag;
            $b13 = $value2->Pid;
            $b14= $value2->Name;
            $b15 = $value2->HMain;
            $b16= $value2->PayPlan; 
            $b17= $value2->ClaimAmt; 
            $b19 = $value2->OtherPay;
            $strText2="\n".$b1."||".$b3."|".$b4."|".$b5."||".$b7."||".$b9."|".$b10."||".$b12."|".$b13."|".$b14."|".$b15."|".$b16."|".$b17."||".$b19;
            $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
            fwrite($objFopen_opd, $ansitxt_pat2);
        }
         
        $opd_head = "\n".'</BILLTRAN>';
        fwrite($objFopen_opd, $opd_head);
  
        $opd_head = "\n".'<BillItems>';
        fwrite($objFopen_opd, $opd_head);
  
        $ssop_items = DB::connection('mysql')->select('   
            SELECT * FROM ssop_billitems  
            ');
        foreach ($ssop_items as $key => $value) {
            $s1 = $value->Invno;
            $s2 = $value->SvDate;
            $s3 = $value->BillMuad;
            $s4 = $value->LCCode;
            $s5 = $value->STDCode;
            $s6 = $value->Desc; 
            $s7 = $value->QTY;
            $s8 = $value->UnitPrice;
            $s9 = $value->ChargeAmt;
            $s10 = $value->ClaimUP;
            $s11 = $value->ClaimAmount;
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
  
        $BillDispcount = DB::connection('mysql')->select('      
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

        $ssop_dispensing = DB::connection('mysql')->select('   
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
            $c10 = $value3->ChargeAmt;
            $c11 = $value3->ClaimAmt;
            $c12 = $value3->Paid;
            $c13 = $value3->OtherPay;
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

        $DispensedItems = DB::connection('mysql')->select('   
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
  
        $opservices = DB::connection('mysql')->select('      
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
        
        $opservices = DB::connection('mysql')->select('   
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

        $ssop_opdx_ = DB::connection('mysql')->select('   
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

 
         
            return redirect()->route('claim.ssop');      
           
    }
    
    
    public function ssop_zipfile(Request $request)
    {     
     
        $filename = Ssop_session::max('ssop_session_no'); 
        $nzip = Ssop_session::where('ssop_session_no','=',$filename)->first(); 
        $namezip = $nzip->ssop_session_filename; 
        $pathdir =  "Export_ssop/".$namezip."/";
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
    }

    public function ssop_data_vn(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
        $vn = $request->VN; 

        $ssop_billtran_ = DB::connection('mysql3')->select('   
            SELECT o.vn as Invno,p.hn as HN,o.an,o.vstdate,o.vsttime,o.hcode as Hcode,pt.pttype,v.pdx as Diag,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.sex,v.uc_money
            ,op.icode,op.qty,op.unitprice,op.income,op.paidst,op.sum_price,CONCAT(p.pname,p.fname," ",p.lname) AS "Name",pt.nhso_code
            ,d.name as doctorname,d.licenseno
            ,"01" AS "Station", "" AS "Authencode", CONCAT(o.vstdate,"T",o.vsttime) AS "DTtran","" AS "Billno"
            , "" AS "MemberNo",v.uc_money AS "Amount","0.00" AS "Paid"
            ,"" AS "VerCode", "A" AS "Tflag",v.cid AS "Pid"
            ,o.hospmain AS "HMain", "80" AS "PayPlan"
			,v.uc_money AS "ClaimAmt"
            
			,"" AS "OtherPayplan"
			,"0.00" AS "OtherPay" ,o.spclty 
            FROM ovst o 
			LEFT JOIN vn_stat v ON o.vn=v.vn
			LEFT JOIN opitemrece op ON o.vn=op.vn
			LEFT JOIN patient p ON o.hn=p.hn   
            LEFT JOIN pttype pt on pt.pttype = o.pttype 
			LEFT JOIN doctor d on d.code = o.doctor
            WHERE o.vn = "'.$vn.'"
            AND op.qty<>0
            AND pt.pttype ="A7"
			GROUP BY o.vn    
        '); 
        // AND pt.pttype ="A7"
        // ,v.uc_money AS "ClaimAmt"
        // ,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS "ClaimAmt"
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

            $check_vn = Stm::where('VN','=',$value->Invno)->count();
            $datenow = date('Y-m-d H:m:s');
            
            if ($check_vn > 0) {
                Stm::where('VN', $value->Invno) 
                        ->update([  
                            'VN'                => $value->Invno,
                            'HN'                => $value->HN,
                            'PID'               => $value->Pid,
                            'VSTDATE'           => $value->vstdate,
                            'FULLNAME'          => $value->Name,  
                            'MAININSCL'         => "SSS",
                            'created_at'        => $datenow, 
                            'ClaimAmt'          =>$value->ClaimAmt
                        ]);
            } else {
                Stm::insert([                        
                    // 'AN'                => $value->AN, 
                    'VN'                => $value->Invno,
                    'HN'                => $value->HN,
                    'PID'               => $value->Pid,
                    'VSTDATE'           => $value->vstdate,
                    'FULLNAME'          => $value->Name,  
                    'MAININSCL'         => "SSS",
                    'created_at'        => $datenow, 
                    'ClaimAmt'          =>$value->ClaimAmt
                ]);
            }
             
        }    
        $ssop_billitems_ = DB::connection('mysql3')->select('   
            SELECT o.vn AS "Invno"
                ,o.vstdate AS "SvDate"
                , i.income_group AS "BillMuad"
                , op.icode AS "LCCode"
                ,ifnull(if(i.income in (03,04),sk.tmt_tmlt,dt.nhso_adp_code),n.nhso_adp_code) AS STDCode
                ,sd.name AS "Desc"        
                ,op.qty AS "QTY"
                , ROUND(op.unitprice,2) AS "UnitPrice"
                , ROUND(op.sum_price,2) AS "ChargeAmt"
                , ROUND(op.unitprice,2) AS "ClaimUP"
                , ROUND(op.sum_price,2)  AS "ClaimAmount"
                , o.vn AS "SvRefID"
                , "OP1" AS "ClaimCat"
                ,op.paidst As "paidst"						
            FROM ovst o  
            LEFT JOIN opitemrece op ON o.vn=op.vn 
            LEFT JOIN patient p ON o.hn=p.hn   
            LEFT JOIN pttype pt on pt.pttype = o.pttype 
            LEFT JOIN doctor d on d.code = o.doctor
            LEFT JOIN s_drugitems sd ON sd.icode=op.icode  
            LEFT JOIN drugitems dt ON dt.icode=op.icode
			LEFT JOIN nondrugitems n ON n.icode=op.icode
            LEFT JOIN claim.income i ON i.income=op.income
            LEFT JOIN claim.aipn_drugcat_labcat sk ON sk.icode=op.icode
            
            WHERE o.vn = "'.$vn.'"
            AND op.qty<>0
            AND op.paidst="02"
            AND pt.pttype ="A7"
            
        ');  
        // ,ifnull(if(inc.group1 in (03,04),dd.tmt_tmlt,d.nhso_adp_code),"") CSCode
        // ,sd.sks_drug_code AS "STDCode"
        // ,sd.nhso_adp_code AS "STDCode"
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
			,IFNULL( (SELECT licenseno FROM doctor WHERE code=o.doctor) ,"ว64919") AS Prescb
			,SUM(IF(op.income IN ("03","17","05"),"1","")) AS Itemcnt
			,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS ChargeAmt
			,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS ClaimAmt
			,"0.00" AS "Paid" ,"0.00" AS "OtherPay" , "HP" AS "Reimburser" , "SS" AS "BenefitPlan" , "1" AS "DispeStat" , " " AS "SvID"," " AS "DayCover"				
            FROM ovst o 
			LEFT JOIN vn_stat v ON o.vn=v.vn
			LEFT JOIN opitemrece op ON o.vn=op.vn
			LEFT JOIN pttype pt on pt.pttype = o.pttype 
            WHERE o.vn = "'.$vn.'"  
            AND op.income IN ("03","17","05")        
			AND op.qty<>0 			
			AND pt.pttype ="A7"
            GROUP BY o.vn    
        ');  
        // AND op.income IN ("03","17","05") 
        // AND op.paidst="02"
        // ,IFNULL( (SELECT licenseno FROM doctor WHERE code=o.doctor) ,"ว64921") AS "Prescb"
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
            WHERE o.vn = "'.$vn.'"
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
            WHERE o.vn = "'.$vn.'" 
            AND v.pttype ="A7"
            GROUP BY o.vn
            
        ');  
        // ,IFNULL( (SELECT licenseno FROM doctor WHERE code=o.doctor) ,"ว64919") AS "SvPID"
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
            SELECT "EC" AS "Class", o.vn AS "SvID", od.diagtype AS "SL" 
            
            ,CASE 
            WHEN od.icd10 BETWEEN "U000" AND "U99999" THEN "TT"
            ELSE "IT" end CodeSet

            ,IF(od.icd10 like "M%", SUBSTR(od.icd10,1,4) ,IF(od.icd10 like "Z%", SUBSTR(od.icd10,1,4) ,od.icd10)) as code
            ," " as "Desc"
        
            FROM ovst o 
            LEFT JOIN ovstdiag od ON o.vn=od.vn
            WHERE o.vn = "'.$vn.'"
            AND od.icd10 NOT BETWEEN "0000" AND "9999"            
        '); 
        Ssop_opdx::truncate();
        foreach ($ssop_opdx_ as $key => $valueop) {      
            $co = $valueop->code; 
                   

            $addop= new Ssop_opdx();
            $addop->Class = $valueop->Class ; 
            $addop->SvID = $valueop->SvID; 
            $addop->SL = $valueop->SL;
            $addop->CodeSet = $valueop->CodeSet;
            $addop->code = $co; 
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
            'ssop_opservices'    => $ssop_opservices,
            'ssop_opdx_'        => $ssop_opdx_,
            'vn'                =>$vn
        ]);
    }
    
  
}
