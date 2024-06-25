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

class ReportCRRTController extends Controller
{
    public function rep_crrt(Request $request)
    { 
        $startdate       = $request->startdate;
        $enddate         = $request->enddate;
        $nhso_adp_code   = $request->nhso_adp_code;
        
        $date       = date('Y-m-d');
        $y          = date('Y') + 543;
        $newweek    = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate    = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear    = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew    = date('Y')+1;
        $yearold    = date('Y');
        $start      = (''.$yearold.'-10-01');
        $end        = (''.$yearnew.'-09-30'); 
        // dd($nhso_adp_code);

        if ($startdate != '') {
            if ($nhso_adp_code != '') {
                $datashow = DB::connection('mysql2')->select('
                    SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname 
                        ,a.dchdate,a.pttype,n.icode,n.name as nonname,n.unitcost 
                        ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                        ,a.income-a.rcpt_money-a.discount_money as debit 
                        from opitemrece op  
                        LEFT OUTER JOIN ipt ip ON ip.an = op.an
                        LEFT OUTER JOIN an_stat a ON a.an = op.an
                        LEFT OUTER JOIN nondrugitems n ON n.icode = op.icode
                        LEFT OUTER JOIN patient pt on pt.hn=a.hn 
                        WHERE a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                        AND n.nhso_adp_code = "'.$nhso_adp_code.'"
                '); 
            } else {
                $datashow = DB::connection('mysql2')->select('
                    SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname 
                        ,a.dchdate,a.pttype,n.icode,n.name as nonname,n.unitcost 
                        ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                        ,a.income-a.rcpt_money-a.discount_money as debit 
                        from opitemrece op  
                        LEFT OUTER JOIN ipt ip ON ip.an = op.an
                        LEFT OUTER JOIN an_stat a ON a.an = op.an
                        LEFT OUTER JOIN nondrugitems n ON n.icode = op.icode
                        LEFT OUTER JOIN patient pt on pt.hn=a.hn 
                        WHERE a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                        AND nhso_adp_code IN("CRRT1","CRRT2","71642","71643")
                '); 
            } 
        } else {
                $datashow = DB::connection('mysql2')->select('
                    SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname 
                        ,a.dchdate,a.pttype,n.icode,n.name as nonname,n.unitcost 
                        ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                        ,a.income-a.rcpt_money-a.discount_money as debit 
                        from opitemrece op  
                        LEFT OUTER JOIN ipt ip ON ip.an = op.an
                        LEFT OUTER JOIN an_stat a ON a.an = op.an
                        LEFT OUTER JOIN nondrugitems n ON n.icode = op.icode
                        LEFT OUTER JOIN patient pt on pt.hn=a.hn 
                        WHERE a.dchdate BETWEEN "'.$start.'" and "'.$end.'" 
                        AND nhso_adp_code IN("CRRT1","CRRT2","71642","71643")
                '); 
        }
        $data['days'] = DB::connection('mysql')->select('select * from d_crrt');

        return view('report_ct.rep_crrt',$data,[
            'startdate'      =>  $startdate,
            'enddate'        =>  $enddate,
            'datashow'       =>   $datashow, 
            'nhso_adp_code'  =>   $nhso_adp_code, 
        ]);
    }
}
