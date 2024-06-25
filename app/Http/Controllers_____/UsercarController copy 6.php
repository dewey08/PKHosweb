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
use DataTables;
use PDF;
use Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class UsercarController extends Controller
{
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('car_service')->max('car_service_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('car_service')->where('car_service_id', '=', $maxnumber)->first();
            if ($refmax->car_service_no != '' ||  $refmax->car_service_no != null) {
                $maxref = substr($refmax->car_service_no, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = 'CS' . '-' . $ref;
        return $refnumber;
    }

    public function car_calenda(Request $request, $iduser)
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
        $carservicess = Car_service::all();
        // $carservicess = Car_service::where('car_service_article_id','=',$id)->get(); 
        foreach ($carservicess as $carservice) {

            if ($carservice->car_service_status == 'request') {
                $color = '#F48506';
            } elseif ($carservice->car_service_status == 'allocate') {
                $color = '#592DF7';
            } elseif ($carservice->car_service_status == 'allocateall') {
                $color = '#07D79E';
            } elseif ($carservice->car_service_status == 'cancel') {
                $color = '#ff0606';
            } elseif ($carservice->car_service_status == 'confirmcancel') {
                $color = '#ab9e9e';
            } elseif ($carservice->car_service_status == 'noallow') {
                $color = '#E80DEF';
            } else {
                $color = '#3CDF44';
            }

            $dateend = $carservice->car_service_date;
            // $dateend = $carservice->car_service_length_backdate;
            $NewendDate = date("Y-m-d", strtotime("1 day", strtotime($dateend)));

            // $datestart=date('H:m');
            $timestart = $carservice->car_service_length_gotime;
            $timeend = $carservice->car_service_length_backtime;
            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);

            $showtitle = $carservice->car_service_register . '=>' . $starttime . '-' . $endtime;

            $event[] = [
                'id' => $carservice->car_service_id,
                'title' => $showtitle,
                // 'start' => $carservice->car_service_length_godate,
                // 'end' => $NewendDate, 
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        }

        return view('user_car.car_calenda', $data, [
            'events'     =>  $event,
            // 'dataedits'  =>  $dataedit
        ]);
    }
    public function car_calenda_add(Request $request, $id)
    {
        $data['article_data'] = Article::where('article_decline_id', '=', '6')->where('article_categoryid', '=', '26')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['users'] = User::get();
        $data['car_location'] = Car_location::get();
        // $data['budget_year'] = Budget_year::orderBy('leave_year_id', 'DESC')->get();
        $y = date('Y')+543;
        $m = date('m');
        $d = date('d');
        $lot = $y.''.$m.''.$d;
        // dd($y);
        $data['budget_year'] = Budget_year::where('leave_year_id', '=',$y)->get();

        $dataedit = Article::where('article_id', '=', $id)->first();

        $event = array();

        $carservicess = Car_service::where('car_service_article_id', '=', $id)->get();


        foreach ($carservicess as $carservice) {

            if ($carservice->car_service_status == 'request') {
                $color = '#F48506';
            } elseif ($carservice->car_service_status == 'allocate') {
                $color = '#592DF7';
            } elseif ($carservice->car_service_status == 'allocateall') {
                $color = '#07D79E';
            } elseif ($carservice->car_service_status == 'cancel') {
                $color = '#ff0606';
            } elseif ($carservice->car_service_status == 'confirmcancel') {
                $color = '#ab9e9e';
            } elseif ($carservice->car_service_status == 'noallow') {
                $color = '#E80DEF';
            } else {
                $color = '#3CDF44';
            }

            // $dateend = $carservice->car_service_length_backdate;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

            $dateend = $carservice->car_service_date;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
            $NewendDate = date("Y-m-d", strtotime($dateend) - 1);  //ลบออก 1 วัน  เพื่อโชว์ปฎิทิน

            // $datestart=date('H:m');
            $timestart = $carservice->car_service_length_gotime;
            $timeend = $carservice->car_service_length_backtime;

            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);

            $showtitle = $carservice->car_service_register . '=>' . $starttime . '-' . $endtime;

            $event[] = [
                'id' => $carservice->car_service_id,
                'title' => $showtitle,
                // 'start' => $carservice->car_service_length_godate,
                // 'end' => $NewendDate, 
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        }

        return view('user_car.car_calenda_add', $data, [
            'events'     =>  $event,
            'dataedits'  =>  $dataedit
        ]);
    }
    public function car_calenda_save(Request $request)
    {
        // return $request;
        date_default_timezone_set('Asia/Bangkok');
        $id = $request->input('car_service_id');
        $dataimg = $request->input('signature');
        $addlocate = $request->car_service_location;
        // dd($addlocate);

        if ($id != '') {
            if ($dataimg != '') {

                $datebigin = $request->carservice_length_godate;
                $dateend = $request->carservice_length_backdate;
                    if ($datebigin != '' || $dateend != '') {
                        // $service_no = $request->carservice_no;
                        // $addbook = $request->carservice_book;
                       
                        // $add->car_service_location = $losave->car_location_id;
                        // $add->car_service_location_name = $losave->car_location_name;
                        $datebigin_befor = date("Y-m-d", strtotime($datebigin) - 1);  //ลบออก 1 วัน เช่น 2022-08-22  -1 == 2022-08-21
                        $dateend_befor = date("Y-m-d", strtotime($dateend) - 1);
                        // กรณีนับวัน
                        // $go = date ("d", strtotime("d", strtotime($datebigin)));
                        // $back = date ("d", strtotime("d", strtotime($dateend)));        
                        // $total =  $back - $go;
                        // $gog = date("Y-m-d", strtotime("1 day", strtotime($datebigin))); //+1 วัน
                        // while (strtotime($datebigin_befor) <= strtotime($dateend_befor)) {
                            // echo "<br>$datebigin_befor " ;
                            $service_no = $request->car_service_no;
                            $service_year = $request->car_service_year;
                            $service_res = $request->car_service_reason;
                            $addbook = $request->car_service_book;
                            $addgotime = $request->car_service_length_gotime;
                            $addbacktime = $request->car_service_length_backtime;
                            $addcar = $request->car_service_article_id;
                            $datebigin_befor = date("Y-m-d", strtotime("+1 days", strtotime($datebigin_befor))); // loop +1 วัน เอาเฉพาะวันที่ เช่น 2022-08-22
                            
                            $losave = DB::table('car_location')->where('car_location_id', '=', $addlocate)->first();

                            Car_service::where('car_service_id', $id)
                            ->update([
                                'car_service_no' => $service_no,
                                'car_service_book' => $addbook,
                                'car_service_year' => $service_year,
                                'car_service_reason' =>  $service_res,
                                'car_service_date' => $datebigin_befor,
                                'car_service_length_godate' => $datebigin,
                                'car_service_length_backdate' => $dateend,
                                'car_service_length_gotime' => $addgotime,
                                'car_service_length_backtime' => $addbacktime,
                                'car_service_article_id' => $addcar,
                                'car_service_location' => $losave->car_location_id,
                                'car_service_location_name' => $losave->car_location_name,
                            ]);
                           
                        $minnoid = DB::table('car_service')->where('car_service_no', '=', $service_no)->min('car_service_id');
                        $maxnoid = DB::table('car_service')->where('car_service_no', '=', $service_no)->max('car_service_id');
                        while ($minnoid <= $maxnoid) {
                            $data2 = array(
                                'car_service_id' => $minnoid, $minnoid++,
                                'car_service_no' => $request->carservice_no,
                                'signature_name_usertext' => $dataimg
                            );
                            Carservice_signature::create($data2);
                        }

                        if ($request->person_join_id != '' || $request->person_join_id != null) {
                            $person_join_id = $request->person_join_id;

                            $number = count($person_join_id);
                            $count = 0;
                            for ($count = 0; $count < $number; $count++) {
                                $iduser = DB::table('users')->where('id', '=', $person_join_id[$count])->first();
                                $minid = DB::table('car_service')->where('car_service_no', '=', $service_no)->min('car_service_id');
                                $maxid = DB::table('car_service')->where('car_service_no', '=', $service_no)->max('car_service_id');

                                while ($minid <= $maxid) {
                                    $data3 = array(
                                        'car_service_id' => $minid, $minid++,
                                        'car_service_no' => $service_no,
                                        'person_join_id' => $iduser->id,
                                        'person_join_name' => $iduser->fname . ' ' . $iduser->lname
                                    );
                                    Car_service_personjoin::create($data3);
                                }
                            }
                        }

                        return response()->json([
                            'status'     => '200',
                        ]);
                    } else {
                        return response()->json([
                            'status'     => '120',
                        ]);
                        // $ye = date('Y');
                        // $y = date('Y')+543;
                        // $m = date('m');
                        // $d = date('d');
                        // $lotthai = $y.'-'.$m.'-'.$d;
                        // $loten = $ye.'-'.$m.'-'.$d;
                        // // dd($loten);
                        // $service_no = $request->carservice_no;
                        // $addbook = $request->carservice_book;
                        // $addlocate = $request->carservice_location;
                        // // $dataimg = $request->signature; 
                        // $datebigin_befor = date("Y-m-d", strtotime($loten) - 1);  //ลบออก 1 วัน เช่น 2022-08-22  -1 == 2022-08-21
                        // $dateend_befor = date("Y-m-d", strtotime($loten) - 1);
                        // // กรณีนับวัน
                        // // $go = date ("d", strtotime("d", strtotime($datebigin)));
                        // // $back = date ("d", strtotime("d", strtotime($dateend)));        
                        // // $total =  $back - $go;
                        // // $gog = date("Y-m-d", strtotime("1 day", strtotime($datebigin))); //+1 วัน
                        // while (strtotime($datebigin_befor) <= strtotime($dateend_befor)) {
                        //     // echo "<br>$datebigin_befor " ;
                        //     $datebigin_befor = date("Y-m-d", strtotime("+1 days", strtotime($datebigin_befor))); // loop +1 วัน เอาเฉพาะวันที่ เช่น 2022-08-22
                        //     $add = new Car_service();
                        //     $add->car_service_no = $service_no;
                        //     $add->car_service_book = $addbook;
                        //     $add->car_service_year = $request->carservice_year;
                        //     // $add->car_service_location = $request->carservice_location;
                        //     $add->car_service_reason = $request->carservice_reason;
                        //     $add->car_service_date = $datebigin_befor;
                        //     $add->car_service_length_godate = $datebigin;
                        //     $add->car_service_length_backdate = $dateend;
                        //     $add->car_service_length_gotime = $request->carservice_length_gotime;
                        //     $add->car_service_length_backtime = $request->carservice_length_backtime;
                        //     $add->car_service_status = 'request';
                        //     $addiduser = $request->userid;
                        //     if ($addiduser != '') {
                        //         $usave = DB::table('users')->where('id', '=', $addiduser)->first();
                        //         $add->car_service_user_id = $usave->id;
                        //         $add->car_service_user_name = $usave->fname . ' ' . $usave->lname;
                        //     } else {
                        //         $add->car_service_user_id = '';
                        //         $add->car_service_user_name = '';
                        //     }
                        //     $addarticleid = $request->carservice_article_id;
                        //     if ($addarticleid != '') {
                        //         $arsave = DB::table('article_data')->where('article_id', '=', $addarticleid)->first();
                        //         $add->car_service_article_id = $arsave->article_id;
                        //         $add->car_service_register = $arsave->article_register;
                        //     } else {
                        //         $add->car_service_article_id = '';
                        //         $add->car_service_register = '';
                        //     }
                        //     if ($addlocate != '') {
                        //         $losave = DB::table('car_location')->where('car_location_id', '=', $addlocate)->first();
                        //         $add->car_service_location = $losave->car_location_id;
                        //         $add->car_service_location_name = $losave->car_location_name;
                        //     } else {
                        //         $add->car_service_location = '';
                        //         $add->car_service_location_name = '';
                        //     }
                        //     $add->save();
                        // }

                        // $minnoid = DB::table('car_service')->where('car_service_no', '=', $service_no)->min('car_service_id');
                        // $maxnoid = DB::table('car_service')->where('car_service_no', '=', $service_no)->max('car_service_id');
                        // while ($minnoid <= $maxnoid) {
                        //     $data2 = array(
                        //         'car_service_id' => $minnoid, $minnoid++,
                        //         'car_service_no' => $request->carservice_no,
                        //         'signature_name_usertext' => $dataimg
                        //     );
                        //     Carservice_signature::create($data2);
                        // }

                        // if ($request->person_join_id != '' || $request->person_join_id != null) {
                        //     $person_join_id = $request->person_join_id;

                        //     $number = count($person_join_id);
                        //     $count = 0;
                        //     for ($count = 0; $count < $number; $count++) {
                        //         $iduser = DB::table('users')->where('id', '=', $person_join_id[$count])->first();
                        //         $minid = DB::table('car_service')->where('car_service_no', '=', $service_no)->min('car_service_id');
                        //         $maxid = DB::table('car_service')->where('car_service_no', '=', $service_no)->max('car_service_id');

                        //         while ($minid <= $maxid) {
                        //             $data3 = array(
                        //                 'car_service_id' => $minid, $minid++,
                        //                 'car_service_no' => $service_no,
                        //                 'person_join_id' => $iduser->id,
                        //                 'person_join_name' => $iduser->fname . ' ' . $iduser->lname
                        //             );
                        //             Car_service_personjoin::create($data3);
                        //         }
                        //     }
                        // }

                        // return response()->json([
                        //     'status'     => '200',
                        // ]);
                    }                    
                                    
            } else {
                return response()->json([
                    'status'     => '50',
                ]);
            }
        } else {
            // แก้ไข
            // return response()->json([
            //     'status'     => '0',
            // ]);
            date_default_timezone_set('Asia/Bangkok');
        $datebigin = $request->carservice_length_godate;
        $dateend = $request->carservice_length_backdate;
        $service_no = $request->carservice_no; 
        $addbook = $request->carservice_book;  
        $dataimg = $request->signature; 
        $datebigin_befor = date ("Y-m-d", strtotime($datebigin)-1);  //ลบออก 1 วัน เช่น 2022-08-22  -1 == 2022-08-21
        $dateend_befor = date ("Y-m-d", strtotime($dateend)-1);
        $maxnoid = DB::table('car_service')->max('car_service_id');
        $maxn = $maxnoid+1;

        $addlocate = $request->car_service_location;
        $car_reason = $request->carservice_reason; 
        $losave = DB::table('car_location')->where('car_location_id', '=', $addlocate)->first();
       
        // กรณีนับวัน
        // $go = date ("d", strtotime("d", strtotime($datebigin)));
        // $back = date ("d", strtotime("d", strtotime($dateend)));        
        // $total =  $back - $go;
        // $gog = date("Y-m-d", strtotime("1 day", strtotime($datebigin))); //+1 วัน

        while (strtotime($datebigin_befor) <= strtotime($dateend_befor)) {
            // echo "<br>$datebigin_befor " ;
            $datebigin_befor = date ("Y-m-d", strtotime("+1 days", strtotime($datebigin_befor))); // loop +1 วัน เอาเฉพาะวันที่ เช่น 2022-08-22

                    $add = new Car_service();  
                    $add->car_service_no = $service_no; 
                    $add->car_service_book = $addbook; 
                    $add->car_service_year = $request->carservice_year;
                    $add->car_service_location = $losave->car_location_id;
                    $add->car_service_location_name = $losave->car_location_name;
                    $add->car_service_reason = $car_reason; 
                    $add->car_service_date = $datebigin_befor;
                    $add->car_service_length_godate = $datebigin;
                    $add->car_service_length_backdate = $dateend;
                    $add->car_service_length_gotime = $request->carservice_length_gotime;
                    $add->car_service_length_backtime = $request->carservice_length_backtime;
                    $add->car_service_status = 'request';                      
                    $addiduser = $request->userid;
                    if ($addiduser != '') {
                        $usave = DB::table('users')->where('id','=',$addiduser)->first();
                        $add->car_service_user_id = $usave->id; 
                        $add->car_service_user_name = $usave->fname .' '.$usave->lname;            
                    }else{
                        $add->car_service_user_id = '';
                        $add->car_service_user_name = '';            
                    }
                    $addarticleid = $request->carservice_article_id;
                    if ($addarticleid != '') {
                        $arsave = DB::table('article_data')->where('article_id','=',$addarticleid)->first();
                        $add->car_service_article_id = $arsave->article_id; 
                        $add->car_service_register = $arsave->article_register;            
                    }else{
                        $add->car_service_article_id = '';
                        $add->car_service_register = '';            
                    }                    
                    $add->save(); 

                }

                $addsig = new Carservice_signature();                
                $addsig->signature_name_usertext = $dataimg; 
                $addsig->car_service_no = $service_no; 
                $addsig->car_service_id = $maxn;
                // $addsig->car_service_id = $serid->car_service_id;
                $addsig->save();
                // $maxnoid = DB::table('car_service')->max('car_service_id');
                // $addsig = new Carservice_signature();
                if($request->person_join_id != '' || $request->person_join_id != null){                
                    $person_join_id = $request->person_join_id;                       
                                    
                    $number =count($person_join_id);
                    $count = 0;           
                    for($count = 0; $count< $number; $count++)
                    {    
                        $iduser = DB::table('users')->where('id','=',$person_join_id[$count])->first();                
                        $add_sub = new Car_service_personjoin();
                        $add_sub->car_service_id = $maxn; 
                        $add_sub->car_service_no = $service_no; 
                        $add_sub->person_join_id = $iduser->id; 
                        $add_sub->person_join_name = $iduser->fname .' '.$iduser->lname;   
                        $add_sub->save(); 
                    }
                }
            return response()->json([
                'status'     => '200',
            ]);

        }
    }

    public function car_narmal_editshow(Request $request,$id)
{  
    $carservice = Car_service::leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')->find($id);
    // $carservice = Car_service::find($id);
    $carser = Car_service::where('car_service_id', '=',$id)->first();
    $carsers = $carser->car_service_location;
    // dd($carsers);
    // $data['car_location'] = Budget_year::where('leave_year_id', '=',$y)->get();
    $data['car_location'] = Car_location::where('car_location_id', '=',$carsers)->get();
    return response()->json([
        'status'     => '200',
        'carservice'      =>  $carservice, 
        ]);
}
    public function car_calenda_edit(Request $request, $id)
    {
        // $carservices = Car_service::find($id);
        $check = Car_service::where('car_service_id', '=', $id)->first();
        $checkstatus = $check->car_service_status;
        // dd($checkstatus);

        if ($checkstatus == 'request' || $checkstatus == 'cancel') {
            $date = $request->start_date;
            Car_service::where('car_service_id', $id)
                ->update([
                    'car_service_date' => $date
                ]);

            return response()->json([
                'status'     => '200',
            ]);
        } else if ($checkstatus == 'allow') {
            return response()->json([
                'status'     => '150',
            ]);
        } else if ($checkstatus == 'allocate' || $checkstatus == 'allocateall') {
            return response()->json([
                'status'     => '250',
            ]);
        } else if ($checkstatus == 'noallow' || $checkstatus == 'confirmcancel') {
            return response()->json([
                'status'     => '300',
            ]);
        } else {

            return response()->json([
                'status'     => '100',
            ]);
        }
    }

    public function car_calenda_savesign(Request $request)
    {
        $maxnoid = DB::table('car_service')->max('car_service_id');

        // $maxid = $maxnoid+1;

        $add = new Carservice_signature();
        $dataimg = $request->input('signature');
        // $userid = $request->input('user_id'); 
        // $carservice_no = $request->input('car_service_no');
        $add->signature_name_usertext = $dataimg;
        $add->car_service_no = $request->input('car_service_no');
        $add->car_service_id = $maxnoid;
        $add->save();

        return response()->json([
            'status'     => '200'
        ]);
    }





    public function car_narmal(Request $request)
    {
        $data['q'] = $request->query('q');
        $query = Car_service::select('car_service_id', 'car_service_year', 'car_service_book', 'car_service_register', 'car_service_length_gotime', 'car_service_length_backtime', 'car_service_status', 'car_service_reason', 'car_location_name', 'car_service_user_name', 'article_data.article_car_type_id', 'car_service_date')
            ->leftjoin('article_data', 'article_data.article_id', '=', 'car_service.car_service_article_id')
            ->leftjoin('car_location', 'car_location.car_location_id', '=', 'car_service.car_service_location')
            ->where(function ($query) use ($data) {
                $query->where('car_service_status', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_service_date', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_service_reason', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_location_name', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_service_user_name', 'like', '%' . $data['q'] . '%');
            })
            ->where('article_data.article_car_type_id', '!=', 2);
        $data['car_service'] = $query->orderBy('car_service.car_service_id', 'DESC')->get();

        return view('user_car.car_narmal', $data);
    }
    public function car_narmal_cancel(Request $request, $id)
    {
        $update = Car_service::find($id);
        $update->car_service_status = 'cancel';
        $update->save();
        return response()->json(['status' => '200', 'success' => 'Delete Success']);
    }
    public function car_ambulance_cancel(Request $request, $id)
    {
        $update = Car_service::find($id);
        $update->car_service_status = 'cancel';
        $update->save();
        return response()->json(['status' => '200', 'success' => 'Delete Success']);
    }
    // public function car_narmal_print2(Request $request, $id)
    // {

    //     $dataedit = Article::where('article_id', '=', $id)->first();
    //     $carservicess = Car_service::all();

    //     $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    //     $pdf = PDF::loadView('user_car.car_narmal_print');
    //     return @$pdf->stream();
    // }

    public function car_narmal_print(Request $request, $id)
    {
        $dataedit = Car_service::where('car_service_id', '=', $id)
            ->leftjoin('car_location', 'car_location.car_location_id', '=', 'car_service.car_service_location')
            ->leftjoin('users', 'users.id', '=', 'car_service.car_service_user_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();

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

        $count = DB::table('carservice_signature')
            ->where('car_service_id', '=', $id)->orwhere('car_service_no', '=', $dataedit->car_service_no)
            ->count();

        $countper = DB::table('car_service_personjoin')
            ->where('car_service_id', '=', $id)->orwhere('car_service_no', '=', $dataedit->car_service_no)
            ->count();

        $countpers = $countper + 1;
        // dd($countper);
        if ($count != 0) {
            $signature = DB::table('carservice_signature')->where('car_service_id', '=', $id)
                // ->orwhere('car_service_no','=',$dataedit->car_service_no)
                ->first();
            $siguser = $signature->signature_name_usertext; //ผู้รองขอ
            $sigstaff = $signature->signature_name_stafftext; //ผู้รองขอ
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
        $date = date_create($dataedit->created_at);
        $datnow =  date_format($date, "Y-m-j");

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
        $pdf->Text(25, 44, iconv('UTF-8', 'TIS-620', 'เรียน  ผู้อำนวยการ' . $orgpo->orginfo_name));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(40, 53, iconv('UTF-8', 'TIS-620', 'ข้าพเจ้า  ' . $dataedit->car_service_user_name));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(110, 53, iconv('UTF-8', 'TIS-620', ' ตำแหน่ง  ' . $dataedit->position_name));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(25, 62, iconv('UTF-8', 'TIS-620', 'ขออนุญาติใช้รถไป  ' . $dataedit->car_location_name));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(25, 71, iconv('UTF-8', 'TIS-620', 'เพื่อ  ' . $dataedit->car_service_reason));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(25, 80, iconv('UTF-8', 'TIS-620', 'มีคนนั่ง    ' . $countpers . '   คน'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(60, 80, iconv('UTF-8', 'TIS-620', 'ในวันที่  ' . dayThai($dataedit->car_service_date) . '  เดือน' . monthThai($dataedit->car_service_date) . '  พ.ศ. ' . yearThai($dataedit->car_service_date) . '   เวลา ' . time($dataedit->car_service_length_gotime) . '  น.'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(25, 89, iconv('UTF-8', 'TIS-620', 'โดยมี  ' . $dataedit->car_service_user_name . '  เป็นผู้รับผิดชอบ'));

        //ผู้ขออนุญาต
        if ($siguser != null) {
            $pdf->Image($siguser, 109, 105, 50, 17, "png");
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(100, 120, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                             ผู้ขออนุญาต'));
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(112, 130, iconv('UTF-8', 'TIS-620', '(   ' . $dataedit->car_service_user_name . '   )'));
        } else {
            // $pdf->Image($sig, 150,220, 40, 20,"png");
        }

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(25, 148, iconv('UTF-8', 'TIS-620', 'ความเห็นของผู้ควบคุมรถยนต์ ( เห็นควรอนุญาตให้ใช้รถยนต์ หมายเลขทะเบียน ' . $dataedit->car_service_register . ' )'));

        if ($dataedit->car_service_userdrive_name == null) {
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(25, 157, iconv('UTF-8', 'TIS-620', 'โดยมี  .......................................................... เป็นพนักงานขับรถยนต์คันดังกล่าว'));
        } else {
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(25, 157, iconv('UTF-8', 'TIS-620', 'โดยมี  ' . $dataedit->car_service_userdrive_name . '     เป็นพนักงานขับรถยนต์คันดังกล่าว'));
        }


        //ผู้ดูแลอนุญาต
        if ($sigstaff != null) {
            $pdf->Image($sigstaff, 109, 173, 50, 17, "png");
            $pdf->SetFont('THSarabunNew', '', 15);
            $pdf->Text(100, 188, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                            ผู้อนุญาต'));
            $pdf->Text(112, 198, iconv('UTF-8', 'TIS-620', '(   ' . $dataedit->car_service_staff_name . '   )'));
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
        // $pdf->Image(base_path('public').'/fpdf/img/checked.png',105,217, 4, 4);
        // $pdf->Image(base_path('public').'/fpdf/img/checkno.jpg',140,217, 4, 4);
        // $pdf->Image(base_path('public').'/fpdf/img/checkno.jpg',105,197, 50, 17);

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
    public function car_narmal_show(Request $request)
    {

        $event = array();
        $carservices = Car_service::all();
        $data['article_data'] = Article::where('article_decline_id', '=', '6')->where('article_categoryid', '=', '26')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();
        foreach ($carservices as $carservice) {

            if ($carservice->car_service_status == 'REQUEST') {
                $color = '#F48506';
            } elseif ($carservice->car_service_status == 'ALLOCATE') {
                $color = '#592DF7';
            } else {
                $color = '#0AC58D';
            }

            $dateend = $carservice->car_service_length_backdate;
            $NewendDate = date("Y-m-d", strtotime("1 day", strtotime($dateend)));

            // $datestart=date('H:m');
            $timestart = $carservice->car_service_length_gotime;
            $timeend = $carservice->car_service_length_backtime;
            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);

            $showtitle = $carservice->car_service_register . '=>' . $starttime . '-' . $endtime;

            $event[] = [
                'id' => $carservice->car_service_id,
                'title' => $showtitle,
                'start' => $carservice->car_service_length_godate,
                'end' => $NewendDate,
                'color' => $color
            ];
        }

        return view('user_car.car_narmal_show', $data, [
            'events' => $event
        ]);
    }

    public function car_narmal_chose(Request $request, $id)
    {
        // dd($id);
        // $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 
        $dataedit = Building_level_room::where('room_type', '!=', '1')->where('room_id', '=', $id)->first();
        $data['building_data'] = Building::leftJoin('building_level', 'building_data.building_id', '=', 'building_level.building_id')
            ->leftJoin('building_level_room', 'building_level_room.building_level_id', '=', 'building_level.building_level_id')
            ->where('room_type', '!=', '1')
            ->orderBy('room_id', 'DESC')
            ->get();
        $data['building_room_list'] = Building_room_list::get();
        $data['food_list'] = Food_list::get();
        $data['meeting_list'] = Meeting_list::get();
        $data['meeting_objective'] = Meeting_objective::get();
        $data['budget_year'] = Budget_year::orderBy('leave_year_id', 'DESC')->get();

        $count =  Meeting_service::where('room_id', '=', $id)->count();
        //  dd($count);
        if ($count == 0) {
            $event = array();
            // $meettings = Meeting_service::all();
            $meettings = Meeting_service::where('room_id', '=', $id)->get();
            foreach ($meettings as $meetting) {
                if ($meetting->meetting_status == 'REQUEST') {
                    $color = '#F48506';
                } elseif ($meetting->meetting_status == 'ALLOCATE') {
                    $color = '#592DF7';
                } else {
                    $color = '#0AC58D';
                }

                $dateend = $meetting->meeting_date_end;
                $NewendDate = date("Y-m-d", strtotime("1 day", strtotime($dateend)));

                $timestart = $meetting->meeting_time_begin;
                $timeend = $meetting->meeting_time_end;
                $starttime = substr($timestart, 0, 5);
                $endtime = substr($timeend, 0, 5);

                $showtitle = $meetting->room_name . '=>' . $starttime . '-' . $endtime;

                $event[] = [
                    'id' => $meetting->meeting_id,
                    'title' => $showtitle,
                    'start' => $meetting->meeting_date_begin,
                    'end' => $NewendDate,
                    'color' => $color
                ];
            }
        } else {
            $event = array();
            $meet = Meeting_service::where('room_id', '=', $id)->get();
            // $meet = Meeting_service::all();  
            foreach ($meet as $meetting) {
                if ($meetting->meetting_status == 'REQUEST') {
                    $color = '#F48506';
                } elseif ($meetting->meetting_status == 'ALLOCATE') {
                    $color = '#592DF7';
                } else {
                    $color = '#0AC58D';
                }
                $dateend = $meetting->meeting_date_end;
                $NewendDate = date("Y-m-d", strtotime("1 day", strtotime($dateend)));

                $timestart = $meetting->meeting_time_begin;
                $timeend = $meetting->meeting_time_end;
                $starttime = substr($timestart, 0, 5);
                $endtime = substr($timeend, 0, 5);

                $showtitle = $meetting->meetting_title . '>' . $starttime . '-' . $endtime;

                $event[] = [
                    'id' => $meetting->meeting_id,
                    'title' => $showtitle,
                    'start' => $meetting->meeting_date_begin,
                    'end' => $NewendDate,
                    'color' => $color
                ];
            }
        }
        // $meettings = Meeting_service::all(); 
        return view('user_car.car_narmal_chose', $data, [
            'dataedits'  => $dataedit,
            'events' => $event
        ]);
    }

    public function car_ambulance(Request $request)
    {
        $data['q'] = $request->query('q');
        $query = Car_service::select('car_service_id', 'car_service_year', 'car_service_book', 'car_service_register', 'car_service_length_gotime', 'car_service_length_backtime', 'car_service_status', 'car_service_reason', 'car_location_name', 'car_service_user_name', 'article_data.article_car_type_id', 'car_service_date')
            ->leftjoin('article_data', 'article_data.article_id', '=', 'car_service.car_service_article_id')
            ->leftjoin('car_location', 'car_location.car_location_id', '=', 'car_service.car_service_location')
            ->where(function ($query) use ($data) {
                $query->where('car_service_status', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_service_date', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_service_reason', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_location_name', 'like', '%' . $data['q'] . '%');
                $query->orwhere('car_service_user_name', 'like', '%' . $data['q'] . '%');
            })
            ->where('article_data.article_car_type_id', '=', 2);
        $data['car_service'] = $query->orderBy('car_service.car_service_id', 'DESC')->get();


        // $data['car_service'] = Car_service::leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')
        // ->leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')
        // ->where('article_data.article_car_type_id','=',2) 
        // ->orderBy('car_service.car_service_id','DESC')
        // ->get();

        return view('user_car.car_ambulance', $data);
    }


    public function supplies_data_add_destroy(Request $request, $id)
    {
        $del = Products_request::find($id);
        $del->delete();
        return response()->json(['status' => '200', 'success' => 'Delete Success']);
    }

    function addlocation(Request $request)
    {
        if ($request->locationnew != null || $request->locationnew != '') {
            $count_check = Car_location::where('car_location_name', '=', $request->locationnew)->count();
            if ($count_check == 0) {
                $add = new Car_location();
                $add->car_location_name = $request->locationnew;
                $add->save();
            }
        }
        $query =  DB::table('car_location')->get();
        $output = '<option value="">--เลือก--</option>';
        foreach ($query as $row) {
            if ($request->locationnew == $row->car_location_name) {
                $output .= '<option value="' . $row->car_location_id . '" selected>' . $row->car_location_name . '</option>';
            } else {
                $output .= '<option value="' . $row->car_location_id . '">' . $row->car_location_name . '</option>';
            }
        }
        echo $output;
    }
}
