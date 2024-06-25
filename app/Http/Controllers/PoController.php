<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use Illuminate\support\Facades\File;
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
use App\Models\Article;
use App\Models\Car_drive;
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
use App\Models\Car_status;
use App\Models\Car_index;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Department_sub_sub;
use DataTables;
use PDF;
use Auth; 
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class PoController extends Controller
{  
public function po_bookindex(Request $request,$iduser)
{        
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep') 
        ->where('bookrep_send_code','=','retire') 
        ->orwhere('bookrep_send_code','=','waitallows')
        ->get();

        $data['status'] = Status::get();
    return view('po.po_bookindex',$data);
}
public function po_bookindex_detail(Request $request,$id,$iduser)
{  
        $dataedit = Bookrep::where('bookrep_id','=',$id)
        ->first(); 

        $userid = Auth::user()->id;
        $data['users'] = User::get();
        
    return view('po.po_bookindex_detail',$data,[
        'dataedits'   =>   $dataedit
    ]);
}
public function po_bookindex_retire(Request $request,$id)
{  
        $dataedit = Bookrep::where('bookrep_id','=',$id)
        ->first(); 

        $dataedit_2 = Bookrep::where('bookrep_send_code','=','retire')
        ->where('bookrep_id','=',$id)
        ->first();

        $userid = Auth::user()->id;
        $data['users'] = User::get();
        $data['book_import_fam'] = DB::table('book_import_fam')->get();
        $data['speed_class'] = DB::table('speed_class')->get();
        $data['secret_class'] = DB::table('secret_class')->get();
        $data['book_type'] = DB::table('book_type')->get();
        $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get(); 
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['book_senddep'] = Book_senddep::where('bookrep_id','=',$id)->get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['org_team'] = DB::table('org_team')->get();
        $data['book_senddep_sub'] = DB::table('book_senddep_sub')->where('bookrep_id','=',$id)->get();
        $data['book_send_person'] = DB::table('book_send_person')->where('bookrep_id','=',$id)->get();
        $data['book_sendteam'] = DB::table('book_sendteam')->where('bookrep_id','=',$id)->get();
        $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get(); 

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','retire')->orwhere('bookrep_send_code','=','waitallows')->count(); 

    return view('po.po_bookindex_retire',$data,[
        'dataedits'   =>   $dataedit,
        'dataedit_2s' =>   $dataedit_2,
        'bookcount'=>$bookcount,
    ]);
}
public function po_bookindex_printdetail(Request $request, $id)
{        
    $dataedit = Bookrep::where('bookrep_id','=',$id)->first();  
    // $signature = DB::table('book_signature')->where('bookrep_id','=',$id)->first();
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

    $count = DB::table('book_signature')->where('bookrep_id','=',$id)->count();
    
    // dd($count);
    if ($count != 0) {
        $signature = DB::table('book_signature')->where('bookrep_id','=',$id)->first();
        $siguser = $signature->signature_name_usertext; //ผู้รองขอ
        $sighn = $signature->signature_name_hntext; //หัวหน้า
        $sig = $signature->signature_name_text; //หัวหน้าบริหาร
        $sigpo = $signature->signature_name_potext; //ผอ
        
    } else {
        $sig = '';
        $siguser = '';
        $sighn = '';
        $sigpo = '';
    }
            
    define('FPDF_FONTPATH','font/');
    require(base_path('public')."/fpdf/WriteHTML.php");

    $pdf = new Fpdi();// Instantiation   start-up Fpdi
    $path = 'storage/bookrep_pdf/'.$dataedit->bookrep_file;// existing PDF Templates ( The material file is in   Project name \public\testA.pdf)
    $table = 'storage/bookrep_pdf/table_1.png';
    
    $count = $pdf->setSourceFile($path);
    for ($i=1; $i<=$count; $i++) {
        $template   = $pdf->importPage($i);
        $size       = $pdf->getTemplateSize($template);
        $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
        $pdf->useTemplate($template);      
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->SetFont('THSarabunNew','',15); 
        $left = 150;
        $top = 12;        
        
        if ($sig != null) {
            $pdf->Cell(145);
            $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->bookrep_recievenum)); 
            $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->bookrep_repbooknum));
            $pdf->Cell(50,15,$no, 1,0, 'C' );
            $pdf->Image($sig, 8,241, 50, 17,"png");
            $pdf->Text(13,260,iconv( 'UTF-8','TIS-620', $rong)); 
            $pdf->Text(19,265,iconv( 'UTF-8','TIS-620','หัวหน้าบริหาร '  ));
            $pdf->SetTextColor(0, 0, 0);// Set the color of new text 
            // Coordinate 
            // $pdf->SetXY(65, 28);// Set the position coordinates of the new text 

        } else {
             
        }

        if ($sigpo != null) {
            $pdf->Cell(145);
            $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->bookrep_recievenum)); 
            $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->bookrep_repbooknum));
            $pdf->Cell(50,15,$no, 1,0, 'C');
            $pdf->Image($sigpo, 156,263, 50, 17,"png");
            $pdf->Text(154,283,iconv( 'UTF-8','TIS-620', $po)); 
            $pdf->Text(150,288,iconv( 'UTF-8','TIS-620','ผู้อำนวยการ'.$orgpo->orginfo_name  ));
            $pdf->SetTextColor(0, 0, 0);// Set the color of new text 
            // Coordinate 
            // $pdf->SetXY(52, 28);// Set the position coordinates of the new text 

        } else {
            // $pdf->Image($sig, 150,220, 40, 20,"png");
        }
        
    }
    $pdf->Output('I', 'example.pdf');// Output results  I: Direct input ,D: Download the file ,F: Save to local file ,S: Return string 
        
}

