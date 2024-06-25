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
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Com_repaire;  
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Patient;
use App\Models\Acc_106_debt_print;
use App\Models\Acc_doc;
use App\Models\Acc_1102050102_106;
use App\Models\Acc_debtor;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class Account106Controller extends Controller
{
     // ************ OPD 106******************
    public function acc_106_dashboard(Request $request)
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

        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        if ($data['startdate'] == '') {
            $data['datashow'] = DB::connection('mysql')->select('
                SELECT month(v.vstdate) as months,year(v.vstdate) as year,l.MONTH_NAME
                    ,COUNT(DISTINCT r.vn) countvn,SUM(r.amount) sumamount
                    from hos.rcpt_arrear r  
                    LEFT OUTER JOIN hos.vn_stat v on v.vn=r.vn  
                    LEFT OUTER JOIN hos.patient p on p.hn=r.hn   
                    LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(v.vstdate)
                    WHERE v.vstdate BETWEEN "'.$newDate.'" and "'.$date.'"
                    AND r.paid ="N" AND r.pt_type="OPD"
                    GROUP BY month(v.vstdate)
                    ORDER BY v.vstdate desc limit 6; 
            '); 
        } else {
            $data['datashow'] = DB::connection('mysql')->select('
                SELECT month(v.vstdate) as months,year(v.vstdate) as year,l.MONTH_NAME
                        ,COUNT(DISTINCT r.vn) countvn,SUM(r.amount) sumamount
                        from hos.rcpt_arrear r  
                        LEFT OUTER JOIN hos.vn_stat v on v.vn=r.vn   
                        LEFT OUTER JOIN hos.patient p on p.hn=r.hn  
                        LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(v.vstdate)
                        WHERE v.vstdate BETWEEN "'.$data['startdate'].'" and "'.$data['enddate'].'" 
                        AND r.paid ="N"
                        ORDER BY v.vstdate desc limit 6;  
            '); 
        }
        
        
        return view('account_106.acc_106_dashboard', $data );
    }
    public function acc_106_pull(Request $request)
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
                left join checksit_hos c on c.vn = a.vn  
                WHERE a.account_code="1102050102.106"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_106.acc_106_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function acc_106_pulldata(Request $request)
    { 
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2; 
        $acc_debtor = DB::connection('mysql2')->select(' 
            SELECT r.vn,r.hn,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname
                ,v.pttype,v.vstdate,r.arrear_date,r.arrear_time,rp.book_number,rp.bill_number,r.amount,rp.total_amount,r.paid
                ,o.vsttime,t.name as pttype_name,"27" as acc_code,"1102050102.106" as account_code,"ชำระเงิน" as account_name,r.staff
                ,r.rcpno,r.finance_number,r.receive_money_date,r.receive_money_staff,v.pdx
                ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money

                FROM hos.rcpt_arrear r  
                LEFT OUTER JOIN hos.rcpt_print rp on r.vn = rp.vn 
                LEFT OUTER JOIN hos.ovst o on o.vn= r.vn  
                LEFT OUTER JOIN hos.vn_stat v on v.vn= r.vn  
                LEFT OUTER JOIN hos.patient p on p.hn=r.hn  
                LEFT OUTER JOIN hos.pttype t on t.pttype = o.pttype
                LEFT OUTER JOIN hos.pttype_eclaim e on e.code = t.pttype_eclaim_id
                WHERE v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND r.paid ="N" AND r.pt_type="OPD"
                GROUP BY r.vn
        ');
        // LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(o.vstdate)
        foreach ($acc_debtor as $key => $value) {
            // $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050102.106')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    // $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050102.106')->count();
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050102.106')->count();
                    if ($check > 0) {
                        Acc_debtor::where('vn', $value->vn)->where('account_code','1102050102.106')->update([                           
                            'income'             => $value->income,
                            'uc_money'           => $value->uc_money,
                            'discount_money'     => $value->discount_money,
                            'paid_money'         => $value->paid_money,
                            'rcpt_money'         => $value->rcpt_money,
                            'debit'              => $value->amount, 
                            'debit_total'        => $value->amount,
                            'rcpno'              => $value->rcpno,  
                            'pdx'                => $value->pdx, 
                        ]);
                        // Acc_1102050102_106::where('vn', $value->vn)->update([ 
                        //     'income'             => $value->income,
                        //     'uc_money'           => $value->uc_money,
                        //     'discount_money'     => $value->discount_money,
                        //     'paid_money'         => $value->paid_money,
                        //     'rcpt_money'         => $value->rcpt_money,
                        //     'debit'              => $value->amount, 
                        //     'debit_total'        => $value->amount,
                        //     'rcpno'              => $value->rcpno,  
                        //     'pdx'                => $value->pdx,
                        // ]);
                    }else{
                        Acc_debtor::insert([
                            // 'stamp'              => 'Y',
                            'hn'                 => $value->hn,
                            // 'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'acc_code'           => $value->acc_code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name, 
                            'income'             => $value->income,
                            'uc_money'           => $value->uc_money,
                            'discount_money'     => $value->discount_money,
                            'paid_money'         => $value->paid_money,
                            'rcpt_money'         => $value->rcpt_money,
                            'debit'              => $value->amount, 
                            'debit_total'        => $value->amount,
                            'rcpno'              => $value->rcpno, 
                            'pdx'                => $value->pdx, 
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }
        }
            return response()->json([

                'status'    => '200'
            ]);
    }
    public function acc_106_stam(Request $request)
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
             $check = Acc_1102050102_106::where('vn', $value->vn)->count(); 
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050102_106::insert([
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
                            'pdx'               => $value->pdx,
                            'max_debt_amount'   => $value->max_debt_amount,
                            'acc_debtor_userid' => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function acc_106_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *
                from acc_1102050102_106 U1
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'" 
                GROUP BY U1.vn
        ');
        // U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_106.acc_106_detail', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function acc_106_detail_date(Request $request,$startdate,$enddate)
    { 
        $data['users'] = User::get();

        $data = DB::select('
        SELECT *
            from acc_1102050102_106 U1
            WHERE U1.vstdate  BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
            GROUP BY U1.vn
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_106.acc_106_detail_date', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function acc_106_file(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // $datashow = DB::connection('mysql')->select('SELECT * FROM acc_stm_repmoney ar LEFT JOIN acc_trimart_liss a ON a.acc_trimart_liss_id = ar.acc_stm_repmoney_tri ORDER BY acc_stm_repmoney_id DESC');
        $datashow = DB::connection('mysql')->select('
          
            SELECT U1.acc_1102050102_106_id,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.account_code,U1.vstdate,U1.pttype,U1.debit_total,U2.file,U2.filename
            from acc_1102050102_106 U1
            LEFT OUTER JOIN acc_doc U2 ON U2.acc_doc_pangid = U1.acc_1102050102_106_id
            GROUP BY U1.vn
        ');
        // SELECT YEAR(a.acc_trimart_start_date) as year,ar.acc_stm_repmoney_id,a.acc_trimart_code,a.acc_trimart_name
        // ,ar.acc_stm_repmoney_book,ar.acc_stm_repmoney_no,ar.acc_stm_repmoney_price301,ar.acc_stm_repmoney_price302,ar.acc_stm_repmoney_price310,ar.acc_stm_repmoney_date,concat(u.fname," ",u.lname) as fullname
        // FROM acc_stm_repmoney ar 
        // LEFT JOIN acc_trimart a ON a.acc_trimart_id = ar.acc_trimart_id 
        // LEFT JOIN users u ON u.id = ar.user_id 
        // ORDER BY acc_stm_repmoney_id DESC
        $countc = DB::table('acc_stm_ucs_excel')->count(); 
        $data['trimart'] = DB::table('acc_trimart')->get();

        return view('account_106.acc_106_file',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    public function acc_106_file_updatefile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx,pdf,png,jpeg'
        ]);
        // $the_file = $request->file('file'); 
        $file_name = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
        //    dd($file_name);
 
        $add = new Acc_doc();
        $add->acc_doc_pangid           = $request->input('acc_1102050102_106_id');
        $add->acc_doc_pang             = $request->input('account_code'); 
        $add->file                     = $request->file('file');
        if($request->hasFile('file')){               
            $request->file->storeAs('account_106',$file_name,'public');
            $add->filename             = $file_name;
        }
        $add->save();
        return redirect()->route('acc.acc_106_file');
        // return response()->json([
        //     'status'    => '200' 
        // ]); 
    }
    public function acc106destroy(Request $request,$id)
    {
        
        $file_ = Acc_doc::find($id);  
        $file_name = $file_->filename; 
        $filepath = public_path('storage/account_106/'.$file_name);
        $description = File::delete($filepath);

        $del = Acc_doc::find($id);  
        $del->delete(); 

        return redirect()->route('acc.acc_106_file');
        // return response()->json(['status' => '200']);
    }

    public function acc_106_debt(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $data['users'] = User::get();
 
        $datashow = DB::connection('mysql')->select('        
                SELECT U1.acc_1102050102_106_id,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.account_code,U1.vstdate,U1.pttype,U3.income,U3.paid_money,U3.rcpt_money,U1.debit_total,U2.file,U2.filename
                FROM acc_1102050102_106 U1
                LEFT OUTER JOIN acc_doc U2 ON U2.acc_doc_pangid = U1.acc_1102050102_106_id
                LEFT OUTER JOIN acc_debtor U3 ON U3.vn = U1.vn
                WHERE U1.debit_total > 0
                GROUP BY U1.vn ORDER BY U1.acc_1102050102_106_id DESC
        ');
        return view('account_106.acc_106_debt',[
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate,
            'datashow'      =>  $datashow,
        ]);
    }
    public function acc_106_debt_outbook(Request $request, $id)
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
        $data_ = Acc_1102050102_106::where('acc_1102050102_106_id', '=', $id)->first();
        $check_106_debt_count = Acc_106_debt_print::where('vn', $data_->vn)->count();
        $check_max_ = Acc_106_debt_print::where('vn', $data_->vn)->max('acc_106_debt_no');
        $check_max = $check_max_ +1;
        // $total_rcpt = $check_max_->debit;
        // $total_rcpt_thai = $check_max_->debit_total_thai;
        $data_Patient = Patient::where('hn', '=', $data_->hn)->first();

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
        Acc_106_debt_print::insert([
            'acc_1102050102_106_id'  => $id,
            'acc_106_debt_no'        => $check_max,
            'acc_106_debt_date'      => $date,
            'acc_106_debt_count'     => '1', 
            'acc_106_debt_address'   => $address,
            'tmb_name'               => $tmb_name,
            'amphur_name'            => $amphur_name,
            'chw_name'               => $chw_name,
            'provincode'             => $po_code,
            'vn'                => $data_->vn,
            'hn'                => $data_->hn,
            'an'                => $data_->an,
            'cid'               => $data_->cid,
            'ptname'            => $data_->ptname,
            'vstdate'           => $data_->vstdate, 
            'dchdate'           => $data_->dchdate,
            'pttype'            => $data_->pttype, 
            'income'            => $data_->income, 
            'discount_money'    => $data_->discount_money,
            'paid_money'        => $data_->paid_money,
            'rcpt_money'        => $data_->rcpt_money, 
            'rcpno'             => $data_->rcpno, 
            'debit_total'       => $data_->debit_total, 
            'acc_106_debt_user' => Auth::user()->id,
            'debit_total_thai'  => Convert($data_->debit_total), 
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


    public function acc_106_debt_print(Request $request, $id)
    { 
        
        $dataedit = Acc_106_debt_print::where('acc_1102050102_106_id', '=', $id)->first();
        $check_max = Acc_106_debt_print::where('acc_1102050102_106_id', '=', $id)->max('acc_106_debt_no');
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
        $datnow_ddd =  date_format($date_dd, "d");
        $date_m = date('M'); 
        $date_mm = date_create($date_m);
        $datnow_mmm =  date_format($date_mm, "m");

        // $date_vsty = date('Y',)+543;
        $date_vstyy = date_create($dataedit->vstdate);
        $datnow_vstyyy =  date_format($date_vstyy, "Y")+543;

        $date_vstd = date('D'); 
        $date_vstdd = date_create($dataedit->vstdate);
        $datnow_vstddd =  date_format($date_vstdd, "d");

        $date_vstm = date('M'); 
        $date_vstmm = date_create($dataedit->vstdate);
        $datnow_vstmmm =  date_format($date_vstmm, "m");

        // $date_d = date('d'); 
        // $date_dd = date_create($date_d);
        // $datnow_ddd =  date_format($date, "Y-m-j");
       
        //  // Arial bold 15
        // $this->SetFont('Arial','B',15);
        // // Calculate width of title and position
        // $w = $this->GetStringWidth($title)+6;
        // $this->SetX((210-$w)/2);
        // // Colors of frame, background and text
        // $this->SetDrawColor(0,80,180);  สีของเส้น
        // $this->SetFillColor(230,230,0); 
        // $this->SetTextColor(220,50,50);  สีตัวหนังสือ
        // // Thickness of frame (1 mm)
        // $this->SetLineWidth(1);
        // // Title
        // $this->Cell($w,9,$title,1,1,'C',true);
        // // Line break
        // $this->Ln(10);
        

        $pdf->SetLeftMargin(22);
        $pdf->SetRightMargin(5);
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
        $pdf->SetFont('THSarabunNew Bold', '', 19);
        // $pdf->AddPage("L", ['100', '100']);
        $pdf->AddPage("P");

        // # list of colors
        // $colors = [(0,0,0),(255,0,0),(255,165,0)];
        // $imgname = 'assets/images/crut.png';
        // $im = imagecreatefrompng($imgname);
        // imagecolorset($im,100, 100,150,0);
        // header("Content-type: image/png");
        // imagepng($im);
        // $pdf->SetFillColor(230,230,0); 
        $pdf->Image('assets/images/crut_red.jpg', 90, 20, 32, 34);
        // $pdf->Image('assets/images/crut.png',  10, 10, -300);
        // $pdf->Image($imgname [, 99 [, 55 [, 88 [, 55 [, 'PNG' [, 'assets/images/crut.png']]]]]]);
        // Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
        // $pdf->SetFont('THSarabunNew Bold', '', 19);       
        // $pdf->Text(93, 25, iconv('UTF-8', 'TIS-620', 'ใบแจ้งซ่อม '));
        // $pdf->SetFont('THSarabunNew', '', 17);
        // $pdf->Text(120, 50, iconv('UTF-8', 'TIS-620', '' . $org->orginfo_name));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 55, iconv('UTF-8', 'TIS-620', 'ที่ ชย ๐๐๓๓.๓๐๓/........'));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(140, 55, iconv('UTF-8', 'TIS-620', '' . $org->orginfo_name)); 

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(140, 63, iconv('UTF-8', 'TIS-620', 'อำเภอภูเขียว  จังหวัดชัยภูมิ ๓๖๑๑๐')); 

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(105, 70, iconv('UTF-8', 'TIS-620', '' . thainumDigit($datnow_ddd).'  '. monthThai($datnow_mmm).'  '. thainumDigit($datnow_yyy) ));
        // $pdf->SetFont('THSarabunNew', '', 15); 
        // $pdf->Text(119, 70, iconv('UTF-8', 'TIS-620', '' . monthThai($datnow_mmm)));
        // $pdf->SetFont('THSarabunNew', '', 15);
        // $pdf->Text(136, 70, iconv('UTF-8', 'TIS-620', '' . thainumDigit($datnow_yyy)));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 80, iconv('UTF-8', 'TIS-620', 'เรื่อง   ขอติดตามค่ารักษาพยาบาลค้างชำระ ครั้งที่ ' .thainumDigit($check_max)));

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Text(20, 88, iconv('UTF-8', 'TIS-620', 'เรียน  '));
        $pdf->SetFont('THSarabunNew Bold', '', 16);
        $pdf->Text(30, 88, iconv('UTF-8', 'TIS-620', '' .$dataedit->ptname));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 96, iconv('UTF-8', 'TIS-620', 'อ้างถึง  คำร้องขอค้างค่ารักษาพยาบาล  ลงวันที่' ));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(85, 96, iconv('UTF-8', 'TIS-620', '  ' .thainumDigit($datnow_vstddd).'  ' . monthThai($datnow_vstmmm).'  ' .thainumDigit($datnow_vstyyy)));
        $pdf->SetFont('THSarabunNew', '', 15); 
        // $pdf->Text(95, 96, iconv('UTF-8', 'TIS-620', 'พฤศจิกายน'));
        // $pdf->Text(95, 96, iconv('UTF-8', 'TIS-620', '' . monthThai($datnow_vstmmm)));
     
        // $pdf->SetFont('THSarabunNew', '', 15);
        // $pdf->Text(110, 96, iconv('UTF-8', 'TIS-620', '  ' .thainumDigit($datnow_vstyyy)));
        
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(35, 104, iconv('UTF-8', 'TIS-620', 'ตามที่ ท่านได้เข้ารับการรักษาพยาบาลจาก' .$org->orginfo_name));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(145, 104, iconv('UTF-8', 'TIS-620', 'เมื่อวันที่ ' .thainumDigit($datnow_vstddd).'  ' . monthThai($datnow_vstmmm).'  ' .thainumDigit($datnow_vstyyy)));
        
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 112, iconv('UTF-8', 'TIS-620', 'มีค่ารักษาพยาบาล  เป็นจำนวนเงิน                                                                    ปรากฎว่าท่านยังไม่ได้ชำระเงิน'));

        $pdf->SetFont('THSarabunNew Bold', '', 15);
        $pdf->Text(70, 112, iconv('UTF-8', 'TIS-620',  thainumDigit($dataedit->debit_total).' บาท  '.'('.$dataedit->debit_total_thai.') '));
        // Bold
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 120, iconv('UTF-8', 'TIS-620', 'จำนวนเงินดังกล่าวให้แก่  '. $org->orginfo_name.'  จึงขอให้ท่านดำเนินการชำระเงินดังกล่าวให้เสร็จสิ้น   '));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 128, iconv('UTF-8', 'TIS-620', 'ภายในวัน 30 วันนับจากวันที่ได้รับหนังสือฉบับนี้  หากท่านมีข้อสอบถามเพิ่มเติม  สามารถติดต่อสอบถามได้ที่'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 136, iconv('UTF-8', 'TIS-620', 'หมายเลขโทรศัพท์ ตามที่แจ้งไว้ด้านล่างหนังสือฉบับนี้'));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(35, 144, iconv('UTF-8', 'TIS-620', 'ทั้งนี้ หากท่านได้ชำระเงินก่อนที่ท่านจะได้รับหนังสือฉบับนี้ ทาง'. $org->orginfo_name.' ต้องขออภัยมา'));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 152, iconv('UTF-8', 'TIS-620', ' ณ โอกาสนี้ ด้วย'));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(35, 160, iconv('UTF-8', 'TIS-620', 'จึงเรียนมาเพื่อโปรดทราบและดำเนินการต่อไป'));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(95, 170, iconv('UTF-8', 'TIS-620', 'ขอแสดงความนับถือ' ));
        // $pdf->SetFont('THSarabunNew', '', 15); 
        // $pdf->Text(95, 96, iconv('UTF-8', 'TIS-620', 'พฤศจิกายน'));
        
        //ผอ 
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(95, 210, iconv('UTF-8', 'TIS-620', '('. $orgpo->orginfo_po_name.')')); 
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(75, 216, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
        
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 240, iconv('UTF-8', 'TIS-620', 'กลุ่มภารกิจด้านพัฒนาระบบบริการและสนับสนุนบริการสุขภาพ'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 248, iconv('UTF-8', 'TIS-620', 'โทร. ๐ ๔๔๘๖ ๑๗๐๐-๔  ต่อ  ๑๐๙,๑๑๙'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(20, 256, iconv('UTF-8', 'TIS-620', 'Email : phukhieohospital.info@gmail.com'));


        $pdf->SetFont('THSarabunNew Bold', '', 15);
        $pdf->Text(145, 266, iconv('UTF-8', 'TIS-620',''.thainumDigit($dataedit->hn))); 
 
        $pdf->SetFont('THSarabunNew Bold', '', 16);
        $pdf->Text(55, 276, iconv('UTF-8', 'TIS-620','อัตลักษณ์ รพ.ภูเขียวเฉลิมพระเกียรติ  '.'"'.'ตรงเวลา รู้หน้าที่ มีวินัย'.'"'));
   
        // $pdf->SetFont('THSarabunNew Bold', '', 16);
        // $pdf->Text(55, 286, '.“.');
        //Page 2
        $pdf->AddPage(); 
        // $pdf->Cell(0,5,'TOC1',0,1,'L');
        $pdf->Image('assets/images/crut.png', 15, 115, 22, 24);
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(42, 130, iconv('UTF-8', 'TIS-620', '' . $orgpo->orginfo_name));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(42, 137, iconv('UTF-8', 'TIS-620', 'อำเภอภูเขียว จังหวัดชัยภูมิ' ));


        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(152, 123, iconv('UTF-8', 'TIS-620', 'ชําระค่าฝากส่งเป็นรายเดือน'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(161, 130, iconv('UTF-8', 'TIS-620', 'ใบอนุญาตที่ ๓๖๑๑๐'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(168, 137, iconv('UTF-8', 'TIS-620', 'ไปรษณีย์ ภูเขียว '));

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(70, 170, iconv('UTF-8', 'TIS-620', '' . $dataedit->ptname));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(70, 177, iconv('UTF-8', 'TIS-620', '' . $dataedit->acc_106_debt_address));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(70, 185, iconv('UTF-8', 'TIS-620', 'อำเภอ' . $dataedit->amphur_name. 'จังหวัด' . $dataedit->chw_name. '' . $dataedit->provincode));

        $pdf->Output();

        exit;
    }
    
 
}
