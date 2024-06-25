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
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('car_service')->where('car_service_id','=',$maxnumber)->first();  
        if($refmax->car_service_no != '' ||  $refmax->car_service_no != null){
        $maxref = substr($refmax->car_service_no, -5)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
    }else{
        $ref = '000001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refnumber = 'CS'.'-'.$ref;
    return $refnumber;
} 
 
public function car_calenda(Request $request,$iduser)
{   
    $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
    ->orderBy('article_id','DESC')
    ->get();
    $data['users'] = User::get();
    $data['car_location'] = Car_location::get();
    // $dataedit = Article::where('article_id','=',$id)->first(); 
    
        $event = array();       
        $carservicess = Car_service::all(); 
        // $carservicess = Car_service::where('car_service_article_id','=',$id)->get(); 
        foreach ($carservicess as $carservice) {
       
            if ($carservice->car_service_status == 'request') {
                $color = '#F48506';
            }elseif ($carservice->car_service_status == 'allocate') {
                $color = '#592DF7';  
            }elseif ($carservice->car_service_status == 'cancel') {
                $color = '#ff0606';  
            }elseif ($carservice->car_service_status == 'confirmcancel') {
                $color = '#ab9e9e';                    
            } else {
                $color = '#3CDF44';
            }
    
            $dateend = $carservice->car_service_date;
            // $dateend = $carservice->car_service_length_backdate;
            $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
    
            // $datestart=date('H:m');
            $timestart = $carservice->car_service_length_gotime;  
            $timeend = $carservice->car_service_length_backtime; 
            $starttime = substr($timestart, 0, 5);  
            $endtime = substr($timeend, 0, 5); 
    
            $showtitle = $carservice->car_service_register.'=>'.$starttime.'-'.$endtime;
            
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
        
    return view('user_car.car_calenda',$data,[
        'events'     =>  $event,
        // 'dataedits'  =>  $dataedit
    ]);
}
public function car_calenda_add(Request $request,$id)
{   
    $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
    ->orderBy('article_id','DESC')
    ->get();
    $data['users'] = User::get();
    $data['car_location'] = Car_location::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();

    $dataedit = Article::where('article_id','=',$id)->first(); 
    
        $event = array();       
       
        $carservicess = Car_service::where('car_service_article_id','=',$id)->get(); 
   

        foreach ($carservicess as $carservice) {
       
            if ($carservice->car_service_status == 'request') {
                $color = '#F48506';
            }elseif ($carservice->car_service_status == 'allocate') {
                $color = '#592DF7';  
            }elseif ($carservice->car_service_status == 'cancel') {
                $color = '#ff0606';  
            }elseif ($carservice->car_service_status == 'confirmcancel') {
                $color = '#ab9e9e';                    
            } else {
                $color = '#0AC58D';
            }
    
            // $dateend = $carservice->car_service_length_backdate;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

            $dateend = $carservice->car_service_date;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
            $NewendDate = date ("Y-m-d", strtotime($dateend)-1);  //ลบออก 1 วัน  เพื่อโชว์ปฎิทิน
    
            // $datestart=date('H:m');
            $timestart = $carservice->car_service_length_gotime;  
            $timeend = $carservice->car_service_length_backtime; 
            
            $starttime = substr($timestart, 0, 5);  
            $endtime = substr($timeend, 0, 5); 
    
            $showtitle = $carservice->car_service_register.'=>'.$starttime.'-'.$endtime;
            
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
        
    return view('user_car.car_calenda_add',$data,[
        'events'     =>  $event,
        'dataedits'  =>  $dataedit
    ]);
}
public function car_calenda_save(Request $request)
{    
    // return $request;
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
                    $add->car_service_location = $request->carservice_location;
                    $add->car_service_reason = $request->carservice_reason; 
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

                    // $addsig = new Carservice_signature();                
                    // $addsig->signature_name_usertext = $dataimg; 
                    // $addsig->car_service_no = $service_no; 
                    // $addsig->car_service_id = $maxnoid;
                    // $addsig->save();

                    // if($request->person_join_id != '' || $request->person_join_id != null){                
                    //     $person_join_id = $request->person_join_id;                       
                                        
                    //     $number =count($person_join_id);
                    //     $count = 0;           
                    //     for($count = 0; $count< $number; $count++)
                    //     {    
                    //         $iduser = DB::table('users')->where('id','=',$person_join_id[$count])->first();                
                    //         $add_sub = new Car_service_personjoin();
                    //         $add_sub->car_service_id = $maxn; 
                    //         $add_sub->car_service_no = $service_no; 
                    //         $add_sub->person_join_id = $iduser->id; 
                    //         $add_sub->person_join_name = $iduser->fname .' '.$iduser->lname;   
                    //         $add_sub->save(); 
                    //     }
                    // }
        }

        
        // $serid =  DB::table('car_service')->where('car_service_id','=',$maxnoid)->first();
        // $maxnoid->car_service_id;
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

            // $update = Car_service::find($bookrepid);
            // $update->car_service_status = 'retire';  
         
            // if ($userid != '') {
            //     $repsave = DB::table('users')->where('id','=',$userid)->first();
            //     $update->bookrep_userretire_id = $repsave->id; 
            //     $update->bookrep_userretire_name = $repsave->fname. '  ' .$repsave->lname ; 
            // } else {
            //     $update->bookrep_userretire_id = ''; 
            //     $update->bookrep_userretire_name =''; 
            // }  
            // $update->save(); 

            return response()->json([
                'status'     => '200'
                ]);
    }
public function car_narmal(Request $request)
{   
    $data['q'] = $request->query('q');
    $query = Car_service::select('car_service_id','car_service_year','car_service_book','car_service_register','car_service_length_gotime','car_service_length_backtime','car_service_status','car_service_reason','car_location_name','car_service_user_name','article_data.article_car_type_id','car_service_date' )
    ->leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')
    ->leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')
    ->where(function ($query) use ($data){
        $query->where('car_service_status','like','%'.$data['q'].'%');
        $query->orwhere('car_service_date','like','%'.$data['q'].'%');
        $query->orwhere('car_service_reason','like','%'.$data['q'].'%');
        $query->orwhere('car_location_name','like','%'.$data['q'].'%');
        $query->orwhere('car_service_user_name','like','%'.$data['q'].'%'); 
    })
    ->where('article_data.article_car_type_id','!=',2);
    $data['car_service'] = $query->orderBy('car_service.car_service_id','DESC')->get();
    
    return view('user_car.car_narmal',$data);
}
public function car_narmal_cancel(Request $request,$id)
{
   $update = Car_service::find($id);
   $update->car_service_status = 'cancel'; 
   $update->save(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
public function car_ambulance_cancel(Request $request,$id)
{
   $update = Car_service::find($id);
   $update->car_service_status = 'cancel'; 
   $update->save(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
public function car_narmal_print2(Request $request,$id)
{
  
    $dataedit = Article::where('article_id','=',$id)->first(); 
    $carservicess = Car_service::all(); 
  
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
 
    $pdf = PDF::loadView('user_car.car_narmal_print' ); 
    return @$pdf->stream();

}

public function car_narmal_print(Request $request, $id)
    {        
        $dataedit = Car_service::where('car_service_id','=',$id)->first();  
      
        $org = DB::table('orginfo')->where('orginfo_id','=',1)
        ->leftjoin('users','users.id','=','orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->first();
        $rong = $org->prefix_name.' '.$org->fname.'  '.$org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id','=',1)
        ->leftjoin('users','users.id','=','orginfo.orginfo_po_id')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->first();
        $po = $orgpo->prefix_name.' '.$orgpo->fname.'  '.$orgpo->lname;

        $count = DB::table('carservice_signature')
        ->where('car_service_id','==',$id)
        // ->where()
        ->count();
        dd($count);
        if ($count != 0) {
            $signature = DB::table('carservice_signature')->where('car_service_id','=',$id)->first();
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
        
        
        define('FPDF_FONTPATH','font/');
        require(base_path('public')."/fpdf/WriteHTML.php");

        $pdf = new Fpdi();// Instantiation   start-up Fpdi
        // $path = 'storage/bookrep_pdf/'.$dataedit->bookrep_file;// existing PDF Templates ( The material file is in   Project name \public\testA.pdf)
        // $table = 'storage/bookrep_pdf/table_1.png';
        // dd($path);
        // $count = $pdf->setSourceFile($path);
        // $count = $pdf->setSourceFile();
        // for ($i=1; $i<=$count; $i++) {
            // $template   = $pdf->importPage();
            // $size       = $pdf->getTemplateSize($template);
            // $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
            // $pdf->useTemplate($template);   
            $pdf->SetLeftMargin( 22 );
            $pdf->SetRightMargin( 5);
            $pdf->AddFont('THSarabunNew','','THSarabunNew.php');   
            $pdf->SetFont('THSarabunNew', '', 15);
            // $pdf->AddPage("L", ['100', '100']);
            $pdf->AddPage("P");
            $pdf->Text(10,10,iconv( 'UTF-8','TIS-620','หัวหน้าบริหาร '  ));    
            $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->car_service_no));
            $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->car_service_register)); 
            $pdf->Cell(50,15,$no, 1,0, 'C');
            $pdf->Image($sigstaff, 8,241, 50, 17,"png");  
            // $left = 150;
            // $top = 12;        
            
            if ($sigstaff != null) {
                $pdf->Cell(145);
                $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->car_service_no));
                $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->car_service_register));
                $pdf->Cell(50,15,$no, 1,0, 'C');
                $pdf->Image($sigstaff, 8,241, 50, 17,"png");
                $pdf->Text(13,260,iconv( 'UTF-8','TIS-620', $rong)); 
                $pdf->Text(19,265,iconv( 'UTF-8','TIS-620','หัวหน้าบริหาร '  ));
                $pdf->SetTextColor(0, 0, 0);// Set the color of new text                 
            } else {
                // $pdf->Image($sig, 150,220, 40, 20,"png");
            }
            if ($sigrong != null) {
                $pdf->Cell(145);
                $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->car_service_no));
                $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->car_service_register));
                $pdf->Cell(50,15,$no, 1,0, 'C');
                $pdf->Image($sigrong, 8,241, 50, 17,"png");
                $pdf->Text(13,260,iconv( 'UTF-8','TIS-620', $rong)); 
                $pdf->Text(19,265,iconv( 'UTF-8','TIS-620','หัวหน้าบริหาร '  ));
                $pdf->SetTextColor(0, 0, 0);// Set the color of new text                 
            } else {
                // $pdf->Image($sig, 150,220, 40, 20,"png");
            }
            if ($sigpo != null) {
                $pdf->Cell(145);
                $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->car_service_no)); 
                $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->car_service_register));
                $pdf->Cell(50,15,$no, 1,0, 'C');
                $pdf->Image($sigpo, 156,263, 50, 17,"png");
                $pdf->Text(154,283,iconv( 'UTF-8','TIS-620', $po)); 
                $pdf->Text(150,288,iconv( 'UTF-8','TIS-620','ผู้อำนวยการ'.$orgpo->orginfo_name  ));
                $pdf->SetTextColor(0, 0, 0);// Set the color of new text 
               
            } else {
                // $pdf->Image($sig, 150,220, 40, 20,"png");
            }
            
          
        // }
        // $pdf->Output('I', 'example.pdf');// Output results  I: Direct input ,D: Download the file ,F: Save to local file ,S: Return string 
        $pdf->Output();

        exit;
    }
