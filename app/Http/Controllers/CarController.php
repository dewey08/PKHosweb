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
use App\Models\Product_spyprice;
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
use App\Models\Product_prop;
use App\Models\Car_status;
use App\Models\Car_index;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Department_sub_sub;
use App\Models\Article;
use App\Models\Car_drive;
use App\Models\Product_decline;
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
use Illuminate\Support\Facades\File;

class CarController extends Controller
{  
    public static function refnumber()
{
    $year = date('Y');
    $maxnumber = DB::table('products_request')->max('request_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('products_request')->where('request_id','=',$maxnumber)->first();  
        if($refmax->request_code != '' ||  $refmax->request_code != null){
        $maxref = substr($refmax->request_code, -5)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
    }else{
        $ref = '000001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refnumber = 'REP'.'-'.$ref;
    return $refnumber;
} 
public function car_narmal_calenda(Request $request)
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
        
    return view('car/car_narmal_calenda',$data,[
        'events'     =>  $event, 
    ]);
}
public function car_narmal_calenda_add(Request $request,$id)
{   
    
    $data['car_status'] = Car_status::where('car_status_code','=','allocate')->orwhere('car_status_code','=','allocateall')->orwhere('car_status_code','=','confirmcancel')->get();
    $data['users'] = User::get();
    $data['car_drive'] = Car_drive::get();


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
                'start' => $dateend,
                'end' => $dateend, 
                'color' => $color
            ];
        } 
        
    return view('car.car_narmal_calenda_add',$data,[
        'events'     =>  $event,
        'dataedits'  =>  $dataedit
    ]);
}
public function car_narmal_index(Request $request)
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
    ->where('article_data.article_car_type_id','!=',2);
    $data['car_service'] = $query->orderBy('car_service.car_service_id','DESC')->get();
    $data['car_status'] = Car_status::where('car_status_code','=','allocate')->orwhere('car_status_code','=','allocateall')->orwhere('car_status_code','=','confirmcancel')->get();
    $data['users'] = User::get();
    $data['car_drive'] = Car_drive::get();
    return view('car.car_narmal_index',$data);
}

public function car_narmal_updatecancel(Request $request,$id)
{
   $update = Car_service::find($id);
   $update->car_service_status = 'confirmcancel'; 
   $update->save(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
public function car_narmal_editallocate(Request $request,$id)
{  
    $carservice = Car_service::leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')->find($id);     
    return response()->json([
        'status'     => '200',
        'carservice'      =>  $carservice, 
        ]);
}
public function car_narmal_allocate(Request $request)
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

                    if ( $dataimg != '') {
                        $update = Car_service::find($id); 
                        $update->car_service_status = $request->input('car_service_status');
                        $update->car_service_mikenumber_befor = $request->input('car_service_mikenumber_befor');
                        $update->car_service_mikenumber_after = $request->input('car_service_mikenumber_after');
                        $iduser = $request->input('car_drive_user_id');
                        if ($iduser != '') {
                            $usersave = DB::table('users')->where('id','=',$iduser)->first();
                            $update->car_service_userdrive_id = $usersave->id; 
                            $update->car_service_userdrive_name = $usersave->fname. '  ' .$usersave->lname ; 
                        } else {
                            $update->car_service_userdrive_id = ''; 
                            $update->car_service_userdrive_name =''; 
                        }
                        $update->car_service_drive_gotime = $request->input('car_service_drive_gotime');
                        $update->car_service_drive_backtime = $request->input('car_service_drive_backtime'); 
                        
                        $iduserstaff = $request->input('userid'); 
                        if ($iduserstaff != '') {
                            $staffsave = DB::table('users')->where('id','=',$iduserstaff)->first();
                            $update->car_service_staff_id = $staffsave->id; 
                            $update->car_service_staff_name = $staffsave->fname. '  ' .$staffsave->lname ; 
                        } else {
                            $update->car_service_staff_id = ''; 
                            $update->car_service_staff_name =''; 
                        }
                        $update->save();
                    
                        $car_services = Car_service::where('car_service_id','=',$id)->get();
                        // $dataimg = $request->input('signature');
                        foreach ($car_services as $items){ 
                            $carservice_id = $items->car_service_id;     
                            DB::table('carservice_signature')
                                ->where('car_service_id', $carservice_id)
                                ->update(['signature_name_stafftext' => $dataimg]);
                        }  
                        return response()->json([
                            'status'     => '200', 
                            ]);
                    } else {
                        return response()->json([
                            'status'     => '50', 
                            ]);
                    }
        
            } 
    } else {
        return response()->json([
            'status'     => '0', 
            ]);
    }    
    
}