public function bookmake_retirepo(Request $request)
    {        
            // $add = new Book_signature();

            $dataimg = $request->input('signature');
            $userid = $request->input('user_id'); 
            $bookrepid = $request->input('bookrep_id'); 

            // $add->signature_name_text = $dataimg; 
            // $add->signature_file = $dataimg;
            // $add->user_id = $userid; 
            // $add->bookrep_id = $bookrepid;
            // $add->save(); 
            $checkdata = Bookrep::where('bookrep_id','=',$bookrepid)->first();
            $data = $checkdata->bookrep_send_code;

            if ( $data == 'waitallows') {
                $addsig = new Book_signature();  
                $addsig->signature_name_potext = $dataimg;  
                $addsig->bookrep_id = $bookrepid;           
                $addsig->save();
            } else {
                $updatsig = Book_signature::find($bookrepid);  
                $updatsig->signature_name_potext = $dataimg;            
                $updatsig->save();
            }

            $update = Bookrep::find($bookrepid);
            $update->bookrep_send_code = 'allows';
            $update->bookrep_send_name = 'ผอ.อนุมัติ';
            $update->bookrep_comment3 = $request->input('bookrep_comment3'); 
            
            if ($userid != '') {
                $repsave = DB::table('users')->where('id','=',$userid)->first();
                $update->bookrep_userallow_id = $repsave->id; 
                $update->bookrep_userallow_name = $repsave->fname. '  ' .$repsave->lname ; 
            } else {
                $update->bookrep_userallow_id = ''; 
                $update->bookrep_userallow_name =''; 
            }  
            $update->save(); 
            
           
                       

            return response()->json([
                'status'     => '200'
                ]);
    }
