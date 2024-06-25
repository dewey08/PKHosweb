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
use App\Models\D_export_ucep;
use App\Models\D_claim;
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
use App\Models\D_ucep24_main;
use App\Models\D_ucep24;
use App\Models\Acc_ucep24;

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
use Arr;
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
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;

date_default_timezone_set("Asia/Bangkok");


class Ucep24Controller extends Controller
 { 
    // ***************** ucep24********************************

    public function ucep24(Request $request)
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
                 
                $data = DB::connection('mysql')->select('SELECT * from acc_ucep24 group by an');  

            } else {
                $data_ = DB::connection('mysql')->select('   
                        SELECT a.vn,o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                        ,i.dchdate,ii.pttype
                        ,o.icode,n.`name` as namelist,a.vstdate,o.rxdate,a.vsttime,o.rxtime,o.income,o.qty,o.unitprice,o.sum_price
                        ,hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate,"",o.rxtime))) ssz
                        FROM hos.ipt i
                        LEFT JOIN hos.opitemrece o on i.an = o.an 
                        LEFT JOIN hos.ovst a on a.an = o.an
                        left JOIN hos.er_regist e on e.vn = i.vn
                        LEFT JOIN hos.ipt_pttype ii on ii.an = i.an
                        LEFT JOIN hos.pttype p on p.pttype = ii.pttype 
                        LEFT JOIN hos.s_drugitems n on n.icode = o.icode
                        LEFT JOIN hos.patient pt on pt.hn = a.hn
                        LEFT JOIN hos.pttype ptt on a.pttype = ptt.pttype	
                        
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and o.an is not null
                        and o.paidst ="02"
                        and p.hipdata_code ="ucs"
                        and DATEDIFF(o.rxdate,a.vstdate)<="1"
                        and hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate," ",o.rxtime))) <="24"
                        and e.er_emergency_type  in("1","2","5")
                       
                        group BY i.an,o.icode,o.rxdate
                        ORDER BY i.an;
                '); 
                // and n.nhso_adp_code in(SELECT code from hshooterdb.h_ucep24)
                Acc_ucep24::truncate();
                foreach ($data_ as $key => $value) {    
                    Acc_ucep24::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'rxdate'            => $value->rxdate,
                        'dchdate'           => $value->dchdate,
                        // 'pttype'            => $value->pttype, 
                        'income'            => $value->income, 
                        'icode'             => $value->icode,
                        'name'              => $value->namelist,
                        'qty'               => $value->qty,
                        'unitprice'         => $value->unitprice,
                        'sum_price'         => $value->sum_price, 
                    ]);
                }
                $data = DB::connection('mysql')->select('SELECT * from acc_ucep24 group by an');  
            }
                  
            return view('ucep.ucep24',[
                'startdate'        =>     $startdate,
                'enddate'          =>     $enddate, 
                'data'             =>     $data, 
            ]);
    }

    public function ucep24_an(Request $request,$an)
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
 
                $data = DB::connection('mysql')->select('   
                       

                        select o.an,i.income,i.name as nameliss,sum(o.qty) as qty,
                        (select sum(sum_price) from hos.opitemrece where an=o.an and income = o.income and paidst in("02")) as paidst02,
                        (select sum(sum_price) from hos.opitemrece where an=o.an and income = o.income and paidst in("01","03")) as paidst0103,
                        (select sum(u.sum_price) from acc_ucep24 u where u.an= o.an and i.income = u.income) as paidst_ucep
                        from hos.opitemrece o
                        left outer join hos.nondrugitems n on n.icode = o.icode
                        left outer join hos.income i on i.income = o.income
                        where o.an = "'.$an.'"  
                        group by i.name
                        order by i.income
                      
                '); 

                // SELECT o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                // ,i.dchdate,ii.pttype
                // ,o.icode,n.name as nameliss,a.vstdate,o.rxdate,a.vsttime,o.rxtime,o.income,o.qty,o.unitprice,o.sum_price
                // ,hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate,"",o.rxtime))) ssz
                // from hos.opitemrece o
                // LEFT JOIN hos.ipt i on i.an = o.an
                // LEFT JOIN hos.ovst a on a.an = o.an
                // left JOIN hos.er_regist e on e.vn = i.vn
                // LEFT JOIN hos.ipt_pttype ii on ii.an = i.an
                // LEFT JOIN hos.pttype p on p.pttype = ii.pttype 
                // LEFT JOIN hos.s_drugitems n on n.icode = o.icode
                // LEFT JOIN hos.patient pt on pt.hn = a.hn
                // LEFT JOIN hos.pttype ptt on a.pttype = ptt.pttype	
                
                // WHERE i.an = "'.$an.'"  
                // and o.paidst ="02"
                // and p.hipdata_code ="ucs"
                // and DATEDIFF(o.rxdate,a.vstdate)<="1"
                // and hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate," ",o.rxtime))) <="24"
                // and e.er_emergency_type  in("1","5")
                // and n.nhso_adp_code in(SELECT code from hshooterdb.h_ucep24)
                // select i.income,i.name,sum(o.qty),
                // (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in('02')),
                // (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in('01','03')),
                // (select sum(u.sum_price) from eclaimdb80.ucep_an u where u.an= o.an and i.income = u.income)

                // from opitemrece o
                // left outer join nondrugitems n on n.icode = o.icode
                // left outer join income i on i.income = o.income
                // where o.an ='666666666' 
                // group by i.name
                // order by i.income
             

            return view('ucep.ucep24_an',[
                'startdate'        =>     $startdate,
                'enddate'          =>     $enddate, 
                'data'             =>     $data, 
            ]);
    }
    public function ucep24_income(Request $request,$an,$income)
    { 
            $startdate = $request->startdate;
            $enddate = $request->enddate;
            // select *
            // from acc_ucep24                         
            // where an = "'.$an.'"  and income = "'.$income.'" 
                $data = DB::connection('mysql')->select('  
                        select o.income,ifnull(n.icode,d.icode) as icode,ifnull(n.billcode,n.nhso_adp_code) as nhso_adp_code,ifnull(n.name,d.name) as dname,sum(o.qty) as qty,sum(sum_price) as sum_price
                        ,(SELECT sum(qty) from pkbackoffice.acc_ucep24 where an = o.an and icode = o.icode) as qty_ucep ,o.unitprice
                        ,(SELECT sum(sum_price) from pkbackoffice.acc_ucep24 where an = o.an and icode = o.icode) as price_ucep
                        from hos.opitemrece o
                        left outer join hos.nondrugitems n on n.icode = o.icode
                        left outer join hos.drugitems d on d.icode = o.icode
                        left outer join hos.income i on i.income = o.income
                        where o.an = "'.$an.'"
                        and o.income = "'.$income.'" 
                        group by o.icode
                        order by o.icode
                '); 

            return view('ucep.ucep24_income',[
                'startdate'        =>     $startdate,
                'enddate'          =>     $enddate, 
                'data'             =>     $data, 
                'an'               =>     $an, 
                'income'           =>     $income, 
            ]);
    }

    public function ucep24_claim(Request $request)
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

                
            } else {
                $iduser = Auth::user()->id;
                D_ucep24_main::truncate();
                D_ucep24::truncate();
               
                $data_opitem = DB::connection('mysql')->select('   
                        SELECT a.vn,o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                        ,i.dchdate,ii.pttype,p.hipdata_code
                        ,o.icode,n.`name` as namelist,a.vstdate,o.rxdate,a.vsttime,o.rxtime,o.income,o.qty,o.unitprice,o.sum_price
                        ,hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate,"",o.rxtime))) ssz
                        FROM hos.ipt i
                        LEFT JOIN hos.opitemrece o on i.an = o.an 
                        LEFT JOIN hos.ovst a on a.an = o.an
                        left JOIN hos.er_regist e on e.vn = i.vn
                        LEFT JOIN hos.ipt_pttype ii on ii.an = i.an
                        LEFT JOIN hos.pttype p on p.pttype = ii.pttype 
                        LEFT JOIN hos.s_drugitems n on n.icode = o.icode
                        LEFT JOIN hos.patient pt on pt.hn = a.hn
                        LEFT JOIN hos.pttype ptt on a.pttype = ptt.pttype	                        
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and o.an is not null
                        and o.paidst ="02"
                        and p.hipdata_code ="ucs"
                        and DATEDIFF(o.rxdate,a.vstdate)<="1"
                        and hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate," ",o.rxtime))) <="24"
                        and e.er_emergency_level_id  in("1","2")                       
                        group BY i.an,o.icode,o.rxdate
                        ORDER BY i.an;
                ');                  
                foreach ($data_opitem as $key => $value) {    
                    D_ucep24::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an, 
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'pttype'            => $value->pttype,
                        'hipdata_code'      => $value->hipdata_code,
                        'vstdate'           => $value->vstdate,
                        'rxdate'            => $value->rxdate,
                        'dchdate'           => $value->dchdate, 
                        'icode'             => $value->icode, 
                        'name'              => $value->namelist,
                        'qty'               => $value->qty,
                        'unitprice'         => $value->unitprice,
                        'sum_price'         => $value->sum_price, 
                        'user_id'           => Auth::user()->id 
                    ]);
                }

                $data_opitem_inst = DB::connection('mysql')->select('   
                        SELECT a.vn,o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                        ,i.dchdate,ii.pttype,p.hipdata_code
                        ,o.icode,n.`name` as namelist,a.vstdate,o.rxdate,a.vsttime,o.rxtime,o.income,o.qty,o.unitprice,o.sum_price
                        ,hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate,"",o.rxtime))) ssz
                        FROM hos.ipt i
                        LEFT JOIN hos.opitemrece o on i.an = o.an 
                        LEFT JOIN hos.ovst a on a.an = o.an
                        left JOIN hos.er_regist e on e.vn = i.vn
                        LEFT JOIN hos.ipt_pttype ii on ii.an = i.an
                        LEFT JOIN hos.pttype p on p.pttype = ii.pttype 
                        LEFT JOIN hos.s_drugitems n on n.icode = o.icode
                        LEFT JOIN hos.patient pt on pt.hn = a.hn
                        LEFT JOIN hos.pttype ptt on a.pttype = ptt.pttype	                        
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                        and o.an is not null
                        and o.paidst ="02"
                        and p.hipdata_code ="ucs" 
                        and e.er_emergency_level_id  in("1","2")  
                        and o.income IN("02","18")                    
                        group BY i.an,o.icode,o.rxdate
                        ORDER BY i.an;
                ');   
                foreach ($data_opitem_inst as $key => $value_ins) {    
                    $check_ins = D_ucep24::where('an',$value_ins->an)->where('icode','=','icode')->count();
                    if ($check_ins > 0) {
                        # code...
                    } else {
                        D_ucep24::insert([
                            'vn'                => $value_ins->vn,
                            'hn'                => $value_ins->hn,
                            'an'                => $value_ins->an, 
                            'cid'               => $value_ins->cid,
                            'ptname'            => $value_ins->ptname,
                            'pttype'            => $value_ins->pttype,
                            'hipdata_code'      => $value_ins->hipdata_code,
                            'vstdate'           => $value_ins->vstdate,
                            'rxdate'            => $value_ins->rxdate,
                            'dchdate'           => $value_ins->dchdate, 
                            'icode'             => $value_ins->icode, 
                            'name'              => $value_ins->namelist,
                            'qty'               => $value_ins->qty,
                            'unitprice'         => $value_ins->unitprice,
                            'sum_price'         => $value_ins->sum_price, 
                            'user_id'           => Auth::user()->id 
                        ]);
                    }
                    
                    
                }       

                $data_opitem0218 = DB::connection('mysql')->select('   
                        SELECT a.vn,o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                        ,i.dchdate,ii.pttype,p.hipdata_code
                        ,o.icode,n.`name` as namelist,a.vstdate,o.rxdate,a.vsttime,o.rxtime,o.income,o.qty,o.unitprice,o.sum_price
                        ,hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate,"",o.rxtime))) ssz
                        FROM hos.ipt i
                        LEFT JOIN hos.opitemrece o on i.an = o.an AND o.income IN("02","18") 
                        LEFT JOIN hos.ovst a on a.an = o.an
                        left JOIN hos.er_regist e on e.vn = i.vn
                        LEFT JOIN hos.ipt_pttype ii on ii.an = i.an
                        LEFT JOIN hos.pttype p on p.pttype = ii.pttype 
                        LEFT JOIN hos.s_drugitems n on n.icode = o.icode
                        LEFT JOIN hos.patient pt on pt.hn = a.hn
                        LEFT JOIN hos.pttype ptt on a.pttype = ptt.pttype	                        
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and o.an is not null
                        and o.paidst ="02"
                        and p.hipdata_code ="ucs"
                        AND o.qty <> 0
                        and e.er_emergency_level_id  in("1","2")                       
                        group BY i.an,o.icode,o.rxdate
                        ORDER BY i.an;
                ');                  
                foreach ($data_opitem0218 as $key => $va0218) {    
                    D_ucep24::insert([
                        'vn'                => $va0218->vn,
                        'hn'                => $va0218->hn,
                        'an'                => $va0218->an, 
                        'cid'               => $va0218->cid,
                        'ptname'            => $va0218->ptname,
                        'pttype'            => $va0218->pttype,
                        'hipdata_code'      => $va0218->hipdata_code,
                        'vstdate'           => $va0218->vstdate,
                        'rxdate'            => $va0218->rxdate,
                        'dchdate'           => $va0218->dchdate, 
                        'icode'             => $va0218->icode, 
                        'name'              => $va0218->namelist,
                        'qty'               => $va0218->qty,
                        'unitprice'         => $va0218->unitprice,
                        'sum_price'         => $va0218->sum_price, 
                        'user_id'           => Auth::user()->id 
                    ]); 
                }

                $data_main_ = DB::connection('mysql')->select('   
                    SELECT a.vn,o.an,o.hn,pt.cid,i.pttype,CONCAT(pt.pname,pt.fname," ",pt.lname) ptname,i.dchdate,ptt.hipdata_code,o.qty,o.sum_price,i1.icd10 as DIAG
                        FROM hos.ipt i
                        LEFT JOIN hos.opitemrece o on i.an = o.an 
                        LEFT JOIN hos.ovst a on a.an = o.an
                        left JOIN hos.er_regist e on e.vn = i.vn
                        LEFT JOIN hos.ipt_pttype ii on ii.an = i.an
                        LEFT JOIN hos.pttype p on p.pttype = ii.pttype 
                        LEFT JOIN hos.s_drugitems n on n.icode = o.icode
                        LEFT JOIN hos.patient pt on pt.hn = a.hn
                        LEFT JOIN hos.pttype ptt on a.pttype = ptt.pttype 
                        LEFT OUTER JOIN hos.iptdiag i1 on i1.an= i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and o.an is not null
                        and o.paidst ="02"
                        and p.hipdata_code ="ucs"
                        and DATEDIFF(o.rxdate,a.vstdate)<="1"
                        and hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate," ",o.rxtime))) <="24"
                        and e.er_emergency_level_id in("1","2")  
                        AND i1.icd10 <> "" AND o.qty <> 0                     
                        group BY i.an
                        ORDER BY i.an;
                ');                 
                foreach ($data_main_ as $key => $value2) {    
                    D_ucep24_main::insert([
                        'vn'                => $value2->vn,
                        'hn'                => $value2->hn,
                        'an'                => $value2->an 
                    ]);
                    
                }   

                $data_total_ = DB::connection('mysql')->select('SELECT vn,an,hn,cid,ptname,pttype,hipdata_code,vstdate,dchdate,SUM(qty) as qty,SUM(sum_price) as sum_price FROM D_ucep24 WHERE qty > 0 GROUP BY an'); 
                foreach ($data_total_ as $key => $vatotal) {
                    $check_to = D_claim::where('an',$vatotal->an)->where('nhso_adp_code','=','UCEP24')->count();
                        if ($check_to > 0) { 
                        } else {
                            D_claim::insert([
                                'vn'                => $vatotal->vn,
                                'hn'                => $vatotal->hn,
                                'an'                => $vatotal->an,
                                'cid'               => $vatotal->cid,
                                'pttype'            => $vatotal->pttype,
                                'ptname'            => $vatotal->ptname,
                                'dchdate'           => $vatotal->dchdate,
                                'hipdata_code'      => $vatotal->hipdata_code,
                                'qty'               => $vatotal->qty,
                                'sum_price'         => $vatotal->sum_price,
                                'type'              => 'IPD',
                                'nhso_adp_code'     => 'UCEP24',
                                'claimdate'         => $date, 
                                'userid'            => $iduser, 
                            ]);
                        }  
                }
                        
                


            }
            $data_main = DB::connection('mysql')->select('SELECT * from d_ucep24_main');  
            $data = DB::connection('mysql')->select('SELECT * from d_ucep24 group by an');
            $data['data_opd'] = DB::connection('mysql')->select('SELECT * from d_opd WHERE d_anaconda_id ="UCEP24"'); 
            $data['data_orf'] = DB::connection('mysql')->select('SELECT * from d_orf WHERE d_anaconda_id ="UCEP24"'); 
            $data['data_oop'] = DB::connection('mysql')->select('SELECT * from d_oop WHERE d_anaconda_id ="UCEP24"');
            $data['data_odx'] = DB::connection('mysql')->select('SELECT * from d_odx WHERE d_anaconda_id ="UCEP24"');
            $data['data_idx'] = DB::connection('mysql')->select('SELECT * from d_idx WHERE d_anaconda_id ="UCEP24"');
            $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from d_ipd WHERE d_anaconda_id ="UCEP24"');
            $data['data_irf'] = DB::connection('mysql')->select('SELECT * from d_irf WHERE d_anaconda_id ="UCEP24"');
            $data['data_aer'] = DB::connection('mysql')->select('SELECT * from d_aer WHERE d_anaconda_id ="UCEP24"');
            $data['data_iop'] = DB::connection('mysql')->select('SELECT * from d_iop WHERE d_anaconda_id ="UCEP24"');
            $data['data_adp'] = DB::connection('mysql')->select('SELECT * from d_adp WHERE d_anaconda_id ="UCEP24"');
            $data['data_pat'] = DB::connection('mysql')->select('SELECT * from d_pat WHERE d_anaconda_id ="UCEP24"');
            $data['data_cht'] = DB::connection('mysql')->select('SELECT * from d_cht WHERE d_anaconda_id ="UCEP24"');
            $data['data_cha'] = DB::connection('mysql')->select('SELECT * from d_cha WHERE d_anaconda_id ="UCEP24"');
            $data['data_ins'] = DB::connection('mysql')->select('SELECT * from d_ins WHERE d_anaconda_id ="UCEP24"');
            $data['data_dru'] = DB::connection('mysql')->select('SELECT * from d_dru WHERE d_anaconda_id ="UCEP24"');
                  
            return view('ucep.ucep24_claim',$data,[
                'startdate'        =>     $startdate,
                'enddate'          =>     $enddate, 
                'data'             =>     $data, 
                'data_main'        =>     $data_main,
               
            ]);
    }
    public function ucep24_claim_process(Request $request)
    { 
        $data_vn_1 = DB::connection('mysql')->select('SELECT vn,an from pkbackoffice.d_ucep24_main');
        $iduser = Auth::user()->id;
        // D_ins::where('d_anaconda_id','=','UCEP24')->delete();
        // D_pat::where('d_anaconda_id','=','UCEP24')->delete();
        // D_opd::where('d_anaconda_id','=','UCEP24')->delete();
        // D_orf::where('d_anaconda_id','=','UCEP24')->delete();
        // D_odx::where('d_anaconda_id','=','UCEP24')->delete();
        // D_oop::where('d_anaconda_id','=','UCEP24')->delete();
        // D_ipd::where('d_anaconda_id','=','UCEP24')->delete();
        // D_irf::where('d_anaconda_id','=','UCEP24')->delete();
        // D_idx::where('d_anaconda_id','=','UCEP24')->delete();
        // D_iop::where('d_anaconda_id','=','UCEP24')->delete();
        // D_cht::where('d_anaconda_id','=','UCEP24')->delete();
        // D_cha::where('d_anaconda_id','=','UCEP24')->delete();
        // D_aer::where('d_anaconda_id','=','UCEP24')->delete();
        // D_adp::where('d_anaconda_id','=','UCEP24')->delete(); 
        // D_dru::where('d_anaconda_id','=','UCEP24')->delete();
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
      
        // D_lvd::where('user_id','=',$iduser)->delete();
         // D_labfu::where('user_id','=',$iduser)->delete();
         
          
         foreach ($data_vn_1 as $key => $va1) {
                 //D_irf
                 $data_irf_ = DB::connection('mysql2')->select('
                    SELECT a.an AN
                    ,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER
                    ,"0100" REFERTYPE 
                    FROM hos.an_stat a
                    LEFT OUTER JOIN hos.referout o on o.vn =a.an
                    LEFT OUTER JOIN hos.referin oo on oo.vn =a.an
                    LEFT OUTER JOIN hos.ipt ip on ip.an = a.an 
                    WHERE a.an IN("'.$va1->an.'")  
                    and (a.an in(select vn from hos.referin where vn = oo.vn) or a.an in(select vn from hos.referout where vn = o.vn)); 
                ');
                foreach ($data_irf_ as $va12) {
                    D_irf::insert([
                        'AN'                 => $va12->AN,
                        'REFER'              => $va12->REFER,
                        'REFERTYPE'          => $va12->REFERTYPE,
                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 'UCEP24',
                    ]);
                }
                 //D_ipd
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
                    WHERE  a.an IN("'.$va1->an.'")
                ');
                foreach ($data_ipd_ as $va13) {                
                    $addipd = new D_ipd; 
                    $addipd->AN             = $va13->AN;
                    $addipd->HN             = $va13->HN;
                    $addipd->DATEADM        = $va13->DATEADM;
                    $addipd->TIMEADM        = $va13->TIMEADM; 
                    $addipd->DATEDSC        = $va13->DATEDSC; 
                    $addipd->TIMEDSC        = $va13->TIMEDSC; 
                    $addipd->DISCHS         = $va13->DISCHS; 
                    $addipd->DISCHT         = $va13->DISCHT; 
                    $addipd->DEPT           = $va13->DEPT; 
                    $addipd->ADM_W          = $va13->ADM_W; 
                    $addipd->UUC            = $va13->UUC; 
                    $addipd->SVCTYPE        = $va13->SVCTYPE; 
                    $addipd->user_id        = $iduser;
                    $addipd->d_anaconda_id  = 'UCEP24'; 
                    $addipd->save();
                }
                //D_idx
                $data_idx_ = DB::connection('mysql2')->select('
                    SELECT i2.AN,i1.icd10 as DIAG,i1.diagtype as DXTYPE , d.licenseno as DRDX,dx.nhso_code as dx_type_code  
                    FROM hos.ipt i2  
                    LEFT OUTER JOIN hos.iptdiag i1 on i1.an= i2.an  
                    LEFT OUTER JOIN hos.diagtype dx on dx.diagtype = i1.diagtype  
                    LEFT OUTER JOIN hos.doctor d on d.code=i1.doctor  
                    WHERE  i2.an IN("'.$va1->an.'")
                ');
                foreach ($data_idx_ as $va7) {
                    $addidrx = new D_idx; 
                    $addidrx->AN             = $va7->AN;
                    $addidrx->DIAG           = $va7->DIAG;
                    $addidrx->DXTYPE         = $va7->DXTYPE;
                    $addidrx->DRDX           = $va7->DRDX; 
                    $addidrx->user_id        = $iduser;
                    $addidrx->d_anaconda_id  = 'UCEP24';
                    $addidrx->save();
                            
                }
                // D_odx
                $data_odx_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                    ,v.spclty CLINIC
                    ,o.icd10 DIAG
                    ,o.diagtype DXTYPE 
                    ,CASE 
                    WHEN d.licenseno IS NULL THEN "ว33980"
                    WHEN d.licenseno LIKE "-%" THEN "ว69577"
                    WHEN d.licenseno LIKE "พ%" THEN "ว33985" 
                    ELSE "ว33985" 
                    END as DRDX
                    ,v.cid PERSON_ID
                    ,v.vn SEQ 
                    from vn_stat v
                    LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                    LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                    LEFT OUTER JOIN icd101 i on i.code = o.icd10
                    WHERE v.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_odx_ as $va5) {
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
                    $adddx->d_anaconda_id  = 'UCEP24';
                    $adddx->save();
                    
                }
                //D_oop
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
                    ,v.vn SEQ 
                    from hos.vn_stat v
                    LEFT OUTER JOIN hos.ovstdiag o on o.vn = v.vn
                    LEFT OUTER JOIN hos.patient pt on v.hn=pt.hn
                    LEFT OUTER JOIN hos.doctor d on d.`code` = o.doctor
                    LEFT OUTER JOIN hos.icd9cm1 i on i.code = o.icd10
                    WHERE v.vn IN("'.$va1->vn.'")
                ');
                foreach ($data_oop_ as $va6) {
                    $addoop = new D_oop;  
                    $addoop->HN             = $va6->HN;
                    $addoop->CLINIC         = $va6->CLINIC;
                    $addoop->DATEOPD        = $va6->DATEOPD;
                    $addoop->OPER           = $va6->OPER;
                    $addoop->DROPID         = $va6->DROPID;
                    $addoop->PERSON_ID      = $va6->PERSON_ID; 
                    $addoop->SEQ            = $va6->SEQ; 
                    $addoop->user_id        = $iduser;
                    $addoop->d_anaconda_id  = 'UCEP24';
                    $addoop->save();
                    
                }
                //D_orf
                $data_orf_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,v.spclty CLINIC
                    ,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                    ,"0100" REFERTYPE
                    ,v.vn SEQ 
                    from hos.vn_stat v 
                    LEFT OUTER JOIN hos.referin r1 on r1.vn = v.vn
                    LEFT OUTER JOIN hos.referout r2 on r2.vn = v.vn
                    WHERE v.vn IN("'.$va1->vn.'") 
                    and (r1.vn is not null or r2.vn is not null);
                ');                
                foreach ($data_orf_ as $va4) {              
                    $addof = new D_orf;  
                    $addof->HN             = $va4->HN;
                    $addof->CLINIC         = $va4->CLINIC;
                    $addof->DATEOPD         = $va4->DATEOPD;
                    $addof->REFER          = $va4->REFER;
                    $addof->SEQ            = $va4->SEQ;
                    $addof->REFERTYPE      = $va4->REFERTYPE; 
                    $addof->user_id        = $iduser;
                    $addof->d_anaconda_id  = 'UCEP24';
                    $addof->save();
                }
                //D_opd
                $data_opd = DB::connection('mysql')->select('
                    SELECT  v.hn HN
                    ,v.spclty CLINIC
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD
                    ,v.vn SEQ
                    ,"1" UUC 
                    from hos.vn_stat v
                    LEFT OUTER JOIN hos.ovst o on o.vn = v.vn
                    LEFT OUTER JOIN hos.pttype p on p.pttype = v.pttype
                    LEFT OUTER JOIN hos.ipt i on i.vn = v.vn
                    LEFT OUTER JOIN hos.patient pt on pt.hn = v.hn
                    WHERE v.vn IN("'.$va1->vn.'")                  
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
                    $addo->d_anaconda_id  = 'UCEP24';
                    $addo->save();
                }
                 //D_aer
                $data_aer_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                    ,i.an AN
                    ,v.vstdate DATEOPD
                    ,vv.claim_code AUTHAE
                    ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI
                    ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ
                    ,"" AESTATUS,"" DALERT,"" TALERT
                    from hos.vn_stat v
                    left outer join hos.ipt i on i.vn = v.vn
                    left outer join hos.visit_pttype vv on vv.vn = v.vn
                    left outer join hos.pttype pt on pt.pttype =v.pttype
                    WHERE v.vn IN("'.$va1->vn.'")
                    and i.an is null
                    GROUP BY v.vn
                    union all
                    SELECT a.hn HN
                    ,a.an AN
                    ,a.dchdate DATEOPD
                    ,vv.claim_code AUTHAE
                    ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI
                    ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,"" SEQ
                    ,"" AESTATUS,"" DALERT,"" TALERT
                    from hos.an_stat a
                    left outer join hos.ipt_pttype vv on vv.an = a.an
                    left outer join hos.pttype pt on pt.pttype =a.pttype
                    WHERE a.an IN("'.$va1->an.'")
                    group by a.an;
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
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                 //D_iop 
                $data_iop_ = DB::connection('mysql2')->select('
                    SELECT v.an AN
                    ,o.icd9 OPER
                    ,o.oper_type as OPTYPE 
                    ,CASE 
                    WHEN d.licenseno IS NULL THEN "ว33980"
                    WHEN d.licenseno LIKE "-%" THEN "ว69577"
                    WHEN d.licenseno LIKE "พ%" THEN "ว33985" 
                    ELSE "ว33985" 
                    END as DROPID
                    ,DATE_FORMAT(o.opdate,"%Y%m%d") DATEIN
                    ,Time_format(o.optime,"%H%i") TIMEIN
                    ,DATE_FORMAT(o.enddate,"%Y%m%d") DATEOUT
                    ,Time_format(o.endtime,"%H%i") TIMEOUT
                    FROM an_stat v
                    left outer join iptoprt o on o.an = v.an
                    left outer join doctor d on d.`code` = o.doctor
                    left outer join icd9cm1 i on i.code = o.icd9
                    left outer join ipt ip on ip.an = v.an
                    WHERE v.vn IN("'.$va1->vn.'")
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
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                //D_adp
                // $data_adp_ = DB::connection('mysql2')->select('
                //     SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ
                //     ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                //     ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER
                //     ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,icode ,vstdate
                //     from
                //     (SELECT v.hn HN
                //     ,if(v.an is null,"",v.an) AN
                //     ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
                  
                //     ,n.nhso_adp_type_id TYPE
                //     ,n.nhso_adp_code CODE 
                //     ,sum(v.QTY) QTY
                //     ,round(v.unitprice,2) RATE
                //     ,if(v.an is null,v.vn,"") SEQ
                //     ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                //     ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC
                //     ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,v.icode,v.vstdate
                //     from hos.opitemrece v
                //     JOIN hos.s_drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                   
                //     left join hos.ipt i on i.an = v.an
                //     AND i.an is not NULL 
                //     WHERE i.vn IN("'.$va1->vn.'")
                //     GROUP BY i.vn,n.nhso_adp_code,rate) a 
                //     GROUP BY an,CODE,rate
                //     UNION
                //     SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ
                //     ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                //     ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER
                //     ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,icode ,vstdate
                //     from
                //     (SELECT v.hn HN
                //     ,if(v.an is null,"",v.an) AN
                //     ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                //     ,n.nhso_adp_type_id TYPE
                //     ,n.nhso_adp_code CODE 
                //     ,sum(v.QTY) QTY
                //     ,round(v.unitprice,2) RATE
                //     ,if(v.an is null,v.vn,"") SEQ
                //     ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                //     ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER
                //     ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,""SP_ITEM,v.icode,v.vstdate
                //     from hos.opitemrece v
                //     JOIN hos.s_drugitems n on n.icode = v.icode and n.nhso_adp_code is not null 
                //     left join hos.vn_stat vv on vv.vn = v.vn
                //     WHERE vv.vn IN("'.$va1->vn.'")
                //     AND v.an is NULL
                //     GROUP BY vv.vn,n.nhso_adp_code,rate) b 
                //     GROUP BY seq,CODE,rate;                
                // ');
                // ,ic.drg_chrgitem_id TYPE
                // LEFT JOIN hos.income ic ON ic.income = n.income

                $data_adp_ = DB::connection('mysql2')->select('
                    select  
                    o.hn as HN,o.an as AN,DATE_FORMAT(u.vstdate,"%Y%m%d") as DATEOPD 
                    ,n.nhso_adp_type_id as TYPE 
                    ,n.nhso_adp_code as CODE 
                    ,(SELECT sum(qty) from pkbackoffice.d_ucep24 where an = o.an and icode = o.icode) as QTY 
                    ,(SELECT sum(sum_price) from pkbackoffice.d_ucep24 where an = o.an and icode = o.icode) as RATE
                    ,o.vn as SEQ
                    ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                    ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,"" ITEMSRC ,"" PROVIDER
                    ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"0000-00-00" LMP ,"01"SP_ITEM 
                    ,u.vstdate,o.icode
                    from hos.opitemrece o 
                    left outer join hos.s_drugitems n on n.icode = o.icode 
                    inner join pkbackoffice.d_ucep24 u on u.icode = o.icode
                    WHERE o.an IN("'.$va1->an.'")
                    AND (SELECT sum(sum_price) from pkbackoffice.d_ucep24 where an = o.an and icode = o.icode) > 0 
                    group by o.icode 
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
                        'd_anaconda_id'        => 'UCEP24'
                    ]);
                }
                //D_dru
                $data_dru_ = DB::connection('mysql2')->select('
                    SELECT vv.hcode HCODE
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
                    ,"" TOTAL,""SIGCODE,"" SIGTEXT,""  PROVIDER,v.vstdate
                    from hos.opitemrece v
                    LEFT JOIN hos.drugitems d on d.icode = v.icode
                    LEFT JOIN hos.vn_stat vv on vv.vn = v.vn
                    LEFT JOIN hos.ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
               
                    WHERE v.vn IN("'.$va1->vn.'")
                    and d.did is not null 
                    GROUP BY v.vn,did,d.icode

                    UNION all

                    SELECT pt.hcode HCODE
                    ,v.hn HN
                    ,v.an AN
                    ,v1.spclty CLINIC
                    ,pt.cid PERSON_ID
                    ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                    ,d.icode DID
                    ,concat(d.`name`,"",d.strength," ",d.units) DIDNAME
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
                    ,"" TOTAL,""SIGCODE,"" SIGTEXT,""  PROVIDER,v.vstdate
                    from hos.opitemrece v
                    LEFT JOIN hos.drugitems d on d.icode = v.icode
                    LEFT JOIN hos.patient pt  on v.hn = pt.hn
                    inner JOIN hos.ipt v1 on v1.an = v.an
                    LEFT JOIN hos.ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
                 
                    WHERE v1.vn IN("'.$va1->vn.'")
                    and d.did is not null AND v.qty<>"0"
                    GROUP BY v.an,d.icode,USE_STATUS;               
                ');
                // LEFT OUTER JOIN pkbackoffice.d_ucep24 dc ON dc.an = v.an AND dc.icode = v.icode
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
                        'UNIT_PACK'      =>$va11->UNIT_PACK,
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
                        'd_anaconda_id'   => 'UCEP24'
                    ]);
                }
                //D_pat
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
                        'd_anaconda_id'      => 'UCEP24'
                    ]);
                }
                 //D_cht
                 $data_cht_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                    ,v.an AN
                    ,DATE_FORMAT(if(a.an is null,v.vstdate,a.dchdate),"%Y%m%d") DATE
                    ,round(if(a.an is null,vv.income,a.income),2) TOTAL
                    ,round(if(a.an is null,vv.paid_money,a.paid_money),2) PAID
                    ,if(vv.paid_money >"0" or a.paid_money >"0","10",pt.pcode) PTTYPE
                    ,pp.cid PERSON_ID 
                    ,v.vn SEQ
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
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                 //D_cha
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
                        WHERE vv.vn IN("'.$va1->vn.'") 
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
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
                //D_ins
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
                    ,"" HTYPE
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
                        'd_anaconda_id'     => 'UCEP24'
                    ]);
                }
         }
               
         D_adp::where('CODE','=','XXXXXX')->delete();
        // return back();
        return response()->json([
            'status'    => '200'
        ]);
    }

    public function ucep24_claim_upucep(Request $request)
    {   
            $data_ = DB::connection('mysql')->select('SELECT vn,an,hn,vstdate,dchdate,icode,qty FROM d_ucep24'); 
            foreach ($data_ as $key => $val) {                
                // D_adp::where('AN',$val->an)->where('icode',$val->icode)
                // ->update([
                //     'SP_ITEM' => '01'
                // ]);
                D_dru::where('AN',$val->an)->where('DID',$val->icode)
                // D_dru::where('AN',$val->an)->where('DID',$val->icode)->where('vstdate',$val->vstdate)
                ->update([
                    'SP_ITEM'     => '01',
                    'AMOUNT'      => $val->qty
                ]);                
            }
            // $data_room = DB::connection('mysql')->select('SELECT CODE FROM d_adp');
            // foreach ($data_room as $key => $valroom) {
            //     if ($valroom->CODE == '21101') {
            //         D_adp::where('CODE',$valroom->CODE)
            //             ->update([
            //                 'QTY'   => '1',
            //                 'RATE'  => '400'
            //             ]);
            //         } else { 
            //         } 
            // } 
            // D_adp::where('SP_ITEM','=',NULL)->delete();          
            // D_dru::where('SP_ITEM',NULL)->delete();         

            $dataucep_ = DB::connection('mysql')->select('SELECT vn,an,hn,DATE_FORMAT(vstdate,"%Y%m%d") vstdate,dchdate,icode FROM d_ucep24');
            $iduser = Auth::user()->id;
            foreach ($dataucep_ as $key => $value_up) {
                $check = D_adp::where('AN',$value_up->an)->where('CODE','UCEP24')->count();
                if ($check > 0) {
                    # code...
                } else {
                    D_adp::insert([
                        'HN'             => $value_up->hn, 
                        'AN'             => $value_up->an, 
                        'DATEOPD'        => $value_up->vstdate,  
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
            }
            // icode
            D_adp::where('SP_ITEM','=','')->delete();
            D_adp::where('QTY','=',['',null])->where('SP_ITEM','=','01')->delete();
            D_dru::where('SP_ITEM','=','')->delete();

            return response()->json([
                'status'    => '200'
            ]);
    }

    public function ucep24_claim_export(Request $request)
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
        $ins = DB::connection('mysql')->select('
            SELECT * from d_ins where d_anaconda_id = "UCEP24"
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
            SELECT * from d_iop where d_anaconda_id = "UCEP24"
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
            SELECT * from d_adp where d_anaconda_id = "UCEP24"
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
            SELECT * from d_aer where d_anaconda_id = "UCEP24"
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
            SELECT * from d_cha where d_anaconda_id = "UCEP24"
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
            SELECT * from d_cht where d_anaconda_id = "UCEP24"
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
            $g16 = $value7->DRUGREMARK;
            $g17 = $value7->PA_NO;
            $g18 = $value7->TOTCOPAY;
            $g19 = $value7->USE_STATUS;
            $g20 = $value7->TOTAL;
            $g21 = $value7->SIGCODE;
            $g22 = $value7->SIGTEXT;  
            $g23 = $value7->PROVIDER;      
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
            SELECT * from d_idx where d_anaconda_id = "UCEP24"
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
            SELECT * from d_pat where d_anaconda_id = "UCEP24"
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
            SELECT * from d_ipd where d_anaconda_id = "UCEP24"
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
            SELECT * from d_irf where d_anaconda_id = "UCEP24"
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
            SELECT * from d_lvd where d_anaconda_id = "UCEP24"
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
            SELECT * from d_odx where d_anaconda_id = "UCEP24"
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
            SELECT * from d_oop where d_anaconda_id = "UCEP24"
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
            SELECT * from d_opd where d_anaconda_id = "UCEP24"
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
            SELECT * from d_orf where d_anaconda_id = "UCEP24"
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
                    return redirect()->route('data.ucep24_claim');                    
                }
        }


            return redirect()->route('data.ucep24_claim');

    }
          
   
 }