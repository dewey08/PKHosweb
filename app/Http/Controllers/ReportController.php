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

class ReportController extends Controller
{
    public function report_refer_main(Request $request)
    {
        $year_id = $request->year_id;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        // $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newDate = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน 
        // $newDate = date('Y-m-d') ; //
        // dd($date);

        if ($year_id != '') {
            // dd($year_id);
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
            // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashow_opd = DB::connection('mysql3')->select('
                select month(v.vstdate) as months
                ,count(distinct v.hn) as hn
                ,count(distinct v.vn) as vn     
                ,round(sum(v.income),2)
                ,round(sum(v.paid_money),2)            
                from hos.vn_stat v 
                inner join hos.referout r on r.vn = v.vn
                left outer join hos.patient pt on pt.hn=v.hn
                left outer join hos.pttype p on p.pttype = v.pttype           
                where v.vstdate between "' . $startdate . '" and "' . $enddate . '"
                and r.refer_hospcode not in("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","04007")
                group by month(v.vstdate)
            ');

            $datashow_ipd = DB::connection('mysql3')->select('   
                select month(v.dchdate) as months
                ,count(distinct v.hn) as HN 
                ,count(distinct v.an) as AN
                ,count(distinct ii.an) as IMC
                ,count(distinct i1.an) as IMC_BRAIN
                ,count(distinct i2.an) as IMC_INJURY 
                from hos.an_stat v
                left outer join hos.ipt i on i.an = v.an
                inner join hos.referout r on r.vn = i.an
                left outer join  hos.opitemrece o on o.an = v.an
                left outer join  hos.nondrugitems n on n.icode = o.icode
                left outer join eclaimdb.m_registerdata m on m.an = v.an
                left outer join eclaimdb.m_sumfund mmm on mmm.eclaim_no = m.eclaim_no
                left join hos.iptdiag ii on ii.an = v.an 
                and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
                and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
                left join hos.iptdiag i1 on i1.an = v.an 
                and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
                left join hos.iptdiag i2 on i2.an = v.an 
                and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
                where v.dchdate between "' . $startdate . '" and "' . $enddate . '"         
                group by month(v.dchdate)
            ');

            // $datashow_oipd = DB::connection('mysql3')->select('
            //     select month(o.vstdate) as months
            //     ,count(distinct o.hn) as HN
            //     ,count(distinct o.vn) as VN
            //     ,count(distinct o.an) as AN
            //     ,count(distinct ii.an) as IMC
            //     ,count(distinct i1.an) as IMC_BRAIN
            //     ,count(distinct i2.an) as IMC_INJURY 
            //     ,i2.an as I2AN
            //     from hos.opitemrece o
            //     left outer join  hos.nondrugitems n on n.icode = o.icode
            //     left outer join hos.an_stat v on v.an = o.an
            //     left join hos.iptdiag ii on ii.an = v.an             
            //     and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
            //     and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
            //     left join hos.iptdiag i1 on i1.an = v.an 
            //     and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
            //     left join hos.iptdiag i2 on i2.an = v.an 
            //     and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
            //     where o.vstdate between "'.$startdate.'" and "'.$enddate.'"
            //     and o.icode in ("3010400","3010401")
            //     group by month(o.vstdate)
            // ');

            // $datashow_repoipd = DB::connection('mysql3')->select('
            //     select month(o.vstdate) as months
            //     ,count(distinct o.hn) as HN
            //     ,count(distinct o.vn) as VN
            //     ,count(distinct o.an) as AN
            //     ,count(distinct ii.an) as IMC
            //     ,count(distinct i1.an) as IMC_BRAIN
            //     ,count(distinct i2.an) as IMC_INJURY 
            //     from hos.opitemrece o
            //     left outer join  hos.nondrugitems n on n.icode = o.icode
            //     left outer join hos.an_stat v on v.an = o.an
            //     inner join hos.referin r on r.vn = v.vn
            //     left join hos.iptdiag ii on ii.an = v.an 
            //     and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
            //     and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
            //     left join hos.iptdiag i1 on i1.an = v.an 
            //     and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
            //     left join hos.iptdiag i2 on i2.an = v.an 
            //     and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
            //     where o.vstdate between "'.$startdate.'" and "'.$enddate.'"
            //     and o.an is not null
            //     group by month(o.vstdate)
            // ');

        } else {
            $datashow_opd = DB::connection('mysql3')->select('
                select month(v.vstdate) as months
                ,count(distinct v.hn) as hn
                ,count(distinct v.vn) as vn     
                ,round(sum(v.income),2)
                ,round(sum(v.paid_money),2)            
                from hos.vn_stat v 
                inner join hos.referout r on r.vn = v.vn
                left outer join hos.patient pt on pt.hn=v.hn
                left outer join hos.pttype p on p.pttype = v.pttype           
                where v.vstdate between "' . $newDate . '" and "' . $date . '" 
                and r.refer_hospcode not in("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","04007")
                group by month(v.vstdate)
            ');

            $datashow_ipd = DB::connection('mysql3')->select('
                select month(v.dchdate) as months
                ,count(distinct v.hn) as HN 
                ,count(distinct v.an) as AN
                ,count(distinct ii.an) as IMC
                ,count(distinct i1.an) as IMC_BRAIN
                ,count(distinct i2.an) as IMC_INJURY 
                ,count(distinct v.an)-count(distinct m.an)
                ,round(sum(v.income),2),round(sum(v.paid_money),2)
                ,ifnull(sum(mmm.sums_carae),sum(mmm.sums_caref))  
                ,round(sum(v.paid_money),2)+ifnull(sum(mmm.sums_carae),sum(mmm.sums_caref))        
                from hos.an_stat v 
                left outer join hos.ipt i on i.an = v.an
                inner join hos.referout r on r.vn = i.an
                left outer join  hos.opitemrece o on o.an = v.an
                left outer join  hos.nondrugitems n on n.icode = o.icode  
                left outer join eclaimdb.m_registerdata m on m.an = v.an  
                left outer join eclaimdb.m_sumfund mmm on mmm.eclaim_no = m.eclaim_no      
                left join hos.iptdiag ii on ii.an = v.an
                and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
                and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
                left join hos.iptdiag i1 on i1.an = v.an 
                left join hos.iptdiag i2 on i2.an = v.an 
                and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
                where v.dchdate between "' . $newDate . '" and "' . $date . '"         
                group by month(v.dchdate)
            ');

            // $datashow_oipd = DB::connection('mysql3')->select('
            //     select month(o.vstdate) as months
            //     ,count(distinct o.hn) as HN
            //     ,count(distinct o.vn) as VN
            //     ,count(distinct o.an) as AN
            //     ,count(distinct ii.an) as IMC
            //     ,count(distinct i1.an) as IMC_BRAIN
            //     ,count(distinct i2.an) as IMC_INJURY 
            //     ,i2.an as I2AN
            //     from hos.opitemrece o
            //     left outer join  hos.nondrugitems n on n.icode = o.icode
            //     left outer join hos.an_stat v on v.an = o.an
            //     left join hos.iptdiag ii on ii.an = v.an             
            //     and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
            //     and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
            //     left join hos.iptdiag i1 on i1.an = v.an 
            //     and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
            //     left join hos.iptdiag i2 on i2.an = v.an 
            //     and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
            //     where o.vstdate between "'.$newDate.'" and "'.$date.'"
            //     and o.icode in ("3010400","3010401")
            //     group by month(o.vstdate)
            // ');

            // $datashow_repoipd = DB::connection('mysql3')->select('
            //     select month(o.vstdate) as months
            //     ,count(distinct o.hn) as HN
            //     ,count(distinct o.vn) as VN
            //     ,count(distinct o.an) as AN
            //     ,count(distinct ii.an) as IMC
            //     ,count(distinct i1.an) as IMC_BRAIN
            //     ,count(distinct i2.an) as IMC_INJURY 
            //     from hos.opitemrece o
            //     left outer join  hos.nondrugitems n on n.icode = o.icode
            //     left outer join hos.an_stat v on v.an = o.an
            //     inner join hos.referin r on r.vn = v.vn
            //     left join hos.iptdiag ii on ii.an = v.an 
            //     and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
            //     and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
            //     left join hos.iptdiag i1 on i1.an = v.an 
            //     and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
            //     left join hos.iptdiag i2 on i2.an = v.an 
            //     and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
            //     where o.vstdate between "'.$newDate.'" and "'.$date.'"
            //     and o.an is not null
            //     group by month(o.vstdate)
            // ');
            // $year_id = $y;
        }

        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_refer_main', [
            'datashow_opd'      =>  $datashow_opd,
            'datashow_ipd'      =>  $datashow_ipd,
            'year'              =>  $year,
            // 'datashow_oipd'     =>  $datashow_oipd,
            // 'datashow_repoipd'  =>  $datashow_repoipd,
            'year_ids'           =>  $year_id
        ]);
    }

    public function report_refer_main_repback(Request $request)
    {
        $year_id = $request->year_id;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        // $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newDate = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน 
        // $newDate = date('Y-m-d') ; //
        // dd($date);

        if ($year_id != '') {
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
            // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashow_oipd = DB::connection('mysql3')->select('
                select month(o.vstdate) as months
                ,count(distinct o.hn) as HN
                ,count(distinct o.vn) as VN
                ,count(distinct o.an) as AN
                ,count(distinct ii.an) as IMC
                ,count(distinct i1.an) as IMC_BRAIN
                ,count(distinct i2.an) as IMC_INJURY 
                ,i2.an as I2AN
                from hos.opitemrece o
                left outer join  hos.nondrugitems n on n.icode = o.icode
                left outer join hos.an_stat v on v.an = o.an
                left join hos.iptdiag ii on ii.an = v.an             
                and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
                and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
                left join hos.iptdiag i1 on i1.an = v.an 
                and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
                left join hos.iptdiag i2 on i2.an = v.an 
                and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
                where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
                and o.icode in ("3010400","3010401")
                group by month(o.vstdate)
            ');
        } else {
            $datashow_oipd = DB::connection('mysql3')->select('
                select month(o.vstdate) as months
                ,count(distinct o.hn) as HN
                ,count(distinct o.vn) as VN
                ,count(distinct o.an) as AN
                ,count(distinct ii.an) as IMC
                ,count(distinct i1.an) as IMC_BRAIN
                ,count(distinct i2.an) as IMC_INJURY 
                ,i2.an as I2AN
                from hos.opitemrece o
                left outer join  hos.nondrugitems n on n.icode = o.icode
                left outer join hos.an_stat v on v.an = o.an
                left join hos.iptdiag ii on ii.an = v.an             
                and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
                and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
                left join hos.iptdiag i1 on i1.an = v.an 
                and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
                left join hos.iptdiag i2 on i2.an = v.an 
                and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
                where o.vstdate between "' . $newDate . '" and "' . $date . '"
                and o.icode in ("3010400","3010401")
                group by month(o.vstdate)
            ');
        }
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        return view('report.report_refer_main_repback', [
            'datashow_oipd'     =>  $datashow_oipd,
            'year_ids'           =>  $year_id,
            'year'           =>  $year
        ]);
    }

    public function report_refer_main_rep(Request $request)
    {
        $year_id = $request->year_id;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        // $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newDate = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน  
        if ($year_id != '') {
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
            // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashow_repoipd = DB::connection('mysql3')->select('
                select month(o.vstdate) as months
                ,count(distinct o.hn) as HN
                ,count(distinct o.vn) as VN
                ,count(distinct o.an) as AN
                ,count(distinct ii.an) as IMC
                ,count(distinct i1.an) as IMC_BRAIN
                ,count(distinct i2.an) as IMC_INJURY 
                from hos.opitemrece o
                left outer join  hos.nondrugitems n on n.icode = o.icode
                left outer join hos.an_stat v on v.an = o.an
                inner join hos.referin r on r.vn = v.vn
                left join hos.iptdiag ii on ii.an = v.an 
                and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
                and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
                left join hos.iptdiag i1 on i1.an = v.an 
                and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
                left join hos.iptdiag i2 on i2.an = v.an 
                and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
                where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
                and o.an is not null
                group by month(o.vstdate)
            ');
        } else {

            $datashow_repoipd = DB::connection('mysql3')->select('
                select month(o.vstdate) as months
                ,count(distinct o.hn) as HN
                ,count(distinct o.vn) as VN
                ,count(distinct o.an) as AN
                ,count(distinct ii.an) as IMC
                ,count(distinct i1.an) as IMC_BRAIN
                ,count(distinct i2.an) as IMC_INJURY 
                from hos.opitemrece o
                left outer join  hos.nondrugitems n on n.icode = o.icode
                left outer join hos.an_stat v on v.an = o.an
                inner join hos.referin r on r.vn = v.vn
                left join hos.iptdiag ii on ii.an = v.an 
                and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
                and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
                left join hos.iptdiag i1 on i1.an = v.an 
                and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
                left join hos.iptdiag i2 on i2.an = v.an 
                and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
                where o.vstdate between "' . $newDate . '" and "' . $date . '"
                and o.an is not null
                group by month(o.vstdate)
            ');
            $year_id = $y;
        }

        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_refer_main_rep', [
            'datashow_repoipd'  =>  $datashow_repoipd,
            'year_ids'           =>  $year_id,
            'year'           =>  $year
        ]);
    }
    public function report_refer_mainsub_opd(Request $request, $month, $year)
    {
        // $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $opd_month = DB::connection('mysql3')->select('
            select v.vstdate 
            ,count(distinct v.vn) as VN
            from hos.vn_stat v 
            inner join hos.referout r on r.vn = v.vn
            left outer join hos.opitemrece o on o.vn = v.vn 
            left outer join hos.patient pt on pt.hn=v.hn
            left outer join hos.pttype p on p.pttype = v.pttype
            where v.vstdate between "' . $startdate . '" and "' . $enddate . '"
            and r.refer_hospcode not in("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","04007")
            and month(v.vstdate) = "' . $month . '" 
            group by day(v.vstdate)
        ');
        // dd($opd_month);
        return view('report.report_refer_mainsub_opd', [
            'opd_month'   =>  $opd_month,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_ipd2(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $ipd_month = DB::connection('mysql3')->select('
            select v.dchdate 
            ,count(distinct v.an) as AN
            from hos.an_stat v 
            left outer join hos.ipt i on i.an = v.an
            inner join hos.referout r on r.vn = i.an
            left outer join  hos.opitemrece o on o.an = v.an
            left outer join  hos.nondrugitems n on n.icode = o.icode
            left outer join eclaimdb.m_registerdata m on m.an = v.an
            left outer join eclaimdb.m_sumfund mmm on mmm.eclaim_no = m.eclaim_no
            where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
            and month(v.dchdate) = "' . $month . '"  
            group by day(v.dchdate)
        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_ipd2', [
            'ipd_month'   =>  $ipd_month,
            'month'       =>  $month
        ]);
    }
    public function report_refer_mainsub_ipd3(Request $request, $day)
    { 
        $ipd_day = DB::connection('mysql3')->select('
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,
            (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
            where oo.an=r.vn
            and oo.icode in("3003086","3003087","3003521","3003089") ORDER BY oo.icode limit 1) as icode,
            w.name as wardname,r.with_nurse,r.with_ambulance
            ,h.name as hname
            ,ifnull(mmm.ae,mmm.ae) as mmm
            from hos.opitemrece o
            inner join hos.referout r on r.vn = o.an
            left outer join hos.an_stat v on v.an = o.an
            left outer join hos.nondrugitems n on n.icode = o.icode
            left outer join hos.patient p on p.hn = v.hn
            left outer join hos.pttype pt on pt.pttype = v.pttype 
            left outer join hos.kskdepartment k on k.depcode = r.depcode
            left join eclaimdb.m_registerdata m on m.an = r.vn
            left outer join eclaimdb.stmipd mmm on mmm.an = m.an
            left outer join hos.hospcode h on h.hospcode= r.refer_hospcode
            left outer join hos.ward w on w.ward= v.ward
           
            where v.dchdate = "'.$day.'"
            group by v.an 
        ');
        // select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname,' ',p.lname) as name,v.pttype,
        // (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
        // where oo.an=r.vn
        // and oo.icode in('3003086','3003087','3003521','3003089') ORDER BY oo.icode limit 1),w.name,r.with_nurse,r.with_ambulance
        // ,h.name
        // ,ifnull(mmm.ae,mmm.ae)
        // from hos.opitemrece o
        // inner join hos.referout r on r.vn = o.an
        // left outer join hos.an_stat v on v.an = o.an
        // left outer join hos.nondrugitems n on n.icode = o.icode
        // left outer join hos.patient p on p.hn = v.hn
        // left outer join hos.pttype pt on pt.pttype = v.pttype 
        // left outer join hos.kskdepartment k on k.depcode = r.depcode
        // left join eclaimdb.m_registerdata m on m.an = r.vn
        // left outer join eclaimdb.stmipd mmm on mmm.an = m.an
        // left outer join hos.hospcode h on h.hospcode= r.refer_hospcode
        // left outer join hos.ward w on w.ward= v.ward
        // where v.dchdate between '2020-10-01' and '2021-09-30'
        // and month(v.dchdate) = '".$month."'
        // and v.dchdate = '".$day."'
        // group by v.an

        // where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
        // and month(v.dchdate) = "' . $month . '"
        return view('report.report_refer_mainsub_ipd3', [
            'ipd_day'   =>  $ipd_day 
        ]);
    }

    public function report_refer_mainsub_imcstork(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $ipd_month = DB::connection('mysql3')->select('
        select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
        (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
        where oo.an=r.vn
        and oo.icode in("3003086","3003087","3003521","3003089") ORDER BY oo.icode limit 1) as list,w.name as name2,r.with_nurse,r.with_ambulance
        ,h.name as name3
        ,ifnull(mmm.ae,mmm.ae) as fullna
        from hos.opitemrece o
        inner join hos.referout r on r.vn = o.an
        left outer join hos.an_stat v on v.an = o.an
        left outer join hos.nondrugitems n on n.icode = o.icode
        left outer join hos.patient p on p.hn = v.hn
        left outer join hos.pttype pt on pt.pttype = v.pttype 
        left outer join hos.kskdepartment k on k.depcode = r.depcode
        left join eclaimdb.m_registerdata m on m.an = r.vn
        left outer join eclaimdb.stmipd mmm on mmm.an = m.an
        left outer join hos.hospcode h on h.hospcode= r.refer_hospcode
        left outer join hos.ward w on w.ward= v.ward
        left join hos.iptdiag ii on ii.an = v.an
        left join hos.iptoprt io on io.an = v.an

        where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
        and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
        and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
        and month(v.dchdate) = "' . $month . '"  
        group by v.an
        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_imcstork', [
            'ipd_month'   =>  $ipd_month,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_imcbrain(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $ipd_month = DB::connection('mysql3')->select('       
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
            (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
            where oo.an=r.vn
            and oo.icode in("3003086","3003087","3003521","3003089") ORDER BY oo.icode limit 1) as list,w.name as name2,r.with_nurse,r.with_ambulance
            ,h.name as name3
            ,ifnull(mmm.ae,mmm.ae) as fullna
            
            from hos.opitemrece o
            inner join hos.referout r on r.vn = o.an
            left outer join hos.an_stat v on v.an = o.an
            left outer join hos.nondrugitems n on n.icode = o.icode
            left outer join hos.patient p on p.hn = v.hn
            left outer join hos.pttype pt on pt.pttype = v.pttype 
            left outer join hos.kskdepartment k on k.depcode = r.depcode
            left join eclaimdb.m_registerdata m on m.an = r.vn
            left outer join eclaimdb.stmipd mmm on mmm.an = m.an
            left outer join hos.hospcode h on h.hospcode= r.refer_hospcode
            left outer join hos.ward w on w.ward= v.ward
            left join hos.iptdiag ii on ii.an = v.an
            left join hos.iptoprt io on io.an = v.an

            where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
            and (ii.icd10 between "s60" and "s609" or ii.icd10 = "t902"  or ii.icd10 = "t905")
            and month(v.dchdate) = "' . $month . '"  
            group by v.an
        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_imcbrain', [
            'ipd_month'   =>  $ipd_month,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_imcinjury(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $ipd_month = DB::connection('mysql3')->select(' 
                select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct i2.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
                group_concat(distinct io.icd9),
                (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
                where oo.an=r.vn
                and oo.icode in("3003086","3003087","3003521","3003089") ORDER BY oo.icode limit 1) as list,w.name as name2,r.with_nurse,r.with_ambulance
                ,h.name as name3
                ,ifnull(mmm.ae,mmm.ae) as fullna

                from hos.opitemrece o
                inner join hos.referout r on r.vn = o.an
                left outer join hos.an_stat v on v.an = o.an
                left outer join hos.nondrugitems n on n.icode = o.icode
                left outer join hos.patient p on p.hn = v.hn
                left outer join hos.pttype pt on pt.pttype = v.pttype 
                left outer join hos.kskdepartment k on k.depcode = r.depcode
                left join eclaimdb.m_registerdata m on m.an = r.vn
                left outer join eclaimdb.stmipd mmm on mmm.an = m.an
                left outer join hos.hospcode h on h.hospcode= r.refer_hospcode
                left outer join hos.ward w on w.ward= v.ward
                left join hos.iptdiag i2 on i2.an = v.an
                left join hos.iptoprt io on io.an = v.an

                where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
                and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
                and month(v.dchdate) = "' . $month . '"  
                group by v.an
        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_imcinjury', [
            'ipd_month'   =>  $ipd_month,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_checkopd(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $opd_month = DB::connection('mysql3')->select(' 
            select o.vstdate,count(distinct o.vn) as VN
            from hos.opitemrece o 
            left outer join  hos.nondrugitems n on n.icode = o.icode
            where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
            and o.icode in ("3010400","3010401")
            and month(o.vstdate) = "' . $month . '" 
            and o.an is null
            group by day(o.vstdate)
        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_checkopd', [
            'opd_month'   =>  $opd_month,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_checkipd(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $ipd_month = DB::connection('mysql3')->select('  
            select o.vstdate,count(distinct o.an) as AN
            from hos.opitemrece o 
            left outer join  hos.nondrugitems n on n.icode = o.icode
            where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
            and o.icode in ("3010400","3010401")
            and month(o.vstdate) = "' . $month . '" 
            group by day(o.vstdate)
        ');
        return view('report.report_refer_mainsub_checkipd', [
            'ipd_month'   =>  $ipd_month,
            'month'       =>  $month
        ]);
    }
    public function report_refer_mainsub_checkimcstork(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $stork = DB::connection('mysql3')->select('               
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
            (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
            where oo.icode in("3010400","3010401") ORDER BY oo.icode limit 1) as list,w.name as name2
            
            from hos.opitemrece o
            left outer join  hos.nondrugitems n on n.icode = o.icode
            left outer join hos.an_stat v on v.an = o.an
            left outer join hos.patient p on p.hn = v.hn
            left outer join hos.pttype pt on pt.pttype = v.pttype 
            left join hos.iptdiag ii on ii.an = v.an 
            left join hos.iptoprt io on io.an = v.an
            left outer join hos.ward w on w.ward= v.ward
            where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
            and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
            and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
            and month(v.dchdate) = "' . $month . '" 
            and o.icode in ("3010400","3010401")
            group by v.an
        ');
        return view('report.report_refer_mainsub_checkimcstork', [
            'stork'   =>  $stork,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_checkimcbrain(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $imcbrain = DB::connection('mysql3')->select('      
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
            (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
            where oo.icode in("3010400","3010401") ORDER BY oo.icode limit 1) as list  ,w.name as name2 
            from hos.opitemrece o
            left outer join  hos.nondrugitems n on n.icode = o.icode
            left outer join hos.an_stat v on v.an = o.an
            left outer join hos.patient p on p.hn = v.hn
            left outer join hos.pttype pt on pt.pttype = v.pttype 
            left join hos.iptdiag ii on ii.an = v.an 
            left join hos.iptoprt io on io.an = v.an
            left outer join hos.ward w on w.ward= v.ward
            where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
            and (ii.icd10 between "s60" and "s609" or ii.icd10 = "t902"  or ii.icd10 = "t905")
            and month(v.dchdate) = "' . $month . '" 
            and o.icode in ("3010400","3010401")
            group by v.an

        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_checkimcbrain', [
            'imcbrain'   =>  $imcbrain,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_checkinjury(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $injury = DB::connection('mysql3')->select('      
            select v.hn,v.an,p.cid,o.vstdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
            (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
            where oo.icode in("3010400","3010401") ORDER BY oo.icode limit 1) as list  ,w.name as name2 
            from hos.opitemrece o
            left outer join  hos.nondrugitems n on n.icode = o.icode
            left outer join hos.an_stat v on v.an = o.an
            left outer join hos.patient p on p.hn = v.hn
            left outer join hos.pttype pt on pt.pttype = v.pttype 
            left join hos.iptdiag ii on ii.an = v.an  

            left join hos.iptoprt io on io.an = v.an
            left outer join hos.ward w on w.ward= v.ward
            where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
            and (ii.icd10 between "s60" and "s609" or ii.icd10 = "t902" or ii.icd10 = "t905")
            and month(v.dchdate) = "' . $month . '" 
            and o.icode in ("3010400","3010401")
            group by v.an

        ');
        // AND e.pdx ='U71' OR e.pdx ='U72'
        // dd($ipd_month);
        return view('report.report_refer_mainsub_checkinjury', [
            'injury'   =>  $injury,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_rep_opd(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $data = DB::connection('mysql3')->select('  
            select o.vstdate,count(distinct o.vn) as VN
            from hos.opitemrece o 
            left outer join  hos.nondrugitems n on n.icode = o.icode
            where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
            and o.icode in ("3010400","3010401")
            and month(o.vstdate) = "' . $month . '" 
            and o.an is null
            group by day(o.vstdate)

        ');
        return view('report.report_refer_mainsub_rep_opd', [
            'data'   =>  $data,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_rep_ipd(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $data = DB::connection('mysql3')->select(' 
            
            select o.vstdate,count(distinct o.an) as AN
            from hos.opitemrece o 
            left outer join  hos.nondrugitems n on n.icode = o.icode
            left outer join hos.an_stat v on v.an = o.an
            inner join hos.referin r on r.vn = v.vn
            left join hos.iptdiag ii on ii.an = v.an 
            and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
            and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
            left join hos.iptdiag i1 on i1.an = v.an 
            and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
            left join hos.iptdiag i2 on i2.an = v.an 
            and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
            where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
            and o.an is not null
            and month(o.vstdate) = "' . $month . '"  
            group by day(o.vstdate)          

        ');
        // select month(o.vstdate) as months
        // ,count(distinct o.hn) as HN
        // ,count(distinct o.vn) as VN
        // ,count(distinct o.an) as AN
        // ,count(distinct ii.an) as IMC
        // ,count(distinct i1.an) as IMC_BRAIN
        // ,count(distinct i2.an) as IMC_INJURY 
        // from hos.opitemrece o
        // left outer join  hos.nondrugitems n on n.icode = o.icode
        // left outer join hos.an_stat v on v.an = o.an
        // inner join hos.referin r on r.vn = v.vn
        // left join hos.iptdiag ii on ii.an = v.an 
        // and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
        // and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
        // left join hos.iptdiag i1 on i1.an = v.an 
        // and (i1.icd10 between "s60" and "s609" or i1.icd10 = "t902"  or i1.icd10 = "t905")
        // left join hos.iptdiag i2 on i2.an = v.an 
        // and (i2.icd10 between "s14" and "s149" or i2.icd10 = "t913"  or i2.icd10 between "s24" and "s249" or i2.icd10 between "s34" and "s349")
        // where o.vstdate between "' . $startdate . '" and "' . $enddate . '"
        // and o.an is not null
        // group by month(o.vstdate)
        return view('report.report_refer_mainsub_rep_ipd', [
            'data'   =>  $data,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_rep_imcstork(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $data = DB::connection('mysql3')->select('  
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9)  as icd9,
            (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
            where oo.icode in("3010400","3010401") ORDER BY oo.icode limit 1) as list ,
            group_concat(distinct m.amountpay like "%3000%",m.amountpay like "%1000%") as imc
            ,group_concat(distinct m.amountpay) as amo,ix.pay ,i1.auth_code
            ,r.refer_hospcode,dd.cc

            from hos.opitemrece o
            left outer join  hos.nondrugitems n on n.icode = o.icode
            left outer join hos.an_stat v on v.an = o.an
            left outer join hos.patient p on p.hn = v.hn
            left join hos.pttype pt on pt.pttype = v.pttype
            left join hos.iptdiag ii on ii.an = v.an 
            left join hos.iptoprt io on io.an = v.an
            inner join hos.referin r on r.vn = v.vn
            left join hshooterdb.m_stm m on m.an = v.an
            left join hos.ipt_pttype i1 on i1.an = v.an
            left JOIN eclaimdb.imc ix on ix.an = v.an
            left join hos.opdscreen dd on dd.vn = v.vn
            where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
            and (ii.icd10 between "i60" and "i64" or ii.icd10 between "g81" and "g83" or ii.icd10 between "g47" and "g48" or ii.icd10 between "g41" 
            and "g419" or ii.icd10 between "g41" and "g419" or ii.icd10 between "g27" and "g279")
            and month(v.dchdate) = "' . $month . '" 
            and pt.hipdata_code ="UCS"
            and v.an is not null
            group by v.an

        ');
        return view('report.report_refer_mainsub_rep_imcstork', [
            'data'   =>  $data,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_rep_imcbrain(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $data = DB::connection('mysql3')->select('  
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
            (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
            where oo.icode in("3010400","3010401") ORDER BY oo.icode limit 1) as list ,w.name as name2
            from hos.opitemrece o
            left outer join  hos.nondrugitems n on n.icode = o.icode
            left outer join hos.an_stat v on v.an = o.an
            left outer join hos.patient p on p.hn = v.hn
            left outer join hos.pttype pt on pt.pttype = v.pttype 
            left join hos.iptdiag ii on ii.an = v.an 
            left join hos.iptoprt io on io.an = v.an
            left outer join hos.ward w on w.ward= v.ward
            where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
            and (ii.icd10 between "s60" and "s609" or ii.icd10 = "t902"  or ii.icd10 = "t905")
            and month(v.dchdate) = "' . $month . '" 
            and o.icode in ("3010400","3010401")
            group by v.an

        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_rep_imcbrain', [
            'data'   =>  $data,
            'month'       =>  $month
        ]);
    }

    public function report_refer_mainsub_rep_imcinjury(Request $request, $month, $year)
    {
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year)->first();
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;
        $data = DB::connection('mysql3')->select('                  
                select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as name,pt.name as nametype,group_concat(distinct ii.icd10) as icd10,group_concat(distinct io.icd9) as icd9,
                (select nn.name from hos.opitemrece oo left join  hos.nondrugitems nn on nn.icode =oo.icode
                where oo.icode in("3010400","3010401") ORDER BY oo.icode limit 1) as list  ,w.name as name2,w.name as name2
                from hos.opitemrece o
                left outer join  hos.nondrugitems n on n.icode = o.icode
                left outer join hos.an_stat v on v.an = o.an
                left outer join hos.pttype pt on pt.pttype = v.pttype 
                left outer join hos.patient p on p.hn = v.hn
                left join hos.iptdiag ii on ii.an = v.an 
                left join hos.iptoprt io on io.an = v.an
                left outer join hos.ward w on w.ward= v.ward
                where v.dchdate between "' . $startdate . '" and "' . $enddate . '"
                and (ii.icd10 between "s14" and "s149" or ii.icd10 = "t913"  or ii.icd10 between "s24" and "s249" or ii.icd10 between "s34" and "s349")
                and month(v.dchdate) = "' . $month . '"  
                and o.icode in ("3010400","3010401")
                group by v.an
                
        ');
        // dd($ipd_month);
        return view('report.report_refer_mainsub_rep_imcinjury ', [
            'data'   =>  $data,
            'month'       =>  $month
        ]);
    }


    public function report_refer_2561(Request $request)
    {
        $datashow_opd = DB::connection('mysql3')->select('
        select month(v.vstdate) as months
        ,count(distinct v.hn) as hn
        ,count(distinct v.vn) as vn     
        ,round(sum(v.income),2)
        ,round(sum(v.paid_money),2)            
        from hos.vn_stat v 
        inner join hos.referout r on r.vn = v.vn
        left outer join hos.patient pt on pt.hn=v.hn
        left outer join hos.pttype p on p.pttype = v.pttype           
        where v.vstdate between "2017-10-01" and "2018-09-30"
        and r.refer_hospcode not in("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","04007")
        group by month(v.vstdate)
        ');

        $datashow_ipd = DB::connection('mysql3')->select('
            select month(v.dchdate) as months
            ,count(distinct v.hn) as HN 
            ,count(distinct v.an) as AN
            ,count(distinct m.an) "vnn"   
            ,count(distinct v.an)-count(distinct m.an)
            ,round(sum(v.income),2),round(sum(v.paid_money),2)
            ,ifnull(sum(mmm.sums_carae),sum(mmm.sums_caref))  
            ,round(sum(v.paid_money),2)+ifnull(sum(mmm.sums_carae),sum(mmm.sums_caref))        
            from hos.an_stat v 
            left outer join hos.ipt i on i.an = v.an
            inner join hos.referout r on r.vn = i.an
            left outer join  hos.opitemrece o on o.an = v.an
            left outer join  hos.nondrugitems n on n.icode = o.icode  
            left outer join eclaimdb.m_registerdata m on m.an = v.an  
            left outer join eclaimdb.m_sumfund mmm on mmm.eclaim_no = m.eclaim_no      
            where v.dchdate between "2017-10-01" and "2018-09-30"        
            group by month(v.dchdate)
        ');

        return view('report.report_refer_2561', [
            'datashow_opd'   =>  $datashow_opd,
            'datashow_ipd'   =>  $datashow_ipd
        ]);
    }
    public static function refereclaim($id)
    {
        $refereclaim  =  $datashow_ipd = DB::connection('mysql4')
            ->select(' ifnull(sum(mmm.sums_carae),sum(mmm.sums_caref))');
        //   Market_product_repsub::where('request_sub_product_code','=',$id)->sum('request_sub_qty');

        return $refereclaim;
    }
    public function report_op(Request $request)
    {
        // $start = $request->startdate;
        // $end = $request->enddate;

        // $date = date("Y-m-d");
        // $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน  
        // $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์         

        // if ($start == '') {
        //     $datashow = DB::connection('mysql3')->select('select month(v.vstdate) as monthshow
        //     ,count(distinct v.hn) as vhn
        //     ,count(distinct v.vn) as vvn
        //     ,count(distinct pt1.vn) as pt
        //     ,count(distinct m.opdseq) "vnn"
        //     ,count(distinct mm.vn) as mmvn
        //     ,count(distinct v.vn)-count(distinct m.opdseq) as aftercount
        //     ,count(distinct ii.vn) as ii
        //     ,format(sum(v.income)/count(distinct o.icode),2) as inco
        //     ,format(sum(v.paid_money)/count(distinct o.icode),2) as paid
        //     ,format(sum(v.uc_money)/count(distinct o.icode),2) as uc
        //     ,format(sum(mm.amountpay)/count(distinct o.icode),2) as amon
        //     from hos.opitemrece o
        //     left outer join hos.vn_stat v on v.vn = o.vn
        //     left outer join eclaimdb.m_registerdata m on m.opdseq = v.vn
        //     left join hshooterdb.m_stm mm on mm.vn = v.vn
        //     left outer join hos.nondrugitems d on d.icode=o.icode
        //     left outer join hos.pttype pt on pt.pttype = v.pttype 
        //     left outer join hos.visit_pttype pt1 on pt1.vn = v.vn and pt1.pttype="co"
        //     left outer join hos.ovstdiag ii on ii.vn = v.vn and ii.icd10="u071"
        //     where v.vstdate between "'.$newDate.'" and "'.$date.'"
        //     and o.icode in("3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600","3000406"
        //     ,"3000407","3010640","3010641","3010697","3010698","3010677")
        //     and o.an is null
        //     group by month(v.vstdate)');
        // } else {
        //     # code...
        // }

        // $start_date   = "2021-10-01"; 
        // $end_date   = "2022-09-30"; 
        // $date = date("Y-m-d");
        // $date_m = date("MONTH(DATE($date))");
        $datashow = DB::connection('mysql4')->select('SELECT * from temptest');
        // SELECT  * from eclaimdb.temptest

        return view('report.report_op', [
            'datashow'   =>  $datashow
        ]);
    }
    public function report_op_getline(Request $request)
    {
        $date = date("Y-m-d");

        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newyear = date('Y', strtotime($date . ' -1 year')) + 543; //ย้อนหลัง 1 ปี 
        $newyear2 = date('Y', strtotime($date . ' -2 year')) + 543; //ย้อนหลัง 2 ปี 
        $newyear3 = date('Y', strtotime($date . ' -3 year')) + 543; //ย้อนหลัง 3 ปี 
        $newyear4 = date('Y', strtotime($date . ' -4 year')) + 543; //ย้อนหลัง 4 ปี 
        $newyear5 = date('Y', strtotime($date . ' -5 year')) + 543; //ย้อนหลัง 5 ปี 
        $type_chart5 = DB::connection('mysql4')->table('temptest')->select('datesave', 'totol', 'ucs', 'ofc', 'lgo', 'sss', 'nrd', 'stp', 'pvt', 'frg', 'dis', 'other')->get();

        foreach ($type_chart5 as $item) {
            // $data_count1 = DB::connection('mysql4')->table('temptest')->where($item->datesave, '=', $newyear)->get();
            // $data_count2 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear2, $date])->count();
            // $data_count3 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear3, $date])->count();
            // $data_count4 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear4, $date])->count();
            // $data_count5 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear5, $date])->count();
            // $data_count_week = DB::connection('mysql3')->table('ovst')->where('pttype', '=', $item->pttype)->WhereBetween('vstdate', [$newweek, $date])->count();  //ย้อนหลัง 1 สัปดาห์

            // if ($data_count1 > 0) {
            $dataset[] = [
                'label' => $item->datesave,
                'totol' => $item->totol,
                'ucs' => $item->ucs,
                'ofc' => $item->ofc,
                'lgo' => $item->lgo,
                'sss' => $item->sss,
                'nrd' => $item->nrd,
                'stp' => $item->stp,
                'pvt' => $item->pvt,
                'frg' => $item->frg,
                'dis' => $item->dis,
                'other' => $item->other,
            ];
            // }
            // if ($data_count_week > 0) {
            //     $dataset_2[] = [
            //         'label_week' => $item->name,
            //         'count_week' => $data_count_week
            //     ];
            // }
        }

        $chartData_year = $dataset;
        // $chartData_dataset_week = $dataset_2;
        // dd($chartData_year1);
        return response()->json([
            'status'             => '200',
            // 'chartData_dataset_week'    => $chartData_dataset_week,
            'chartData_year'  => $chartData_year
        ]);
    }
    public function report_op_getbar(Request $request)
    {
        $date = date("Y-m-d");

        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newyear = date('Y', strtotime($date . ' -1 year')) + 543; //ย้อนหลัง 1 ปี 
        $newyear2 = date('Y', strtotime($date . ' -2 year')) + 543; //ย้อนหลัง 2 ปี 
        $newyear3 = date('Y', strtotime($date . ' -3 year')) + 543; //ย้อนหลัง 3 ปี 
        $newyear4 = date('Y', strtotime($date . ' -4 year')) + 543; //ย้อนหลัง 4 ปี 
        $newyear5 = date('Y', strtotime($date . ' -5 year')) + 543; //ย้อนหลัง 5 ปี 
        $type_chart5 = DB::connection('mysql4')->table('temptest')->select('datesave', 'totol', 'ucs', 'ofc', 'lgo', 'sss', 'nrd', 'stp', 'pvt', 'frg', 'dis', 'other')->get();

        foreach ($type_chart5 as $item) {
            // $data_count1 = DB::connection('mysql4')->table('temptest')->where($item->datesave, '=', $newyear)->get();
            // $data_count2 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear2, $date])->count();
            // $data_count3 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear3, $date])->count();
            // $data_count4 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear4, $date])->count();
            // $data_count5 = DB::connection('mysql4')->table('temptest')->where('datesave', [$newyear5, $date])->count();
            // $data_count_week = DB::connection('mysql3')->table('ovst')->where('pttype', '=', $item->pttype)->WhereBetween('vstdate', [$newweek, $date])->count();  //ย้อนหลัง 1 สัปดาห์

            // if ($data_count1 > 0) {
            $dataset[] = [
                'label' => $item->datesave,
                'totol' => $item->totol,
                'ucs' => $item->ucs,
                'ofc' => $item->ofc,
                'lgo' => $item->lgo,
                'sss' => $item->sss,
                'nrd' => $item->nrd,
                'stp' => $item->stp,
                'pvt' => $item->pvt,
                'frg' => $item->frg,
                'dis' => $item->dis,
                'other' => $item->other,
            ];
        }

        $chartData_year = $dataset;
        return response()->json([
            'status'             => '200',
            'chartData_year'  => $chartData_year
        ]);
    }
    public function report_ods_hsoft(Request $request)
    {
        $start_date   = "2022-09-01";
        $end_date   = "2022-09-03";
        $date = date("Y-m-d");
        $date_m = date("MONTH(DATE($date))");

        $datashow = DB::connection('mysql3')->select('select month(v.vstdate),count(distinct v.hn),count(distinct v.vn)
        ,count(distinct pt1.vn)
        ,count(distinct m.opdseq) "vnn"
        ,count(distinct mm.vn)
        ,count(distinct v.vn)-count(distinct m.opdseq)
        ,count(distinct ii.vn)
        ,format(sum(v.income)/count(distinct o.icode),2),format(sum(v.paid_money)/count(distinct o.icode),2),format(sum(v.uc_money)/count(distinct o.icode),2),format(sum(mm.amountpay)/count(distinct o.icode),2)
        from hos.opitemrece o
        left outer join hos.vn_stat v on v.vn = o.vn
        left outer join eclaimdb.m_registerdata m on m.opdseq = v.vn
        left join hshooterdb.m_stm mm on mm.vn = v.vn
        left outer join hos.nondrugitems d on d.icode=o.icode
        left outer join hos.pttype pt on pt.pttype = v.pttype 
        left outer join hos.visit_pttype pt1 on pt1.vn = v.vn and pt1.pttype="co"
        left outer join hos.ovstdiag ii on ii.vn = v.vn and ii.icd10="u071"
        where v.vstdate between "2021-10-01" and "2022-09-30"
        and o.icode in("3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600","3000406"
        ,"3000407","3010640","3010641","3010697","3010698","3010677")
        and o.an is null
        group by month(v.vstdate)');

        return view('report.report_ods_hsoft', [
            'datashow'   =>  $datashow
        ]);
    }

    public function report_ipd(Request $request)
    {
        $datashow = DB::connection('mysql4')->select('SELECT  * from temptestipd');

        return view('report.report_ipd', [
            'datashow'   =>  $datashow
        ]);
    }
    public function report_ipd_getbar(Request $request)
    {
        $type_chart5 = DB::connection('mysql4')->table('temptestipd')->select('datesave', 'totol', 'ucs', 'ofc', 'lgo', 'sss', 'nrd', 'stp', 'pvt', 'frg', 'dis', 'other')->get();

        foreach ($type_chart5 as $item) {
            $dataset[] = [
                'label' => $item->datesave,
                'totol' => $item->totol,
                'ucs' => $item->ucs,
                'ofc' => $item->ofc,
                'lgo' => $item->lgo,
                'sss' => $item->sss,
                'nrd' => $item->nrd,
                'stp' => $item->stp,
                'pvt' => $item->pvt,
                'frg' => $item->frg,
                'dis' => $item->dis,
                'other' => $item->other,
            ];
        }

        $chartData_year = $dataset;
        return response()->json([
            'status'             => '200',
            'chartData_year'  => $chartData_year
        ]);
    }

    public function report_opd_ofc(Request $request)
    {
        $datashow = DB::connection('mysql4')->select('SELECT  * from temptestofcyear');

        return view('report.report_opd_ofc', [
            'datashow'   =>  $datashow
        ]);
    }
    public function report_opd_ofc_getbar(Request $request)
    {
        $type_chart5 = DB::connection('mysql4')->table('temptestofcyear')->select('datesave', 'totol', 'svnx', 'hosx', 'stmx', 'amountx', 'yearx', 'monthx')->get();

        foreach ($type_chart5 as $item) {
            $dataset[] = [
                'label' => $item->datesave,
                'totol' => $item->totol,
                'svnx' => $item->svnx,
                'hosx' => $item->hosx,
                'stmx' => $item->stmx,
                'amountx' => $item->amountx,
            ];
        }

        $chartData_year = $dataset;
        return response()->json([
            'status'             => '200',
            'chartData_year'  => $chartData_year
        ]);
    }

    public function report_ipd_ofc(Request $request)
    {
        $datashow = DB::connection('mysql4')->select('SELECT  * from temptestofcipdyear');

        return view('report.report_ipd_ofc', [
            'datashow'   =>  $datashow
        ]);
    }
    public function report_ipd_ofc_getbar(Request $request)
    {
        $type_chart5 = DB::connection('mysql4')->table('temptestofcipdyear')->select('datesave', 'totol', 'svnx', 'hosx', 'stmx', 'amountx', 'yearx', 'monthx')->get();

        foreach ($type_chart5 as $item) {
            $dataset[] = [
                'label' => $item->datesave,
                'totol' => $item->totol,
                'svnx' => $item->svnx,
                'hosx' => $item->hosx,
                'stmx' => $item->stmx,
                'amountx' => $item->amountx,
            ];
        }

        $chartData_year = $dataset;
        return response()->json([
            'status'             => '200',
            'chartData_year'  => $chartData_year
        ]);
    }


    // between "'.$startdate.'" and "'.$enddate.'"

    public function report_ipopd(Request $request)
    {
        $year_id = $request->q;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); // 1 เดือน 

        // dd($year_id);


        if ($year_id != null) {
            // dd($year_id);
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first();
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashowipopd = DB::connection('mysql3')->select('
                select h.hospcode,h.name,
                sum(CASE WHEN (o.an<>" ") THEN 1 ELSE 0 END) AS ipd, 
                sum(CASE WHEN (o.an is null) THEN 1 ELSE 0 END) AS opd
                from referin ro 
                left outer join ovst o on o.vn=ro.vn  
                left outer join pttype pty on pty.pttype = o.pttype  
                left outer join patient p on p.hn=o.hn  
                left outer join hospcode h on h.hospcode = o.rfrilct  
                left outer join rfrcs r on r.rfrcs = o.rfrics  
                left outer join doctor d on d.code = o.doctor  
                left outer join icd101 ic on ic.code = ro.icd10  
                where ro.vn in (select vn from ovst where vstdate between "' . $startdate . '" and "' . $enddate . '") 
                group by h.hospcode
          
                ');
        } else {
            $datashowipopd = DB::connection('mysql3')->select('
            select h.hospcode,h.name,
            sum(CASE WHEN (o.an<>" ") THEN 1 ELSE 0 END) AS ipd, 
            sum(CASE WHEN (o.an is null) THEN 1 ELSE 0 END) AS opd
            from referin ro 
            left outer join ovst o on o.vn=ro.vn  
            left outer join pttype pty on pty.pttype = o.pttype  
            left outer join patient p on p.hn=o.hn  
            left outer join hospcode h on h.hospcode = o.rfrilct  
            left outer join rfrcs r on r.rfrcs = o.rfrics  
            left outer join doctor d on d.code = o.doctor  
            left outer join icd101 ic on ic.code = ro.icd10  
            where ro.vn in (select vn from ovst where vstdate between "' . $newDate . '" and "' . $date . '") 
            group by h.hospcode
          
            ');
            $year_id = $y;
        }
        // "2021-01-01" and "2022-09-01"
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_ipopd', [
            'datashowipopd'      =>  $datashowipopd,
            'year'              =>  $year,
            'year_ids'           =>  $year_id
        ]);
    }

    public function report_refer_main_ipopd_search(Request $request)
    {
        $year_id = $request->leave_year_id;
        dd($year_id);

        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
        // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;

        $datashow = DB::connection('mysql3')->select('
                select h.hospcode,h.name,
                sum(CASE WHEN (o.an<>" ") THEN 1 ELSE 0 END) AS ipd, 
                sum(CASE WHEN (o.an is null) THEN 1 ELSE 0 END) AS opd
                from referin ro 
                left outer join ovst o on o.vn=ro.vn  
                left outer join pttype pty on pty.pttype = o.pttype  
                left outer join patient p on p.hn=o.hn  
                left outer join hospcode h on h.hospcode = o.rfrilct  
                left outer join rfrcs r on r.rfrcs = o.rfrics  
                left outer join doctor d on d.code = o.doctor  
                left outer join icd101 ic on ic.code = ro.icd10  
                where ro.vn in (select vn from ovst where vstdate between "' . $startdate . '" and "' . $enddate . '") 
                group by h.hospcode
                order by ipd desc 
                ');


        // "2021-01-01" and "2022-09-01"
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_refer_main_ipopd', [
            'datashow'      =>  $datashow,
            'year'              =>  $year,
            'year_ids'           =>  $year_id
        ]);
    }

    public function report_refer_out(Request $request)
    {
        $year_id = $request->year_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); // 1 ปี 


        if ($year_id != '') {
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
            // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashow = DB::connection('mysql3')->select(' 
            SELECT ro.department,ro.refer_number,"----" AS AN,ro.hn,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.vstdate,o.vsttime,CONCAT(p.pname,p.fname,"  ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,r.name AS refername, ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ovst o ON o.vn = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode  
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="OPD" AND ro.refer_date BETWEEN "' . $startdate . '" and "' . $enddate . '" 
            union  
            SELECT ro.department,ro.refer_number,o.an AS AN,ro.hn,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.regdate AS vstdate,o.regtime AS vsttime,
            CONCAT(p.pname,p.fname," ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,  r.name AS refername,ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ipt o ON o.an = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode 
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="IPD" AND ro.refer_date BETWEEN "' . $startdate . '" and "' . $enddate . '" 
 
            ');
        } else {

            $datashow = DB::connection('mysql3')->select('
            SELECT ro.department,ro.refer_number,"----" AS AN,ro.hn,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.vstdate,o.vsttime,CONCAT(p.pname,p.fname,"  ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,r.name AS refername, ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ovst o ON o.vn = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode  
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="OPD" AND ro.refer_date BETWEEN "' . $newDate . '" and "' . $date . '" 
            union  
            SELECT ro.department,ro.refer_number,o.an AS AN,ro.hn,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.regdate AS vstdate,o.regtime AS vsttime,
            CONCAT(p.pname,p.fname," ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,  r.name AS refername,ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ipt o ON o.an = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode 
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="IPD" AND ro.refer_date BETWEEN "' . $newDate . '" and "' . $date . '" 
 
            ');
            $year_id = $y;
        }

        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_refer_out', [
            'datashow'      =>  $datashow,
            'year'              =>  $year,
            'year_ids'           =>  $year_id
        ]);
    }

    public function report_refer_outs(Request $request)
    {
        $year_id = $request->year_id;
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
        $startdate =  $yearget->date_begin;
        $enddate =  $yearget->date_end;

        $datashow = DB::connection('mysql3')->select(' 
            SELECT ro.department,ro.refer_number,"----" AS AN,ro.hn,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.vstdate,o.vsttime,CONCAT(p.pname,p.fname,"  ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,r.name AS refername, ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ovst o ON o.vn = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode  
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="OPD" AND ro.refer_date BETWEEN "' . $startdate . '" and "' . $enddate . '" 
            union  
            SELECT ro.department,ro.refer_number,o.an AS AN,ro.hn,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.regdate AS vstdate,o.regtime AS vsttime,
            CONCAT(p.pname,p.fname," ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,  r.name AS refername,ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ipt o ON o.an = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode 
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="IPD" AND ro.refer_date BETWEEN "' . $startdate . '" and "' . $enddate . '" 
 
            ');



        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_refer_outs', [
            'datashow'      =>  $datashow,
            'year'              =>  $year,
            'year_ids'           =>  $year_id
        ]);
    }

    public function report_refer_outipd(Request $request)
    {
        $year_id = $request->year_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); // 1 ปี 


        if ($year_id != '') {
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
            // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashow = DB::connection('mysql3')->select('            
            SELECT ro.department,o.an AS AN,ro.hn AS HN,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.regdate,o.regtime AS vsttime,
            CONCAT(p.pname,p.fname," ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,  r.name AS refername,ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ipt o ON o.an = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode 
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="IPD" AND ro.refer_date BETWEEN "' . $startdate . '" and "' . $enddate . '" 
            ORDER BY ro.refer_date,o.regdate,o.regtime
              
            ');
        } else {

            $datashow = DB::connection('mysql3')->select('
            SELECT ro.department,o.an AS AN,ro.hn AS HN,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.regdate,o.regtime AS vsttime,
            CONCAT(p.pname,p.fname," ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,  r.name AS refername,ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ipt o ON o.an = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode 
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="IPD" AND ro.refer_date BETWEEN "' . $newDate . '" and "' . $date . '" 
            ORDER BY ro.refer_date,o.regdate,o.regtime  
            ');
            $year_id = $y;
        }

        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_refer_outipd', [
            'datashow'      =>  $datashow,
            'year'              =>  $year,
            'year_ids'           =>  $year_id
        ]);
    }

    public function report_refer_outopd(Request $request)
    {
        $year_id = $request->year_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); // 1 ปี 


        if ($year_id != '') {
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
            // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashow = DB::connection('mysql3')->select('  
            SELECT ro.department,ro.hn AS HN,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.vstdate,o.vsttime,CONCAT(p.pname,p.fname," ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,r.name AS refername, ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ovst o ON o.vn = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode  
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="OPD" AND ro.refer_date BETWEEN "' . $startdate . '" and "' . $enddate . '" 
            ORDER BY ro.refer_date,o.vstdate,o.vsttime 
            ');
        } else {

            $datashow = DB::connection('mysql3')->select('
            SELECT ro.department,ro.hn AS HN,d.name AS doctor_name,
            ro.refer_date,ro.refer_time,o.vstdate,o.vsttime,CONCAT(p.pname,p.fname," ",p.lname) AS ptname,
            CONCAT(h.hosptype," ",h.name) AS hospname,h.province_name,h.area_code,
            pe.name AS pttype_name,r.name AS refername, ro.refer_point,ro.with_ambulance,
            ro.with_nurse,CONCAT(ro.pdx," : ",ic.name) AS icd_name
            FROM referout ro  
            LEFT JOIN ovst o ON o.vn = ro.vn  
            LEFT JOIN patient p ON p.hn=ro.hn  
            LEFT JOIN hospcode h ON h.hospcode = ro.refer_hospcode  
            LEFT JOIN rfrcs r ON r.rfrcs = ro.rfrcs  
            LEFT JOIN doctor d ON d.code = ro.doctor  
            LEFT JOIN pttype pe ON pe.pttype = o.pttype  
            LEFT JOIN icd101 ic ON ic.code = ro.pdx  
            WHERE ro.department="OPD" AND ro.refer_date BETWEEN "' . $newDate . '" and "' . $date . '" 
            ORDER BY ro.refer_date,o.vstdate,o.vsttime             
            ');
            $year_id = $y;
        }

        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();

        return view('report.report_refer_outopd', [
            'datashow'      =>  $datashow,
            'year'              =>  $year,
            'year_ids'           =>  $year_id
        ]);
    }

    public function report_refer_outmonth(Request $request)
    {
        $year_id = $request->year_id;
        $sp = $request->spclty;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); // 1 ปี 


        if ($year_id != '') {
            $yearget = DB::table('budget_year')->where('leave_year_id', '=', $year_id)->first(); // ปีงบ
            // $yearget = DB::table('year')->where('leave_year_id', '=', $year_id)->first();  // ต้นปี-ปลายปี ปกติ
            $startdate =  $yearget->date_begin;
            $enddate =  $yearget->date_end;

            $datashow = DB::connection('mysql3')->select(' 
                select DATE_FORMAT(refer_date,"%m-%Y") as month,
                count(hn) as amoung
                from referout r
                LEFT JOIN spclty s ON s.spclty = r.spclty 
                WHERE refer_date between  "' . $startdate . '" and "' . $enddate . '" 
                and not(pdx like "z380") 
                and r.spclty = "' . $sp . '"
                and r.pdx !=" "
                group by DATE_FORMAT(refer_date,"%m-%Y")
                ORDER BY refer_date DESC 
                ');
        } else {

            $datashow = DB::connection('mysql3')->select('
                select DATE_FORMAT(refer_date,"%m-%Y") as month,
                count(hn) as amoung
                from referout r
                LEFT JOIN spclty s ON s.spclty = r.spclty 
                WHERE refer_date between  "' . $newDate . '" and "' . $date . '" 
                and not(pdx like "z380") 
                and r.spclty = "' . $sp . '" 
                and r.pdx !=" "
                group by DATE_FORMAT(refer_date,"%m-%Y")
                ORDER BY refer_date DESC 
                ');

            $year_id = $y;
        }


        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $spclty = DB::connection('mysql3')->select('select * from spclty');

        return view('report.report_refer_outmonth', [
            'datashow'      =>  $datashow,
            'year'          =>  $year,
            'year_ids'      =>  $year_id,
            'spcltyts'        =>  $spclty,

        ]);
    }

    public function report_refer_opd(Request $request, $years)
    {
        $y = date('Y') + 543;
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $yearget = DB::table('budget_year')->where('leave_year_id', '=', $years)->first(); // ปีงบ
        $startdate =  $yearget->date_begin;
        $sy = date('Y', strtotime($startdate . '')) + 543;
        $sm = date('m', strtotime($startdate . ''));
        $sd = date('d', strtotime($startdate . ''));

        $enddate =  $yearget->date_end;
        $ey = date('Y', strtotime($enddate . '')) + 543;
        $em = date('m', strtotime($enddate . ''));
        $ed = date('d', strtotime($enddate . ''));

        $spclty = DB::connection('mysql3')->select('select * from spclty');
        $year_id = $y;

        $startnew = $sy . '' . $sm . '' . $sd;     // แปลงปีให้เรียงตาม eclaim เช่น 25601015  
        $endnew = $ey . '' . $em . '' . $ed;
        // dd($sm);
        $datashow = DB::connection('mysql3')->select('
            SELECT m1.doc,count(DISTINCT m1.TRAN_ID) as am
            from eclaimdb.r9opch m1 
            where m1.HCODE ="10978" AND m1.DATEADM BETWEEN "' . $startnew . '" and "' . $endnew . '" 
            group by m1.doc
        ');

        return view('report.report_refer_opd', [
            'datashow'      =>  $datashow,
            'year'          =>  $year,
            'year_ids'      =>  $year_id,
            'spcltyts'      =>  $spclty,
            'years'         =>  $years
        ]);
    }
    public function report_refer_opdrep(Request $request, $doc)
    {

        $y = date('Y') + 543;
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $spclty = DB::connection('mysql3')->select('select * from spclty');
        $year_id = $y;

        $datashow = DB::connection('mysql3')->select('
        SELECT h.hospcode,h.name,count(distinct v.hn) as vhn,count(distinct m1.TRAN_ID) as ssj
        ,round(sum(IF(o.sum_price<600,600,"")),2) as sumprice
         from eclaimdb.m_registerdata m
        left join hos.ovst ov on ov.hn = m.hn 
        and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = ov.vstdate
        and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5) and m.status in("0","1","4")
        LEFT JOIN vn_stat v on v.vn = ov.vn
         LEFT OUTER JOIN eclaimdb.opitemrece_refer o ON o.vn=v.vn
        LEFT OUTER JOIN patient p ON p.hn=v.hn
        left outer join pttype pt on pt.pttype = v.pttype
        
        left outer join eclaimdb.vn_stat_ncd vv on vv.vn = v.vn
        left join eclaimdb.r9opch m1 on m1.tran_id = m.tran_id and m1.code_id is null
        left outer join hospcode h on h.hospcode = m1.hmain2
        where v.vstdate between "2020-10-01" and "2022-09-30"
        and m1.hmain2 in ("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007") 
        and v.income > "1"
        and m1.doc= "' . $doc . '"        
        group by h.name
        order by count(distinct v.hn) desc
        ');

        return view('report.report_refer_opdrep', [
            'datashow'      =>  $datashow,
            'year'          =>  $year,
            'year_ids'      =>  $year_id,
            'spcltyts'      =>  $spclty,
            'doc'         =>  $doc
        ]);
    }
    public static function ins($vn)
    {
        $ins =  DB::connection('mysql3')
            ->select('
        select sum(oo.sum_price) as sum
        from eclaimdb.opitemrece_refer oo 
        LEFT JOIN nondrugitems n on n.icode = oo.icode
        LEFT JOIN vn_stat v on v.vn = oo.vn 
        where oo.vn = "' . $vn . '"
        and oo.icode in(select icode from hos.nondrugitems where income="02")  limit 1
        ');

        return $ins;
    }
    public function report_refer_opdrep_sub(Request $request, $hosname, $doc)
    {
        $y = date('Y') + 543;
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $spclty = DB::connection('mysql3')->select('select * from spclty');
        $year_id = $y;

        $datashow = DB::connection('mysql3')->select('
            SELECT v.vn,v.hn,v.vstdate
            from vn_stat v
            left outer join hospcode h on h.hospcode = v.hospmain
            left join eclaimdb.m_registerdata m on m.opdseq = v.vn
            left join eclaimdb.r9opch m1 on m1.tran_id = m.tran_id and m1.code_id is null
            where v.vstdate between "2020-10-01" and "2022-09-30"
            and v.hospmain in ("10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983","10702","04007")
            and v.pttype in ("98","99")  
            and h.hospcode = "' . $hosname . '"
            and m1.doc= "' . $doc . '" 
            group by v.vstdate,v.hn HAVING count(v.vn) > "1"
            ORDER BY v.hn,v.vstdate,v.vn
        ');

        $datashow2 = DB::connection('mysql3')->select('
            SELECT v.vn,v.vstdate,v.hn,v.pdx,v.op0,concat(p.pname,p.fname," ",p.lname) as fullname,v.cid   
            ,round((v.inc16),0) as bed
            ,round((v.inc01),0) as chun
            ,round(v.inc04,0) as rn
            ,round(v.inc05,0) as tru,round(v.inc06,0) as pha
            ,round(v.inc08,0) as tiam,round(v.inc09,0) as spe
            ,round(v.inc10,0) as nondrug,round(v.inc12,0) as drug
            ,round(v.inc13,0) as wet,round(v.inc14,0) as khem
            ,round(v.inc17,0) as serall,round(v.inc11,0) as den
            ,o.sum_price
            ,m1.tran_id
            ,m1.sums_serviceitem
            ,m1.pay
            from eclaimdb.m_registerdata m
            left join hos.ovst ov on ov.hn = m.hn 
            and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = ov.vstdate
            and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5) and m.status in("0","1","4")
            LEFT JOIN vn_stat v on v.vn = ov.vn
            LEFT OUTER JOIN eclaimdb.opitemrece_refer o ON o.vn=v.vn
            LEFT OUTER JOIN patient p ON p.hn=v.hn
            left outer join pttype pt on pt.pttype = v.pttype
            left outer join eclaimdb.vn_stat_ncd vv on vv.vn = v.vn
            left join eclaimdb.r9opch m1 on m1.tran_id = m.tran_id and m1.code_id is null
            left outer join hospcode h on h.hospcode = m1.hmain2
            where v.vstdate between "2020-10-01" and "2022-09-30"
            and h.hospcode = "' . $hosname . '"
                and m1.doc= "' . $doc . '"
            and v.income > "1"
            group by m1.tran_id
            order by p.fname,v.vstdate
        ');
        return view('report.report_refer_opdrep_sub', [
            'datashow'      =>  $datashow,
            'year'          =>  $year,
            'year_ids'      =>  $year_id,
            'spcltyts'      =>  $spclty,
            'datashow2'         =>  $datashow2
        ]);
    }

    public function report_refer_opdrep_subsub(Request $request, $vn)
    {
        $y = date('Y') + 543;
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $spclty = DB::connection('mysql3')->select('select * from spclty');
        $year_id = $y;

        $datashow = DB::connection('mysql3')->select('
         select n.name,o.qty,round(n.price,2) as price2,round(o.sum_price,2) as pricetotal,o.vstdate from opitemrece o
         left outer join nondrugitems n on n.icode = o.icode
          left outer join drugitems nn on nn.icode = o.icode
          where  o.vn ="' . $vn . '" 
          and n.income="12" 
        ');

        return view('report.report_refer_opdrep_subsub', [
            'datashow'      =>  $datashow,
            'year'          =>  $year,
            'year_ids'      =>  $year_id,
        ]);
    }
    public function report_refer_opdrep_subsubtotal(Request $request, $vn)
    {
        $y = date('Y') + 543;
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get(); 
        $year_id = $y;

        $datashow = DB::connection('mysql3')->select('
            select o.icode,n.name,o.qty,round(o.sum_price,2) as pricetotal from opitemrece o
            left outer join s_drugitems n on n.icode = o.icode
            where  o.vn ="' . $vn . '"         
        ');
        
        $total =DB::connection('mysql3')->table('opitemrece')
        ->leftJoin('s_drugitems','s_drugitems.icode','=','opitemrece.icode')
        ->where('vn','=',$vn)->sum('sum_price');

        return view('report.report_refer_opdrep_subsubtotal', [
            'datashow'      =>  $datashow,
            'year'          =>  $year,
            'year_ids'      =>  $year_id,
            'total'         =>  $total
        ]);
    }
    public function report_refer_opdrep_subsubtran(Request $request, $tran_id)
    {
        $y = date('Y') + 543;
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get(); 
        $year_id = $y;

        $datashow = DB::connection('mysql3')->select('
        select dateadm,rep,filename_send from eclaimdb.m_registerdata
        where tran_id ="'.$tran_id.'" group by eclaim_no      
        ');
        
        return view('report.report_refer_opdrep_subsubtran', [
            'datashow'      =>  $datashow,
            'year'          =>  $year,
            'year_ids'      =>  $year_id 
        ]);
    }
}