public function bookmake_allowpo(Request $request)
{    
    $databooks =  Bookrep::where('bookrep_send_code','=','retire')->orwhere('bookrep_send_code','=','waitallows')
    ->get();

    $iduser = $request->input('user_id'); 
    $dataimg = $request->input('signature');
    $comment3 = $request->input('bookrep_comment3');

    if ($dataimg != '') {
        foreach ($databooks as $items){ 
            $bookrepid = $items->bookrep_id;   
            
            // if ($iduser != '') {
                $repsave = DB::table('users')->where('id','=',$iduser)->first();
                // $updateall->bookrep_userallow_id = $repsave->id; 
                // $updateall->bookrep_userallow_name = $repsave->fname. '  ' .$repsave->lname ; 
            // } else {
            //     $updateall->bookrep_userallow_id = ''; 
            //     $updateall->bookrep_userallow_name =''; 
            // }  

            DB::table('bookrep')
                // ->where('car_service_id', $carservice_id)
                ->update([
                    'bookrep_userallow_id' => $repsave->id,
                    'bookrep_userallow_name' => $repsave->fname. '  ' .$repsave->lname,
                    'bookrep_comment3' => $comment3,
                    'bookrep_send_code' => 'allows',
                    'bookrep_send_name' => 'ผอ.อนุมัติ',
                ]);

                DB::table('book_signature')
                ->where('bookrep_id', $bookrepid)
                ->update(['signature_name_potext' => $dataimg]);
        }  
        return response()->json([
            'status'     => '200', 
            ]);
    } else {
        return response()->json([
            'status'     => '0', 
            ]);
    }
    

        // foreach ($databooks as $items){ 
        //     $bookrepid = $items->bookrep_id;
        //     $updateall = Bookrep::find($bookrepid);
        //     $updateall->bookrep_send_code = 'allows';
        //     $updateall->bookrep_send_name = 'ผอ.อนุมัติ'; 
        //     $updateall->bookrep_comment3 = $comment3; 

        //     if ($iduser != '') {
        //         $repsave = DB::table('users')->where('id','=',$iduser)->first();
        //         $updateall->bookrep_userallow_id = $repsave->id; 
        //         $updateall->bookrep_userallow_name = $repsave->fname. '  ' .$repsave->lname ; 
        //     } else {
        //         $updateall->bookrep_userallow_id = ''; 
        //         $updateall->bookrep_userallow_name =''; 
        //     }  
        //     $updateall->save(); 
        //     $updatsig = Book_signature::find($bookrepid);  
        //     $updatsig->signature_name_potext = $dataimg;            
        //     $updatsig->save(); 
            
        // }

       

    return response()->json([
        'statusCode'     => '200' 
        ]);
}


