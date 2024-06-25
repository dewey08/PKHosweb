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
// use SheetDB;

class PtController extends Controller
{ 
    public function restore(Request $request)
    {  
        $startdate = $request->startdate;
        $enddate = $request->enddate; 

        // "กายภาพ" 
        $kayapap = DB::connection('mysql3')->select('
                select count(distinct v.cid,v.vstdate,n.detail) as VS
                ,count(distinct s.cid,s.registdate,s.equipment_code) as Keyspsch
                ,format(sum(o.sum_price),2) as sumhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join eclaimdb.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9339") 
        '); 
        // "หู คอ จมูก" 
        $hoocojmok = DB::connection('mysql3')->select('
                select count(distinct v.cid,v.vstdate,n.detail) as VS
                ,count(distinct s.cid,s.registdate,s.equipment_code) as Keyspsch
                ,format(sum(o.sum_price),2) as sumhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join eclaimdb.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9549") 
        '); 
        // "ตา" 
        $ta = DB::connection('mysql3')->select('
                select count(distinct v.cid,v.vstdate,n.detail) as VS
                ,count(distinct s.cid,s.registdate,s.equipment_code) as Keyspsch
                ,format(sum(o.sum_price),2) as sumhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join eclaimdb.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and v.pttype="74"
                and n.detail in ("H9378") 
        '); 
        // "จิต/Day care/ยาเสพติด" 
        $jitdaycare = DB::connection('mysql3')->select('

                select count(distinct v.cid,v.vstdate,n.detail) as VS
                ,count(distinct s.cid,s.registdate,s.equipment_code) as Keyspsch
                
                ,format(sum(o.sum_price),2) as sumhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join eclaimdb.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and left(s.equipment_code,5) = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in("H9433","H9449") 
        '); 

         // "กระตุ้นพัฒนาการ" 
        $kratoon = DB::connection('mysql3')->select(' 
                select count(distinct v.cid,v.vstdate) as VS
                ,count(distinct s.cid,s.registdate) as Keyspsch
                
                ,format(sum(o.sum_price),2) as sumhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate)/count(distinct v.cid,v.vstdate),2) as percen
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join eclaimdb.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate 
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail <>" "
                and n.icode in ("3010119","3010118","3010073","3001131","3003731") 
        '); 

        $dataarray = array(); 
        $dataptrestore_type = DB::table('pt_restore_type')->get(); 
        return view('pt.restore',[
                // 'datashow'   =>  $datashow,
                'startdate'           =>  $startdate,
                'enddate'             =>  $enddate,
                'dataarray'           =>  $dataarray,
                'dataptrestore_type'  =>  $dataptrestore_type,
                'kayapap'             =>  $kayapap,
                'hoocojmok'           =>  $hoocojmok,
                'ta'                  =>  $ta,
                'jitdaycare'          =>  $jitdaycare,
                'kratoon'             =>  $kratoon
        ]);
    }
    public function kayapap_vs(Request $request,$startdate,$enddate)
    {   
        $kayapap_vs = DB::connection('mysql3')->select('
                select year(v.vstdate)  as year
                ,month(v.vstdate)  as months
                ,count(distinct v.cid,v.vstdate,n.detail) as VN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spsch
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokey
                ,format(sum(o.sum_price),2) as incomhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9339") 
                GROUP BY month(v.vstdate)
                order by year(v.vstdate),month(v.vstdate) 
        '); 

        $total = DB::connection('mysql3')->select('
                select  " "," ","รวมทั้งหมด" 
                ,count(distinct v.cid,v.vstdate,n.detail) as VNN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spschh
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokeyy
                ,format(sum(o.sum_price),2) as incomhoss
                ,format(sum(s.pay_price),2) as chodd
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percenn
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9339")  
        ');

        return view('pt.kayapap_vs',[
            'kayapap_vs'             =>  $kayapap_vs,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate,
            'total'                  =>  $total,
        ]);
    }

    public function kayapap_tavs(Request $request,$startdate,$enddate)
    {   
        $kayapap_tavs = DB::connection('mysql3')->select('
                select year(v.vstdate) as year
                ,month(v.vstdate) as months 
                ,count(distinct v.cid,v.vstdate,n.detail) as VN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spsch
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokey
                ,format(sum(o.sum_price),2) as incomhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and left(s.equipment_code,5) = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.pttype="74"
                and n.detail ="H9378"
                GROUP BY month(v.vstdate)
                order by year(v.vstdate),month(v.vstdate) 
        '); 

        $total = DB::connection('mysql3')->select('
                select  " "," ","รวมทั้งหมด"
                ,count(distinct v.cid,v.vstdate,n.detail) as VNN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spschh
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokeyy
                ,format(sum(o.sum_price),2) as incomhoss
                ,format(sum(s.pay_price),2) as chodd
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percenn
                from hos.vn_stat v
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and left(s.equipment_code,5) = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and pt.pttype="74"
                and n.detail  in ("H9378")  
        ');

        return view('pt.kayapap_tavs',[
            'kayapap_tavs'             =>  $kayapap_tavs,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate,
            'total'                  =>  $total,
        ]);
    }
    public function kayapap_jitvs_mian(Request $request)
    {   
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $kayapap_jitvs = DB::connection('mysql3')->select('
                select year(v.vstdate) as year
                ,month(v.vstdate) as months
                ,count(distinct v.cid,v.vstdate,n.detail) as VN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spsch
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokey
                ,format(sum(o.sum_price),2) as incomhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in("H9433.1","H9449.1")
                GROUP BY month(v.vstdate) 
        '); 

        $total = DB::connection('mysql3')->select('
                select " "," ","รวมทั้งหมด" 
                ,count(distinct v.cid,v.vstdate,n.detail) as VNN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spschh
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokeyy
                ,format(sum(o.sum_price),2) as incomhoss
                ,format(sum(s.pay_price),2) as chodd
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percenn
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in("H9433.1","H9449.1") 
        ');

        return view('pt.kayapap_jitvs',[
            'kayapap_jitvs'             =>  $kayapap_jitvs,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate,
            'total'                  =>  $total,
        ]);
    }
    public function kayapap_jitvs(Request $request,$startdate,$enddate)
    {   
        $kayapap_jitvs = DB::connection('mysql3')->select('
                select year(v.vstdate) as year
                ,month(v.vstdate) as months
                ,count(distinct v.cid,v.vstdate,n.detail) as VN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spsch
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokey
                ,format(sum(o.sum_price),2) as incomhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in("H9433.1","H9449.1")
                GROUP BY month(v.vstdate) 
        '); 

        $total = DB::connection('mysql3')->select('
                select " "," ","รวมทั้งหมด" 
                ,count(distinct v.cid,v.vstdate,n.detail) as VNN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spschh
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokeyy
                ,format(sum(o.sum_price),2) as incomhoss
                ,format(sum(s.pay_price),2) as chodd
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percenn
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in("H9433.1","H9449.1") 
        ');

        return view('pt.kayapap_jitvs',[
            'kayapap_jitvs'             =>  $kayapap_jitvs,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate,
            'total'                  =>  $total,
        ]);
    }

    public function kayapap_hoocojmokvs(Request $request,$startdate,$enddate)
    {   
        $kayapap_hoocojmokvs = DB::connection('mysql3')->select('
                select year(v.vstdate) as year
                ,month(v.vstdate) as months
                ,count(distinct v.cid,v.vstdate,n.detail) as VN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spsch
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokey
                ,format(sum(o.sum_price),2) as incomhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percen
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9549")
                GROUP BY month(v.vstdate)
                order by year(v.vstdate),month(v.vstdate) 
        '); 

        $total = DB::connection('mysql3')->select('
                select  " "," ","รวมทั้งหมด" 
                ,count(distinct v.cid,v.vstdate,n.detail) as VNN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spschh
                ,count(distinct v.cid,v.vstdate,n.detail)-count(distinct s.cid,s.registdate,s.equipment_code) as nokeyy
                ,format(sum(o.sum_price),2) as incomhoss
                ,format(sum(s.pay_price),2) as chodd
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,v.vstdate,n.detail),2) as percenn
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9549")
        ');

        return view('pt.kayapap_hoocojmokvs',[
            'kayapap_hoocojmokvs'             =>  $kayapap_hoocojmokvs,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate,
            'total'                  =>  $total,
        ]);
    }

    public function kayapap_kratoonvs(Request $request,$startdate,$enddate)
    {   
        $kayapap_kratoonvs = DB::connection('mysql3')->select('
                select year(v.vstdate) as year
                ,month(v.vstdate) as months
                ,count(distinct v.cid,v.vstdate) as VN
                ,count(distinct s.cid,s.registdate) as spsch
                ,count(distinct v.cid,v.vstdate)-count(distinct s.cid,s.registdate) as nokey
                ,format(sum(o.sum_price),2) as incomhos
                ,format(sum(s.pay_price),2) as chod
                ,format(100*count(distinct s.cid,s.registdate)/count(distinct v.cid,v.vstdate),2) as percen
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate 
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.icode in ("3010119","3010118","3010073","3001131","3003731")
                GROUP BY month(v.vstdate) 
        '); 

        $total = DB::connection('mysql3')->select('
                select " "," ","รวมทั้งหมด"   
                ,count(distinct v.cid,v.vstdate) as VNN
                ,count(distinct s.cid,s.registdate) as spschh
                ,count(distinct v.cid,v.vstdate)-count(distinct s.cid,s.registdate) as nokeyy
                ,format(sum(o.sum_price),2) as incomhoss
                ,format(sum(s.pay_price),2) as chodd
                ,format(100*count(distinct s.cid,s.registdate)/count(distinct v.cid,v.vstdate),2) as percenn
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate 
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.icode in ("3010119","3010118","3010073","3001131","3003731") 
        ');

        return view('pt.kayapap_kratoonvs',[
            'kayapap_kratoonvs'             =>  $kayapap_kratoonvs,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate,
            'total'                  =>  $total,
        ]);
    }
    public function kayapap_kratoonvs_sub(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_kratoonvs_sub = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.age_y
                ,v.pttype
                ,n.detail
                ,n1.name as nname
                ,o.qty                
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn as truehn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.nondrugitems n1 on n1.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and left(s.equipment_code,5) = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'"
                and pt.hipdata_code="UCS"
                and n.icode in ("3010119","3010118","3010073","3001131","3003731")
                GROUP BY v.cid,v.vstdate order by v.vstdate
        '); 
        
        return view('pt.kayapap_kratoonvs_sub',[
            'kayapap_kratoonvs_sub'  =>  $kayapap_kratoonvs_sub,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate,             
        ]);
    }
    public function kayapap_kratoonvs_spsch(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_kratoonvs_spsch = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.detail
                ,n.name as nname
                ,o.qty
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                inner join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate 
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.icode in ("3010119","3010118","3010073","3001131","3003731")
                and month(v.vstdate) = "'.$months.'"
                GROUP BY v.cid,v.vstdate
                order by v.vstdate 
        '); 

        return view('pt.kayapap_kratoonvs_spsch',[
            'kayapap_kratoonvs_spsch'       =>  $kayapap_kratoonvs_spsch,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }
    public function kayapap_kratoonvs_nokey(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_kratoonvs_nokey = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.detail
                ,n.name as nname
                ,o.qty  
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate 
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.icode in ("3010119","3010118","3010073","3001131","3003731")
                and month(v.vstdate) = "'.$months.'"
               
                GROUP BY v.vn,v.vstdate
                order by v.vstdate
 
        '); 
        // ,n.detail
        // ,n.name as nname
        // and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate )
        return view('pt.kayapap_kratoonvs_nokey',[
            'kayapap_kratoonvs_nokey'       =>  $kayapap_kratoonvs_nokey,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }
    public function kayapap_vs_sub(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_vs_sub = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.detail
                ,n.name as nname
                ,o.qty
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code 
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn as truehn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9339")
                GROUP BY v.cid,v.vstdate,n.detail
 
        '); 

        return view('pt.kayapap_vs_sub',[
            'kayapap_vs_sub'             =>  $kayapap_vs_sub,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }
    public function kayapap_vs_spsch(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_vs_spsch = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,s.equipment_name
                ,o.qty  
                ,s.personel
                ,s.pay_price
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                inner  join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9339")
                and month(v.vstdate) = "'.$months.'"
                GROUP BY v.cid,v.vstdate,n.detail
                order by v.vstdate
 
        '); 

        return view('pt.kayapap_vs_spsch',[
            'kayapap_vs_spsch'       =>  $kayapap_vs_spsch,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_vs_nokey(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_vs_nokey = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.name as listname
                ,o.qty
                ,o.sum_price  
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in ("H9339")
                and month(v.vstdate) = "'.$months.'"
                
                and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate and cid is not null)
                GROUP BY v.vn,v.vstdate,n.detail
                order by v.vstdate
  
        '); 
        // and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate and cid is not null)
        return view('pt.kayapap_vs_nokey',[
            'kayapap_vs_nokey'       =>  $kayapap_vs_nokey,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_hoocojmokvs_vs(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_hoocojmokvs_vs = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.detail
                ,n.name as nname
                ,o.qty
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn as truehn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'" 
                and pt.hipdata_code="UCS"
                and n.detail ="H9549"
                GROUP BY v.cid,v.vstdate,n.detail 
        '); 
        // and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate and cid is not null)
        return view('pt.kayapap_hoocojmokvs_vs',[
            'kayapap_hoocojmokvs_vs'       =>  $kayapap_hoocojmokvs_vs,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_hoocojmokvs_spsch(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_hoocojmokvs_spsch = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,s.equipment_name
                ,o.qty  
                ,s.personel
                ,s.pay_price

                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                inner  join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and left(s.equipment_code,5) = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail ="H9549"
                and month(v.vstdate) = "'.$months.'" 
                GROUP BY v.cid,v.vstdate,n.detail
                order by v.vstdate  
        '); 
         
        return view('pt.kayapap_hoocojmokvs_spsch',[
            'kayapap_hoocojmokvs_spsch'       =>  $kayapap_hoocojmokvs_spsch,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_hoocojmokvs_nokey(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_hoocojmokvs_nokey = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.name
                ,o.qty
                ,o.sum_price  
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail ="H9549"
                and month(v.vstdate) = "'.$months.'" 
                and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate and cid is not null)
                GROUP BY v.vn,v.vstdate,n.detail
                order by v.vstdate 
        '); 
         
        return view('pt.kayapap_hoocojmokvs_nokey',[
            'kayapap_hoocojmokvs_nokey'       =>  $kayapap_hoocojmokvs_nokey,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_tavs_subvn(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_tavs_subvn = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.detail
                ,n.name as nname
                ,o.qty
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code 
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn as truehn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and left(s.equipment_code,5) = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'"  
                and pt.hipdata_code="UCS"
                and pt.pttype="74"
                and n.detail ="H9378"
                GROUP BY v.cid,v.vstdate,n.detail 
        '); 
         
        return view('pt.kayapap_tavs_subvn',[
            'kayapap_tavs_subvn'     =>  $kayapap_tavs_subvn,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_tavs_subspsch(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_tavs_subspsch = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,ii.insname
                ,o.qty  
                ,ii.staff
                ,ii.claim
                ,ii.payclaim
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                inner  join eclaimdb.insdetailx ii on ii.cid = v.cid and ii.vstdate = v.vstdate
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and pt.pttype="74"
                and n.detail ="H9378"
                and month(v.vstdate) = "'.$months.'" 
                GROUP BY v.cid,v.vstdate
                order by v.vstdate 
        '); 
         
        return view('pt.kayapap_tavs_subspsch',[
            'kayapap_tavs_subspsch'       =>  $kayapap_tavs_subspsch,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_tavs_subnokey(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_tavs_subnokey = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pdx
                ,v.pttype
                ,n.name as nname
                ,o.qty  
                ,ii.staff
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code 
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN eclaimdb.opitemrece61 o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join eclaimdb.insdetailx ii on ii.cid = v.cid and ii.vstdate = v.vstdate
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and pt.pttype="74"
                and n.detail ="H9378"
                and month(v.vstdate) = "'.$months.'"
                and v.hn not in(select hn from eclaimdb.insdetailx where cid=v.cid  and vstdate =v.vstdate)
                and v.vstdate not in(select vstdate from eclaimdb.insdetailx where cid=v.cid  and vstdate =v.vstdate)
                GROUP BY v.vn,v.vstdate
                order by v.vstdate
        '); 
         
        return view('pt.kayapap_tavs_subnokey',[
            'kayapap_tavs_subnokey'     =>  $kayapap_tavs_subnokey,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_jitvs_vn(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_jitvs_vn = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.detail
                ,n.name as nname
                ,o.qty
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code 
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn as truehn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'"  
                and pt.hipdata_code="UCS"
                and n.detail in("H9433.1","H9449.1")
                GROUP BY v.cid,v.vstdate,n.detail
        '); 
         
        return view('pt.kayapap_jitvs_vn',[
            'kayapap_jitvs_vn'     =>  $kayapap_jitvs_vn,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

    public function kayapap_jitvs_spsch(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_jitvs_spsch = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.detail
                ,n.name as nname
                ,o.qty
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code 
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                left join hos.nondrugitems_ptxxx n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                inner join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in("H9433.1","H9449.1")
                and month(v.vstdate) = "'.$months.'" 
                GROUP BY v.cid,v.vstdate,n.detail
                order by v.vstdate 
        '); 
         
        return view('pt.kayapap_jitvs_spsch',[
            'kayapap_jitvs_spsch'     =>  $kayapap_jitvs_spsch,
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate, 
        ]);
    }

    public function kayapap_jitvs_nokey(Request $request,$months,$startdate,$enddate)
    {   
        $kayapap_jitvs_nokey = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.name as nname
                ,o.qty 
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                left join hos.pttype pt on pt.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.detail
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code="UCS"
                and n.detail in("H9433.1","H9449.1")
                and month(v.vstdate) = "'.$months.'" 
              
                GROUP BY v.vn,v.vstdate,n.detail
                order by v.vstdate 
        '); 

        // ,ii.staff
        // ,ii.claim
        // ,ii.payclaim
        // ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code 


        // left join eclaimdb.insdetailx ii on ii.cid = v.cid and ii.vstdate = v.vstdate


        // and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate and s.equipment_code = equipment_code)
         
        return view('pt.kayapap_jitvs_nokey',[
            'kayapap_jitvs_nokey'     =>  $kayapap_jitvs_nokey,
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate, 
        ]);
    }



    public function equipment(Request $request)
    {  
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
  
        $equipment = DB::connection('mysql3')->select('
                select  year(v.vstdate) as year
                ,month(v.vstdate) as months
                ,count(distinct v.cid) as HN
                ,count(distinct v.cid,v.vstdate,o.icode) as VN
                ,count(distinct s.cid,s.registdate,s.equipment_code) as spsch
                ,count(distinct v.cid,o.icode)-count(distinct s.cid,s.registdate,s.equipment_code) as nokey
                ,format(sum(o.sum_price),2) as incomhos
                ,format(sum(payclaim),2) as chod
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,o.icode),2) as percen
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                inner join eclaimdb.insx  i on i.code = n.billcode
                left  join eclaimdb.insdetail ii on ii.cid = v.cid and ii.billcode= n.billcode 
                left outer join hos.pttype p on p.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.billcode
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and p.hipdata_code ="UCS"
                and n.billcode not in("2502")
                GROUP BY month(v.vstdate) 
        '); 
        $total = DB::connection('mysql3')->select('
                select  " "," ","รวมทั้งหมด" 
                ,count(distinct v.cid) as VNN
                ,count(distinct v.cid,v.vstdate,o.icode) as spschh
                ,count(distinct s.cid,s.registdate,s.equipment_code) as nokeyy
                ,count(distinct v.cid,o.icode)-count(distinct s.cid,s.registdate,s.equipment_code) as chodd
                ,format(sum(o.sum_price),2) as incomhoss
                ,format(sum(payclaim),2) as payclaim
                ,format(100*count(distinct s.cid,s.registdate,s.equipment_code)/count(distinct v.cid,o.icode),2) as percenn
                from hos.vn_stat v
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                inner join eclaimdb.insx  i on i.code = n.billcode
                left  join eclaimdb.insdetail ii on ii.cid = v.cid and ii.billcode= n.billcode 
                left outer join hos.pttype p on p.pttype = v.pttype
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.billcode
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and p.hipdata_code ="UCS"
                and n.billcode not in("2502") 
 
        ');
                  
        return view('pt.equipment',[
                'equipment'   =>  $equipment, 
                'startdate'           =>  $startdate,
                'enddate'             =>  $enddate, 
                'total'                  =>  $total,               
        ]);
    }
    public function equipment_vn(Request $request,$months,$startdate,$enddate)
    {   
        $equipment_vn = DB::connection('mysql3')->select('
                select v.hn ,v.vstdate ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype ,n.billcode ,n.name as nname
                ,o.qty
                ,format(o.sum_price,2) as price
                ,if(ip.claim_code="2","ไม่เบิก"," ") as claim_code 
                ,ip.nhso_ownright_name
                ,if(group_concat(distinct s.pay_price) is null,"check",s.pay_price) as pay_price
                ,s.hn as truehn
                from hos.vn_stat v
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                inner join eclaimdb.insx  i on i.code = n.billcode
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.billcode
                left outer join hos.pttype pt on pt.pttype = v.pttype
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and month(v.vstdate) = "'.$months.'" 
                and pt.hipdata_code ="UCS"
                and n.billcode not in("2502")
                GROUP BY v.vn,o.icode

               
        '); 
         
        return view('pt.equipment_vn',[
            'equipment_vn'     =>  $equipment_vn,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }
    public function equipment_spsch(Request $request,$months,$startdate,$enddate)
    {   
        $equipment_spsch = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,s.equipment_name
                ,o.qty  
                ,s.personel
                ,s.status_pay
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                inner join eclaimdb.insx  i on i.code = n.billcode
                inner join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.billcode
                left outer join hos.pttype pt on pt.pttype = v.pttype
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code ="UCS"
                and n.billcode not in("2502")
                and month(v.vstdate) = "'.$months.'" 
                GROUP BY v.cid,s.equipment_code
        '); 
         
        return view('pt.equipment_spsch',[
            'equipment_spsch'     =>  $equipment_spsch,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }
    public function equipment_nokey(Request $request,$months,$startdate,$enddate)
    {   
        $equipment_nokey = DB::connection('mysql3')->select('
                select v.hn
                ,v.vstdate
                ,v.cid
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,v.pttype
                ,n.name as nname
                ,o.qty 
                ,sum(o.sum_price) as sum_price
                ,s.personel
                ,s.status_pay
                ,ip.claim_code
                ,ip.nhso_ownright_name
                from hos.vn_stat v
                LEFT JOIN hos.patient p on p.hn = v.hn
                LEFT JOIN hos.opitemrece o on o.vn =v.vn
                LEFT JOIN hos.visit_pttype ip on ip.vn=v.vn
                left join hos.nondrugitems n on n.icode = o.icode
                inner join eclaimdb.insx  i on i.code = n.billcode
                left join hshooterdb.m_physical s on s.cid = v.cid and s.registdate = v.vstdate and s.equipment_code = n.billcode
                left outer join hos.pttype pt on pt.pttype = v.pttype
                where v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                and pt.hipdata_code ="UCS"
                and n.billcode not in("2502")
                and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate and cid is not null)
                and month(v.vstdate) = "'.$months.'" 
                GROUP BY v.cid,o.icode 
        '); 
        // and v.cid not in(select cid from hshooterdb.m_physical where cid=s.cid and registdate =s.registdate and cid is not null)
        return view('pt.equipment_nokey',[
            'equipment_nokey'     =>  $equipment_nokey,
            'startdate'              =>  $startdate,
            'enddate'                =>  $enddate, 
        ]);
    }

}