public function car_narmal_show(Request $request )
{       
 
    $event = array();
    $carservices = Car_service::all();
    $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
    ->orderBy('article_id','DESC')
    ->get();
    foreach ($carservices as $carservice) {
       
        if ($carservice->car_service_status == 'REQUEST') {
            $color = '#F48506';
        }elseif ($carservice->car_service_status == 'ALLOCATE') {
            $color = '#592DF7';           
        } else {
            $color = '#0AC58D';
        }

        $dateend = $carservice->car_service_length_backdate;
        $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

        // $datestart=date('H:m');
        $timestart = $carservice->car_service_length_gotime;  
        $timeend = $carservice->car_service_length_backtime; 
        $starttime = substr($timestart, 0, 5);  
        $endtime = substr($timeend, 0, 5); 

        $showtitle = $carservice->car_service_register.'=>'.$starttime.'-'.$endtime;
        
        $event[] = [
            'id' => $carservice->car_service_id, 
            'title' => $showtitle,
            'start' => $carservice->car_service_length_godate,
            'end' => $NewendDate, 
            'color' => $color
        ];
    }   
    
    return view('user_car.car_narmal_show',$data,[
        'events' => $event
    ]);
}

public function car_narmal_chose(Request $request,$id)
{   
    // dd($id);
    // $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 
    $dataedit = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 
    $data['building_data'] = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')
    ->orderBy('room_id','DESC')
    ->get(); 
    $data['building_room_list'] = Building_room_list::get();
    $data['food_list'] = Food_list::get();
    $data['meeting_list'] = Meeting_list::get();
    $data['meeting_objective'] = Meeting_objective::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();
  
    $count =  Meeting_service::where('room_id','=',$id)->count(); 
    //  dd($count);
    if ( $count == 0) {
        $event = array();
        // $meettings = Meeting_service::all();
        $meettings = Meeting_service::where('room_id','=',$id)->get(); 
        foreach ($meettings as $meetting) {       
            if ($meetting->meetting_status == 'REQUEST') {
                $color = '#F48506';
            }elseif ($meetting->meetting_status == 'ALLOCATE') {
                $color = '#592DF7';           
            } else {
                $color = '#0AC58D';
            }    
            
            $dateend = $meetting->meeting_date_end;
            $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

            $timestart = $meetting->meeting_time_begin;  
            $timeend = $meetting->meeting_time_end; 
            $starttime = substr($timestart, 0, 5);  
            $endtime = substr($timeend, 0, 5); 
    
            $showtitle = $meetting->room_name.'=>'.$starttime.'-'.$endtime;

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
        $meet = Meeting_service::where('room_id','=',$id)->get();
        // $meet = Meeting_service::all();  
        foreach ($meet as $meetting) {       
            if ($meetting->meetting_status == 'REQUEST') {
                $color = '#F48506';
            }elseif ($meetting->meetting_status == 'ALLOCATE') {
                $color = '#592DF7';           
            } else {
                $color = '#0AC58D';
            }  
            $dateend = $meetting->meeting_date_end;
            $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

            $timestart = $meetting->meeting_time_begin;  
            $timeend = $meetting->meeting_time_end; 
            $starttime = substr($timestart, 0, 5);  
            $endtime = substr($timeend, 0, 5); 
    
            $showtitle = $meetting->meetting_title.'>'.$starttime.'-'.$endtime;

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
    return view('user_car.car_narmal_chose',$data,[
        'dataedits'  => $dataedit,
        'events' => $event
    ]);
}

public function car_ambulance(Request $request)
{   
    $data['q'] = $request->query('q');
    $query = Car_service::select('car_service_id','car_service_year','car_service_book','car_service_register','car_service_length_gotime','car_service_length_backtime','car_service_status','car_service_reason','car_location_name','car_service_user_name','article_data.article_car_type_id','car_service_date' )
    ->leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')
    ->leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')
    ->where(function ($query) use ($data){
        $query->where('car_service_status','like','%'.$data['q'].'%');
        $query->orwhere('car_service_date','like','%'.$data['q'].'%');
        $query->orwhere('car_service_reason','like','%'.$data['q'].'%');
        $query->orwhere('car_location_name','like','%'.$data['q'].'%');
        $query->orwhere('car_service_user_name','like','%'.$data['q'].'%'); 
    })
    ->where('article_data.article_car_type_id','=',2);
    $data['car_service'] = $query->orderBy('car_service.car_service_id','DESC')->get();


    // $data['car_service'] = Car_service::leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')
    // ->leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')
    // ->where('article_data.article_car_type_id','=',2) 
    // ->orderBy('car_service.car_service_id','DESC')
    // ->get();

    return view('user_car.car_ambulance',$data);
}


public function supplies_data_add_destroy(Request $request,$id)
{
   $del = Products_request::find($id); 
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

function addlocation(Request $request)
{     
 if($request->locationnew!= null || $request->locationnew != ''){    
     $count_check = Car_location::where('car_location_name','=',$request->locationnew)->count();           
        if($count_check == 0){    
                $add = new Car_location(); 
                $add->car_location_name = $request->locationnew;
                $add->save(); 
        }
        }
            $query =  DB::table('car_location')->get();            
            $output='<option value="">--เลือก--</option>';                
            foreach ($query as $row){
                if($request->locationnew == $row->car_location_name){
                    $output.= '<option value="'.$row->car_location_id.'" selected>'.$row->car_location_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->car_location_id.'">'.$row->car_location_name.'</option>';
                }   
        }    
    echo $output;        
}
}