public function po_carcalenda(Request $request)
{   
    $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
    ->orderBy('article_id','DESC')
    ->get(); 
    $data['car_location'] = Car_location::get(); 
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();
    $data['car_status'] = Car_status::where('car_status_code','=','allocate')->orwhere('car_status_code','=','allocateall')->orwhere('car_status_code','=','confirmcancel')->get();
    $data['users'] = User::get();
    $data['car_drive'] = Car_drive::get();

        $event = array();       
        $carservicess = Car_service::all();  
        foreach ($carservicess as $carservice) {
       
            if ($carservice->car_service_status == 'request') {
                $color = '#F48506';
            }elseif ($carservice->car_service_status == 'allocate') {
                $color = '#592DF7'; 
            }elseif ($carservice->car_service_status == 'allocateall') {
                $color = '#07D79E';   
            }elseif ($carservice->car_service_status == 'cancel') {
                $color = '#ff0606';  
            }elseif ($carservice->car_service_status == 'confirmcancel') {
                $color = '#ab9e9e';  
            }elseif ($carservice->car_service_status == 'noallow') {
                $color = '#E80DEF';                   
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
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        } 
        
    return view('po/po_carcalenda',$data,[
        'events'     =>  $event, 
    ]);
}
public function po_carcalenda_add(Request $request,$id)
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
            }elseif ($carservice->car_service_status == 'allocateall') {
                $color = '#07D79E';   
            }elseif ($carservice->car_service_status == 'cancel') {
                $color = '#ff0606';  
            }elseif ($carservice->car_service_status == 'confirmcancel') {
                $color = '#ab9e9e';  
            }elseif ($carservice->car_service_status == 'noallow') {
                $color = '#E80DEF';                   
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
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        } 
        
    return view('po.po_carcalenda_add',$data,[
        'events'     =>  $event,
        'dataedits'  =>  $dataedit
    ]);
}
public function po_carcalenda_allowpo(Request $request)
{  
    $id = $request->input('car_service_id');    
    $dataimg = $request->input('signature');
    $stat = $request->input('car_service_status');   
   
        if ($id != '') {
            $check = Car_service::where('car_service_id','=',$id)->first();    
            $checkstatus = $check->car_service_status;
            if ($checkstatus == 'allow') {
                return response()->json([
                    'status'     => '20', 
                    ]);
            } else {
                if ($checkstatus == 'allocate' || $checkstatus == 'allocateall') {
                    if ($stat != '') {                        
                        if ($dataimg != '') { 
                            $update = Car_service::find($id); 
                            $update->car_service_status = $stat;    
                            $iduserpo = $request->input('user_id'); 
                            if ($iduserpo != '') {
                                $posave = DB::table('users')->where('id','=',$iduserpo)->first();
                                $update->car_service_po_id = $posave->id; 
                                $update->car_service_po_name = $posave->fname. '  ' .$posave->lname ; 
                            } else {
                                $update->car_service_po_id = ''; 
                                $update->car_service_po_name =''; 
                            }
                            $update->save();
                            $car_services = Car_service::where('car_service_id','=',$id)->get();        
                            foreach ($car_services as $items){ 
                                $carservice_id = $items->car_service_id;      
                                DB::table('carservice_signature')
                                    ->where('car_service_id', $carservice_id)
                                    ->update(['signature_name_potext' => $dataimg]);
                            }  
                            return response()->json([
                                'status'     => '200', 
                                ]);                             
                        } else {
                            return response()->json([
                                'status'     => '50', 
                                ]);
                        }                                     
                    } else {
                        return response()->json([
                            'status'     => '150', 
                            ]);
                    } 
                } else { 
                    return response()->json([
                        'status'     => '100' 
                        ]);
                } 
            }   
        } else {
            return response()->json([
                'status'     => '0', 
                ]);
        }
   
    // if ($id != '') {
    //     if ($dataimg != '') {
    //         $update = Car_service::find($id); 
    //         $update->car_service_status = $request->input('car_service_status');    
    //         $iduserpo = $request->input('user_id'); 
    //         if ($iduserpo != '') {
    //             $posave = DB::table('users')->where('id','=',$iduserpo)->first();
    //             $update->car_service_po_id = $posave->id; 
    //             $update->car_service_po_name = $posave->fname. '  ' .$posave->lname ; 
    //         } else {
    //             $update->car_service_po_id = ''; 
    //             $update->car_service_po_name =''; 
    //         }
    //         $update->save();
    //         $car_services = Car_service::where('car_service_id','=',$id)->get();        
    //         foreach ($car_services as $items){ 
    //             $carservice_id = $items->car_service_id;      
    //             DB::table('carservice_signature')
    //                 ->where('car_service_id', $carservice_id)
    //                 ->update(['signature_name_potext' => $dataimg]);
    //         }  
    //         return response()->json([
    //             'status'     => '200', 
    //             ]);
    //     } else {
    //         return response()->json([
    //             'status'     => '0', 
    //             ]);
    //     }  
    // } else {
    //     return response()->json([
    //         'status'     => '0', 
    //         ]);
    // }
    
   
    // $update = Car_service::find($id); 
    // $update->car_service_status = $request->input('car_service_status');    
    // $iduserpo = $request->input('user_id'); 
    // if ($iduserpo != '') {
    //     $posave = DB::table('users')->where('id','=',$iduserpo)->first();
    //     $update->car_service_po_id = $posave->id; 
    //     $update->car_service_po_name = $posave->fname. '  ' .$posave->lname ; 
    // } else {
    //     $update->car_service_po_id = ''; 
    //     $update->car_service_po_name =''; 
    // }
    // $update->save();

    // $car_services = Car_service::where('car_service_id','=',$id)->get();
    // $dataimg = $request->input('signature');
    // foreach ($car_services as $items){ 
    //     $carservice_id = $items->car_service_id;      
    //     DB::table('carservice_signature')
    //         ->where('car_service_id', $carservice_id)
    //         ->update(['signature_name_potext' => $dataimg]);
    // }  
    // return response()->json([
    //     'status'     => '200', 
    //     ]);
}
public function allow_all(Request $request)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get();  
    $data['q'] = $request->query('q');
    $query = Car_service::select('car_service_id','car_service_year','car_service_book','car_service_register','car_service_length_gotime','car_service_length_backtime','car_service_status','car_service_reason','car_location_name','car_service_user_name','article_data.article_car_type_id','car_service_date','article_img' )
    ->leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')
    ->leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')
    ->where(function ($query) use ($data){
        $query->where('car_service_status','like','%'.$data['q'].'%');
        $query->orwhere('car_service_date','like','%'.$data['q'].'%');
        $query->orwhere('car_service_reason','like','%'.$data['q'].'%');
        $query->orwhere('car_location_name','like','%'.$data['q'].'%');
        $query->orwhere('car_service_user_name','like','%'.$data['q'].'%'); 
    })
    ->where('car_service_status','=','allocate')
    ->orwhere('car_service_status','=','allocateall')
    ->where('article_data.article_car_type_id','!=',2);
    $data['car_service'] = $query->orderBy('car_service.car_service_id','DESC')->get();
    $data['car_status'] = Car_status::where('car_status_code','=','allocate')->orwhere('car_status_code','=','allocateall')->orwhere('car_status_code','=','confirmcancel')->get();
    $data['users'] = User::get();
    $data['car_drive'] = Car_drive::get();
    return view('po.allow_all',$data);
}

