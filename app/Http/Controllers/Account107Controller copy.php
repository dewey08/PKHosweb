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
use App\Models\Acc_doc;
use App\Models\Product_brand;
use App\Models\Product_color;  
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Patient;
use App\Models\Acc_1102050102_107;
use App\Models\Acc_1102050102_106;
use App\Models\Acc_debtor;
use App\Models\Acc_107_debt_print;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use SoapClient;

class Account107Controller extends Controller
{
     // ************ OPD 107******************
    public function acc_107_dashboard(Request $request)
    { 
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            $data['datashow'] = DB::connection('mysql')->select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.an) as an
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newDate.'" and "'.$date.'"
                    and account_code="1102050102.107"
                    and income <> 0
                    group by month(a.dchdate) 
                    order by a.dchdate desc limit 6; 
              
            '); 
            // SELECT month(a.dchdate) as months,year(a.dchdate) as year ,l.MONTH_NAME
            // ,COUNT(DISTINCT r.vn) countvn,SUM(r.amount) sumamount
            //     from hos.rcpt_arrear r  
            //     LEFT OUTER JOIN hos.an_stat a ON r.vn = a.an  
            //     LEFT OUTER JOIN hos.patient p ON p.hn = a.hn   
            //     LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
            //     WHERE a.dchdate BETWEEN "'.$newDate.'" and "'.$date.'"
            //     AND r.paid ="N" AND r.pt_type="IPD"
            //     GROUP BY month(a.dchdate)
            //     ORDER BY a.dchdate desc limit 6; 
        } else {
            $data['datashow'] = DB::connection('mysql')->select('
            SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.an) as an
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050102.107"
                    and income <> 0
                   
                   
            '); 
        }
        // group by month(a.dchdate) 
        // order by a.dchdate desc limit 6; 

        // SELECT month(a.dchdate) as months,year(a.dchdate) as year ,l.MONTH_NAME
        // ,COUNT(DISTINCT r.vn) countvn,SUM(r.amount) sumamount
        //     from hos.rcpt_arrear r  
        //     LEFT OUTER JOIN hos.an_stat a ON r.vn = a.an  
        //     LEFT OUTER JOIN hos.patient p ON p.hn = a.hn   
        //     LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
        //     WHERE a.dchdate BETWEEN "'.$data['startdate'].'" and "'.$data['enddate'].'" 
        //     AND r.paid ="N" AND r.pt_type="IPD"
        //     ORDER BY a.dchdate desc limit 6;  
        
        return view('account_107.acc_107_dashboard', $data ,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
        ]);
    }
    public function acc_107_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        // dd($year);
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left join checksit_hos c on c.an = a.an  
                WHERE a.account_code="1102050102.107"
                AND a.stamp = "N"
                group by a.an
                order by a.dchdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_107.acc_107_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function acc_107_pulldata(Request $request)
    { 
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2; 
        $acc_debtor = DB::connection('mysql2')->select(' 
                SELECT a.vn,a.an,r.hn,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname
                ,a.pttype,a.dchdate,r.arrear_date,r.arrear_time,rp.book_number,rp.bill_number,r.amount,r.paid 
                ,"" as acc_code,"1102050102.107" as account_code,"ชำระเงิน" as account_name
                ,r.rcpno,r.finance_number,r.receive_money_date,r.receive_money_staff
                ,a.income,a.paid_money,a.discount_money,a.rcpt_money,a.remain_money

                FROM rcpt_arrear r  
                LEFT OUTER JOIN rcpt_print rp on r.vn = rp.vn 
                LEFT OUTER JOIN ovst o on o.vn= r.vn  
                LEFT OUTER JOIN an_stat a ON r.vn = a.an  
                LEFT OUTER JOIN patient p on p.hn=r.hn  
                LEFT OUTER JOIN pttype t on t.pttype = o.pttype
                LEFT OUTER JOIN pttype_eclaim e on e.code = t.pttype_eclaim_id
                WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND r.paid ="N" AND r.pt_type="IPD"
                GROUP BY a.an
        ');
        // LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(o.vstdate)
        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050102.107')->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check > 0) {
                        // Acc_debtor::where('an', $value->an)->where('account_code','1102050102.107')->update([  
                        //     'income'             => $value->income, 
                        //     'discount_money'     => $value->discount_money, 
                        //     'paid_money'         => $value->paid_money, 
                        //     'rcpt_money'         => $value->rcpt_money,  
                        // ]);
                        // Acc_1102050102_107::where('an', $value->an)->update([
                        //     'income'             => $value->income, 
                        //     'discount_money'     => $value->discount_money, 
                        //     'paid_money'         => $value->paid_money, 
                        //     'rcpt_money'         => $value->rcpt_money,  
                        // ]);
                    }else {
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->ptname,
                                'pttype'             => $value->pttype,
                                'dchdate'            => $value->dchdate,
                                'vstdate'            => $value->arrear_date,
                                'acc_code'           => $value->acc_code,
                                'account_code'       => $value->account_code,
                                'account_name'       => $value->account_name, 

                                'income'             => $value->income, 
                                'discount_money'     => $value->discount_money, 
                                'paid_money'         => $value->paid_money, 
                                'rcpt_money'         => $value->rcpt_money, 
                                
                                'debit'              => $value->amount, 
                                'debit_total'        => $value->amount,
                                'rcpno'              => $value->rcpno, 
                                'acc_debtor_userid'  => Auth::user()->id
                            ]);
                    }
        }
            return response()->json([

                'status'    => '200'
            ]);
    }
    public function acc_107_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);
        foreach ($data as $key => $value) {
                $date = date('Y-m-d H:m:s');
             $check = Acc_1102050102_107::where('an', $value->an)->count(); 
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050102_107::insert([
                            'vn'                => $value->vn,
                            'hn'                => $value->hn,
                            'an'                => $value->an,
                            'cid'               => $value->cid,
                            'ptname'            => $value->ptname,
                            'vstdate'           => $value->vstdate,
                            'regdate'           => $value->regdate,
                            'dchdate'           => $value->dchdate,
                            'pttype'            => $value->pttype,
                            'pttype_nhso'       => $value->pttype_spsch,
                            'acc_code'          => $value->acc_code,
                            'account_code'      => $value->account_code,
                            'income'            => $value->income,
                            'income_group'      => $value->income_group,
                            'uc_money'          => $value->uc_money,
                            'discount_money'    => $value->discount_money,
                            'rcpt_money'        => $value->rcpt_money,
                            'debit'             => $value->debit,
                            'debit_drug'        => $value->debit_drug,
                            'debit_instument'   => $value->debit_instument,
                            'debit_refer'       => $value->debit_refer,
                            'debit_toa'         => $value->debit_toa,
                            'debit_total'       => $value->debit_total,
                            'max_debt_amount'   => $value->max_debt_amount,
                            'acc_debtor_userid' => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function acc_107_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
            from acc_1102050102_107 U1
            WHERE month(U1.dchdate) = "'.$months.'" AND year(U1.dchdate) = "'.$year.'" 
            GROUP BY U1.an
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_107.acc_107_detail', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function acc_107_detail_date(Request $request,$startdate,$enddate)
    { 
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
            from acc_1102050102_107 U1
            WHERE U1.dchdate  BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
            GROUP BY U1.an
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_107.acc_107_detail_date', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function acc_107_file(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // $datashow = DB::connection('mysql')->select('SELECT * FROM acc_stm_repmoney ar LEFT JOIN acc_trimart_liss a ON a.acc_trimart_liss_id = ar.acc_stm_repmoney_tri ORDER BY acc_stm_repmoney_id DESC');
        $datashow = DB::connection('mysql')->select('
          
            SELECT U1.acc_1102050102_107_id,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.account_code,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.file,U2.filename
            from acc_1102050102_107 U1
            LEFT OUTER JOIN acc_doc U2 ON U2.acc_doc_pangid = U1.acc_1102050102_107_id
            GROUP BY U1.vn
        ');
     
        $countc = DB::table('acc_stm_ucs_excel')->count(); 
        $data['trimart'] = DB::table('acc_trimart')->get();

        return view('account_107.acc_107_file',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    public function acc_107_file_updatefile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx,pdf,png,jpeg'
        ]);
        // $the_file = $request->file('file'); 
        $file_name = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
        //    dd($file_name);
 
        $add = new Acc_doc();
        $add->acc_doc_pangid           = $request->input('acc_1102050102_107_id');
        $add->acc_doc_pang             = $request->input('account_code'); 
        $add->file                     = $request->file('file');
        if($request->hasFile('file')){               
            $request->file->storeAs('account_107',$file_name,'public');
            $add->filename             = $file_name;
        }
        $add->save();

        return redirect()->route('acc.acc_107_file');
        // return response()->json([
        //     'status'    => '200' 
        // ]); 
    }
    public function acc107destroy(Request $request,$id)
    {
        
        $file_ = Acc_doc::find($id);  
        $file_name = $file_->filename; 
        $filepath = public_path('storage/account_107/'.$file_name);
        $description = File::delete($filepath);

        $del = Acc_doc::find($id);  
        $del->delete(); 

        return redirect()->route('acc.acc_106_file');
        // return response()->json(['status' => '200']);
    }
    public function acc_107_debt(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $data['users'] = User::get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate =='') {
            $datashow = DB::connection('mysql')->select('        
                    SELECT U1.acc_1102050102_107_id,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.account_code,U1.vstdate,U1.dchdate,U1.pttype,U1.income,U1.paid_money,U1.rcpt_money,U1.debit,U1.debit_total,U2.file,U2.filename
                    ,U1.sumtotal_amount,U1.pttype_nhso
                    FROM acc_1102050102_107 U1
                    LEFT OUTER JOIN acc_doc U2 ON U2.acc_doc_pangid = U1.acc_1102050102_107_id
                    LEFT OUTER JOIN acc_debtor U3 ON U3.an = U1.an
                    WHERE U1.dchdate BETWEEN  "'.$newDate.'" and "'.$date.'"
                    GROUP BY U1.an ORDER BY U1.dchdate DESC
            ');
            // WHERE U1.debit_total > 0
        } else {
            $datashow = DB::connection('mysql')->select('        
                SELECT U1.acc_1102050102_107_id,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.account_code,U1.vstdate,U1.dchdate,U1.pttype,U1.income,U1.paid_money,U1.rcpt_money,U1.debit,U1.debit_total,U2.file,U2.filename
                ,U1.sumtotal_amount,U1.pttype_nhso
                FROM acc_1102050102_107 U1
                LEFT OUTER JOIN acc_doc U2 ON U2.acc_doc_pangid = U1.acc_1102050102_107_id
                LEFT OUTER JOIN acc_debtor U3 ON U3.an = U1.an
                WHERE U1.dchdate BETWEEN  "'.$startdate.'" and "'.$enddate.'"
                GROUP BY U1.an
                ORDER BY U1.dchdate DESC
        ');
        }        
        // U1.debit_total > 0 AND 
        return view('account_107.acc_107_debt',[
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate,
            'datashow'      =>  $datashow,
        ]);
    }
    public function acc_107_debt_sync(Request $request)
    { 
        $sync = DB::connection('mysql2')->select(' 
                SELECT a.an,r.finance_number,r.hn,a.pttype,r.bill_amount,r.total_amount,a.paid_money,a.remain_money,a.income
                ,SUM(r.bill_amount) as s_bill 
                FROM rcpt_print r  
                 
                LEFT OUTER JOIN an_stat a on a.an = r.vn  
                LEFT OUTER JOIN patient p on p.hn=r.hn  
                LEFT OUTER JOIN pttype t on t.pttype=r.pttype  
                WHERE department ="IPD" AND a.an IN(SELECT an FROM pkbackoffice.acc_1102050102_107)
                GROUP BY a.an 
            ');
            // ,rp.amount
            // LEFT OUTER JOIN rcpt_arrear rp on r.vn = rp.vn 
            // ,SUM(r.bill_amount) as s_bill 
            // LEFT OUTER JOIN rcpt_arrear rp on rp.vn = r.vn 
            foreach ($sync as $key => $value) { 
                $total_ = Acc_1102050102_107::where('an',$value->an)->first(); 
                $deb = $total_->debit;
                $deb_paid = $total_->paid_money; 
                // $d =  $deb - $value->total_amount;
                // $d =  $deb - $value->s_bill;   
                // dd($d);
                // Acc_1102050102_107::where('an',$value->an) 
                //         ->update([  
                //             'sumtotal_amount'    => $value->s_bill
                //     ]);
                    if ($value->s_bill >= $deb) {
                        // Acc_1102050102_107::where('an',$value->an) 
                        // ->update([   
                        //     'income'             => $value->income,
                        //     'sumtotal_amount'    => $value->s_bill,
                        //     'paid_money'         => $deb,
                        //     'debit_total'        => $deb
                        // ]);
                        if ($value->s_bill == $deb_paid) {
                            Acc_1102050102_107::where('an',$value->an) 
                                ->update([   
                                    'sumtotal_amount'    => $value->s_bill,
                                    'paid_money'         => $value->paid_money, 
                                    'debit_total'        => "0.00"
                            ]);
                        }elseif ($value->s_bill < $value->paid_money) {
                            Acc_1102050102_107::where('an',$value->an) 
                                ->update([   
                                    'sumtotal_amount'    => $value->s_bill,
                                    'paid_money'         => $value->paid_money, 
                                    'debit_total'        => $value->paid_money - $value->s_bill
                            ]);
                        }elseif ($value->s_bill >= $deb) {
                            Acc_1102050102_107::where('an',$value->an) 
                                ->update([   
                                    'sumtotal_amount'    => $value->s_bill,
                                    'paid_money'         => $value->paid_money, 
                                    'debit_total'        => "0.00"
                            ]);
                        
                    
                        } else {                        
                            Acc_1102050102_107::where('an',$value->an) 
                                ->update([   
                                    'sumtotal_amount'    => $value->s_bill,
                                    'paid_money'         => $value->paid_money,  
                                    'debit_total'        => $value->s_bill - $deb
                            ]);
                        } 
                    } else {
                        if ($value->paid_money < 1) {
                            if ($value->remain_money > 0 ) {
                                if ($value->remain_money - $value->s_bill < 1) {
                                    Acc_1102050102_107::where('an',$value->an) 
                                        ->update([   
                                            'sumtotal_amount'    => $value->s_bill,
                                            'paid_money'         => $value->remain_money,
                                            'debit_total'        => "0.00"
                                    ]);
                                } else {
                                    Acc_1102050102_107::where('an',$value->an) 
                                        ->update([   
                                            'sumtotal_amount'    => $value->s_bill,
                                            'paid_money'         => $value->remain_money,
                                            'debit_total'        => $value->remain_money - $value->s_bill
                                    ]);
                                } 
                            } else {
                                if ( $deb > $value->paid_money) {
                                    # code...
                                } else {
                                    # code...
                                }
                                
                                
                            }
                            
                            
                        } else {
                            if ($value->remain_money > 0) {
                                Acc_1102050102_107::where('an',$value->an) 
                                    ->update([   
                                        'sumtotal_amount'    => $value->s_bill,
                                        'paid_money'         => $value->paid_money,
                                        // 'debit_total'        => $d
                                        'debit_total'        => $value->remain_money,
                                ]);
                            } else {
                                Acc_1102050102_107::where('an',$value->an) 
                                    ->update([   
                                        'sumtotal_amount'    => $value->s_bill,
                                        'paid_money'         => $value->paid_money,
                                        // 'debit_total'        => $d
                                        'debit_total'        => $value->paid_money - $value->s_bill,
                                ]);
                            }
                            
                            
                        }
                        // if ($value->pttype == '10') {
                        //     Acc_1102050102_107::where('an',$value->an) 
                        //         ->update([  
                        //             // 'sumtotal_amount'    => $value->total_amount,
                        //             'income'    => $value->income,
                        //             'sumtotal_amount'    => $value->s_bill,
                        //             'paid_money'         => $deb,
                        //             // 'debit_total'        => $deb - $value->s_bill
                        //             'debit_total'        => $d 
                        //             // 'debit_total'        => $value->remain_money
                        //         ]);
                        // } else {
                            // Acc_1102050102_107::where('an',$value->an) 
                            //     ->update([  
                            //         // 'sumtotal_amount'    => $value->total_amount,
                            //         'income'             => $value->income,
                            //         'sumtotal_amount'    => $value->s_bill,
                            //         'paid_money'         => $deb,
                            //         // 'debit_total'        => $deb - $value->s_bill
                            //         'debit_total'        => $deb 
                            //         // 'debit_total'        => $value->remain_money
                            //     ]);
                   
                        
                        
                    }
            }
            return response()->json([
                'status'    => '200'
            ]);
        
        
    }
    public function acc_107_debt_check_sit(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        // dd($startdate);
        if ($startdate != '') { 
               
                $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
                foreach ($token_data as $key => $value) {
                    $cid_    = $value->cid;
                    $token_  = $value->token;
                }
                // dd($token_);
                $data_107 = DB::connection('mysql')->select('
                    SELECT cid FROM acc_1102050102_107 
                    WHERE dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                ');
                foreach ($data_107 as $key => $v) {
                        $pid = $v->cid; 
                    // }
                        // dd($pid);
                        $client = new SoapClient(
                            "http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                            array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0)
                        );
                        $params = array(
                            'sequence' => array(
                                "user_person_id" => "$cid_",
                                "smctoken"       => "$token_",
                                "person_id"      => "$pid"
                            )
                        );
                        // dd($params);
                        $contents = $client->__soapCall('searchCurrentByPID', $params);
                        // dd($contents);

                        foreach ($contents as $v) {
                            @$status           = $v->status;
                            @$maininscl        = $v->maininscl;
                            @$startdate_        = $v->startdate;
                            @$hmain            = $v->hmain;
                            @$subinscl         = $v->subinscl;
                            @$person_id_nhso   = $v->person_id;
                            @$hmain_op         = $v->hmain_op;  //"10978"
                            @$hmain_op_name    = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                            @$hsub             = $v->hsub;    //"04047"
                            @$hsub_name        = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                            @$subinscl_name    = $v->subinscl_name; //"ช่วงอายุ 12-59 ปี"
                        }
                        Acc_1102050102_107::where('cid',$pid)->whereBetween('dchdate', [$startdate, $enddate])
                            ->update([   
                                'pttype_nhso'    => @$subinscl
                        ]);
 
                }

        } else {
            // return redirect()->back();
            return response()->json([
                'status'    => '100'
            ]);
        }
        return response()->json([
            'status'    => '200'
        ]);
       
    }
    public function acc_107_debt_outbook(Request $request, $id)
    { 
        function Convert($amount_number)
        {
            $amount_number = number_format($amount_number, 2, ".","");
            $pt = strpos($amount_number , ".");
            $number = $fraction = "";
            if ($pt === false) 
                $number = $amount_number;
            else
            {
                $number = substr($amount_number, 0, $pt);
                $fraction = substr($amount_number, $pt + 1);
            }
            
            $ret = "";
            $baht = ReadNumber ($number);
            if ($baht != "")
                $ret .= $baht . "บาท";
            
            $satang = ReadNumber($fraction);
            if ($satang != "")
                $ret .=  $satang . "สตางค์";
            else 
                $ret .= "ถ้วน";
            return $ret;
        }
        function ReadNumber($number)
        {
            $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
            $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
            $number = $number + 0;
            $ret = "";
            if ($number == 0) return $ret;
            if ($number > 1000000)
            {
                $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
                $number = intval(fmod($number, 1000000));
            }
            
            $divider = 100000;
            $pos = 0;
            while($number > 0)
            {
                $d = intval($number / $divider);
                $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
                    ((($divider == 10) && ($d == 1)) ? "" :
                    ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
                $ret .= ($d ? $position_call[$pos] : "");
                $number = $number % $divider;
                $divider = $divider / 10;
                $pos++;
            }
            return $ret;
        }

        $date = date('Y-m-d');
        $data_ = Acc_1102050102_107::where('acc_1102050102_107_id', '=', $id)->first();
        $check_106_debt_count = Acc_107_debt_print::where('an', $data_->an)->count();
        $check_max_ = Acc_107_debt_print::where('an', $data_->an)->max('acc_107_debt_no');
        $check_max = $check_max_ +1;
        // $total_rcpt = $check_max_->debit;
        // $total_rcpt_thai = $check_max_->debit_total_thai;
        // $data_Patient = Patient::where('hn', '=', $data_->hn)->first();

        $data_Patient_ = DB::connection('mysql2')->select(' 
            SELECT 
                hn,p.addrpart,p.moopart,CONCAT(p.pname,p.fname," ",p.lname),td.DISTRICT_NAME,a.AMPHUR_NAME,tp.PROVINCE_NAME
                ,CONCAT("บ้านเลขที่ ",p.addrpart,"  หมู่ ",p.moopart," ","  ตำบล",td.DISTRICT_NAME) as address,p.po_code
                FROM patient p
                LEFT OUTER JOIN thaiaddress_provinces tp ON tp.PROVINCE_CODE = p.chwpart 
                LEFT JOIN thaiaddress_amphures a ON a.AMPHUR_CODE = CONCAT(p.chwpart,"",p.amppart) 
                LEFT JOIN thaiaddress_districts td ON td.DISTRICT_CODE = CONCAT(p.chwpart,"",p.amppart,"",p.tmbpart)       
                  
                WHERE p.hn = "'.$data_->hn.'"
        ');
        foreach ($data_Patient_ as $key => $value_p) {
            // $address2 = $value_p->informaddr;
            $address     = $value_p->address;
            $tmb_name    = $value_p->DISTRICT_NAME;
            $amphur_name = $value_p->AMPHUR_NAME;
            $chw_name    = $value_p->PROVINCE_NAME;
            $po_code     = $value_p->po_code;
        }
        // LEFT OUTER JOIN thaiaddress t1 on t1.chwpart = p.chwpart and t1.amppart = p.amppart and t1.tmbpart = p.tmbpart and t1.codetype = "3"
        // $address ='บ้านเลขที่'.$value_p->addrpart.'หมู่'.$value_p->moopart.''.$value_p->tmbpart.''.$value_p->amppart.''.$value_p->full_name;
        // $address = $data_Patient->addrpart.''.$data_Patient->moopart.''.$data_Patient->tmbpart.''.$data_Patient->amppart;
        Acc_107_debt_print::insert([
            'acc_1102050102_107_id'  => $id,
            'acc_107_debt_no'        => $check_max,
            'acc_107_debt_date'      => $date,
            'acc_107_debt_count'     => '1', 
            'acc_107_debt_address'   => $address,
            'tmb_name'               => $tmb_name,
            'amphur_name'            => $amphur_name,
            'chw_name'               => $chw_name,
            'provincode'             => $po_code,
            'vn'                     => $data_->vn,
            'hn'                     => $data_->hn,
            'an'                     => $data_->an,
            'cid'                    => $data_->cid,
            'ptname'                 => $data_->ptname,
            'vstdate'                => $data_->vstdate, 
            'dchdate'                => $data_->dchdate,
            'pttype'                 => $data_->pttype, 
            'income'                 => $data_->income, 
            'discount_money'         => $data_->discount_money,
            'paid_money'             => $data_->paid_money,
            'rcpt_money'             => $data_->rcpt_money, 
            'rcpno'                  => $data_->rcpno, 
            'debit_total'            => $data_->debit_total, 
            'acc_107_debt_user'      => Auth::user()->id,
            'debit_total_thai'       => Convert($data_->debit_total), 
        ]); 
    }
    protected $_toc=array();
    protected $_numbering=false;
    protected $_numberingFooter=false;
    protected $_numPageNum=1;

    function AddPage($orientation='', $size='', $rotation=0) {
        parent::AddPage($orientation,$size,$rotation);
        if($this->_numbering)
            $this->_numPageNum++;
    }

    function startPageNums() {
        $this->_numbering=true;
        $this->_numberingFooter=true;
    }

    function stopPageNums() {
        $this->_numbering=false;
    }

    function numPageNo() {
        return $this->_numPageNum;
    }

    function TOC_Entry($txt, $level=0) {
        $this->_toc[]=array('t'=>$txt,'l'=>$level,'p'=>$this->numPageNo());
    }


    public function acc_107_debt_print(Request $request, $id)
    { 
        $dataedit_count = Acc_107_debt_print::where('acc_1102050102_107_id', '=', $id)->max('acc_107_debt_no');
        $dataedit = Acc_107_debt_print::where('acc_1102050102_107_id', '=', $id)->where('acc_107_debt_no', '=', $dataedit_count)->first();
        
        // dd($dataedit->debit_total);
        $check_max = Acc_107_debt_print::where('acc_1102050102_107_id', '=', $id)->max('acc_107_debt_no');
        $org = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $rong = $org->prefix_name . ' ' . $org->fname . '  ' . $org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_po_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $po = $orgpo->prefix_name . ' ' . $orgpo->fname . '  ' . $orgpo->lname;

        $count = DB::table('com_repaire_signature')
            ->where('com_repaire_id', '=', $id)
            // ->orwhere('com_repaire_no', '=', $dataedit->com_repaire_no)
            ->count();
 
        if ($count != 0) {
            $signature = DB::table('com_repaire_signature')->where('com_repaire_id', '=', $id)
                // ->orwhere('com_repaire_no','=',$dataedit->com_repaire_no)
                ->first();
            $siguser = $signature->signature_name_usertext; //ผู้รองขอ
            $sigstaff = $signature->signature_name_stafftext; //ผู้รองขอ
            $sigrep = $signature->signature_name_reptext; //ผู้รับงาน
            $sighn = $signature->signature_name_hntext; //หัวหน้า
            $sigrong = $signature->signature_name_rongtext; //หัวหน้าบริหาร
            $sigpo = $signature->signature_name_potext; //ผอ

        } else {
            $sigrong = '';
            $siguser = '';
            $sigstaff = '';
            $sighn = '';
            $sigpo = '';
        }


        define('FPDF_FONTPATH', 'font/');
        require(base_path('public') . "/fpdf/WriteHTML.php");

        $pdf = new Fpdi(); // Instantiation   start-up Fpdi

        function dayThai($strDate)
        {
            $strDay = date("j", strtotime($strDate));
            return $strDay;
        }
        function monthThai($strDate)
        {
            $strMonth = date("n", strtotime($strDate));
            $strMonthCut = array("", "มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            $strMonthThai = $strMonthCut[$strMonth];
            return $strMonthThai;
        }
        function yearThai($strDate)
        {
            $strYear = date("Y", strtotime($strDate)) + 543;
            return $strYear;
        }
        function time($strtime)
        {
            $H = substr($strtime, 0, 5);
            return $H;
        }

        function DateThai($strDate)
        {
            if ($strDate == '' || $strDate == null || $strDate == '0000-00-00') {
                $datethai = '';
            } else {
                $strYear = date("Y", strtotime($strDate)) + 543;
                $strMonth = date("n", strtotime($strDate));
                $strDay = date("j", strtotime($strDate));
                $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                $strMonthThai = $strMonthCut[$strMonth];
                $datethai = $strDate ? ($strDay . ' ' . $strMonthThai . ' ' . $strYear) : '-';
            }
            return $datethai;
        }
     
        function thainumDigit($num){
            return str_replace(array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ),array( "o" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ),$num);
        }

        

        // $date = date_create($dataedit->created_at);
        $date_y = date('Y')+543;
        $date_yy = date_create($date_y);
        $datnow_yyy =  date_format($date_yy, "Y");
        $date_d = date('D'); 
        $date_dd = date_create($date_d);
        $datnow_ddd_ =  date_format($date_dd, "d");
        if ($datnow_ddd_ == '01') {
            $datnow_ddd = '1'; 
        }elseif ($datnow_ddd_ == '02') {
            $datnow_ddd = '2';
        }elseif ($datnow_ddd_ == '03') {
            $datnow_ddd = '3'; 
        }elseif ($datnow_ddd_ == '04') {
            $datnow_ddd = '4'; 
        }elseif ($datnow_ddd_ == '05') {
            $datnow_ddd = '5'; 
        }elseif ($datnow_ddd_ == '06') {
            $datnow_ddd = '6'; 
        }elseif ($datnow_ddd_ == '07') {
            $datnow_ddd = '7'; 
        }elseif ($datnow_ddd_ == '08') {
            $datnow_ddd = '8'; 
        }elseif ($datnow_ddd_ == '09') {
            $datnow_ddd = '9'; 
        }elseif ($datnow_ddd_ == '10') {
            $datnow_ddd = '10'; 
        }elseif ($datnow_ddd_ == '11') {
            $datnow_ddd = '11'; 
        } else {
            $datnow_ddd = '12';
        }

        $date_m = date('M'); 
        $date_mm = date_create($date_m);
        $datnow_mmm_ =  date_format($date_mm, "m");
        if ($datnow_mmm_ == '1') {
            $datnow_mmm = 'มกราคม';
        } else if ($datnow_mmm_ == '2') {
            $datnow_mmm = 'กุมภาพันธ์';
        } else if ($datnow_mmm_ == '3') {
            $datnow_mmm = 'มีนาคม';
        } else if ($datnow_mmm_ == '4') {
            $datnow_mmm = 'เมษายน';
        } else if ($datnow_mmm_ == '5') {
            $datnow_mmm = 'พฤษภาคม';
        } else if ($datnow_mmm_ == '6') {
            $datnow_mmm = 'มิถุนายน';
        } else if ($datnow_mmm_ == '7') {
            $datnow_mmm = 'กรกฎาคม';
        } else if ($datnow_mmm_ == '8') {
            $datnow_mmm = 'สิงหาคม';
        } else if ($datnow_mmm_ == '9') {
            $datnow_mmm = 'กันยายน';
        } else if ($datnow_mmm_ == '10') {
            $datnow_mmm = 'ตุลาคม';
        } else if ($datnow_mmm_ == '11') {
            $datnow_mmm = 'พฤศจิกายน';
        } else {
            $datnow_mmm = 'ธันวาคม';
        }
        

        // dd($datnow_mmm);
        // $date_vsty = date('Y',)+543;
        $date_vstyy = date_create($dataedit->vstdate);
        $datnow_vstyyy =  date_format($date_vstyy, "Y")+543;

        $date_vstd = date('D'); 
        $date_vstdd = date_create($dataedit->vstdate);
        $datnow_vstddd_ =  date_format($date_vstdd, "d");
        if ($datnow_vstddd_ == '01') {
            $datnow_vstddd = '๑';
        } else if ($datnow_vstddd_ == '02') {
            $datnow_vstddd = '๒';
        } else if ($datnow_vstddd_ == '03') {
            $datnow_vstddd = '๓';
        } else if ($datnow_vstddd_ == '04') {
            $datnow_vstddd = '๔';
        } else if ($datnow_vstddd_ == '05') {
            $datnow_vstddd = '๕';
        } else if ($datnow_vstddd_ == '06') {
            $datnow_vstddd = '๖';
        } else if ($datnow_vstddd_ == '07') {
            $datnow_vstddd = '๗';
        } else if ($datnow_vstddd_ == '08') {
            $datnow_vstddd = '๘';
        } else if ($datnow_vstddd_ == '09') {
            $datnow_vstddd = '๙';
        } else if ($datnow_vstddd_ == '10') {
            $datnow_vstddd = '๑๐';
        } else if ($datnow_vstddd_ == '11') {
            $datnow_vstddd = '๑๑';
        } else {
            $datnow_vstddd = '๑๒';
        }
        // dd($datnow_vstddd);
        $date_vstm = date('M'); 
        $date_vstmm = date_create($dataedit->vstdate);
        $datnow_vstmmm_ =  date_format($date_vstmm, "m");
        if ($datnow_vstmmm_ == '1') {
            $datnow_vstmmm = 'มกราคม';
        } else if ($datnow_vstmmm_ == '2') {
            $datnow_vstmmm = 'กุมภาพันธ์';
        } else if ($datnow_vstmmm_ == '3') {
            $datnow_vstmmm = 'มีนาคม';
        } else if ($datnow_vstmmm_ == '4') {
            $datnow_vstmmm = 'เมษายน';
        } else if ($datnow_vstmmm_ == '5') {
            $datnow_vstmmm = 'พฤษภาคม';
        } else if ($datnow_vstmmm_ == '6') {
            $datnow_vstmmm = 'มิถุนายน';
        } else if ($datnow_vstmmm_ == '7') {
            $datnow_vstmmm = 'กรกฎาคม';
        } else if ($datnow_vstmmm_ == '8') {
            $datnow_vstmmm = 'สิงหาคม';
        } else if ($datnow_vstmmm_ == '9') {
            $datnow_vstmmm = 'กันยายน';
        } else if ($datnow_vstmmm_ == '10') {
            $datnow_vstmmm = 'ตุลาคม';
        } else if ($datnow_vstmmm_ == '11') {
            $datnow_vstmmm = 'พฤศจิกายน';
        } else {
            $datnow_vstmmm = 'ธันวาคม';
        }
  
        $pdf->SetLeftMargin(22);
        $pdf->SetRightMargin(5);
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
        $pdf->SetFont('THSarabunNew Bold', '', 19); 
        $pdf->AddPage("P");
 
        $pdf->Image('assets/images/crut_red.jpg', 90, 20, 32, 34);
        
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Text(23, 55, iconv('UTF-8', 'TIS-620', 'ที่ ชย ๐๐๓๓.๓๐๓/........'));
 
        $pdf->Text(138, 55, iconv('UTF-8', 'TIS-620', '' . $org->orginfo_name)); 
 
        $pdf->Text(138, 63, iconv('UTF-8', 'TIS-620', 'อำเภอภูเขียว  จังหวัดชัยภูมิ ๓๖๑๑๐')); 
 
        $pdf->Text(105, 70, iconv('UTF-8', 'TIS-620', '' . thainumDigit($datnow_ddd).'  '. $datnow_mmm.'  '. thainumDigit($datnow_yyy) ));
        
        $pdf->Text(23, 80, iconv('UTF-8', 'TIS-620', 'เรื่อง   ขอติดตามค่ารักษาพยาบาลค้างชำระ ครั้งที่ ' .thainumDigit($check_max)));
 
        $pdf->Text(23, 88, iconv('UTF-8', 'TIS-620', 'เรียน  '));
        $pdf->SetFont('THSarabunNew Bold', '', 16);
        $pdf->Text(34, 88, iconv('UTF-8', 'TIS-620', '' .$dataedit->ptname));

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Text(23, 96, iconv('UTF-8', 'TIS-620', 'อ้างถึง  คำร้องขอค้างค่ารักษาพยาบาล  ลงวันที่' ));
       
        $pdf->Text(92, 96, iconv('UTF-8', 'TIS-620', '  ' .thainumDigit($datnow_vstddd).'  ' . $datnow_vstmmm.'  ' .thainumDigit($datnow_vstyyy)));
             
        // $pdf->SetFont('THSarabunNew', '', 16);
        // $pdf->Text(32, 104, iconv('UTF-8', 'TIS-620', 'ตามที่ ท่านได้เข้ารับการรักษาพยาบาลจาก' .$org->orginfo_name.' เมื่อวันที่ ' .thainumDigit($datnow_vstddd). ' '.$datnow_vstmmm.' '.thainumDigit($datnow_vstyyy)));
 
        $pdf->Text(46, 104, iconv('UTF-8', 'TIS-620', 'ตามที่   ท่านได้เข้ารับการรักษาพยาบาลจาก' .$org->orginfo_name ));

        // $pdf->SetFont('THSarabunNew', '', 16);
        // $pdf->Text(32, 104, iconv('UTF-8', 'TIS-620', 'ตามที่ ท่านได้เข้ารับการรักษาพยาบาลจาก' .$org->orginfo_name.' เมื่อวันที่ ' .thainumDigit($datnow_vstddd). ' '.$datnow_vstmmm.' '.thainumDigit($datnow_vstyyy)));

        // $pdf->SetFont('THSarabunNew', '', 16);
        // $pdf->Text(20, 112, iconv('UTF-8', 'TIS-620', ' ' .'  ' . $datnow_vstmmm.'  ' .thainumDigit($datnow_vstyyy)));
        
        // $pdf->SetFont('THSarabunNew', '', 15);
        // $pdf->Text(20, 112, iconv('UTF-8', 'TIS-620', 'มีค่ารักษาพยาบาล  เป็นจำนวนเงิน                                                                    ปรากฎว่าท่านยังไม่ได้ชำระเงิน'));
 
        $pdf->Text(23, 112, iconv('UTF-8', 'TIS-620','เมื่อวันที่ ' .thainumDigit($datnow_vstddd). ' '.$datnow_vstmmm.' '.thainumDigit($datnow_vstyyy).' มีค่ารักษาพยาบาล  เป็นจำนวนเงิน                                                                    '));
        
        $pdf->Text(125, 112, iconv('UTF-8', 'TIS-620',  thainumDigit(number_format($dataedit->debit_total, 2)).' บาท  '.'( '.$dataedit->debit_total_thai.' ) '));   
        
        $pdf->Text(23, 120, iconv('UTF-8', 'TIS-620', 'ปรากฎว่าท่านยังไม่ได้ชำระเงินจำนวนเงินดังกล่าวให้แก่'. $org->orginfo_name.'  จึงขอให้ท่านดำเนินการ'));

        $pdf->Text(23, 128, iconv('UTF-8', 'TIS-620', 'ชำระเงินดังกล่าวให้เสร็จสิ้นภายใน 30 วัน นับจากวันที่ได้รับหนังสือฉบับนี้  หากท่านมีข้อสอบถามเพิ่มเติม'));      
        // $pdf->Text(20, 120, iconv('UTF-8', 'TIS-620', 'ดังกล่าวให้แก่'. $org->orginfo_name.'  จึงขอให้ท่านดำเนินการชำระเงินดังกล่าวให้เสร็จสิ้นภายใน 30 วัน'));
        // $pdf->Text(20, 128, iconv('UTF-8', 'TIS-620', 'นับจากวันที่ได้รับหนังสือฉบับนี้  หากท่านมีข้อสอบถามเพิ่มเติมสามารถติดต่อสอบถามได้ที่หมายเลขโทรศัพท์ตามที่'));
         
        $pdf->Text(23, 136, iconv('UTF-8', 'TIS-620', 'สามารถติดต่อสอบถามได้ที่หมายเลขโทรศัพท์ตามที่แจ้งไว้ด้านล่างหนังสือฉบับนี้'));

        $pdf->Text(46, 144, iconv('UTF-8', 'TIS-620', 'ทั้งนี้ หากท่านได้ชำระเงินก่อนที่ท่านจะได้รับหนังสือฉบับนี้ ทาง'. $org->orginfo_name.' '));

        $pdf->Text(23, 152, iconv('UTF-8', 'TIS-620', 'ต้องขออภัยมา ณ โอกาสนี้ ด้วย'));
 
        $pdf->Text(46, 160, iconv('UTF-8', 'TIS-620', 'จึงเรียนมาเพื่อโปรดทราบและดำเนินการต่อไป'));

        $pdf->Text(97, 185, iconv('UTF-8', 'TIS-620', 'ขอแสดงความนับถือ' ));
       
        //ผอ 
        $pdf->Text(93, 210, iconv('UTF-8', 'TIS-620', '( นาย'. $orgpo->orginfo_po_name.' )')); 
 
        $pdf->Text(77, 216, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
        
        $pdf->Text(20, 240, iconv('UTF-8', 'TIS-620', 'กลุ่มภารกิจด้านพัฒนาระบบบริการและสนับสนุนบริการสุขภาพ'));
  
        $pdf->Text(20, 248, iconv('UTF-8', 'TIS-620', 'โทร. ๐ ๔๔๘๖ ๑๗๐๐-๔  ต่อ  ๑๐๙,๑๑๙'));
  
        $pdf->Text(20, 256, iconv('UTF-8', 'TIS-620', 'Email : phukhieohospital.info@gmail.com'));


        $pdf->SetFont('THSarabunNew Bold', '', 16);
        $pdf->Text(145, 256, iconv('UTF-8', 'TIS-620',''.thainumDigit($dataedit->hn))); 
 
        $pdf->Text(55, 276, iconv('UTF-8', 'TIS-620','อัตลักษณ์ รพ.ภูเขียวเฉลิมพระเกียรติ  '.'"'.'ตรงเวลา รู้หน้าที่ มีวินัย'.'"'));
   
        //Page 2
        $pdf->AddPage();  
        $pdf->Image('assets/images/crut.png', 15, 100, 22, 24);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Text(42, 115, iconv('UTF-8', 'TIS-620', '' . $orgpo->orginfo_name));
       
        $pdf->Text(42, 122, iconv('UTF-8', 'TIS-620', 'อำเภอภูเขียว จังหวัดชัยภูมิ' ));
 
        $pdf->Text(152, 108, iconv('UTF-8', 'TIS-620', 'ชําระค่าฝากส่งเป็นรายเดือน'));
      
        $pdf->Text(161, 115, iconv('UTF-8', 'TIS-620', 'ใบอนุญาตที่ ๓๖๑๑๐'));
    
        $pdf->Text(168, 122, iconv('UTF-8', 'TIS-620', 'ไปรษณีย์ ภูเขียว '));
 
        $pdf->Text(90, 155, iconv('UTF-8', 'TIS-620', '' . $dataedit->ptname));
  
        $pdf->Text(90, 163, iconv('UTF-8', 'TIS-620', '' . $dataedit->acc_107_debt_address));
    
        $pdf->Text(90, 171, iconv('UTF-8', 'TIS-620', 'อำเภอ' . $dataedit->amphur_name. 'จังหวัด' . $dataedit->chw_name. '' . $dataedit->provincode));

        $pdf->Output();

        exit;
    }


    public function account_107_destroy(Request $request)
    {
        $id = $request->ids; 
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                  
        return response()->json([
            'status'    => '200'
        ]);
    }
 
}
