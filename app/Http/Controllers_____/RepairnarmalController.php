<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
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
use App\Models\Product_color;
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Building_level;
use App\Models\Building_level_room;
use App\Models\Building_room_type;
use App\Models\Building_type;
use App\Models\Meeting_service;
use App\Models\Meeting_service_list;
use App\Models\Meeting_service_food;
use App\Models\Meeting_status;
use App\Models\Repaire_req;
use App\Models\Car_location;
use App\Models\Carservice_signature;
use App\Models\Car_service_personjoin;
use App\Models\Car_drive;
use App\Models\Com_repaire;
use App\Models\Com_repaire_signature;
use App\Models\Com_repaire_speed;
use App\Models\Com_tec;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use App\Models\Repaire_tech;

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class RepairnarmalController extends Controller
{
    public function repaire_calenda(Request $request)
    {
        $data['article_data'] = Article::where('article_decline_id', '=', '6')->where('article_categoryid', '=', '26')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['car_location'] = Car_location::get();
        $ye = date('Y');
        $y = date('Y') + 543;
        $m = date('m');
        $d = date('d');
        $lotthai = $y . '-' . $m . '-' . $d;
        $loten = $ye . '-' . $m . '-' . $d;
        // dd($loten);
        $data['budget_year'] = Budget_year::where('leave_year_id', '=', $y)->get();
        $data['car_status'] = Car_status::where('car_status_code', '=', 'allocate')->orwhere('car_status_code', '=', 'allocateall')->orwhere('car_status_code', '=', 'confirmcancel')->get();
        $data['users'] = User::get();
        $data['car_drive'] = Car_drive::get();

        $event = array();
        $req = Repaire_req::all();
        // $carservicess = Car_service::where('car_service_article_id','=',$id)->get(); 
        foreach ($req as $item) {

            if ($item->repaire_req_status == 'notifyrepair') {
                $color = '#F48506';
            } elseif ($item->repaire_req_status == 'carry_out') {
                $color = '#592DF7';
            } elseif ($item->repaire_req_status == 'waiting') {
                $color = '#07D79E';
            } elseif ($item->repaire_req_status == 'cancel') {
                $color = '#ff0606';
            } elseif ($item->repaire_req_status == 'confirmcancel') {
                $color = '#ab9e9e';
            } elseif ($item->repaire_req_status == 'sendout') {
                $color = '#E80DEF';
            } else {
                $color = '#3CDF44';
            }
            $datestart = $item->repaire_req_date;
            $timestart = $item->repaire_req_time;
            $timeend = $item->repaire_req_work_time;
            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);

            $showtitle = $item->repaire_req_debsubsub_name;

            $event[] = [
                'id' => $item->com_repaire_id,
                'title' => $showtitle,
                'start' => $datestart,
                // 'end' => $dateend,
                'color' => $color
            ];
        }

        return view('repaire.repaire_calenda', $data, [
            'events'     =>  $event,
            // 'dataedits'  =>  $dataedit
        ]);
    }

    public function repaire_narmal(Request $request)
    {        
        $data['q'] = $request->query('q');
        $query = Com_repaire::select('com_repaire.*', 'com_repaire_speed.*','article_data.*')
            ->leftJoin('com_repaire_speed', 'com_repaire_speed.status_id', '=', 'com_repaire.com_repaire_speed')
            ->leftJoin('article_data', 'article_data.article_id', '=', 'com_repaire.com_repaire_article_id')
            ->where(function ($query) use ($data) {
                $query->where('com_repaire_no', 'like', '%' . $data['q'] . '%');
                $query->orwhere('com_repaire_speed', 'like', '%' . $data['q'] . '%');
                $query->orwhere('com_repaire_detail', 'like', '%' . $data['q'] . '%');
                $query->orwhere('com_repaire_article_name', 'like', '%' . $data['q'] . '%');
                $query->orwhere('com_repaire_user_name', 'like', '%' . $data['q'] . '%');
            });
        $data['com_repaire'] = $query->orderBy('com_repaire_id', 'DESC')->get();


        return view('repaire.repaire_narmal ', $data);
    }

    // public function com_staff_index_add(Request $request, $id)
    // {
    //     $dataedit = Com_repaire::leftJoin('com_repaire_speed', 'com_repaire_speed.status_id', '=', 'com_repaire.com_repaire_speed')
    //         ->where('com_repaire_id', '=', $id)->first();
    //     $sig = Com_repaire_signature::where('com_repaire_id', '=', $id)->first();
    //     $signat = $sig->signature_name_usertext;

    //     $data['users'] = User::get();
    //     $signature = base64_encode(file_get_contents($signat));
    //     // dd($signature);

    //     $data['com_tec'] = Com_tec::get();
    //     $data['com_repaire_speed'] = DB::table('com_repaire_speed')->get();
    //     $y = date('Y') + 543;
    //     $m = date('m');
    //     $d = date('d');
    //     $lot = $y . '' . $m . '' . $d;
    //     // dd($y);
    //     $data['budget_year'] = Budget_year::get();
    //     $data['article_data'] = Article::where('article_categoryid', '=', '38')->where('article_status_id', '=', '1')->get();

    //     return view('computer.com_staff_index_add', $data, [
    //         'dataedits'   => $dataedit,
    //         'signature'   => $signature
    //     ]);
    // }

    // public function com_staff_index_update(Request $request)
    // {
    //     date_default_timezone_set('Asia/Bangkok');
    //     $iduser = $request->com_repaire_tec_id;
    //     $add_img = $request->input('signature');
    //     $add_img2 = $request->input('signature2');
    //     $no = $request->com_repaire_no;
    //     $datework = $request->com_repaire_work_date;
    //     $worktime = $request->com_repaire_work_time;
    //     $article_id = $request->com_repaire_article_id;
    //     $detailtec = $request->com_repaire_detail_tech;
    //     $id = $request->com_repaire_id;
    //     $idrep = $request->com_repaire_rep_id;

    //     if ($add_img != '') {

    //         $update = Com_repaire::find($id);
    //         $update->com_repaire_work_date = $datework;
    //         $update->com_repaire_work_time = $worktime;
    //         $update->com_repaire_send_date = $datework;
    //         $update->com_repaire_send_time = $worktime;
    //         $update->com_repaire_detail_tech = $detailtec;
    //         $update->com_repaire_status = 'finish';


    //         if ($article_id != '') {
    //             $bransave = DB::table('article_data')->where('article_id', '=', $article_id)->first();
    //             $update->com_repaire_article_id = $bransave->article_id;
    //             $update->com_repaire_article_num = $bransave->article_num;
    //             $update->com_repaire_article_name = $bransave->article_name;
    //         } else {
    //             $update->com_repaire_article_id = '';
    //             $update->com_repaire_article_num = '';
    //             $update->com_repaire_article_name = '';
    //         }


    //         if ($iduser != '') {
    //             $usave = DB::table('users')->where('id', '=', $iduser)->first();
    //             $update->com_repaire_tec_id = $usave->id;
    //             $update->com_repaire_tec_name = $usave->fname . ' ' . $usave->lname;
    //         } else {
    //             $update->com_repaire_tec_id = '';
    //             $update->com_repaire_tec_name = '';
    //         }

    //         if ($idrep != '') {
    //             $usave = DB::table('users')->where('id', '=', $idrep)->first();
    //             $update->com_repaire_rep_id = $usave->id;
    //             $update->com_repaire_rep_name = $usave->fname . ' ' . $usave->lname;
    //         } else {
    //             $update->com_repaire_rep_id = '';
    //             $update->com_repaire_rep_name = '';
    //         }

    //         $update->save();

    //         Com_repaire_signature::where('com_repaire_id', $id)
    //             ->update([
    //                 'com_repaire_no' => $no,
    //                 'signature_name_reptext' => $add_img,
    //                 'signature_name_stafftext' => $add_img2
    //             ]);


    //         //แจ้งเตือน 
    //         function DateThailine($strDate)
    //         {
    //             $strYear = date("Y", strtotime($strDate)) + 543;
    //             $strMonth = date("n", strtotime($strDate));
    //             $strDay = date("j", strtotime($strDate));

    //             $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    //             $strMonthThai = $strMonthCut[$strMonth];
    //             return "$strDay $strMonthThai $strYear";
    //         }

    //         $header = "แจ้งซ่อมคอมพิวเตอร์";
    //         $linegroup = DB::table('line_token')->where('line_token_id', '=', 6)->first();
    //         $line = $linegroup->line_token_code;

    //         $link = DB::table('orginfo')->where('orginfo_id', '=', 1)->first();
    //         $link_line = $link->orginfo_link;

    //         $datesend = date('Y-m-d');
    //         $sendate = DateThailine($datesend);

    //         $user = DB::table('users')->where('id', '=', $iduser)->first();

    //         function formatetime($strtime)
    //         {
    //             $H = substr($strtime, 0, 5);
    //             return $H;
    //         }

    //         $message = $header .
    //             "\n" . "รหัสแจ้งซ่อม : " . $no .
    //             "\n" . "วันที่ซ่อม : " . DateThailine($datework) .
    //             "\n" . "เวลา : " . formatetime($worktime) .
    //             "\n" . "ช่างซ่อม : " . $user->fname . ' ' . $user->lname .
    //             "\n" . "หน่วยงาน : " . $user->dep_subsubtruename .
    //             "\n" . "สถานะ : " . 'ซ่อมเสร็จ' .
    //             "\n" . "รายละเอียด : " . $detailtec;

    //         $linesend = $line;
    //         if ($linesend == null) {
    //             $test = '';
    //         } else {
    //             $test = $linesend;
    //         }

    //         if ($test !== '' && $test !== null) {
    //             $chOne = curl_init();
    //             curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    //             curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    //             curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    //             curl_setopt($chOne, CURLOPT_POST, 1);
    //             curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
    //             curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
    //             curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
    //             $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test . '',);
    //             curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    //             $result = curl_exec($chOne);
    //             if (curl_error($chOne)) {
    //                 echo 'error:' . curl_error($chOne);
    //             } else {
    //                 $result_ = json_decode($result, true);
    //                 // return response()->json([
    //                 //     'status'     => 200 , 
    //                 //     ]);                        
    //             }
    //             curl_close($chOne);
    //         }
    //         return response()->json([
    //             'status'     => 200,
    //         ]);
    //     } else if ($add_img2 == '') {
    //         return response()->json([
    //             'status'     => 60,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status'     => 50,
    //         ]);
    //     }
    // }

    // public function com_staff_cancel(Request $request, $id)
    // {
    //     $update = Com_repaire::find($id);
    //     $update->com_repaire_status = 'confirmcancel';
    //     $update->save();

    //     return response()->json([
    //         'status'     => '200',
    //     ]);
    // }

    public function repaire_tech(Request $request)
    {
        $data['repaire_tech'] = DB::table('repaire_tech')
        ->leftJoin('users', 'users.id', '=', 'repaire_tech.repaire_tech_user_id')
        ->leftJoin('position', 'position.POSITION_ID', '=', 'users.position_id')
        ->get();
        $data['users'] = User::get();
     
        return view('repaire.repaire_tech', $data);
    }

    public function repaire_techsave(Request $request)
    {
        if ($request->repaire_tech_user_id != '' || $request->repaire_tech_user_id != null) {

            $repaire_tech_user_id = $request->repaire_tech_user_id;
            $repaire_techcount = DB::table('repaire_tech')->where('repaire_tech_user_id','=', $repaire_tech_user_id)->count();
            if ($repaire_techcount > 0) {
                return response()->json([
                    'status'     => '100',
                ]);
            } else {
                $number = count($repaire_tech_user_id);
                $count = 0;
                for ($count = 0; $count < $number; $count++) {
                    $iduser = DB::table('users')->where('id', '=', $repaire_tech_user_id[$count])->first();
                    $date = date("Y-m-d H:i:s");
                    DB::table('repaire_tech')->insert([
                        'repaire_tech_user_id' => $iduser->id,
                        'repaire_tech_user_name' => $iduser->fname . ' ' . $iduser->lname,
                        'repaire_tech_user_position' => $iduser->position_name,
                        'created_at' => $date,
                        'updated_at' => $date
                    ]);
                }
                return response()->json([
                    'status'     => '200',
                ]);

            }
            

            
        }
       
    }

    public function repaire_tech_destroy(Request $request, $id)
    {
        $del = Repaire_tech::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    
    public function com_staff_print(Request $request, $id)
    {
     
        $dataedit = Com_repaire::leftJoin('com_repaire_speed', 'com_repaire_speed.status_id', '=', 'com_repaire.com_repaire_speed')
            ->leftjoin('users', 'users.id', '=', 'com_repaire.com_repaire_user_id')
            ->where('com_repaire_id', '=', $id)->first();

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

        $date = date_create($dataedit->created_at);
        $datnow =  date_format($date, "Y-m-j");
 

        $pdf->SetLeftMargin(22);
        $pdf->SetRightMargin(5);
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
        $pdf->SetFont('THSarabunNew Bold', '', 19);
        // $pdf->AddPage("L", ['100', '100']);
        $pdf->AddPage("P");
        $pdf->Image('assets/images/crut.png', 22, 15, 16, 16);
        $pdf->SetFont('THSarabunNew Bold', '', 19);
        $pdf->Text(93, 25, iconv('UTF-8', 'TIS-620', 'ใบแจ้งซ่อม '));
        $pdf->SetFont('THSarabunNew', '', 17);
        $pdf->Text(75, 33, iconv('UTF-8', 'TIS-620', 'โรงพยาบาล ' . $org->orginfo_name));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(25, 41, iconv('UTF-8', 'TIS-620', 'หน่วยงานที่แจ้งซ่อม :   ' . $dataedit->com_repaire_debsubsub_name));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(110, 41, iconv('UTF-8', 'TIS-620', 'เบอร์โทร :   ' . $dataedit->tel));
        // x1,y1,x2,y2
        $pdf->Line(25, 45, 180, 45);   // 25 คือ ย่อหน้า  // 45 คือ margintop   // 180 คือความยาวเส้น 
        $pdf->SetFont('THSarabunNew Bold', '', 14);
        $pdf->Text(25, 52, iconv('UTF-8', 'TIS-620', 'ส่วนที่ 1 ผู้แจ้ง  :  '));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(50, 52, iconv('UTF-8', 'TIS-620', 'รหัสแจ้งซ่อม  :  ' . $dataedit->com_repaire_no));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(100, 52, iconv('UTF-8', 'TIS-620', 'วันที่  :  ' . DateThai($dataedit->com_repaire_date)));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(150, 52, iconv('UTF-8', 'TIS-620', 'เวลา  :  ' . time($dataedit->com_repaire_time). ' น.'));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(25, 60, iconv('UTF-8', 'TIS-620', 'หมายเลขครุภัณฑ์  :  ' . $dataedit->com_repaire_article_num));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(25, 68, iconv('UTF-8', 'TIS-620', 'ชื่อครุภัณฑ์  :  ' . $dataedit->com_repaire_article_name));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(25, 76, iconv('UTF-8', 'TIS-620', 'รายละเอียดแจ้งซ่อม  :  ' . $dataedit->com_repaire_detail));
        // $pdf->SetFont('THSarabunNew', '', 15);
        // $pdf->Text(130, 35, iconv('UTF-8', 'TIS-620', 'วันที่  ' . dayThai($datnow) . '  ' . monthThai($datnow) . '  พ.ศ. ' . yearThai($datnow)));

        //ผู้ขออนุญาต
        if ($siguser != null) { 
            // $pdf->SetTextColor(128);
            // ชิดซ้าย
            // $pdf->Image($siguser, 50, 82, 50, 17, "png");
            // $pdf->SetFont('THSarabunNew', '', 15);
            // $pdf->Text(41, 92, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                        ผู้แจ้งซ่อม'));
            // $pdf->SetFont('THSarabunNew', '', 15);
            // $pdf->Text(55, 102, iconv('UTF-8', 'TIS-620', '(   ' . $dataedit->com_repaire_user_name . '   )'));

            //ตรงกลาง
            $pdf->Image($siguser, 80, 85, 50, 17, "png");
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(71, 95, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                        ผู้แจ้งซ่อม'));
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(85, 105, iconv('UTF-8', 'TIS-620', '(   ' . $dataedit->com_repaire_user_name . '   )'));
        } else {
            // $pdf->Image($sig, 150,220, 40, 20,"png");
        }

        $pdf->Line(25, 110, 180, 110);   // 25 คือ ย่อหน้า  // 45 คือ margintop   // 180 คือความยาวเส้น 
        $pdf->SetFont('THSarabunNew Bold', '', 14);
        $pdf->Text(25, 117, iconv('UTF-8', 'TIS-620', 'ส่วนที่ 2 ช่าง  :  '));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(50, 117, iconv('UTF-8', 'TIS-620', 'รหัสแจ้งซ่อม  :  ' . $dataedit->com_repaire_no));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(100, 117, iconv('UTF-8', 'TIS-620', 'วันที่  :  ' . DateThai($dataedit->com_repaire_date)));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(150, 117, iconv('UTF-8', 'TIS-620', 'เวลา  :  ' . time($dataedit->com_repaire_time). ' น.'));

        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(50, 126, iconv('UTF-8', 'TIS-620', 'ความเร่งด่วน'));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(85, 126, iconv('UTF-8', 'TIS-620', 'ปกติ  '));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(110, 126, iconv('UTF-8', 'TIS-620', 'ด่วน  '));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(135, 126, iconv('UTF-8', 'TIS-620', 'ด่วนมาก  '));
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Text(165, 126, iconv('UTF-8', 'TIS-620', 'ด่วนที่สุด  ')); 
        if ($dataedit->com_repaire_speed == "1") { 
            $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 78, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 103, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 128, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 157, 123, 4, 4);
        }else if ($dataedit->com_repaire_speed == "2") { 
            $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 103, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 78, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 128, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 157, 123, 4, 4);
        }else if ($dataedit->com_repaire_speed == "3") { 
            $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 128, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 103, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 78, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 157, 123, 4, 4);
        } else {
            $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 157, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 103, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 128, 123, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 78, 123, 4, 4);
         }
         $pdf->SetFont('THSarabunNew', '', 14);
         $pdf->Text(25, 136, iconv('UTF-8', 'TIS-620', 'รายละเอียดการตรวจซ่อมที่พบ/ความเห็นของช่าง  ')); 
         $pdf->SetFont('THSarabunNew', '', 14);
         $pdf->Text(90, 136, iconv('UTF-8', 'TIS-620',' :  ' .$dataedit->com_repaire_detail_tech));   
        //ผู้ดูแลอนุญาต
        if ($sigstaff != null) {
            $pdf->Image($sigstaff, 109, 173, 50, 17, "png");
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(100, 188, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                            ผู้อนุญาต'));
            // $pdf->Text(112, 198, iconv('UTF-8', 'TIS-620', '(   ' . $dataedit->car_service_staff_name . '   )'));
        } else {
            // $pdf->Image($siguser, 105,173, 50, 17,"png"); 
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(100, 180, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) ......................................................... ผู้อนุญาต'));
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(108, 189, iconv('UTF-8', 'TIS-620', '( .......................................................... )'));
        }

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(25, 220, iconv('UTF-8', 'TIS-620', 'ความเห็นของผู้มีอำนาจสั่งรถยนต์ '));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(113, 220, iconv('UTF-8', 'TIS-620', 'อนุญาต '));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(150, 220, iconv('UTF-8', 'TIS-620', 'ไม่อนุญาต '));

        if ($sigpo != null) {

            // dd($dataedit->car_service_status);
            if ($dataedit->car_service_status == "noallow") {
                $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 105, 217, 4, 4);
                $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 140, 217, 4, 4);
            } else {
                $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 140, 217, 4.5, 4.5);
                $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 105, 217, 4.5, 4.5);
                // $pdf->Image(base_path('public').'/fpdf/img/checkno.jpg',140,217, 4, 4); 
            }


            $pdf->Image($sigpo, 109, 225, 50, 17, "png");
            $pdf->Text(108, 249, iconv('UTF-8', 'TIS-620', $po));
            // $pdf->Text(150,288,iconv( 'UTF-8','TIS-620','ผู้อำนวยการ'.$orgpo->orginfo_name  ));
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(100, 240, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                              ผู้อนุญาต'));
            // $pdf->SetFont('THSarabunNew','',15);
            // $pdf->Text(108,249,iconv( 'UTF-8','TIS-620','( .......................................................... )' )); 
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(108, 258, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
        } else {
            // $pdf->Image($siguser, 105,225, 50, 17,"png");
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 105, 217, 4, 4);
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 140, 217, 4, 4);
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(100, 240, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) ......................................................... ผู้อนุญาต'));
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(108, 249, iconv('UTF-8', 'TIS-620', '( .......................................................... )'));
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(108, 258, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
        }


        $pdf->Output();

        exit;
    }
 
    public function repaire_req(Request $request)
    {
        $data['q'] = $request->query('q');
        $query = Repaire_req::select('repaire_req.*', 'com_repaire_speed.*','article_data.*')
            ->leftJoin('com_repaire_speed', 'com_repaire_speed.status_id', '=', 'repaire_req.repaire_req_speed')
            ->leftJoin('article_data', 'article_data.article_id', '=', 'repaire_req.repaire_req_article_id')
            ->where(function ($query) use ($data) {
                $query->where('repaire_req_no', 'like', '%' . $data['q'] . '%');
                $query->orwhere('repaire_req_speed', 'like', '%' . $data['q'] . '%');
                $query->orwhere('repaire_req_detail', 'like', '%' . $data['q'] . '%');
                $query->orwhere('repaire_req_article_name', 'like', '%' . $data['q'] . '%');
                $query->orwhere('repaire_req_user_name', 'like', '%' . $data['q'] . '%');
            });
        $data['repaire_req'] = $query->orderBy('repaire_req_id', 'DESC')->get();

        return view('repaire.repaire_req', $data);
    }

    // public function com_qrcode(Request $request,$id)
    // {
    //     $data['users'] = User::get();
    //     $data_article = Article::where('article_id','=',$id)->first();
        

    //     return view('computer.com_qrcode',$data,[
    //         'data_article'       =>       $data_article
    //     ]);
    // }

    // public function com_repair(Request $request)
    // {
    //     $data['department_sub_sub'] = Department_sub_sub::get();
    //     $data['product_decline'] = Product_decline::get();
    //     $data['product_prop'] = Product_prop::get();
    //     $data['supplies_prop'] = DB::table('supplies_prop')->get();
    //     $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
    //     $data['product_data'] = Products::get();
    //     $data['product_category'] = Products_category::get();
    //     $data['product_type'] = Products_type::get();
    //     $data['product_spyprice'] = Product_spyprice::get();
    //     $data['product_group'] = Product_group::get();
    //     $data['product_unit'] = Product_unit::get();
    //     $data['article_data'] = Article::get();
    //     $data['data_province'] = DB::table('data_province')->get();
    //     $data['data_amphur'] = DB::table('data_amphur')->get();
    //     $data['data_tumbon'] = DB::table('data_tumbon')->get();
    //     $data['land_data'] = Land::get();
    //     $data['product_budget'] = Product_budget::get();
    //     $data['product_method'] = Product_method::get();
    //     $data['product_buy'] = Product_buy::get();
    //     $data['building_data'] = Building::leftjoin('product_decline', 'product_decline.decline_id', '=', 'building_data.building_decline_id')->where('building_type_id', '!=', '1')->where('building_type_id', '!=', '5')->orderBy('building_id', 'DESC')->get();
    //     return view('computer.com_repair', $data);
    // }
    // public function com_report(Request $request)
    // {
    //     $data['department_sub_sub'] = Department_sub_sub::get();
    //     $data['product_decline'] = Product_decline::get();
    //     $data['product_prop'] = Product_prop::get();
    //     $data['supplies_prop'] = DB::table('supplies_prop')->get();
    //     $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
    //     $data['product_data'] = Products::get();
    //     $data['product_category'] = Products_category::get();
    //     $data['product_type'] = Products_type::get();
    //     $data['product_spyprice'] = Product_spyprice::get();
    //     $data['product_group'] = Product_group::get();
    //     $data['product_unit'] = Product_unit::get();
    //     $data['article_data'] = Article::get();
    //     $data['data_province'] = DB::table('data_province')->get();
    //     $data['data_amphur'] = DB::table('data_amphur')->get();
    //     $data['data_tumbon'] = DB::table('data_tumbon')->get();
    //     $data['land_data'] = Land::get();
    //     $data['product_budget'] = Product_budget::get();
    //     $data['product_method'] = Product_method::get();
    //     $data['product_buy'] = Product_buy::get();
    //     $data['building_data'] = Building::leftjoin('product_decline', 'product_decline.decline_id', '=', 'building_data.building_decline_id')->where('building_type_id', '!=', '1')->where('building_type_id', '!=', '5')->orderBy('building_id', 'DESC')->get();
    //     return view('computer.com_report', $data);
    // }
    // *************Dom pdf*********************//
    // public function createPDF()
    // {
    //     // retreive all records from db
    //     $data = User::all();
    //     // share data to view
    //     // view()->share('employee',$data);
    //     $pdf = PDF::loadView('computer/pdf_view', [
    //         'data'  =>  $data
    //     ]);
    //     // download PDF file with download method
    //     // return $pdf->download('pdf_file.pdf');
    //     return @$pdf->stream();
    // }

    // *************FPDI pdf*********************//
    // public function createFPDI(Request $request)
    // {
    //     define('FPDF_FONTPATH', 'font/');
    //     require(base_path('public') . "/fpdf/WriteHTML.php");

    //     $pdf = new Fpdi(); // Instantiation   start-up Fpdi

    //     function dayThai($strDate)
    //     {
    //         $strDay = date("j", strtotime($strDate));
    //         return $strDay;
    //     }
    //     function monthThai($strDate)
    //     {
    //         $strMonth = date("n", strtotime($strDate));
    //         $strMonthCut = array("", "มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    //         $strMonthThai = $strMonthCut[$strMonth];
    //         return $strMonthThai;
    //     }
    //     function yearThai($strDate)
    //     {
    //         $strYear = date("Y", strtotime($strDate)) + 543;
    //         return $strYear;
    //     }
    //     function time($strtime)
    //     {
    //         $H = substr($strtime, 0, 5);
    //         return $H;
    //     }
    //     $datnow =  date("Y-m-j");

    //     $pdf->SetLeftMargin(22);
    //     $pdf->SetRightMargin(5);
    //     $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
    //     $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
    //     $pdf->SetFont('THSarabunNew Bold', '', 19);
    //     // $pdf->AddPage("L", ['100', '100']);
    //     $pdf->AddPage("P");
    //     $pdf->Text(70, 25, iconv('UTF-8', 'TIS-620', 'แบบฟอร์มขออนุญาตใช้รถส่วนกลาง '));
    //     $pdf->SetFont('THSarabunNew', '', 15);
    //     $pdf->Text(130, 35, iconv('UTF-8', 'TIS-620', 'วันที่  ' . dayThai($datnow) . '  เดือน' . monthThai($datnow) . '  พ.ศ. ' . yearThai($datnow)));
    //     $pdf->SetFont('THSarabunNew Bold', '', 15);

    //     $pdf->Output();

    //     exit;
    // }

    // public function com_maintenance (Request $request, $id)
    // {    
    //     $data['com_tec'] = Com_tec::get();
    //     $data['com_repaire_speed'] = DB::table('com_repaire_speed')->get();
    //     $y = date('Y') + 543;
    //     $m = date('m');
    //     $d = date('d');
    //     $lot = $y . '' . $m . '' . $d;
    //     // dd($y);
    //     $data['budget_year'] = Budget_year::get();
    //     $dataedit = Article::where('article_categoryid', '=', '38')->where('article_status_id', '=', '1')->first();

    //     return view('computer.com_maintenance ', $data, [
    //         'dataedits'   => $dataedit,
           
    //     ]);
    // }

}