public function po_carcalenda_update_allallowpo(Request $request)
{  
    $id = $request->input('car_service_id');
   
    // $update = Car_service::find($id); 
    // $update->car_service_status = $request->input('car_service_status');     
    // $iduserpo = $request->input('user_id'); 
    // if ($iduserpo != '') {
    //     $posave = DB::table('users')->where('id','=',$iduserpo)->first();
    //     $update->car_service_po_id = $posave->id; 
    //     $update->car_service_po_name = $posave->fname. '  ' .$posave->lname ; 
    // } else {
    //     $update->car_service_po_id = ''; 
    //     $update->car_service_po_name =''; 
    // }
    // $update->save();

    // $car_services = Car_service::where('car_service_id','=',$id)->get();
    $car_services = Car_service::where('car_service_status','=','allocate')
    ->orwhere('car_service_status','=','allocateall')
    ->get();

    $dataimg = $request->input('signature');
    $status = $request->input('car_service_status');  
    $iduserpo = $request->input('user_id'); 
    $posave = DB::table('users')->where('id','=',$iduserpo)->first();

    DB::table('car_service')
    ->where('car_service_status','=','allocate')
    ->orwhere('car_service_status','=','allocateall')
    ->update([
        'car_service_po_id' => $posave->id,
        'car_service_po_name' => $posave->fname. '  ' .$posave->lname,
        'car_service_status' => $status
    ]);

    // dd($status );

    foreach ($car_services as $items){ 
        $carservice_id = $items->car_service_id; 
      
        DB::table('carservice_signature')
            ->where('car_service_id', $carservice_id)
            ->update(['signature_name_potext' => $dataimg]);
    }
  
    return response()->json([
        'status'     => '200', 
        ]);
}

