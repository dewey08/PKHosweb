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

class AccController extends Controller
{
    public function acc_test(Request $request)
    {
      $data =  DB::connection('mysql')->select('              
          SELECT a.vn,p.pang_stamp_vn,a.hn,p.pang_stamp_hn,vstdate,pang_stamp_vstdate,dchdate,pang_stamp_dchdate,a.debit_total,p.pang_stamp_uc_money 
          FROM acc_1102050101_217 a 
          LEFT JOIN pang_stamp p ON p.pang_stamp_hn = a.hn
          WHERE a.dchdate BETWEEN "2023-04-01" AND "2023-04-30"
          GROUP BY a.hn;
        '); 
      return view('account_pk.acc_test', [  
        'data'          =>  $data
    ]);
    }
     
    // public function karn_main(Request $request)
    // {
    //   $startdate = $request->startdate;
    //   $enddate = $request->enddate;

    //     $year_id = $request->year_id;
    //     $date = date('Y-m-d');
    //     $newweek = date('Y-m-d H:m:s', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    //     $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน  
    //     // $newDate2 = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน         
    //     // $newDate = date('Y-m-d H:m:s', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน  

    //     $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
    //     // $data = DB::select('select patien_code,patien_hn,patien_pid,patien_fname,patien_lname from karn_pt');
    //     $data = DB::select('select ci_code,ci_hn,ci_pid,ci_fullname from karn_ci where created_at between "'.$newDate.'" and "'.$date.'"');
        
    //     $data['data_repipdpay'] =  DB::connection('mysql3')->select('              

    //             select month(v.dchdate) as months,count(distinct v.hn) as hn,count(distinct v.an) as an
    //             ,sum(vp.nhso_ownright_pid >"0") as nhso_ownright_pidover
    //             ,count(distinct v.an)-sum(vp.claim_code ="1") as claim_code
    //             ,sum(v.income) as income
    //             ,sum(vp.nhso_ownright_pid) as nhso_ownright_pid
    //             ,sum(vp.nhso_ownright_name) as nhso_ownright_name
    //             ,100*sum(vp.claim_code ="1")/count(distinct v.an) as claim_codeafter
    //             from an_stat v
    //             left outer join pttype p on p.pttype = v.pttype 
    //             left outer join ipt_pttype vp on vp.an = v.an
    //             where v.dchdate between "'.$newDate.'" and "'.$newDate.'"
    //             and vp.pttype in("33","09","36","31","37","38")
               
 
    //     '); 
    //     // group by month(v.dchdate)
    //     // dd($date);
    //     return view('karn.karn_main', [ 
    //         'year'          =>  $year, 
    //         'year_ids'      =>  $year_id,
    //         'data'          =>  $data
    //     ]);
    // }
   
    
}
