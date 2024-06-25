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
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Position;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
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
use App\Models\Department_sub_sub;
use App\Models\Article;
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Building_level;
use App\Models\Building_level_room;
use App\Models\Building_room_type;
use App\Models\Building_room_status;
use App\Models\Building_room_list;
use App\Models\Food_list;
use App\Models\Meeting_list;
use App\Models\Meeting_objective;
use App\Models\Budget_year;
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
use DataTables;
use PDF;
use Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
date_default_timezone_set("Asia/Bangkok");

class UsercomController extends Controller
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

    public function com_calenda(Request $request)
    {
        $data['article_data'] = Article::where('article_decline_id', '=', '6')->where('article_categoryid', '=', '26')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['car_location'] = Car_location::get();
        $ye = date('Y');
        $y = date('Y')+543;
        $m = date('m');
        $d = date('d');
        $lotthai = $y.'-'.$m.'-'.$d;
        $loten = $ye.'-'.$m.'-'.$d;
        // dd($loten);
        $data['budget_year'] = Budget_year::where('leave_year_id', '=',$y)->get();
        $data['car_status'] = Car_status::where('car_status_code', '=', 'allocate')->orwhere('car_status_code', '=', 'allocateall')->orwhere('car_status_code', '=', 'confirmcancel')->get();
        $data['users'] = User::get();
        $data['car_drive'] = Car_drive::get();

        $event = array();
        $coms = Com_repaire::all();
        // $carservicess = Car_service::where('car_service_article_id','=',$id)->get(); 
        foreach ($coms as $item) {

            if ($item->com_repaire_status == 'notifyrepair') {
                $color = '#F48506';
            } elseif ($item->com_repaire_status == 'carry_out') {
                $color = '#592DF7';
            } elseif ($item->com_repaire_status == 'waiting') {
                $color = '#07D79E';
            } elseif ($item->com_repaire_status == 'cancel') {
                $color = '#ff0606';
            } elseif ($item->com_repaire_status == 'confirmcancel') {
                $color = '#ab9e9e';
            } elseif ($item->com_repaire_status == 'sendout') {
                $color = '#E80DEF';
            } else {
                $color = '#3CDF44';
            }
            $datestart = $item->com_repaire_date;
            // $dateend = $item->car_service_date; 
            // $NewendDate = date("Y-m-d", strtotime("1 day", strtotime($dateend)));

            // $datestart=date('H:m');
            $timestart = $item->car_service_length_gotime;
            $timeend = $item->car_service_length_backtime;
            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);

            $showtitle = $item->com_repaire_debsubsub_name;

            $event[] = [
                'id' => $item->com_repaire_id,
                'title' => $showtitle, 
                'start' => $datestart,
                // 'end' => $dateend,
                'color' => $color
            ];
        }

        return view('user_com.com_calenda', $data, [
            'events'     =>  $event,
            // 'dataedits'  =>  $dataedit
        ]);
    }

    public function repair_com_calenda(Request $request)
    {
        $data['article_data'] = Article::where('article_decline_id', '=', '6')->where('article_categoryid', '=', '26')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['car_location'] = Car_location::get();
        $ye = date('Y');
        $y = date('Y')+543;
        $m = date('m');
        $d = date('d');
        $lotthai = $y.'-'.$m.'-'.$d;
        $loten = $ye.'-'.$m.'-'.$d;
        // dd($loten);
        $data['budget_year'] = Budget_year::where('leave_year_id', '=',$y)->get();
        $data['car_status'] = Car_status::where('car_status_code', '=', 'allocate')->orwhere('car_status_code', '=', 'allocateall')->orwhere('car_status_code', '=', 'confirmcancel')->get();
        $data['users'] = User::get();
        $data['car_drive'] = Car_drive::get();

        $event = array();
        $coms = Com_repaire::all();
        // $carservicess = Car_service::where('car_service_article_id','=',$id)->get(); 
        foreach ($coms as $item) {

            if ($item->com_repaire_status == 'notifyrepair') {
                $color = '#F48506';
            } elseif ($item->com_repaire_status == 'carry_out') {
                $color = '#592DF7';
            } elseif ($item->com_repaire_status == 'waiting') {
                $color = '#07D79E';
            } elseif ($item->com_repaire_status == 'cancel') {
                $color = '#ff0606';
            } elseif ($item->com_repaire_status == 'confirmcancel') {
                $color = '#ab9e9e';
            } elseif ($item->com_repaire_status == 'sendout') {
                $color = '#E80DEF';
            } else {
                $color = '#3CDF44';
            }
            $datestart = $item->com_repaire_date; 
            $timestart = $item->car_service_length_gotime;
            $timeend = $item->car_service_length_backtime;   
            $showtitle = $item->com_repaire_debsubsub_name; 
            $event[] = [
                'id' => $item->com_repaire_id,
                'title' => $showtitle, 
                'start' => $datestart, 
                'color' => $color
            ];
        }

        return view('user_com.com_calenda', $data, [
            'events'     =>  $event,
            // 'dataedits'  =>  $dataedit
        ]);
    }

    public function repair_com(Request $request)
    {   
        $iddebsubsub = Auth::user()->dep_subsubtrueid;
        $data['q'] = $request->query('q');
        $query = Com_repaire::select('com_repaire.*', 'com_repaire_speed.*','article_data.*')
        ->leftJoin('com_repaire_speed', 'com_repaire_speed.status_id', '=', 'com_repaire.com_repaire_speed')
        ->leftJoin('article_data', 'article_data.article_id', '=', 'com_repaire.com_repaire_article_id')
        ->where(function ($query) use ($data){
            $query->where('com_repaire_no','like','%'.$data['q'].'%');
            $query->orwhere('com_repaire_speed','like','%'.$data['q'].'%');
            $query->orwhere('com_repaire_detail','like','%'.$data['q'].'%');
            $query->orwhere('com_repaire_article_name','like','%'.$data['q'].'%');
            $query->orwhere('com_repaire_user_name','like','%'.$data['q'].'%');
        })
        ->where('com_repaire_debsubsub_id','=',$iddebsubsub);
        $data['com_repaire'] = $query->orderBy('com_repaire_id','DESC')->get();                       
        return view('user_com.repair_com',$data);
    }

    public function repair_com_add(Request $request)
    {   
        $data['car_service'] = Car_service::all();
        $data['com_repaire_speed'] = DB::table('com_repaire_speed')->get();
        $y = date('Y')+543;
        $m = date('m');
        $d = date('d');
        $lot = $y.''.$m.''.$d;
        // dd($y);
        $data['budget_year'] = Budget_year::where('leave_year_id', '=',$y)->get();
        $data['article_data'] = Article::where('article_categoryid', '=','38')->get();

        return view('user_com.repair_com_add',$data);
    }

    public function repair_com_cancel(Request $request,$id)
    { 
        $update = Com_repaire::find($id);  
        $update->com_repaire_status = 'cancel'; 
        $update->save();
        
        return response()->json([
            'status'     => '200',
        ]);
    }
 public function repair_com_save(Request $request)
    { 
        date_default_timezone_set('Asia/Bangkok');
        $iduser = $request->user_id;  
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

                    function formatetime($strtime)
                    {
                    $H = substr($strtime, 0, 5);
                    return $H;
                    }

                    $message = $header.
                        "\n"."รหัสแจ้งซ่อม : " . $no .
                        "\n"."ความเร่งด่วน : " . $speed.
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

    public function repair_com_edit(Request $request,$id)
    {   
        $dataedit = Com_repaire::where('com_repaire_id','=',$id)->first();
        $sig = Com_repaire_signature::where('com_repaire_id','=',$id)->first();
        $signat = $sig->signature_name_usertext;

        $signature = base64_encode(file_get_contents($signat));
        // dd($signature);

        $data['car_service'] = Car_service::all();
        $data['com_repaire_speed'] = DB::table('com_repaire_speed')->get();
        $y = date('Y')+543;
        $m = date('m');
        $d = date('d');
        $lot = $y.''.$m.''.$d;
        // dd($y);
        $data['budget_year'] = Budget_year::get();

        return view('user_com.repair_com_edit',$data,[
            'dataedits'   => $dataedit,
            'signature'   => $signature
        ]);
    }

    public function repair_com_update(Request $request)
    { 
        date_default_timezone_set('Asia/Bangkok');
        $iduser = $request->user_id;  
        $add_img = $request->input('signature'); 
        $no = $request->com_repaire_no;
        $datetart = $request->com_repaire_date;
        $time = $request->com_repaire_time;
        $speed = $request->com_repaire_speed;
        $detail = $request->com_repaire_detail;
        $id = $request->com_repaire_id;
        $article = $request->article_id;

        if ($add_img != '') { 

                $update = Com_repaire::find($id);
                $update->com_repaire_no = $no;
                $update->com_repaire_date = $datetart;
                $update->com_repaire_time = $time;
                $update->com_repaire_speed = $speed;
                $update->com_repaire_detail = $detail; 
                // $update->com_repaire_status = 'request'; 
                $update->com_repaire_year = $request->com_repaire_year;
              

                if ($iduser != '') {
                    $usave = DB::table('users')->where('id', '=', $iduser)->first(); 
                    $update->com_repaire_user_id = $usave->id;
                    $update->com_repaire_user_name = $usave->fname . ' ' . $usave->lname;
                    $update->com_repaire_debsubsub_id = $usave->dep_subsubtrueid;
                    $update->com_repaire_debsubsub_name = $usave->dep_subsubtruename;
                } else {
                    $update->com_repaire_user_id = '';
                    $update->com_repaire_user_name = '';
                    $update->com_repaire_debsubsub_id = '';
                    $update->com_repaire_debsubsub_name = '';
                }   

                if ($article != '') {
                    $arsave = DB::table('article_data')->where('article_id', '=', $article)->first(); 
                    $update->com_repaire_article_id = $arsave->article_id;
                    $update->com_repaire_article_name = $arsave->article_name; 
                } else {
                    $update->com_repaire_article_id = '';
                    $update->com_repaire_article_name = ''; 
                }   
                $update->save();                     

                Com_repaire_signature::where('com_repaire_id', $id)
                    ->update([ 
                                'com_repaire_no' => $no,
                                'signature_name_usertext' => $add_img
                    ]);
                    

  
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

                    function formatetime($strtime)
                    {
                    $H = substr($strtime, 0, 5);
                    return $H;
                    }

                    $message = $header.
                        "\n"."รหัสแจ้งซ่อม : " . $no .
                        "\n"."ความเร่งด่วน : " . $speed.
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
            $update = Com_repaire::find($id);
                $update->com_repaire_no = $no;
                $update->com_repaire_date = $datetart;
                $update->com_repaire_time = $time;
                $update->com_repaire_speed = $speed;
                $update->com_repaire_detail = $detail; 
                // $update->com_repaire_status = 'request'; 
                $update->com_repaire_year = $request->com_repaire_year;

                if ($iduser != '') {
                    $usave = DB::table('users')->where('id', '=', $iduser)->first(); 
                    $update->com_repaire_user_id = $usave->id;
                    $update->com_repaire_user_name = $usave->fname . ' ' . $usave->lname;
                    $update->com_repaire_debsubsub_id = $usave->dep_subsubtrueid;
                    $update->com_repaire_debsubsub_name = $usave->dep_subsubtruename;
                } else {
                    $update->com_repaire_user_id = '';
                    $update->com_repaire_user_name = '';
                    $update->com_repaire_debsubsub_id = '';
                    $update->com_repaire_debsubsub_name = '';
                }   
                $update->save();                     

                // Com_repaire_signature::where('com_repaire_id', $id)
                //     ->update([ 
                //                 'com_repaire_no' => $no,
                //                 'signature_name_usertext' => $add_img
                //     ]);
                    
  
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

                    function formatetime($strtime)
                    {
                    $H = substr($strtime, 0, 5);
                    return $H;
                    }

                    $message = $header.
                        "\n"."รหัสแจ้งซ่อม : " . $no .
                        "\n"."ความเร่งด่วน : " . $speed.
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
        }
 
    }
   
   
}