public function allow_all_add(Request $request,$id)
{   
    $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
    ->orderBy('article_id','DESC')
    ->get();
    $data['users'] = User::get();
    $data['car_location'] = Car_location::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();

    $dataedit = Car_service::where('car_service_id','=',$id)->first(); 
    
        $event = array();       
       
        $carservicess = Car_service::where('car_service_article_id','=',$id)->get(); 
     
        foreach ($carservicess as $carservice) {
       
            if ($carservice->car_service_status == 'request') {
                $color = '#F48506';
            }elseif ($carservice->car_service_status == 'allocate') {
                $color = '#592DF7'; 
            }elseif ($carservice->car_service_status == 'allocateall') {
                $color = '#07D79E';   
            }elseif ($carservice->car_service_status == 'cancel') {
                $color = '#ff0606';  
            }elseif ($carservice->car_service_status == 'confirmcancel') {
                $color = '#ab9e9e';  
            }elseif ($carservice->car_service_status == 'noallow') {
                $color = '#E80DEF';                   
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
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        } 
        
    return view('po.allow_all_add',$data,[
        'events'     =>  $event,
        'dataedits'  =>  $dataedit
    ]);
}
public function po_carcalenda_update_allowonepo(Request $request)
{  
    $id = $request->input('car_service_id');    
    $dataimg = $request->input('signature');
    $stat = $request->input('car_service_status');   
   
        // if ($id != '') {
            $check = Car_service::where('car_service_id','=',$id)->first();    
            $checkstatus = $check->car_service_status;
            // if ($checkstatus == 'allow') {
            //     return response()->json([
            //         'status'     => '20', 
            //         ]);
            // } else {
                // if ($checkstatus == 'allocate' || $checkstatus == 'allocateall') {
                    if ($stat != '') {                        
                        if ($dataimg != '') { 
                            $update = Car_service::find($id); 
                            $update->car_service_status = $stat;    
                            $iduserpo = $request->input('user_id'); 
                            if ($iduserpo != '') {
                                $posave = DB::table('users')->where('id','=',$iduserpo)->first();
                                $update->car_service_po_id = $posave->id; 
                                $update->car_service_po_name = $posave->fname. '  ' .$posave->lname ; 
                            } else {
                                $update->car_service_po_id = ''; 
                                $update->car_service_po_name =''; 
                            }
                            $update->save();
                            
                            $car_services = Car_service::where('car_service_id','=',$id)->get();        
                            foreach ($car_services as $items){ 
                                $carservice_id = $items->car_service_id;      
                                DB::table('carservice_signature')
                                    ->where('car_service_id', $carservice_id)
                                    ->update(['signature_name_potext' => $dataimg]);
                            }  
                            return response()->json([
                                'status'     => '200', 
                                ]);                             
                        } else {
                            return response()->json([
                                'status'     => '50', 
                                ]);
                        }                                     
                    } else {
                        return response()->json([
                            'status'     => '150', 
                            ]);
                    } 
                // } else { 
                //     return response()->json([
                //         'status'     => '100' 
                //         ]);
                // } 
            // }   
        // } else {
        //     return response()->json([
        //         'status'     => '0', 
        //         ]);
        // }
      
}




public function po_leaveindex(Request $request,$iduser)
{  
        // $iduser = Auth::user()->id;
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)->get(); 
        
        $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')->get();  
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)
        ->get();
        $data['status'] = Status::paginate(15);
    return view('po.po_leaveindex',$data,[
        'dataedit'   =>   $dataedit
    ]);
}
public function po_trainindex(Request $request,$iduser)
{  
        // $iduser = Auth::user()->id;
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)->get(); 
        
        $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')->get();  
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)
        ->get();
        $data['status'] = Status::paginate(15);
    return view('po.po_trainindex',$data,[
        'dataedit'   =>   $dataedit
    ]);
}
public function po_storeindex(Request $request,$iduser)
{  
        // $iduser = Auth::user()->id;
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)->get(); 
        
        $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')->get();  
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)
        ->get();
        $data['status'] = Status::paginate(15);
    return view('po.po_storeindex',$data,[
        'dataedit'   =>   $dataedit
    ]);
}

public function po_purchaseindex(Request $request,$id)
{  
    $datarequesr = User::where('id','=',$id)->first();
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $datashow = User::get();
    $data['products_vendor'] = Products_vendor::get();
    $data['products_request'] = Products_request::join('products_status','products_request.request_status','=','products_status.products_status_code')
    ->join('products_request_sub','products_request_sub.request_id','=','products_request.request_id')
    // ->where('request_debsubsub_id','=',$datarequesr->dep_subsubtrueid)
    ->where('request_hn_id','=',$id)
    ->where('request_status','=','REQUEST')
    ->orderBy('products_request.request_id','DESC')->get();
 
    return view('po.po_purchaseindex',$data,
    [
        'datashows'=>$datashow,
        'datarequesr'=>$datarequesr,
        // 'dataedits'=>$dataedit,
    ]);
}
// public function bookmake_allowpo(Request $request,$iduser)
// {    
//     $databooks =  Bookrep::where('bookrep_send_code','=','retire')->orwhere('bookrep_send_code','=','waitallows')
//     ->get();

//         foreach ($databooks as $items){ 
//             $updateall = Bookrep::find($items->bookrep_id);
//             $updateall->bookrep_send_code = 'allows';
//             $updateall->bookrep_send_name = 'ผอ.อนุมัติ'; 

//             if ($iduser != '') {
//                 $repsave = DB::table('users')->where('id','=',$iduser)->first();
//                 $updateall->bookrep_userallow_id = $repsave->id; 
//                 $updateall->bookrep_userallow_name = $repsave->fname. '  ' .$repsave->lname ; 
//             } else {
//                 $updateall->bookrep_userallow_id = ''; 
//                 $updateall->bookrep_userallow_name =''; 
//             }  

//             $updateall->save();
//         }



//     return response()->json([
//         'statusCode'     => '200' 
//         ]);
// }

}