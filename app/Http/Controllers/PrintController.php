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
use App\Models\Car_service;
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

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Exports\Otform1Export;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class PrintController extends Controller
{     
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
     

        //ผู้ขออนุญาต
        if ($siguser != null) { 
          
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
 
    // *************Dom pdf*********************//
    public function otone_from1()
    { 
        $data = User::all(); 
        $pdf = PDF::loadView('ot/otone_from1', [
            'data'  =>  $data
        ]); 
        return @$pdf->stream();
        // define('FPDF_FONTPATH', 'font/');
        // require(base_path('public') . "/fpdf/WriteHTML.php");

        // $pdf = new Fpdi(); // Instantiation   start-up Fpdi

        // function dayThai($strDate)
        // {
        //     $strDay = date("j", strtotime($strDate));
        //     return $strDay;
        // }
        // function monthThai($strDate)
        // {
        //     $strMonth = date("n", strtotime($strDate));
        //     $strMonthCut = array("", "มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        //     $strMonthThai = $strMonthCut[$strMonth];
        //     return $strMonthThai;
        // }
        // function yearThai($strDate)
        // {
        //     $strYear = date("Y", strtotime($strDate)) + 543;
        //     return $strYear;
        // }
        // function time($strtime)
        // {
        //     $H = substr($strtime, 0, 5);
        //     return $H;
        // }

        // function DateThai($strDate)
        // {
        //     if ($strDate == '' || $strDate == null || $strDate == '0000-00-00') {
        //         $datethai = '';
        //     } else {
        //         $strYear = date("Y", strtotime($strDate)) + 543;
        //         $strMonth = date("n", strtotime($strDate));
        //         $strDay = date("j", strtotime($strDate));
        //         $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        //         $strMonthThai = $strMonthCut[$strMonth];
        //         $datethai = $strDate ? ($strDay . ' ' . $strMonthThai . ' ' . $strYear) : '-';
        //     }
        //     return $datethai;
        // }

        // $date = date_create($dataedit->created_at);
        // $datnow =  date_format($date, "Y-m-j");
 
        // $pdf->SetLeftMargin(22);
        // $pdf->SetRightMargin(5);
        // $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        // $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
        // $pdf->SetFont('THSarabunNew Bold', '', 19);
 
        // $pdf->AddPage("P");
        // $pdf->Image('assets/images/crut.png', 22, 15, 16, 16);
        // $pdf->SetFont('THSarabunNew Bold', '', 19);
        // $pdf->Text(93, 25, iconv('UTF-8', 'TIS-620', 'ใบแจ้งซ่อม '));
        // $pdf->SetFont('THSarabunNew', '', 17);
        // $pdf->Text(75, 33, iconv('UTF-8', 'TIS-620', 'โรงพยาบาล ' . $org->orginfo_name));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(25, 41, iconv('UTF-8', 'TIS-620', 'หน่วยงานที่แจ้งซ่อม :   ' . $dataedit->com_repaire_debsubsub_name));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(110, 41, iconv('UTF-8', 'TIS-620', 'เบอร์โทร :   ' . $dataedit->tel));
 
        // $pdf->Line(25, 45, 180, 45);   // 25 คือ ย่อหน้า  // 45 คือ margintop   // 180 คือความยาวเส้น 
        // $pdf->SetFont('THSarabunNew Bold', '', 14);
        // $pdf->Text(25, 52, iconv('UTF-8', 'TIS-620', 'ส่วนที่ 1 ผู้แจ้ง  :  '));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(50, 52, iconv('UTF-8', 'TIS-620', 'รหัสแจ้งซ่อม  :  ' . $dataedit->com_repaire_no));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(100, 52, iconv('UTF-8', 'TIS-620', 'วันที่  :  ' . DateThai($dataedit->com_repaire_date)));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(150, 52, iconv('UTF-8', 'TIS-620', 'เวลา  :  ' . time($dataedit->com_repaire_time). ' น.'));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(25, 60, iconv('UTF-8', 'TIS-620', 'หมายเลขครุภัณฑ์  :  ' . $dataedit->com_repaire_article_num));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(25, 68, iconv('UTF-8', 'TIS-620', 'ชื่อครุภัณฑ์  :  ' . $dataedit->com_repaire_article_name));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(25, 76, iconv('UTF-8', 'TIS-620', 'รายละเอียดแจ้งซ่อม  :  ' . $dataedit->com_repaire_detail));
      
        // $pdf->Line(25, 110, 180, 110);   // 25 คือ ย่อหน้า  // 45 คือ margintop   // 180 คือความยาวเส้น 
        // $pdf->SetFont('THSarabunNew Bold', '', 14);
        // $pdf->Text(25, 117, iconv('UTF-8', 'TIS-620', 'ส่วนที่ 2 ช่าง  :  '));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(50, 117, iconv('UTF-8', 'TIS-620', 'รหัสแจ้งซ่อม  :  ' . $dataedit->com_repaire_no));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(100, 117, iconv('UTF-8', 'TIS-620', 'วันที่  :  ' . DateThai($dataedit->com_repaire_date)));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(150, 117, iconv('UTF-8', 'TIS-620', 'เวลา  :  ' . time($dataedit->com_repaire_time). ' น.'));

        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(50, 126, iconv('UTF-8', 'TIS-620', 'ความเร่งด่วน'));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(85, 126, iconv('UTF-8', 'TIS-620', 'ปกติ  '));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(110, 126, iconv('UTF-8', 'TIS-620', 'ด่วน  '));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(135, 126, iconv('UTF-8', 'TIS-620', 'ด่วนมาก  '));
        // $pdf->SetFont('THSarabunNew', '', 14);
        // $pdf->Text(165, 126, iconv('UTF-8', 'TIS-620', 'ด่วนที่สุด  ')); 
    }

    public function otone_from2()
    { 
        $data = User::all(); 
        $pdf = PDF::loadView('ot/otone_from2', [
            'data'  =>  $data
        ]); 
        return @$pdf->stream();
    }
    public function otone_from3()
    { 
        $data = User::all(); 
        $pdf = PDF::loadView('ot/otone_from3', [
            'data'  =>  $data
        ]); 
        return @$pdf->stream();
    }

    // *************FPDI pdf*********************//
    public function createFPDI(Request $request)
    {
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
        $datnow =  date("Y-m-j");

        $pdf->SetLeftMargin(22);
        $pdf->SetRightMargin(5);
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
        $pdf->SetFont('THSarabunNew Bold', '', 19);
        // $pdf->AddPage("L", ['100', '100']);
        $pdf->AddPage("P");
        $pdf->Text(70, 25, iconv('UTF-8', 'TIS-620', 'แบบฟอร์มขออนุญาตใช้รถส่วนกลาง '));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(130, 35, iconv('UTF-8', 'TIS-620', 'วันที่  ' . dayThai($datnow) . '  เดือน' . monthThai($datnow) . '  พ.ศ. ' . yearThai($datnow)));
        $pdf->SetFont('THSarabunNew Bold', '', 15);

        $pdf->Output();

        exit;
    }
    // public function export_otform1 (Request $request)
    // {
    //     $data = new Otform1Export;
    //     return Excel::download( $data,'Otform1Export.xlsx');
    // }
    public function export_otform1 (Request $request,$start,$end,$reqsend,$iddep)
    {
        // $datestart = $request->startdate;
        // $dateend = $request->enddate;
        // $iddep =  Auth::user()->dep_subsubtrueid;
        
        // $reqsend = $request->ot_type_pk;
        
        if ($reqsend != '') {
            if ($reqsend == 2) {
             
                $ot_one = DB::connection('mysql')->select('
                    select o.ot_one_id,o.ot_one_date,o.ot_one_starttime,o.ot_one_endtime
                        ,o.ot_one_nameid,o.ot_one_fullname,o.ot_one_detail,o.ot_one_sign,o.ot_one_sign2
                        ,o.dep_subsubtrueid,de.DEPARTMENT_SUB_SUB_NAME,u.users_group_id,up.prefix_name
                        ,u.fname,u.lname

                        from ot_one o
                        left outer join users u on u.id = o.ot_one_nameid 
                        left outer join users_prefix up on up.prefix_code = u.pname  
                        left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = o.dep_subsubtrueid

                        where o.dep_subsubtrueid = "'.$iddep.'" 
                        AND u.users_group_id in("5","6","7")
                        AND o.ot_one_date between "'.$start.'" AND "'.$end.'"   
                        order by o.ot_one_date asc       
                ');
            }else if($reqsend == 1) {
                $ot_one = DB::connection('mysql')->select('
                select o.ot_one_id,o.ot_one_date,o.ot_one_starttime,o.ot_one_endtime
                    ,o.ot_one_nameid,o.ot_one_fullname,o.ot_one_detail,o.ot_one_sign,o.ot_one_sign2
                    ,o.dep_subsubtrueid,de.DEPARTMENT_SUB_SUB_NAME,u.users_group_id,up.prefix_name
                    ,u.fname,u.lname

                    from ot_one o
                    left outer join users u on u.id = o.ot_one_nameid 
                    left outer join users_prefix up on up.prefix_code = u.pname  
                    left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = o.dep_subsubtrueid

                    where o.dep_subsubtrueid = "'.$iddep.'" 
                    AND u.users_group_id in("1","2","3","4")
                    AND o.ot_one_date between "'.$start.'" AND "'.$end.'"     
                    order by o.ot_one_date asc      
            ');
            } else {
                
            }
            // dd($req);           
           
        } else {           
            
            $reqsend == '';
        }
 

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();
        $datadepartment_sub_sub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$iddep)->first();
        $dataorginfo = DB::table('orginfo')->where('orginfo_id','=',1)->first();

        return view('ot.export_otform1', $data,[
            'start' => $start,
            'end' => $end,
            'reqsend' => $reqsend,
            'ot_one'  =>  $ot_one,
            'datadepartment_sub_sub'   => $datadepartment_sub_sub,
            'dataorginfo'   =>  $dataorginfo
        ]);
    }

    public function export_otform3 (Request $request,$start,$end,$reqsend,$iddep)
    {
        // $datestart = $request->startdate;
        // $dateend = $request->enddate;
        // $iddep =  Auth::user()->dep_subsubtrueid;        
        // $reqsend = $request->ot_type_pk;        
        if ($reqsend != '') {
            if ($reqsend == 2) {
             
                $ot_one = DB::connection('mysql')->select('
                    select o.ot_one_id,o.ot_one_date,o.ot_one_starttime,o.ot_one_endtime
                        ,o.ot_one_nameid,o.ot_one_fullname,o.ot_one_detail,o.ot_one_sign,o.ot_one_sign2
                        ,o.dep_subsubtrueid,de.DEPARTMENT_SUB_SUB_NAME,u.users_group_id,up.prefix_name
                        ,u.fname,u.lname

                        from ot_one o
                        left outer join users u on u.id = o.ot_one_nameid 
                        left outer join users_prefix up on up.prefix_code = u.pname  
                        left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = o.dep_subsubtrueid

                        where o.dep_subsubtrueid = "'.$iddep.'" 
                        AND u.users_group_id in("5","6","7")
                        AND o.ot_one_date between "'.$start.'" AND "'.$end.'"  
                        order by o.ot_one_date asc        
                ');
            }else if($reqsend == 1) {
                $ot_one = DB::connection('mysql')->select('
                select o.ot_one_id,o.ot_one_date,o.ot_one_starttime,o.ot_one_endtime
                    ,o.ot_one_nameid,o.ot_one_fullname,o.ot_one_detail,o.ot_one_sign,o.ot_one_sign2
                    ,o.dep_subsubtrueid,de.DEPARTMENT_SUB_SUB_NAME,u.users_group_id,up.prefix_name
                    ,u.fname,u.lname

                    from ot_one o
                    left outer join users u on u.id = o.ot_one_nameid 
                    left outer join users_prefix up on up.prefix_code = u.pname  
                    left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = o.dep_subsubtrueid

                    where o.dep_subsubtrueid = "'.$iddep.'" 
                    AND u.users_group_id in("1","2","3","4")
                    AND o.ot_one_date between "'.$start.'" AND "'.$end.'"   
                    order by o.ot_one_date asc       
            ');
            } else {
                
            } 
        } else {    
            $reqsend == '';
        } 

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();
        $datadepartment_sub_sub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$iddep)->first();
        $dataorginfo = DB::table('orginfo')->where('orginfo_id','=',1)->first();
        $depuser = DB::table('users')
        ->leftjoin('department','department.DEPARTMENT_ID','=','users.dep_id')
        ->where('dep_subsubtrueid','=',$iddep)->first();
        

        return view('ot.export_otform3', $data,[
            'start' => $start,
            'end' => $end,
            'reqsend' => $reqsend,
            'ot_one'  =>  $ot_one,
            'datadepartment_sub_sub'   => $datadepartment_sub_sub,
            'dataorginfo'   =>  $dataorginfo,
            'depuser'       =>  $depuser
        ]);
    }

    public function export_otform4 (Request $request,$start,$end,$reqsend,$iddep)
    { 
                if ($reqsend != '') {
                    if ($reqsend == 2) {
                    
                        $usershow = DB::connection('mysql')->select('
                        select  u.id,u.fname,u.lname,u.cid,u.users_group_id,u.dep_subsubtrueid
                        from users u 
                        left outer join users_prefix up on up.prefix_code = u.pname                               
                        where u.dep_subsubtrueid = "'.$iddep.'" 
                        AND u.users_group_id in("5","6","7") 
                        AND u.status = "1"
                         
                        ');
                    }else if($reqsend == 1) {
                        $usershow = DB::connection('mysql')->select('
                        select  u.id,u.fname,u.lname,u.cid,u.users_group_id,u.dep_subsubtrueid
                                from users u 
                                left outer join users_prefix up on up.prefix_code = u.pname                               
                                where u.dep_subsubtrueid = "'.$iddep.'" 
                                AND u.users_group_id in("1","2","3","4") 
                                AND u.status = "1"
                        ');
                } else {
                    
                }
            
                // $ot_one = DB::connection('mysql')->select('
                            // select o.ot_one_id,o.ot_one_date,o.ot_one_starttime,o.ot_one_endtime
                            //     ,o.ot_one_nameid,o.ot_one_fullname,o.ot_one_detail,o.ot_one_sign,o.ot_one_sign2
                            //     ,o.dep_subsubtrueid,de.DEPARTMENT_SUB_SUB_NAME,u.users_group_id,up.prefix_name
                            //     ,u.fname,u.lname,u.id

                            //     from ot_one o
                            //     left outer join users u on u.id = o.ot_one_nameid 
                            //     left outer join users_prefix up on up.prefix_code = u.pname  
                            //     left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = o.dep_subsubtrueid

                            //     where o.dep_subsubtrueid = "'.$iddep.'" 
                            //     AND u.users_group_id in("5","6","7")
                            //     AND o.ot_one_date between "'.$start.'" AND "'.$end.'"  
                                // group by id 
                //         ');

 
                $data['users'] = User::get();
                $data['leave_month'] = DB::table('leave_month')->get();
                $data['users_group'] = DB::table('users_group')->get();
                $data['ot_type_pk'] = DB::table('ot_type_pk')->get();
                $datadepartment_sub_sub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$iddep)->first();
                $dataorginfo = DB::table('orginfo')->where('orginfo_id','=',1)->first();
                $depuser = DB::table('users')
                ->leftjoin('department','department.DEPARTMENT_ID','=','users.dep_id')
                ->where('dep_subsubtrueid','=',$iddep)->first();

                $dateshow = date('Y-m-d');
                $strYear = date("Y", strtotime($dateshow)) + 543;
                $strM = date('m', strtotime($dateshow));
                $strD = date('d', strtotime($dateshow));

                // dd($strD);

                return view('ot.export_otform4', $data,[ 
                    'start' => $start,
                    'end'  =>  $end,
                    'reqsend' => $reqsend,
                    'usershow'  =>  $usershow,
                    'datadepartment_sub_sub'   => $datadepartment_sub_sub,
                    'dataorginfo'   =>  $dataorginfo,
                    'depuser'       =>  $depuser
                ]);
            }
        }
   
}
