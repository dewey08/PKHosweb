<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Acc_debtor;
use App\Models\Pttype_eclaim;
use App\Models\Account_listpercen;
use App\Models\Leave_month;
use App\Models\Acc_debtor_stamp;
use App\Models\Acc_debtor_sendmoney;
use App\Models\Pttype;
use App\Models\Pttype_acc; 
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
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Product_buy;
use App\Models\Acc_stm_ucs_excel;
use App\Models\Article_status;
use App\Models\Land;
use App\Models\Cctv_report_months;
use App\Models\Product_budget;
use App\Models\Fire_check;
use App\Models\Fire;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\DissendeMail;
use Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
use Http;
use SoapClient;
use Str;
// use SplFileObject;
use Arr;
// use Storage;
use GuzzleHttp\Client;

use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\Acc_1102050101_217_stam;
use App\Models\Acc_opitemrece_stm;

use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set("Asia/Bangkok");


class FireController extends Controller
 { 
    public function fire_main(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * from fire WHERE active="Y" ORDER BY fire_id DESC'); 

        return view('support_prs.fire.fire_main',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function fire_detail(Request $request, $id)
    {

        $dataprint = Fire::where('fire_id', '=', $id)->first();
        // dd($dataprint->fire_num);
        $data_count = Fire_check::where('fire_num','=', $dataprint->fire_num)->count();
        // dd($data_count);
        if ($data_count < 1) {

            $arnum = $dataprint->fire_num;
            $data_detail = Fire::where('fire_num', '=', $dataprint->fire_num)->first();

            $data_detail2 = Fire::where('fire_num', '=', 'F9999999')->first();
            $signat = $data_detail2->fire_img_base;
            // dd($signat);
          
            $pic_fire = base64_encode(file_get_contents($signat));  
            return view('support_prs.fire.fire_detail_null', [
                'arnum'        => $arnum,
                'data_detail'  => $data_detail,
                'pic_fire'     => $pic_fire
            ]);
        } else {
            $data_detail = Fire_check::leftJoin('users', 'fire_check.user_id', '=', 'users.id') 
            ->where('fire_check.fire_num', '=', $dataprint->fire_num)
            ->get();

            $data_detail = Fire::where('fire_num', '=', $dataprint->fire_num)->first();
            $signat = $data_detail->fire_img_base;

            // dd($data_detail);
            return view('support_prs.fire.fire_detail', [
                'dataprint'    => $dataprint,
                'data_detail'  => $data_detail,
                'pic_fire'     => $pic_fire,
                'id'           => $id
            ]);
        }
        
    }

    public function fire_add(Request $request)
    { 
        $data['article_data']       = DB::select('SELECT * from article_data WHERE cctv="Y" order by article_id desc'); 
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get();
        // $data['land_data']      = Land::get();
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get();
        // $data['product_method']     = Product_method::get();
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get();
        // $data['product_brand']   = Product_brand::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();

        return view('support_prs.fire.fire_add', $data);
    }
    public function fire_save(Request $request)
    {
        $fire_num = $request->fire_num;
        $add = new Fire();
        $add->fire_year           = $request->fire_year;
        $add->fire_date           = $request->fire_date;
        $add->fire_num            = $fire_num;
        $add->fire_name           = $request->fire_name;
        $add->fire_price          = $request->fire_price;
        $add->active              = $request->active;
        $add->fire_location       = $request->fire_location; 
        $add->fire_size           = $request->fire_size;  
        $add->fire_color          = $request->fire_color; 

        $add->fire_qty            = '1'; 
        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $add->fire_brand = $bransave->brand_name;
        } else { 
            $add->fire_brand = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $add->fire_unit = $unisave->unit_name;
        } else {         
            $add->fire_unit = '';
        }
 
        if ($request->hasfile('fire_imgname')) {
            $image_64 = $request->file('fire_imgname'); 
            // $image_64 = $data['fire_imgname']; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[0])[0];   // .jpg .png .pdf            
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);             
            // find substring fro replace here eg: data:image/png;base64,      
            $image = str_replace($replace, '', $image_64);             
            $image = str_replace(' ', '+', $image);             
            $imageName = Str::random(10).'.'.$extension;
            Storage::disk('public')->put($imageName, base64_decode($image));

            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $fire_num. '.' . $extention;
            $request->fire_imgname->storeAs('fire', $filename, 'public');    

            $destinationPath = public_path('/fire/');
            $image_64->move($destinationPath, $filename);
            $add->fire_img            = $filename;
            $add->fire_imgname = $destinationPath . $filename;

            $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
            $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
  
            $add->fire_img_base       = $file64;
            $add->fire_img_base_name  = $file65;
        }

        // if (request()->hasFile('imagePath')){
        //     $uploadedImage = $request->file('imagePath');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $destinationPath = public_path('/images/productImages/');
        //     $uploadedImage->move($destinationPath, $imageName);
        //     $image->imagePath = $destinationPath . $imageName;
        // }
        //   $fire_imgname = str_replace('data:image/png;base64,', '', $fire_imgname);
            // $image = str_replace(' ', '+', $fire_imgname);
            // $imageName = str_random(10).'.'.'png';
        // $add->fire_img = $fire_imgname;
        // $image = $request->image;  // your base64 encoded
        // $image = str_replace('data:image/png;base64,', '', $image);
        // $image = str_replace(' ', '+', $image);
        // $imageName = str_random(10).'.'.'png';
        // \File::put(storage_path(). '/' . $imageName, base64_decode($image));

        // $image = str_replace('data:image/jpeg;base64,', '', $image);
        // $image = str_replace(' ', '+', $image);
        // $imageName = str_random(10).'.'.'jpg';
    

        // $image = str_replace('data:image/png;base64,', '', $image);
        // $image = str_replace(' ', '+', $image);
        // $imageName = str_random(10).'.'.'png';
    

        // $path     = "test/image.png";
        // $image    = explode(',',$imgbg);
        // $base64   = $image[1];
        // $result   = base64_decode($base64);

        // file_put_contents("ori.png", $result);
        // Storage::disk('ftp-dev')->put($path, $result);
        // // Example 1: Save as the default type (JPEG)
        // Storage::put('public/images/my_profile.jpeg', $file->encode());
        // // Example 2: Save as a PNG
        // Storage::put('public/images/my_profile.png', $file->encode('png'));

        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function fire_edit(Request $request,$id)
    { 
        $data['article_data']       = DB::select('SELECT * from article_data WHERE cctv="Y" order by article_id desc'); 
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get(); 
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get(); 
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get(); 
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();

        return view('support_prs.fire.fire_add', $data);
    }
    
    public function fire_report_day(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
         
        return view('support_prs.fire.fire_report_day',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }
 
    public function fire_qrcode(Request $request, $id)
    {

            $dataprint = Fire::where('fire_id', '=', $id)->first();

        return view('support_prs.fire.fire_qrcode', [
            'dataprint'  =>  $dataprint
        ]);

    }
    public function fire_qrcode_detail(Request $request, $id)
    {

        $dataprint = Fire::where('fire_id', '=', $id)->first();
        $data_detail = Fire_check::where('fire_num', '=', $dataprint->fire_num) 
        // ->leftJoin('users', 'fire_check.user_id', '=', 'users.id')
        ->get();
      
        
        return view('support_prs.fire.fire_qrcode_detail', [
            'dataprint'    => $dataprint,
            'data_detail'  => $data_detail,
            'id'           => $id
        ]);

    }
     
 

 }