<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Exports\RefercrossExport;
use PDF;
use Excel;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use App\Models\Refer_cross;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class ReportIncomeController extends Controller
{
    
    public function check_bumbat(Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $data = DB::connection('mysql3')->select('
                SELECT a.dchdate,a.vn,pt.cid ,a.hn,a.an,a.rw
                ,n.income as groupincome,ic.name as incomename
                
                ,concat(pt.pname,pt.fname," ",pt.lname) ptname
                ,a.pdx,idx.icd9 as ICD9,d.name as DOCTOR,o.icode,n.name as inname
                ,idx.opdate,idx.optime,p.pttype,p.name ,a.inc08,a.income,a.uc_money,a.item_money,o.unitprice,o.sum_price
                FROM an_stat a
                LEFT JOIN opitemrece o on o.an=a.an
                LEFT JOIN iptoprt idx ON idx.an = a.an
                LEFT JOIN icd9cm1 on icd9cm1.code=idx.icd9
                LEFT JOIN patient pt on pt.hn = a.hn
                LEFT JOIN pttype p on p.pttype = a.pttype  
                LEFT JOIN doctor d on d.code = a.dx_doctor 
                LEFT JOIN nondrugitems n on n.icode = o.icode
                LEFT JOIN income ic on ic.income = n.income
                WHERE o.icode = "3010581"
                AND a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"

                group by a.an 
        ');
        
       
        return view('reportincome.check_bumbat', [
            'data'             =>  $data, 
            'startdate'        =>     $startdate,
            'enddate'          =>     $enddate, 
        ]);
    }
    public function check_lapo(Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $data = DB::connection('mysql3')->select('
                SELECT a.dchdate,a.vn,pt.cid ,a.hn,a.an,a.rw
                ,n.income as groupincome,ic.name as incomename
                ,o.rxdate
                ,concat(pt.pname,pt.fname," ",pt.lname) ptname
                ,a.pdx,idx.icd9 as ICD9,d.name as DOCTOR,o.icode,n.name as inname
                ,idx.opdate,idx.optime,p.pttype,p.name ,a.inc08,a.income,a.uc_money,a.item_money,o.unitprice,o.sum_price
                FROM an_stat a
                LEFT JOIN opitemrece o on o.an=a.an
                LEFT JOIN iptoprt idx ON idx.an = a.an
                LEFT JOIN icd9cm1 on icd9cm1.code=idx.icd9
                LEFT JOIN patient pt on pt.hn = a.hn
                LEFT JOIN pttype p on p.pttype = a.pttype  
                LEFT JOIN doctor d on d.code = a.dx_doctor 
                LEFT JOIN nondrugitems n on n.icode = o.icode
                LEFT JOIN income ic on ic.income = n.income
                WHERE idx.icd9 ="4701" 
                AND a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                group by a.an 
        ');
        
       
        return view('reportincome.check_lapo', [
            'data'             =>  $data, 
            'startdate'        =>     $startdate,
            'enddate'          =>     $enddate, 
        ]);
    }
    
}
