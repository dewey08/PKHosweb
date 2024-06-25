<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Account_main;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use SheetDB;

class AccountController extends Controller
{
    public function checksit_admit(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }
        // dd($pang);        
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['pang'] = DB::connection('mysql5')->table('pang')->get();
        $datashow = DB::connection('mysql3')->select('
            SELECT IF(ps.pang_stamp_an IS NULL,"","Y")AS Stamp , o.an AS AN ,o.hn AS HN ,CONCAT(o.regdate," / ",o.dchdate) AS AdmitDischarge ,p.cid ,ip.pttype ,IF(cs.check_sit_status="003","จำหน่าย/เสียชีวิต",CONCAT(cs.check_sit_subinscl," (",IFNULL(cs.check_sit_hmain," "),")" ) ) AS spsc ,ps.pang_stamp_nhso ,v.pdx ,ROUND(v.income,2)AS income,ROUND(v.uc_money,2) AS uc_money ,ROUND(v.paid_money,2) AS paid_money ,ps.pang_stamp_id 
                FROM hos.ipt o 
                LEFT OUTER JOIN hos.patient p ON o.hn=p.hn 
                LEFT OUTER JOIN money_bn.check_sit cs ON o.an = cs.check_sit_vn AND "' . $datenow . '" = cs.check_sit_date 
                LEFT OUTER JOIN money_bn.pang_stamp ps ON 1102050101.888=ps.pang_stamp AND o.an=ps.pang_stamp_an 
                LEFT OUTER JOIN hos.an_stat v ON o.an=v.an 
                LEFT OUTER JOIN hos.ipt_pttype ip ON ip.an=v.an 
                LEFT OUTER JOIN hos.pttype ptt ON ip.pttype=ptt.pttype 
                left join hos.ipt_pttype vp on vp.an = o.an 
                WHERE o.dchdate is null 
                AND ps.pang_stamp_an IS NULL 
                AND o.regdate BETWEEN "' . $startdate . '" and "' . $enddate . '" 
                AND ip.pttype IN ("21","39","E1","L1","L2","L3","L4","L5","L6","L7",
                "m6","m6","08","11","12","18","30","31","33","36","49","50","55","60",
                "66","68","69","70","71","72","73","74","75","76","77","78","80","81",
                "82","83","84","85","86","87","88","89","90","91","92","93","94","95",
                "96","98","99","AG","C2","C5","ca","co","dm","hc","m3","m4","m9","p1",
                "pa","pd","pl","s4","W1","w2","x1","x4","x7","x9","xo","xo","09","20",
                "22","25","38","97","B1","B2","B3","B4","B5","m1","m7","O1","O2","O3",
                "O4","O5","O6","o7","p2","S1","S2","s5","x2","x2","14","15","17","32",
                "34","35","37","45","a1","A7","C1","C3","C4","m2","m5","p3","s3","s7","ss","x3","x3") 
                group by o.an
            ');
        return view('account.checksit_admit', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'pang_id'       =>     $pang_id
        ]);
    }
    public function checksit_admit_spsch(Request $request)
    {
        $datenow = date('Y-m-d');
        $star_tdate = $request->startdate;
        $end_date = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }

        $data['pang'] = DB::connection('mysql5')->table('pang')->get();
        $datashow = DB::connection('mysql3')->select('
            SELECT IF(ps.pang_stamp_an IS NULL,"","Y")AS Stamp , o.an AS AN ,o.hn AS HN ,CONCAT(o.regdate," / ",o.dchdate) AS AdmitDischarge ,p.cid ,ip.pttype ,IF(cs.check_sit_status="003","จำหน่าย/เสียชีวิต",CONCAT(cs.check_sit_subinscl," (",IFNULL(cs.check_sit_hmain," "),")" ) ) AS spsc ,ps.pang_stamp_nhso ,v.pdx ,ROUND(v.income,2)AS income,ROUND(v.uc_money,2) AS uc_money ,ROUND(v.paid_money,2) AS paid_money ,ps.pang_stamp_id 
                FROM hos.ipt o 
                LEFT OUTER JOIN hos.patient p ON o.hn=p.hn 
                LEFT OUTER JOIN money_bn.check_sit cs ON o.an = cs.check_sit_vn AND "' . $datenow . '" = cs.check_sit_date 
                LEFT OUTER JOIN money_bn.pang_stamp ps ON 1102050101.888=ps.pang_stamp AND o.an=ps.pang_stamp_an 
                LEFT OUTER JOIN hos.an_stat v ON o.an=v.an 
                LEFT OUTER JOIN hos.ipt_pttype ip ON ip.an=v.an 
                LEFT OUTER JOIN hos.pttype ptt ON ip.pttype=ptt.pttype 
                left join hos.ipt_pttype vp on vp.an = o.an 
                WHERE o.dchdate is null 
                AND ps.pang_stamp_an IS NULL 
                AND o.regdate BETWEEN "' . $star_tdate . '" and "' . $end_date . '" 
                AND ip.pttype IN ("21","39","E1","L1","L2","L3","L4","L5","L6","L7",
                "m6","m6","08","11","12","18","30","31","33","36","49","50","55","60",
                "66","68","69","70","71","72","73","74","75","76","77","78","80","81",
                "82","83","84","85","86","87","88","89","90","91","92","93","94","95",
                "96","98","99","AG","C2","C5","ca","co","dm","hc","m3","m4","m9","p1",
                "pa","pd","pl","s4","W1","w2","x1","x4","x7","x9","xo","xo","09","20",
                "22","25","38","97","B1","B2","B3","B4","B5","m1","m7","O1","O2","O3",
                "O4","O5","O6","o7","p2","S1","S2","s5","x2","x2","14","15","17","32",
                "34","35","37","45","a1","A7","C1","C3","C4","m2","m5","p3","s3","s7","ss","x3","x3") 
                group by o.an
            ');
        $event = array();
        // $cid = $datashow[];
        foreach ($datashow as $item) {
            $client = new SoapClient(
                "http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                    "trace"      => 1,    // enable trace to view what is happening
                    "exceptions" => 0,    // disable exceptions
                    "cache_wsdl" => 0
                )
            );

            @$params = array(
                'sequence' => array(
                    "user_person_id" => "$user_person_id",
                    "smctoken" => "$smctoken",
                    "person_id" => "$person_id",
                )
            );
        }
        // dd($datashow);

        return view('account.checksit_admit', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'pang_id'       =>     $pang_id
        ]);
    }

    public function debtor_sss(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sheet.best/api/sheets/a29c3c74-c191-4ad5-abcd-4c8e1ff7a2bb"); //paste api link
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $zapuser =  User::all();
        //change to array format
        // $datashow = json_decode($output);

        // $sheetdb = new SheetDB('58f61be4dda40');

        // returns all spreadsheets data
        // $response = $sheetdb->get();

        return response()->json(['output' => $output]);
        // return response()->json(['name' => 'Virat Gandhi', 'state' => 'Gujarat']);

        // return view('account.debtor_sss', $data,[
        //     'startdate'      =>  $startdate,
        //     'enddate'      =>  $enddate,
        //     'datashow'      =>  $datashow,
        // ]);
    }
    // public function debtor_sssAPI(Request $request)
    // {
        // $zapuser =  Zapuser::all();
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://sheet.best/api/sheets/a29c3c74-c191-4ad5-abcd-4c8e1ff7a2bb"); //paste api link
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output = curl_exec($ch);
        // curl_close($ch);

        // $startdate = $request->startdate;
        // $enddate = $request->enddate;

        // $datashow = Bookrep::all();
        // return response()->json([
        //     'status' => true,
        //     'datashow' => $datashow
        // ]);

        //     return response([
        //     'datashow' => $datashow
        // ]);
    // }
    // public function account_info(Request $request,$months,$startdate,$enddate)
    public function account_info(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $datashow = DB::connection('mysql3')->select('
                select year(a.vstdate) as monyear
                ,month(a.vstdate) as months 
                ,count(distinct a.vn) as vn
                from hos.vn_stat a
                left outer join hos.ipt o on o.vn = a.vn
                LEFT JOIN hos.patient p on p.hn = a.hn
                left outer join hos.rcpt_debt rr on rr.vn = a.vn 
                left outer join hos.hpc11_ktb_approval hh on hh.pid=p.cid and hh.transaction_date = a.vstdate
                left outer join eclaimdb.m_registerdata m on m.opdseq = a.vn and m.status in("0","1","4")
                where a.vstdate between "' . $startdate . '" AND "' . $enddate . '"
                and a.pttype in("o1","o2","o3","o4","o5")
                and (rr.sss_approval_code is null or rr.sss_approval_code =" ")
                and a.vn not in(select opdseq from eclaimdb.m_registerdata  where opdseq = m.opdseq)
                and o.an is null
                and a.uc_money > 1
                group by year(a.vstdate),month(a.vstdate) 
        ');
        $datashow2 = DB::connection('mysql3')->select('
                select year(a.vstdate) as monyear
                ,month(a.vstdate) as months
                ,count(distinct a.vn) as vn
                ,sum(rr.sss_approval_code is null) as no_appprove

                from hos.vn_stat a
                left outer join hos.ipt o on o.vn = a.vn
                LEFT JOIN hos.patient p on p.hn = a.hn
                left outer join hos.rcpt_debt rr on rr.vn = a.vn
                left outer join hos.ktb_edc_transaction k on k.vn = a.vn
                where a.vstdate between "' . $startdate . '" AND "' . $enddate . '"
                and a.pttype in("of")
                and o.an is null
                and a.uc_money > 1
                group by month(a.vstdate)
        ');

        // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
        // $y = date('Y-m-d',$startdate)+543;
        $strYear = date("Y", strtotime($startdate)) + 543;
        $strM = date('m', strtotime($startdate));
        $strD = date('d', strtotime($startdate));

        $endYear = date("Y", strtotime($enddate)) + 543;
        $endM = date('m', strtotime($enddate));
        $endD = date('d', strtotime($enddate));

        $strdateadmit = $strYear . '' . $strM . '' . $strD;
        $enddateadmit = $endYear . '' . $endM . '' . $endD;

        // dd($enddateadmit);

        $datashow3 = DB::connection('mysql3')->select('
                select left(DATEADM,4) as monyear,mid(dateadm,5,2) as months,count(distinct m.opdseq) as errorc
                from eclaimdb.m_registerdata m  
                LEFT JOIN hshooterdb.m_stm s on s.vn = m.opdseq
                LEFT JOIN hos.vn_stat v on v.vn = m.opdseq
                left outer join hos.ktb_edc_transaction k on k.vn = v.vn
                left outer join rcpt_print r on r.vn =v.vn
                left outer join rcpt_debt r1 on r1.vn =v.vn

                where DATEADM between "' . $strdateadmit . '" and "' . $enddateadmit . '"
                and (m.code_id like "%307%" or m.code_id like "%305%") 
                and m.OPDSEQ not in(SELECT vn from hshooterdb.m_stm where vn = s.vn)
                and mid(dateadm,5,2)
                and m.maininscl ="ofc"
                GROUP BY left(DATEADM,4),mid(dateadm,5,2) 
        ');
        return view('account.account_info', [
            'datashow'   =>  $datashow,
            'datashow2'   =>  $datashow2,
            'datashow3'   =>  $datashow3,
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,
            'strdateadmit'  => $strdateadmit,
            'enddateadmit'  => $enddateadmit,
        ]);
    }
    public function account_info_vn(Request $request, $monyear, $months, $startdate, $enddate)
    {
        $datashow = DB::connection('mysql3')->select('
            select e.hn,p.cid,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname
                ,e.uc_money,e.paid_money,r.rcpno,format(e.income,2) as hincome,
                format(rr.amount,2) as rramont,
                group_concat(distinct k.amount) as edc,
                oo.cc,
                group_concat(distinct rr.sss_approval_code,":",rr.amount,"/") as apphoscode,
                group_concat(distinct k.approval_code,":",k.amount,"/") as appktb,
                e.age_y,
                (select if(group_concat(status) like "%4%","ออก stm","check") from eclaimdb.m_registerdata where hn=m.hn and dateadm=m.dateadm ) as scheck
                from hos.vn_stat e
                left outer join hos.ovst o on o.vn = e.vn
                left outer join hos.patient p on p.hn = e.hn
                left outer join hos.rcpt_print r on r.vn =e.vn
                left outer join hos.opdscreen oo on oo.vn =e.vn
                left outer join hos.rcpt_debt rr on rr.vn = e.vn
                left outer join hos.ktb_edc_transaction k on k.vn = e.vn
                left outer join eclaimdb.m_registerdata m on m.opdseq = e.vn and m.status in("0","1","4")
                where e.vstdate between "' . $startdate . '" AND "' . $enddate . '"
                and e.pttype in("o1","o2","o3","o4","o5")
                and o.an is null
                and e.uc_money > 1
                and (rr.sss_approval_code is null or rr.sss_approval_code =" ")
                and e.vn not in(select opdseq from eclaimdb.m_registerdata  where opdseq = m.opdseq)
                and year(e.vstdate) = "' . $monyear . '" 
                and month(e.vstdate) = "' . $months . '" 
                group by e.vn,e.vstdate 
                order by e.vstdate 
        ');
        return view('account.account_info_vn', [
            'datashow'   =>  $datashow,
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,
        ]);
    }
    public function account_info_vn_subofc_vn(Request $request, $year, $months, $strdateadmit, $enddateadmit)
    {
        // $strYear = date("Y",strtotime($startdate))+543;
        // $strM = date('m',strtotime($startdate));
        // $strD = date('d',strtotime($startdate));

        // $endYear = date("Y",strtotime($enddate))+543;
        // $endM = date('m',strtotime($enddate));
        // $endD = date('d',strtotime($enddate)); 

        // $strdateadmit = $strYear.''.$strM.''.$strD;
        // $enddateadmit = $endYear.''.$endM.''.$endD; 

        $datashow = DB::connection('mysql3')->select('
            select m.opdseq,m.hn,m.DATEADM
                ,v.vn
                ,concat(left(m.TIMEADM,2),":",right(m.timeadm,2)) as timeadm
                ,m.pid,concat(m.titles,m.fname," ",m.lname) as fullname
                ,m.age,v.pttype,v.income
                ,group_concat(" ",r.rcpno,"/",r.total_amount) as paid
                ,m.CODE_ID
                ,group_concat(distinct k.approval_code,":",k.amount,"/") as approval_code
                ,group_concat(distinct r1.sss_approval_code,":",r1.total_amount,"/") as apphoscode
                ,m.claimcode
                ,group_concat(distinct s.amountpay) as amountpay
                from eclaimdb.m_registerdata m  
                LEFT JOIN hshooterdb.m_stm s on s.vn = m.opdseq
                LEFT JOIN hos.vn_stat v on v.vn = m.opdseq
                left outer join hos.ktb_edc_transaction k on k.vn = v.vn
                left outer join rcpt_print r on r.vn =v.vn
                left outer join rcpt_debt r1 on r1.vn =v.vn
                where m.DATEADM between "' . $strdateadmit . '" and "' . $enddateadmit . '"
                and (m.code_id like "%307%" or m.code_id like "%305%") 
                and m.OPDSEQ not in(SELECT vn from hshooterdb.m_stm where vn = s.vn)
                and mid(dateadm,5,2) = "' . $months . '" 
                and left(DATEADM,4) = "' . $year . '"
                and m.maininscl ="ofc"
                GROUP BY m.opdseq
                order by r1.sss_approval_code 
        ');

        // $datashow = DB::connection('mysql3')->select('
        //     select e.hn,e.vn,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid
        //         ,e.uc_money,e.paid_money,r.rcpno,format(e.income,2) as incomehos,
        //         format(rr.amount,2) as rramount,
        //         group_concat(distinct hh.transaction_amount) as transaction_amount,
        //         oo.cc,
        //         group_concat(distinct rr.sss_approval_code,":",rr.amount,"/") as sss_approval_code,
        //         group_concat(distinct hh.appr_code,":",hh.transaction_amount,"/") as appr_code,
        //         e.age_y
        //         from hos.vn_stat e
        //         left outer join hos.ipt o on o.vn = e.vn
        //         left outer join hos.patient p on p.hn = e.hn
        //         left outer join hos.rcpt_print r on r.vn =e.vn
        //         left outer join hos.visit_pttype vp on vp.vn = e.vn
        //         left outer join hos.opdscreen oo on oo.vn =e.vn
        //         left outer join hos.rcpt_debt rr on rr.vn = e.vn
        //         left outer join hos.hpc11_ktb_approval hh on hh.pid=p.cid and hh.transaction_date = e.vstdate
        //         where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
        //         and e.pttype in("of")
        //         and o.an is null
        //         and month(e.vstdate) = "'.$months.'"
        //         group by e.vn 
        //         order by e.vstdate


        // '); 
        return view('account.account_info_vn_subofc_vn', [
            'datashow'   =>  $datashow,
            'strdateadmit'  =>  $strdateadmit,
            'enddateadmit'    =>  $enddateadmit,
        ]);
    }
    public function account_info_vn_subofc_vndetail(Request $request, $vn)
    {
        $datashow = DB::connection('mysql3')->select('
            select i.income,ifnull(n.name,i.name) as iname,sum(o.qty) as qty,
                (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("02")) as paidst,
                (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("01","03")) as nopaidst
                from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                left outer join income i on i.income = o.income
                left outer join ovst ov on ov.vn = o.vn
                left join eclaimdb.m_registerdata m on m.hn = o.hn 
                and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = o.vstdate
                and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5) and m.status in("0","1","4","5")
                left outer join eclaimdb.m_sumfund mm on mm.eclaim_no = m.eclaim_no
                left join hshooterdb.m_stm s on s.vn = o.vn
                where o.vn ="' . $vn . '" 
                group by i.name
                order by i.income
               
            ');
        $datashow2 = DB::connection('mysql3')->select('
                select ifnull(n.icode,d.icode) as icode,n.nhso_adp_code,ifnull(n.name,d.name) as dname,sum(o.qty) as qty,format(sum(sum_price),2) as sum_price 
                from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                left outer join drugitems d on d.icode = o.icode
                left outer join income i on i.income = o.income
                where o.vn ="' . $vn . '"
                group by o.icode
                order by o.icode
            ');
        $datashow3 = DB::connection('mysql3')->select('
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev01,","," ")) as sev,sum(REPLACE(mm1.sev01,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV01" 
                    where m.opdseq ="' . $vn . '" 
                    UNION all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev02,","," ")) as sev,sum(REPLACE(mm1.sev02,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV02"
                    where m.opdseq ="' . $vn . '"
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev03,","," ")) as sev,sum(REPLACE(mm1.sev03,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV03"
                    where m.opdseq ="' . $vn . '"
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev04,","," ")) as sev,sum(REPLACE(mm1.sev04,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV04"
                    where m.opdseq ="' . $vn . '"

                    UNION all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev05,","," ")) as sev,sum(REPLACE(mm1.sev05,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV05"
                    where m.opdseq ="' . $vn . '" 
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev06,","," ")) as sev,sum(REPLACE(mm1.sev06,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV06"
                    where m.opdseq ="' . $vn . '"
                    UNION all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev07,","," ")) as sev,sum(REPLACE(mm1.sev07,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV07"
                    where m.opdseq ="' . $vn . '" 
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev08,","," ")) as sev,sum(REPLACE(mm1.sev08,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV08"
                    where m.opdseq ="' . $vn . '"
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev09,","," ")) as sev,sum(REPLACE(mm1.sev09,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV09"
                    where m.opdseq ="' . $vn . '" 
                    UNION all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev10,","," ")) as sev,sum(REPLACE(mm1.sev10,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV10"
                    where m.opdseq ="' . $vn . '" 
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev11,","," ")) as sev,sum(REPLACE(mm1.sev11,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV11"
                    where m.opdseq ="' . $vn . '"  
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev12,","," ")) as sev,sum(REPLACE(mm1.sev12,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV12"
                    where m.opdseq ="' . $vn . '"  
                    UNION all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev13,","," ")) as sev,sum(REPLACE(mm1.sev13,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV13"
                    where m.opdseq ="' . $vn . '"  
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev14,","," ")) as sev,sum(REPLACE(mm1.sev14,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV14"
                    where m.opdseq ="' . $vn . '"
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev15,","," ")) as sev,sum(REPLACE(mm1.sev15,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV15"
                    where m.opdseq ="' . $vn . '" 
                    UNION all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev16,","," ")) as sev,sum(REPLACE(mm1.sev16,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV16"
                    where m.opdseq ="' . $vn . '" 
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev17,","," ")) as sev,sum(REPLACE(mm1.sev17,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV17"
                    where m.opdseq ="' . $vn . '"  
                    union all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev18,","," ")) as sev,sum(REPLACE(mm1.sev18,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV18"
                    where m.opdseq ="' . $vn . '" 
                    UNION all
                    select l.SERVICE_ITEM,sum(REPLACE(mm.sev19,","," ")) as sev,sum(REPLACE(mm1.sev19,","," ")) as REsev from eclaimdb.m_registerdata m
                    LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                    LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                    LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV19"
                    where m.opdseq ="' . $vn . '" 
            ');
        $datashow4 = DB::connection('mysql3')->select('
                select m.claimcode from eclaimdb.m_registerdata m
                    where m.opdseq ="' . $vn . '"
               
            ');
        return view('account.account_info_vn_subofc_vndetail', [
            'datashow'   =>  $datashow,
            'datashow2'   =>  $datashow2,
            'datashow3'   =>  $datashow3,
            'datashow4'   =>  $datashow4,
        ]);
    }

    public function account_info_vn_subofc(Request $request, $months, $startdate, $enddate)
    {
        $datashow = DB::connection('mysql3')->select('
            select e.hn,e.vn,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid
                ,e.uc_money,e.paid_money,r.rcpno,format(e.income,2) as incomehos,
                format(rr.amount,2) as rramount,
                group_concat(distinct hh.transaction_amount) as transaction_amount,
                oo.cc,
                group_concat(distinct rr.sss_approval_code,":",rr.amount,"/") as sss_approval_code,
                group_concat(distinct hh.appr_code,":",hh.transaction_amount,"/") as appr_code,
                e.age_y
                from hos.vn_stat e
                left outer join hos.ipt o on o.vn = e.vn
                left outer join hos.patient p on p.hn = e.hn
                left outer join hos.rcpt_print r on r.vn =e.vn
                left outer join hos.visit_pttype vp on vp.vn = e.vn
                left outer join hos.opdscreen oo on oo.vn =e.vn
                left outer join hos.rcpt_debt rr on rr.vn = e.vn
                left outer join hos.hpc11_ktb_approval hh on hh.pid=p.cid and hh.transaction_date = e.vstdate
                where e.vstdate between "' . $startdate . '" and "' . $enddate . '"
                and e.pttype in("of")
                and o.an is null
                and month(e.vstdate) = "' . $months . '"
                group by e.vn 
                order by e.vstdate
 
 
        ');
        return view('account.account_info_vn_subofc', [
            'datashow'   =>  $datashow,
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,
        ]);
    }
    public function account_info_vn_subofcdetail(Request $request, $vn)
    {
        $datashow = DB::connection('mysql3')->select('
                        select o.vn,i.income,i.name as iname,sum(o.qty) as qty,
                        (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("02")) as paidst,
                        (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("01","03")) as nopaidst
                        from opitemrece o
                        left outer join nondrugitems n on n.icode = o.icode
                        left outer join income i on i.income = o.income
                        where o.vn ="' . $vn . '" 
                        group by i.name
                        order by i.income    
            ');
        $datashow2 = DB::connection('mysql3')->select('
                        select o.icode,n.billcode,ifnull(n.name,nn.name) as nnname,concat(i.income,"/",i.name) as iname
                        ,o.qty,round(n.price,2) as rprice,round(o.sum_price,2) as sum_price,o.rxdate,o.rxtime,o.last_modified from opitemrece o
                            left outer join nondrugitems n on n.icode = o.icode
                            left outer join drugitems nn on nn.icode = o.icode
                            left join income i on i.income = o.income
                            where  o.vn ="' . $vn . '" order by o.income,o.icode
                        
            ');
        $datashow3 = DB::connection('mysql3')->select('
                        select d.outdate,o.name as staff_name,d.intime,k1.department as from_department,d.outtime,k2.department as to_department
                        from ptdepart d  
                        left outer join kskdepartment k1 on k1.depcode = d.depcode 
                        left outer join kskdepartment k2 on k2.depcode = d.outdepcode  
                        left outer join opduser o on o.loginname = d.staff 
                        where d.vn = "' . $vn . '" order by d.intime 
            ');
        return view('account.account_info_vn_subofcdetail', [
            'datashow'   =>  $datashow,
            'datashow2'   =>  $datashow2,
            'datashow3'   =>  $datashow3,
        ]);
    }
    public function account_info_vn_subofcdetail_sub(Request $request, $vn, $income)
    {
        $datashow = DB::connection('mysql3')->select('
            select ifnull(n.icode,d.icode) as icode
                ,n.nhso_adp_code
                ,ifnull(n.name,d.name) as dname
                ,sum(o.qty) as qty
                ,format(sum(sum_price),2) as sum_price
                ,ifnull(ifnull(ifnull(ifnull(mm.cost*sum(o.qty),m4.cost*sum(o.qty)),m5.cost*sum(o.qty))
                ,m1.cost*sum(o.qty)),m2.cost*sum(o.qty))  as eclaim
                from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                left outer join drugitems d on d.icode = o.icode
                left outer join income i on i.income = o.income
                left join ovst ov on ov.vn = o.vn

                left join eclaimdb.l_sev7 mm on mm.code = n.nhso_adp_code and mm.maininscl ="ofc" and mm.gyear ="2021"
                left join eclaimdb.l_sev13 m1 on m1.code = n.nhso_adp_code and m1.maininscl ="ofc" and m1.gyear ="2021"
                left join eclaimdb.l_sev15 m2 on m2.code = n.nhso_adp_code and m2.maininscl ="ofc" and m2.gyear ="2021"
                left join eclaimdb.l_sev6 m3 on m3.code = n.nhso_adp_code and m3.maininscl ="ofc" and m3.gyear ="2021"
                left join eclaimdb.l_sev8 m4 on m4.code = n.nhso_adp_code and m4.maininscl ="ofc" and m4.gyear ="2021"
                left join eclaimdb.l_serviceother m5 on m5.code = n.nhso_adp_code and m5.maininscl ="ofc" and m5.gyear ="2021"
                where o.vn ="' . $vn . '" 
                and o.income= "' . $income . '"
                group by o.icode
                order by o.icode
 
        ');
        return view('account.account_info_vn_subofcdetail_sub', [
            'datashow'   =>  $datashow,
        ]);
    }
    public function account_info_vnstmx(Request $request, $cid, $startdate, $enddate)
    {
        $datashow = DB::connection('mysql3')->select('
            select k.personal_id,k.transaction_date1,k.amount,approval_code from hos.hpc11_ktb_approval_transaction k
                where k.personal_id ="' . $cid . '" 
                group by k.personal_id,k.transaction_date1
                order by k.transaction_date1             
        ');
        $datashow2 = DB::connection('mysql3')->select('
                    select v.vn,v.cid,v.vstdate,k.transaction_date,k.amount,k.approval_code from hos.vn_stat v
                    left join ktb_edc_transaction k on k.vn = v.vn
                    where v.vstdate between "' . $startdate . '" and "' . $enddate . '"
                    and v.cid ="' . $cid . '" 
                    group by k.vn
                    order by k.transaction_date 
        ');
        $datashow3 = DB::connection('mysql3')->select('
                select v.vn,v.cid,v.vstdate,hh.transaction_date,hh.transaction_amount,hh.appr_code,hh.reason_keyin,hh.appr_code_old_payment from hos.vn_stat v
                    left join hpc11_ktb_approval hh on hh.pid = v.cid and hh.transaction_date = v.vstdate
                    where v.vstdate between "' . $startdate . '" and "' . $enddate . '"
                    and v.cid ="' . $cid . '"
                    order by hh.transaction_date         
        ');
        return view('account.account_info_vnstmx', [
            'datashow'   =>  $datashow,
            'datashow2'   =>  $datashow2,
            'datashow3'   =>  $datashow3,
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,
        ]);
    }

    public function account_info_noapproveofc(Request $request, $months, $startdate, $enddate)
    {
        $datashow = DB::connection('mysql3')->select('
            select e.vn,e.hn,p.cid,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname
                ,e.uc_money,e.paid_money,r.rcpno,format(e.income,2) as hincome,
                format(rr.amount,2) as rramont,
                group_concat(distinct k.amount) as edc,
                oo.cc,
                group_concat(distinct rr.sss_approval_code,":",rr.amount,"/") as apphoscode,
                group_concat(distinct k.approval_code,":",k.amount,"/") as appktb,
                e.age_y,
                (select if(group_concat(status) like "%4%","ออก stm","check") from eclaimdb.m_registerdata where hn=m.hn and dateadm=m.dateadm) as scheck
                from hos.vn_stat e
                left outer join hos.ovst o on o.vn = e.vn
                left outer join hos.patient p on p.hn = e.hn
                left outer join hos.rcpt_print r on r.vn =e.vn
                left outer join hos.opdscreen oo on oo.vn =e.vn
                left outer join hos.rcpt_debt rr on rr.vn = e.vn
                left outer join hos.ktb_edc_transaction k on k.vn = e.vn
                left outer join eclaimdb.m_registerdata m on m.opdseq = e.vn
                where e.vstdate between "' . $startdate . '" and "' . $enddate . '"
                and e.pttype in("of")
                and o.an is null
                and e.uc_money > 1
                and (rr.sss_approval_code is null or rr.sss_approval_code ="")
                and month(e.vstdate) = "' . $months . '"
                group by e.vn,e.vstdate 
                order by e.vstdate  
        ');
        return view('account.account_info_noapproveofc', [
            'datashow'   =>  $datashow,
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,
        ]);
    }
    public function account_info_noapproveofc_vn(Request $request, $vn, $startdate, $enddate)
    {
        $datashow = DB::connection('mysql3')->select('
            select i.income,i.name as iname,sum(o.qty) as qty,
                (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("02")) as paidst,
                (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("01","03")) as nopaidst
                from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                left outer join income i on i.income = o.income
                where o.vn ="' . $vn . '" 
                group by i.name
                order by i.income    
        ');
        $datashow2 = DB::connection('mysql3')->select('
                select o.icode,n.billcode,ifnull(n.name,nn.name) as nnname
                ,concat(i.income,"/",i.name) as iname,o.qty,round(n.price,2) as price
                ,round(o.sum_price,2) as sumprice,o.rxdate,o.rxtime,o.last_modified 
                from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                left outer join drugitems nn on nn.icode = o.icode
                left join income i on i.income = o.income
                where  o.vn ="' . $vn . '" order by o.income,o.icode 
        ');
        $datashow3 = DB::connection('mysql3')->select('
                select d.outdate,o.name as staff_name,d.intime,k1.department as from_department,d.outtime,k2.department as to_department
                from ptdepart d  
                left outer join kskdepartment k1 on k1.depcode = d.depcode 
                left outer join kskdepartment k2 on k2.depcode = d.outdepcode  
                left outer join opduser o on o.loginname = d.staff 
                where d.vn = "' . $vn . '"  order by d.intime 
        ');
        return view('account.account_info_noapproveofc_vn', [
            'datashow'   =>  $datashow,
            'datashow2'   =>  $datashow2,
            'datashow3'   =>  $datashow3,
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,
        ]);
    }

    public function account_money_rep(Request $request,$id)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $main_type = $request->account_main_type;
        // $hoscode = $request->store_id;
        $date = date('Y-m-d');
        $strM = date('m', strtotime($startdate));
        $strY = date('Y', strtotime($startdate)) + 543;

        $endM = date('m', strtotime($enddate));
        $endY = date('Y', strtotime($enddate)) + 543;
       
        if ($main_type != '' ) {
            $datashow = DB::connection('mysql')->select('
                select a.account_main_id,a.account_main_date,a.account_main_time,a.account_main_year,a.account_main_type
                ,a.cid,a.acc,a.salary,a.backpay,a.positionpay,a.a0811 as a0811,a.cost_of_living,a.a24percent as a24percent,a.ot,a.revenue_sum
                ,a.tax,a.fund,a.fundbackpay,a.add,a.installment,a.flat,a.share,a.loan,a.food,a.water,a.electric
                ,a.coop,a.F24,a.F25,a.F26,a.F27,a.F28,a.F29,a.other,a.expend_sum,a.balance,a.account_main_active
                ,u.fname,u.lname,u.cid,up.prefix_name,ug.users_group_name,a.store_id,a.account_main_mounts
                from account_main a
                left outer join users u on u.cid = a.cid 
                left outer join users_prefix up on up.prefix_code = u.pname 
                left outer join users_group ug on ug.users_group_id = a.account_main_type  
                where a.account_main_year between "' . $strY . '" AND "' . $endY . '" 
                AND a.account_main_mounts between "' . $strM . '" AND "' . $endM . '" 
                AND a.account_main_type ="'.$main_type.'" AND  a.store_id = "'.$id.'"           
            ');
        } else {
            $datashow = DB::connection('mysql')->select('
                select a.account_main_id,a.account_main_date,a.account_main_time,a.account_main_year,a.account_main_type
                ,a.cid,a.acc,a.salary,a.backpay,a.positionpay,a.a0811 as a0811,a.cost_of_living,a.a24percent as a24percent,a.ot,a.revenue_sum
                ,a.tax,a.fund,a.fundbackpay,a.add,a.installment,a.flat,a.share,a.loan,a.food,a.water,a.electric
                ,a.coop,a.F24,a.F25,a.F26,a.F27,a.F28,a.F29,a.other,a.expend_sum,a.balance,a.account_main_active
                ,u.fname,u.lname,u.cid,up.prefix_name,ug.users_group_name,a.account_main_mounts
                from account_main a
                left outer join users u on u.cid = a.cid 
                left outer join users_prefix up on up.prefix_code = u.pname 
                left outer join users_group ug on ug.users_group_id = a.account_main_type  
                where a.account_main_year between "' . $strY . '" AND "' . $endY . '" 
                AND a.account_main_mounts between "' . $strM . '" AND "' . $endM . '" 
                AND  a.store_id = "'.$id.'"    
            ');
            $main_type ='';
        }              
       
        $data_account_main = DB::table('account_main')->whereBetween('account_main_date', [$startdate, $enddate])->count();
        $data['users'] = User::where('store_id','=',$id)->get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_groups'] = DB::table('users_group')->get();
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['users_hos'] = DB::table('users_hos')->get();
        // dd($main_type);
        return view('account.account_money_rep', $data, [
            'datashow'   =>  $datashow,
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,
            'data_account_main' => $data_account_main,
            'strM'       => $strM,
            'strY'       => $strY,
            'main_type'  => $main_type,
            'id'    => $id
        ]);
    }

    public function account_money_hosrep(Request $request)
    {
        $data['users_hos'] = DB::table('users_hos')->get();
        return view('account.account_money_hosrep', $data );
    }
    public function account_money_personsave(Request $request)
    {
        $years_idold = $request->leave_year_id;
        $years_id = $years_idold;

        $months_id = $request->MONTH_ID;
        $user_group = $request->account_main_type;
        $store_id = $request->store_id;

        $time = date("H:i:s");
        $date = date('Y-m-d');
        $yearcount = Account_main::where('account_main_year','=',$years_id)->count();
        $monthsid = Account_main::where('account_main_mounts','=',$months_id)->count();
        $usergroup = Account_main::where('account_main_type','=',$user_group)->count();
        $storeid = Account_main::where('store_id','=',$store_id)->count();

        // if ($yearcount == 0 && $monthsid == 0 && $usergroup == 0) {
        //     $users = User::where('users_group_id','=',$user_group)->where('store_id','=',$store_id)->get();
        //     // $users = User::where('users_group_id','=',$user_group)->get();
        //     foreach ($users as $item) {  
        //         $add = new Account_main();
        //         // $add->account_main_date = $years_id.'-'.$months_id.'-'.'1';
        //           $add->account_main_date = $years_id.'-'.$months_id.'-'.'1';
        //         // $add->account_main_date = $date;
        //         $add->cid = $item->cid;
        //         $add->account_main_year = $years_id;
        //         $add->account_main_time = $time;
        //         $add->account_main_mounts = $months_id;
        //         $add->account_main_type = $user_group;
        //         $add->person_name = $item->fname.' '.$item->lname;
        //         $add->store_id = $store_id;
        //         $add->save();                  
        //     }   
        //     return response()->json([
        //         'status'     => '200'
        //     ]);
        // }else if($yearcount = 0 && $monthsid != 0 && $usergroup && $storeid != 0 ) {
        //     return response()->json([
        //         'status'     => '110'
        //     ]);
        // } else {
        //          return response()->json([
        //         'status'     => '100'
        //     ]);
        // }
        if ($yearcount > 0 && $monthsid > 0 && $usergroup && $storeid > 0) {
            return response()->json([
                'status'     => '100'
            ]);       
        } else {
            $users = User::where('users_group_id','=',$user_group)->where('store_id','=',$store_id)->get();
            foreach ($users as $item) {  
                $add = new Account_main();
                // $add->account_main_date = $years_id.'-'.$months_id.'-'.'1';
                //   $add->account_main_date = $years_id.'-'.$months_id.'-'.'1'; 
                $add->account_main_date = $date;
                $add->cid = $item->cid;
                $add->account_main_year = $years_id;
                $add->account_main_time = $time;
                $add->account_main_mounts = $months_id;
                $add->account_main_type = $user_group;
                $add->person_name = $item->fname.' '.$item->lname;
                $add->store_id = $store_id;
                $add->save();                  
            }   
            return response()->json([
                'status'     => '200'
            ]);
        }
        
      
    }

    public function account_money_copysave(Request $request)
    {
        $leave_yearid22 = $request->leave_year_id22;
        $MONTH_ID22 = $request->MONTH_ID22;
        $account_maintype22 = $request->account_main_type22;

        $leave_yearid3 = $request->leave_year_id3;
        $MONTH_ID3 = $request->MONTH_ID3;
        // $account_maintype3 = $request->account_main_type3;

        $time = date("H:i:s");
        $date = date('Y-m-d');

        //Check มีข้อมูลไหม
        $checkperson = Account_main::where('account_main_year','=',$leave_yearid22)
        ->where('account_main_mounts','=',$MONTH_ID22)
        ->where('account_main_type','=',$account_maintype22)
        ->count();

        //Check ซ้ำ เดือนใหม่
        $yearcount = Account_main::where('account_main_year','=',$leave_yearid22)->count();
        $monthsid = Account_main::where('account_main_mounts','=',$MONTH_ID3)->count();
        $usergroup = Account_main::where('account_main_type','=',$leave_yearid3)->count();

        if ($checkperson == 0) {
            return response()->json([
                'status'     => '50'
            ]);
        } else {    
            if ($yearcount > 0 && $monthsid > 0 && $usergroup) {
                return response()->json([
                    'status'     => '100'
                ]);
            } else {
                $users_old = Account_main::where('account_main_year','=',$leave_yearid22)->where('account_main_mounts','=',$MONTH_ID22)
                ->where('account_main_type','=',$account_maintype22)->get();
                foreach ($users_old as $item) {  
                    $add = new Account_main();
                    // $add->account_main_date = $years_id.'-'.$months_id.'-'.'1';
                    $add->account_main_date = $date;
                    $add->cid = $item->cid;
                    $add->account_main_year = $leave_yearid3;
                    $add->account_main_time = $time;
                    $add->account_main_mounts = $MONTH_ID3;
                    $add->account_main_type = $account_maintype22;
                    $add->person_name = $item->fname.' '.$item->lname;
                    $add->cid = $item->cid;
                    $add->person_name = $item->person_name;
                    $add->acc = $item->acc;
                    $add->salary = $item->salary;
                    $add->backpay = $item->backpay;
                    $add->positionpay = $item->positionpay;
                    $add->a0811 = $item->a0811;
                    $add->cost_of_living = $item->cost_of_living;
                    $add->a24percent = $item->a24percent;
                    $add->ot = $item->ot;
                    $add->revenue_sum = $item->revenue_sum;
                    $add->tax = $item->tax;
                    $add->fund = $item->fund;
                    $add->fundbackpay = $item->fundbackpay;
                    $add->add = $item->add;
                    $add->installment = $item->installment;
                    $add->flat = $item->flat;
                    $add->share = $item->share;
                    $add->loan = $item->loan;
                    $add->food = $item->food;
                    $add->water = $item->water;
                    $add->electric = $item->electric;
                    $add->coop = $item->coop;
                    $add->F24 = $item->F24;
                    $add->F25 = $item->F25;
                    $add->F26 = $item->F26;
                    $add->F27 = $item->F27;
                    $add->F28 = $item->F28;
                    $add->F29 = $item->F29;
                    $add->other = $item->other;
                    $add->expend_sum = $item->expend_sum;
                    $add->balance = $item->balance;
                    $add->account_main_active = $item->account_main_active;
                    $add->save();                  
                }   
                return response()->json([
                    'status'     => '200'
                ]);
            }        
        }  
  
    }
    public function account_money_personedit(Request $request,$id)
    {
        $account = Account_main::find($id);

        return response()->json([
            'status'     => '200',
            'account'      =>  $account,
        ]);
    }
    public function account_money_personupdate(Request $request)
    {
        $id = $request->account_main_id;
        $acc = $request->acc;
        $salary = $request->salary;
        $backpay = $request->backpay;
        $positionpay = $request->positionpay;
        $a0811 = $request->a0811;
        $cost_of_living = $request->cost_of_living;
        $a24percent = $request->a24percent;
        $ot = $request->ot;
        Account_main::where('account_main_id', $id) 
            ->update([
                'acc'              => $acc,
                'salary'           => $salary,
                'backpay'          => $backpay,
                'positionpay'      => $positionpay,
                'a0811'            => $a0811,
                'cost_of_living'   => $cost_of_living,
                'a24percent'       => $a24percent,
                'ot'               => $ot,
                'revenue_sum'      => $salary + $backpay + $positionpay + $a0811 + $cost_of_living + $a24percent + $ot
            ]);
        return response()->json([
            'status'     => '200'
        ]);
    }
      

    public function account_money_hospay(Request $request)
    {
        $data['users_hos'] = DB::table('users_hos')->get();
        return view('account.account_money_hospay', $data );
    }
    
}
  // if ($request->ajax()) {
        //     Account_main::find($request->pk)
        //         ->update([
        //             $request->acc => $request->value
        //         ]);  
        //         return response()->json([
        //             'status'     => '200'
        //         ]);
        // }