// ************** ข้อมูลยานพาหนะ ********************
public function car_data_index(Request $request)
{   
    // $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
    // ->orderBy('article_id','DESC')
    // ->get(); 
    $startdate = $request->startdate;
    $enddate = $request->enddate;
    $req = $request->article_register;

    if ($req != '') {
        $data['article_data'] = DB::connection('mysql')->select('
            select a.article_decline_id,a.article_categoryid,a.article_status_id,a.article_id
                ,a.article_num,a.article_name,a.article_attribute,a.article_price,a.article_year,a.article_recieve_date,a.article_spypriceid,a.article_register
                ,a.article_typeid,a.article_categoryid,a.article_groupid,a.article_method_id
                ,a.article_buy_id,a.article_decline_id,a.article_budget_id,a.article_vendor_id,a.article_deb_subsub_id,a.article_car_type_id
                ,a.article_car_number,a.article_serial_no,a.article_status_id,a.article_user_id,a.article_model_id,a.article_color_id,a.article_brand_id
                ,a.article_size_id ,a.article_img,a.store_id,a.article_claim,a.article_img_name,a.article_unit_id
                ,s.brand_name,pb.buy_name,c.category_name,co.color_name,pd.decline_name,pg.product_group_name,pt.sub_type_name
                ,pu.unit_name,pv.vendor_name,pv.vendor_phone,de.DEPARTMENT_SUB_SUB_NAME

                from article_data a
                left outer join product_brand s on s.brand_id = a.article_brand_id 
                left outer join product_buy pb on pb.buy_id = a.article_buy_id 
                left outer join product_category c on c.category_id = a.article_categoryid  
                left outer join product_color co on co.color_id = a.article_color_id 
                left outer join product_decline pd on pd.decline_id = a.article_decline_id 
                left outer join product_group pg on pg.product_group_id = a.article_groupid
                left outer join product_type pt on pt.sub_type_id = a.article_typeid
                left outer join product_unit pu on pu.unit_id = a.article_unit_id
                left outer join products_vendor pv on pv.vendor_id = a.article_vendor_id
                left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = a.article_deb_subsub_id

                where a.article_decline_id = "6" AND a.article_categoryid = "26" 
                AND a.article_status_id = "3"  
                AND a.article_id = "'.$req.'"          
        ');
    } else {
        $data['article_data'] = DB::connection('mysql')->select('
            select a.article_decline_id,a.article_categoryid,a.article_status_id,a.article_id
                ,a.article_num,a.article_name,a.article_attribute,a.article_price,a.article_year,a.article_recieve_date,a.article_spypriceid,a.article_register
                ,a.article_typeid,a.article_categoryid,a.article_groupid,a.article_method_id
                ,a.article_buy_id,a.article_decline_id,a.article_budget_id,a.article_vendor_id,a.article_deb_subsub_id,a.article_car_type_id
                ,a.article_car_number,a.article_serial_no,a.article_status_id,a.article_user_id,a.article_model_id,a.article_color_id,a.article_brand_id
                ,a.article_size_id ,a.article_img,a.store_id,a.article_claim,a.article_img_name,a.article_unit_id
                ,s.brand_name,pb.buy_name,c.category_name,co.color_name,pd.decline_name,pg.product_group_name,pt.sub_type_name
                ,pu.unit_name,pv.vendor_name,pv.vendor_phone,de.DEPARTMENT_SUB_SUB_NAME

                from article_data a
                left outer join product_brand s on s.brand_id = a.article_brand_id 
                left outer join product_buy pb on pb.buy_id = a.article_buy_id 
                left outer join product_category c on c.category_id = a.article_categoryid  
                left outer join product_color co on co.color_id = a.article_color_id 
                left outer join product_decline pd on pd.decline_id = a.article_decline_id 
                left outer join product_group pg on pg.product_group_id = a.article_groupid
                left outer join product_type pt on pt.sub_type_id = a.article_typeid
                left outer join product_unit pu on pu.unit_id = a.article_unit_id
                left outer join products_vendor pv on pv.vendor_id = a.article_vendor_id
                left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = a.article_deb_subsub_id

                where a.article_decline_id = "6" 
                AND a.article_categoryid = "26" 
                AND a.article_status_id = "3"           
        ');
        $req = '';
    }
    $data['department_sub_sub'] = Department_sub_sub::get();
    $data['product_decline'] = Product_decline::get();
    $data['product_prop'] = Product_prop::get();
    $data['supplies_prop'] = DB::table('supplies_prop')->get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['product_data'] = Products::get();
    $data['product_category'] = Products_category::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::get();
    $data['product_unit'] = Product_unit::get(); 

    $data['articleregister'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','3')->get(); 
   
    return view('car.car_data_index',$data,[
        'req'    =>  $req
    ]);
}
public function car_data_indexsearch(Request $request)
{   
    
    $startdate = $request->startdate;
    $enddate = $request->enddate;
    $req = $request->article_register;

    if ($req != '') {
        $data['article_data'] = DB::connection('mysql')->select('
            select a.article_decline_id,a.article_categoryid,a.article_status_id,a.article_id
                ,a.article_num,a.article_name,a.article_attribute,a.article_price,a.article_year,a.article_recieve_date,a.article_spypriceid,a.article_register
                ,a.article_typeid,a.article_categoryid,a.article_groupid,a.article_method_id
                ,a.article_buy_id,a.article_decline_id,a.article_budget_id,a.article_vendor_id,a.article_deb_subsub_id,a.article_car_type_id
                ,a.article_car_number,a.article_serial_no,a.article_status_id,a.article_user_id,a.article_model_id,a.article_color_id,a.article_brand_id
                ,a.article_size_id ,a.article_img,a.store_id,a.article_claim,a.article_img_name,a.article_unit_id
                ,s.brand_name,pb.buy_name,c.category_name,co.color_name,pd.decline_name,pg.product_group_name,pt.sub_type_name
                ,pu.unit_name,pv.vendor_name,pv.vendor_phone,de.DEPARTMENT_SUB_SUB_NAME

                from article_data a
                left outer join product_brand s on s.brand_id = a.article_brand_id 
                left outer join product_buy pb on pb.buy_id = a.article_buy_id 
                left outer join product_category c on c.category_id = a.article_categoryid  
                left outer join product_color co on co.color_id = a.article_color_id 
                left outer join product_decline pd on pd.decline_id = a.article_decline_id 
                left outer join product_group pg on pg.product_group_id = a.article_groupid
                left outer join product_type pt on pt.sub_type_id = a.article_typeid
                left outer join product_unit pu on pu.unit_id = a.article_unit_id
                left outer join products_vendor pv on pv.vendor_id = a.article_vendor_id
                left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = a.article_deb_subsub_id

                where a.article_decline_id = "6" AND a.article_categoryid = "26" 
                AND a.article_status_id = "3"  
                AND a.article_id = "'.$req.'"          
        ');
    } else {
        $data['article_data'] = DB::connection('mysql')->select('
            select a.article_decline_id,a.article_categoryid,a.article_status_id,a.article_id
                ,a.article_num,a.article_name,a.article_attribute,a.article_price,a.article_year,a.article_recieve_date,a.article_spypriceid,a.article_register
                ,a.article_typeid,a.article_categoryid,a.article_groupid,a.article_method_id
                ,a.article_buy_id,a.article_decline_id,a.article_budget_id,a.article_vendor_id,a.article_deb_subsub_id,a.article_car_type_id
                ,a.article_car_number,a.article_serial_no,a.article_status_id,a.article_user_id,a.article_model_id,a.article_color_id,a.article_brand_id
                ,a.article_size_id ,a.article_img,a.store_id,a.article_claim,a.article_img_name,a.article_unit_id
                ,s.brand_name,pb.buy_name,c.category_name,co.color_name,pd.decline_name,pg.product_group_name,pt.sub_type_name
                ,pu.unit_name,pv.vendor_name,pv.vendor_phone,de.DEPARTMENT_SUB_SUB_NAME

                from article_data a
                left outer join product_brand s on s.brand_id = a.article_brand_id 
                left outer join product_buy pb on pb.buy_id = a.article_buy_id 
                left outer join product_category c on c.category_id = a.article_categoryid  
                left outer join product_color co on co.color_id = a.article_color_id 
                left outer join product_decline pd on pd.decline_id = a.article_decline_id 
                left outer join product_group pg on pg.product_group_id = a.article_groupid
                left outer join product_type pt on pt.sub_type_id = a.article_typeid
                left outer join product_unit pu on pu.unit_id = a.article_unit_id
                left outer join products_vendor pv on pv.vendor_id = a.article_vendor_id
                left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = a.article_deb_subsub_id

                where a.article_decline_id = "6" 
                AND a.article_categoryid = "26" 
                AND a.article_status_id = "3"           
        ');
        $req = '';
    }
    

    
    // $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
    // ->orderBy('article_id','DESC')
    // ->get();  
    $data['department_sub_sub'] = Department_sub_sub::get();
    $data['product_decline'] = Product_decline::get();
    $data['product_prop'] = Product_prop::get();
    $data['supplies_prop'] = DB::table('supplies_prop')->get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['product_data'] = Products::get();
    $data['product_category'] = Products_category::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::get();
    $data['product_unit'] = Product_unit::get();
    $data['articleregister'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','3')->get(); 
    return view('car.car_data_index',$data,[
        'req'    =>  $req
    ]);
}


public function car_data_index_add(Request $request)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get(); 
    $data['users'] = User::get(); 
    $data['article_status'] = Article_status::get(); 
    $data['car_type'] = Car_type::get(); 
    $data['product_brand'] = Product_brand::get(); 
    $data['product_color'] = Product_color::get();
    $data['department_sub_sub'] = Department_sub_sub::orderBy('DEPARTMENT_SUB_SUB_ID','DESC')->get(); 

    return view('car.car_data_index_add',$data);
}
public function car_data_index_save(Request $request)
{  
        $add = new Article();
        $add->article_year = $request->input('article_year'); 
        $add->article_recieve_date = $request->input('article_recieve_date'); 
        $add->article_price = $request->input('article_price');  
        $add->article_num = $request->input('article_num');
        $add->article_name = $request->input('article_name');
        $add->article_attribute = $request->input('article_attribute');
        $add->article_register = $request->input('article_register');
        $add->store_id = $request->input('store_id'); 
        $add->article_car_gas = $request->input('article_car_gas'); 
        $add->article_car_number = $request->input('article_car_number');
        $add->article_serial_no = $request->input('article_serial_no');  
      
        $iduser = $request->input('article_user_id'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->article_user_id = $usersave->id; 
            $add->article_user_name = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->article_user_id = ''; 
            $add->article_user_name =''; 
        }

        $typeid = $request->input('article_typeid'); 
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id','=',$typeid)->first();
            $add->article_typeid = $typesave->sub_type_id; 
            $add->article_typename = $typesave->sub_type_name; 
        } else {
            $add->article_typeid = ''; 
            $add->article_typename =''; 
        }

        $groupid = $request->input('article_groupid');
        if ($groupid != '') {
                $groupsave = DB::table('product_group')->where('product_group_id','=',$groupid)->first();
                $add->article_groupid = $groupsave->product_group_id; 
                $add->article_groupname = $groupsave->product_group_name; 
        } else {
            $add->article_groupid = ''; 
            $add->article_groupname = ''; 
        }

        $decliid = $request->input('article_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id','=',$decliid)->first();
            $add->article_decline_id = $decsave->decline_id; 
            $add->article_decline_name = $decsave->decline_name; 
        }else{
            $add->article_decline_id = '';
            $add->article_decline_name = '';
        }

        $debid = $request->input('article_deb_subsub_id');
        if ($debid != '') {
            $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$debid)->first();
            $add->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID; 
            $add->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME; 
        }else{
            $add->article_deb_subsub_id = '';
            $add->article_deb_subsub_name = '';
        }

        $stsid = $request->input('article_status_id');
        if ($stsid != '') {
            $debsave = DB::table('article_status')->where('article_status_id','=',$stsid)->first();
            $add->article_status_id = $debsave->article_status_id; 
            $add->article_status_name = $debsave->article_status_name; 
        }else{
            $add->article_status_id = '';
            $add->article_status_name = '';
        }
        
        $brandid = $request->input('article_brand_id');
        if ($brandid != '') {
            $groupsave = DB::table('product_brand')->where('brand_id','=',$brandid)->first();
            $add->article_brand_id = $groupsave->brand_id; 
            $add->article_brand_name = $groupsave->brand_name; 
        } else {
            $add->article_brand_id = ''; 
            $add->article_brand_name = ''; 
        }

        $colorid = $request->input('article_color_id');
        if ($colorid != '') {
            $colsave = DB::table('product_color')->where('color_id','=',$colorid)->first();
            $add->article_color_id = $colsave->color_id; 
            $add->article_color_name = $colsave->color_name; 
        } else {
            $add->article_color_id = ''; 
            $add->article_color_name = ''; 
        }

        $typecarid = $request->input('article_car_type_id'); 
        if ($typecarid != '') {
            $typesave = DB::table('car_type')->where('car_type_id','=',$typecarid)->first();
            $add->article_car_type_id = $typesave->car_type_id; 
            $add->article_car_type_name = $typesave->car_type_name; 
        } else {
            $add->article_car_type_id = ''; 
            $add->article_car_type_name =''; 
        }

        $catid = $request->input('article_categoryid'); 
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id','=',$catid)->first();
            $add->article_categoryid = $catsave->category_id; 
            $add->article_categoryname = $catsave->category_name; 
        } else {
            $add->article_categoryid = ''; 
            $add->article_categoryname =''; 
        }
           

        // if ($request->hasfile('article_img')) {
        //     $file = $request->file('article_img');
        //     $extention = $file->getClientOriginalExtension();
        //     $filename = time().'.'.$extention; 
        //     $request->article_img->storeAs('car',$filename,'public'); 
        //     $add->article_img = $filename;
        //     $add->article_img_name = $filename;
        // }
        if ($request->hasfile('article_img')) {
            $file = $request->file('article_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            // $file->move('uploads/article/',$filename);
            $request->article_img->storeAs('article',$filename,'public');
            // $file->storeAs('article/',$filename);
            $add->article_img = $filename;
            $add->article_img_name = $filename;
        }
       
        $add->save(); 

        return response()->json([
            'status'     => '200'
            ]);
}
public function car_data_index_edit(Request $request,$id)
{    
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get(); 
    $data['users'] = User::get(); 
    $data['article_status'] = Article_status::get(); 
    $data['car_type'] = Car_type::get(); 
    $data['product_brand'] = Product_brand::get(); 
    $data['product_color'] = Product_color::get();
    $data['department_sub_sub'] = Department_sub_sub::orderBy('DEPARTMENT_SUB_SUB_ID','DESC')->get(); 
    $dataedit = Article::where('article_id','=',$id)->first(); 

    return view('car.car_data_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function car_data_index_update(Request $request)
{  
        $idarticle = $request->article_id;     
        $update = Article::find($idarticle);
        $update->article_year = $request->input('article_year'); 
        $update->article_recieve_date = $request->input('article_recieve_date'); 
        $update->article_price = $request->input('article_price');  
        $update->article_num = $request->input('article_num');
        $update->article_name = $request->input('article_name');
        $update->article_attribute = $request->input('article_attribute');
        $update->article_register = $request->input('article_register');
        $update->store_id = $request->input('store_id'); 
        $update->article_car_gas = $request->input('article_car_gas'); 
        $update->article_car_number = $request->input('article_car_number');
        $update->article_serial_no = $request->input('article_serial_no');  
      
        $iduser = $request->input('article_user_id'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $update->article_user_id = $usersave->id; 
            $update->article_user_name = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $update->article_user_id = ''; 
            $update->article_user_name =''; 
        }

        $typeid = $request->input('article_typeid'); 
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id','=',$typeid)->first();
            $update->article_typeid = $typesave->sub_type_id; 
            $update->article_typename = $typesave->sub_type_name; 
        } else {
            $update->article_typeid = ''; 
            $update->article_typename =''; 
        }

        $groupid = $request->input('article_groupid');
        if ($groupid != '') {
                $groupsave = DB::table('product_group')->where('product_group_id','=',$groupid)->first();
                $update->article_groupid = $groupsave->product_group_id; 
                $update->article_groupname = $groupsave->product_group_name; 
        } else {
            $update->article_groupid = ''; 
            $update->article_groupname = ''; 
        }

        $decliid = $request->input('article_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id','=',$decliid)->first();
            $update->article_decline_id = $decsave->decline_id; 
            $update->article_decline_name = $decsave->decline_name; 
        }else{
            $update->article_decline_id = '';
            $update->article_decline_name = '';
        }

        $debid = $request->input('article_deb_subsub_id');
        if ($debid != '') {
            $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$debid)->first();
            $update->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID; 
            $update->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME; 
        }else{
            $update->article_deb_subsub_id = '';
            $update->article_deb_subsub_name = '';
        }

        $stsid = $request->input('article_status_id');
        if ($stsid != '') {
            $debsave = DB::table('article_status')->where('article_status_id','=',$stsid)->first();
            $update->article_status_id = $debsave->article_status_id; 
            $update->article_status_name = $debsave->article_status_name; 
        }else{
            $update->article_status_id = '';
            $update->article_status_name = '';
        }
        
        $brandid = $request->input('article_brand_id');
        if ($brandid != '') {
            $groupsave = DB::table('product_brand')->where('brand_id','=',$brandid)->first();
            $update->article_brand_id = $groupsave->brand_id; 
            $update->article_brand_name = $groupsave->brand_name; 
        } else {
            $update->article_brand_id = ''; 
            $update->article_brand_name = ''; 
        }

        $colorid = $request->input('article_color_id');
        if ($colorid != '') {
            $colsave = DB::table('product_color')->where('color_id','=',$colorid)->first();
            $update->article_color_id = $colsave->color_id; 
            $update->article_color_name = $colsave->color_name; 
        } else {
            $update->article_color_id = ''; 
            $update->article_color_name = ''; 
        }

        $typecarid = $request->input('article_car_type_id'); 
        if ($typecarid != '') {
            $typesave = DB::table('car_type')->where('car_type_id','=',$typecarid)->first();
            $update->article_car_type_id = $typesave->car_type_id; 
            $update->article_car_type_name = $typesave->car_type_name; 
        } else {
            $update->article_car_type_id = ''; 
            $update->article_car_type_name =''; 
        }

        $catid = $request->input('article_categoryid'); 
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id','=',$catid)->first();
            $update->article_categoryid = $catsave->category_id; 
            $update->article_categoryname = $catsave->category_name; 
        } else {
            $update->article_categoryid = ''; 
            $update->article_categoryname =''; 
        }
           

        if ($request->hasfile('article_img')) {
            $description = 'storage/article/'.$update->article_img;
            if (File::exists($description))
            {
                File::delete($description);
            }
            $file = $request->file('article_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            // $file->move('uploads/article/',$filename);
            $request->article_img->storeAs('article',$filename,'public');
            $update->article_img = $filename;
            $update->article_img_name = $filename;
        }

 
        $update->save(); 

        return response()->json([
            'status'     => '200'
            ]);
}
public function car_destroy(Request $request,$id)
{
   $del = Article::find($id);  
   $description = 'storage/car/'.$del->article_img;
   if (File::exists($description)) {
       File::delete($description);
   }
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}




public function car_ambulance(Request $request)
{   
    // $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    // ->get();  
    // $data['q'] = $request->query('q');
    // $query = Car_service::select('car_service_id','car_service_year','car_service_book','car_service_register','car_service_length_gotime','car_service_length_backtime',
    // 'car_service_status','car_service_reason','car_location_name','car_service_user_name','article_data.article_car_type_id','car_service_date','article_img' )
    // ->leftjoin('article_data','article_data.article_id','=','car_service.car_service_article_id')
    // ->leftjoin('car_location','car_location.car_location_id','=','car_service.car_service_location')
    // ->where(function ($query) use ($data){
    //     $query->where('car_service_status','like','%'.$data['q'].'%');
    //     $query->orwhere('car_service_date','like','%'.$data['q'].'%');
    //     $query->orwhere('car_service_reason','like','%'.$data['q'].'%');
    //     $query->orwhere('car_location_name','like','%'.$data['q'].'%');
    //     $query->orwhere('car_service_user_name','like','%'.$data['q'].'%'); 
    // })
    // ->where('article_data.article_car_type_id','=',2);
    // $data['car_service'] = $query->orderBy('car_service.car_service_id','DESC')->get();
    $startdate = $request->startdate;
    $enddate = $request->enddate;
    // dd($startdate);

    $data['car_service'] = DB::connection('mysql')->select('
        select a.car_service_id,a.car_service_year,a.car_service_book,a.car_service_register
            ,a.car_service_length_gotime,a.car_service_length_backtime,a.car_service_status,a.car_service_reason
            ,pb.car_location_name,a.car_service_user_name,s.article_car_type_id,a.car_service_date,s.article_img,a.car_service_length_backdate
            
            from car_service a
            left outer join article_data s on s.article_id = a.car_service_article_id 
            left outer join car_location pb on pb.car_location_id = a.car_service_location  

            where a.car_service_date between "' . $startdate . '" AND "' . $enddate . '"      
        ');

        $data['car_status'] = Car_status::where('car_status_code','=','allocate')->orwhere('car_status_code','=','allocateall')->orwhere('car_status_code','=','confirmcancel')->get();
        $data['users'] = User::get();
        $data['car_drive'] = Car_drive::get();

    return view('car.car_ambulance',$data,[
        'startdate'                =>  $startdate,
        'enddate'                  =>  $enddate,
    ]);
}

public function car_ambulancesearch(Request $request)
{   
    
    $startdate = $request->startdate;
    $enddate = $request->enddate;
    // dd($startdate);
    $data['car_service'] = DB::connection('mysql')->select('
        select a.car_service_id,a.car_service_year,a.car_service_book,a.car_service_register
            ,a.car_service_length_gotime,a.car_service_length_backtime,a.car_service_status,a.car_service_reason
            ,pb.car_location_name,a.car_service_user_name,s.article_car_type_id,a.car_service_date,s.article_img,a.car_service_length_backdate
            
            from car_service a
            left outer join article_data s on s.article_id = a.car_service_article_id 
            left outer join car_location pb on pb.car_location_id = a.car_service_location  

            where a.car_service_date between "' . $startdate . '" AND "' . $enddate . '"      
        ');

        // between "' . $strY . '" AND "' . $endY . '" 
        // where  a.car_service_date = "'.$startdate.'"  AND a.car_service_length_backdate = "'.$startdate.'" 
    $data['car_status'] = Car_status::where('car_status_code','=','allocate')->orwhere('car_status_code','=','allocateall')->orwhere('car_status_code','=','confirmcancel')->get();
    $data['users'] = User::get();
    $data['car_drive'] = Car_drive::get();

    return view('car.car_ambulance',$data,[
        'startdate'                =>  $startdate,
        'enddate'                  =>  $enddate,
    ]);
}







public function car_report(Request $request)
{   
    $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['book_objective'] = DB::table('book_objective')->get();
    $data['bookrep'] = DB::table('bookrep')->get();
    return view('car.car_report',$data);
}

function add_cartype(Request $request)
{     
 if($request->car_typename!= null || $request->car_typename != ''){    
     $count_check = Car_type::where('car_type_name','=',$request->car_typename)->count();   
        if($count_check == 0){    
                $add = new Car_type();  
                $add->car_type_name = $request->car_typename;
                $add->save(); 
        }
        }
            $query =  DB::table('car_type')->get();            
            $output='<option value="">--ประเภทรถ--</option>';                
            foreach ($query as $row){
                if($request->car_typename == $row->car_type_name){
                    $output.= '<option value="'.$row->car_type_id.'" selected>'.$row->car_type_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->car_type_id.'">'.$row->car_type_name.'</option>';
                }   
        }    
    echo $output;        
}

function add_carbrand(Request $request)
{     
 if($request->car_brandname!= null || $request->car_brandname != ''){    
     $count_check = Product_brand::where('brand_name','=',$request->car_brandname)->count();   
        if($count_check == 0){    
                $add = new Product_brand();  
                $add->brand_name = $request->car_brandname;
                $add->save(); 
        }
        }
            $query =  DB::table('product_brand')->get();            
            $output='<option value="">--ยี่ห้อรถ--</option>';                
            foreach ($query as $row){
                if($request->car_brandname == $row->brand_name){
                    $output.= '<option value="'.$row->brand_id.'" selected>'.$row->brand_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->brand_id.'">'.$row->brand_name.'</option>';
                }   
        }    
    echo $output;        
}
function add_carcolor(Request $request)
{     
 if($request->car_colorname!= null || $request->car_colorname != ''){    
     $count_check = Product_color::where('color_name','=',$request->car_colorname)->count();   
        if($count_check == 0){    
                $add = new Product_color();  
                $add->color_name = $request->car_colorname;
                $add->save(); 
        }
        }
            $query =  DB::table('product_color')->get();            
            $output='<option value="">--สีรถ--</option>';                
            foreach ($query as $row){
                if($request->car_colorname == $row->color_name){
                    $output.= '<option value="'.$row->color_id.'" selected>'.$row->color_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->color_id.'">'.$row->color_name.'</option>';
                }   
        }    
    echo $output;        
}

function adddrive(Request $request)
{     
 if($request->drivenew!= null || $request->drivenew != ''){    
    //  $count_check = Car_drive::where('car_type_name','=',$request->drivenew)->count();   
    $count_check = Car_drive::where('car_drive_user_id','=',$request->drivenew)->count(); 
    // dd($count_check);
        if($count_check == 0){    
                $add = new Car_drive();  
                // $add->car_type_name = $request->drivenew;
                $iduser = $request->drivenew; 
                if ($iduser != '') {
                    $usersave = DB::table('users')->where('id','=',$iduser)->first();
                    $add->car_drive_user_id = $usersave->id; 
                    $add->car_drive_user_name = $usersave->fname. '  ' .$usersave->lname ; 
                    $add->car_drive_user_position = $usersave->position_name; 
                } else {
                    $add->car_drive_user_id = ''; 
                    $add->car_drive_user_name =''; 
                    $add->car_drive_user_position =''; 
                }

                $add->save(); 
        }
        }
            $query =  DB::table('car_drive')->get();            
            $output='<option value="">--เลือก--</option>';                
            foreach ($query as $row){
                if($request->drivenew == $row->car_drive_user_id){
                    $output.= '<option value="'.$row->car_drive_user_id.'" selected>'.$row->car_drive_user_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->car_drive_user_id.'">'.$row->car_drive_user_name.'</option>';
                }   
        }    

        
    echo $output;        
}

}