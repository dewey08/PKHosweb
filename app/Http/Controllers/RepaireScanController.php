<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
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

class RepaireScanController extends Controller
{  
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('com_repaire')->max('com_repaire_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('com_repaire')->where('com_repaire_id', '=', $maxnumber)->first();
            if ($refmax->com_repaire_no != '' ||  $refmax->com_repaire_no != null) {
                $maxref = substr($refmax->com_repaire_no, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = 'COM' . '-' . $ref;
        return $refnumber;
    }
    public function com_repair_add (Request $request, $id)
    {    
        $data['com_tec'] = Com_tec::get();  
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['users'] = User::get();
        $data['com_repaire_speed'] = DB::table('com_repaire_speed')->get();
        $y = date('Y')+543;
        $m = date('m');
        $d = date('d');
        $lot = $y.''.$m.''.$d;
        // dd($y);
        $data['budget_year'] = Budget_year::where('leave_year_id', '=',$y)->get();
        $dataedit = Article::where('article_id', '=',$id)->where('article_status_id', '=', '1')->first();
        $data['article_data'] = Article::where('article_categoryid', '=','38')->get();


        return view('computer.com_repair_add ', $data, [
            'dataedits'   => $dataedit,           
        ]);
    }
    public function com_repairscan_save(Request $request)
    { 
        date_default_timezone_set('Asia/Bangkok');
        $iduser = $request->com_repaire_user_id;  
        $add_img = $request->input('signature'); 
        $no = $request->com_repaire_no;
        $datetart = $request->com_repaire_date;
        $time = $request->com_repaire_time;
        $speed = $request->com_repaire_speed;
        $detail = $request->com_repaire_detail;
        $article = $request->article_id;

        if ($add_img != '') { 
                $add = new Com_repaire();
                $add->com_repaire_no = $no;
                $add->com_repaire_date = $datetart;
                $add->com_repaire_time = $time;
                $add->com_repaire_speed = $speed;
                $add->com_repaire_detail = $detail; 
                $add->com_repaire_status = 'notifyrepair'; 
                $add->com_repaire_year = $request->com_repaire_year;

                if ($iduser != '') {
                    $usave = DB::table('users')->where('id', '=', $iduser)->first(); 
                    $add->com_repaire_user_id = $usave->id;
                    $add->com_repaire_user_name = $usave->fname . ' ' . $usave->lname;
                    $add->com_repaire_debsubsub_id = $usave->dep_subsubtrueid;
                    $add->com_repaire_debsubsub_name = $usave->dep_subsubtruename;
                } else {
                    $add->com_repaire_user_id = '';
                    $add->com_repaire_user_name = '';
                    $add->com_repaire_debsubsub_id = '';
                    $add->com_repaire_debsubsub_name = '';
                }   
                 
                
                if ($article != '') {
                    $arsave = DB::table('article_data')->where('article_id', '=', $article)->first(); 
                    $add->com_repaire_article_id = $arsave->article_id;
                    $add->com_repaire_article_name = $arsave->article_name; 
                } else {
                    $add->com_repaire_article_id = '';
                    $add->com_repaire_article_name = ''; 
                }    

                $add->save();
                      
                $minnoid = Com_repaire::max('com_repaire_id');

                $add2 = new Com_repaire_signature();
                $add2->com_repaire_id = $minnoid;
                $add2->com_repaire_no =$no;
                $add2->signature_name_usertext =$add_img;
                $add2->save();

  
                    //แจ้งเตือน 
                    function DateThailine($strDate)
                    {
                        $strYear = date("Y",strtotime($strDate))+543;
                        $strMonth= date("n",strtotime($strDate));
                        $strDay= date("j",strtotime($strDate));
                
                        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                        $strMonthThai=$strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear";
                    }

                    $header = "แจ้งซ่อมคอมพิวเตอร์";    
                    $linegroup = DB::table('line_token')->where('line_token_id','=',6)->first(); 
                    $line = $linegroup->line_token_code;
 
                    $link = DB::table('orginfo')->where('orginfo_id','=',1)->first(); 
                    $link_line = $link->orginfo_link;
                    
                    $datesend = date('Y-m-d');
                    $sendate = DateThailine($datesend);

                    $user = DB::table('users')->where('id', '=', $iduser)->first(); 

                    $speedd = DB::table('com_repaire_speed')->where('status_id','=',$speed)->first(); 
                    $speedname = $speedd->status_name;

                    function formatetime($strtime)
                    {
                    $H = substr($strtime, 0, 5);
                    return $H;
                    }

                    $message = $header.
                        "\n"."รหัสแจ้งซ่อม : " . $no .
                        "\n"."ความเร่งด่วน : " . $speedname.
                        "\n"."วันที่แจ้ง : " . DateThailine($datetart) .
                        "\n"."เวลา : " . formatetime($time).                                       
                        "\n"."ผู้แจ้ง : " . $user->fname . ' ' . $user->lname.    
                        "\n"."หน่วยงาน : " . $user->dep_subsubtruename. 
                        "\n"."รายละเอียด : " . $detail; 
 
                        $linesend = $line;       
                        if($linesend == null){
                            $test ='';
                        }else{
                            $test = $linesend;
                        }

                    if($test !== '' && $test !== null){  
                            $chOne = curl_init();
                            curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                            curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt( $chOne, CURLOPT_POST, 1);
                            curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                            curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                            curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                            $result = curl_exec( $chOne );
                            if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                            else { 
                                $result_ = json_decode($result, true); 
                                // return response()->json([
                                //     'status'     => 200 , 
                                //     ]);                        
                        }
                            curl_close( $chOne );                            
                    }
                    return response()->json([
                        'status'     => 200 , 
                        ]); 
                   
        } else {
            return response()->json([
                'status'     => '50',
            ]);
        }
 
    }

}
