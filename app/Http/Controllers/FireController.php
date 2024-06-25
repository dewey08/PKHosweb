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
use App\Models\Fire_pramuan;
use App\Models\Article_status;
use App\Models\Fire_pramuan_sub;
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
    public function fire_dashboard(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * from fire WHERE active="Y" ORDER BY fire_id DESC'); 

        return view('support_prs.fire.fire_dashboard',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function fire_main(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * from fire ORDER BY fire_id ASC'); 
        // WHERE active="Y"
        return view('support_prs.fire.fire_main',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function fire_detail(Request $request, $id)
    {

        // $dataprint = Fire::where('fire_id', '=', $id)->first();
        // dd($dataprint->fire_num);
        // $data_count = Fire_check::where('fire_num','=', $id)->count();
        $data_count = Fire::where('fire_num','=', $id)->count();
        // dd($data_count);
        if ($data_count < 1) {

            $arnum = $id;
            $data_detail = Fire::where('fire_num', '=', $id)->first();

            $data_detail2 = Fire::where('fire_num', '=', 'F9999999')->first();
            $signat = $data_detail2->fire_img_base;
            // dd($signat);          
            $pic_fire = base64_encode(file_get_contents($signat));  
            
            return view('support_prs.fire.fire_detail_null', [
                // 'dataprint'    => $dataprint,
                'arnum'        => $arnum,
                'data_detail'  => $data_detail,
                'pic_fire'     => $pic_fire
            ]);
        } else {
            $data_detail = Fire_check::leftJoin('users', 'fire_check.user_id', '=', 'users.id') 
            ->leftJoin('fire', 'fire.fire_num', '=', 'fire_check.fire_num') 
            ->where('fire_check.fire_num', '=', $id)
            ->get();

            $data_detail_ = Fire::where('fire_num', '=', $id)->first();
            $signat = $data_detail_->fire_img_base;
            $pic_fire = base64_encode(file_get_contents($signat));  
            // dd($data_detail);
            return view('support_prs.fire.fire_detail', [
                // 'dataprint'    => $dataprint,
                'data_detail'   => $data_detail,
                'data_detail_'  => $data_detail_,
                'pic_fire'      => $pic_fire,
                'id'            => $id
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
        $add->fire_date_pdd       = $request->fire_date_pdd; 
        $add->fire_date_exp       = $request->fire_date_exp; 

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
            // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[0])[0];   // .jpg .png .pdf            
            // $replace = substr($image_64, 0, strpos($image_64, ',')+1);             
            // // find substring fro replace here eg: data:image/png;base64,      
            // $image = str_replace($replace, '', $image_64);             
            // $image = str_replace(' ', '+', $image);             
            // $imageName = Str::random(10).'.'.$extension;
            // Storage::disk('public')->put($imageName, base64_decode($image));

            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $fire_num. '.' . $extention;
            $request->fire_imgname->storeAs('fire', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $add->fire_img            = $filename;
            $add->fire_imgname        = $filename;
            // $add->fire_imgname        = $destinationPath . $filename;

            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } 
            $add->fire_img_base       = $file64;
            // $add->fire_img_base_name  = $file65;
        }
 
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function fire_edit(Request $request,$id)
    {  
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->where('active','=',true)->orderBy('leave_year_id', 'DESC')->get();
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
        $data_edit                  = Fire::where('fire_id', '=', $id)->first();
        // $signat                     = $data_edit->fire_img_base;
        // dd($signat); 
        // $pic_fire = base64_encode(file_get_contents($signat)); 
        // dd($pic_fire); 
        return view('support_prs.fire.fire_edit', $data,[
            'data_edit'    => $data_edit,
            // 'pic_fire'     => $pic_fire
        ]);
    }
    public function fire_update(Request $request)
    { 
        $id = $request->fire_id;
        // $update_base = Fire::find($id); 
        // $update_base->fire_img_base   = '';
        // $update_base->save();

        $fire_num = $request->fire_num;
       
        $update = Fire::find($id); 
        $update->fire_year           = $request->fire_year;
        $update->fire_date           = $request->fire_date;
        $update->fire_num            = $fire_num;
        $update->fire_name           = $request->fire_name;
        $update->fire_price          = $request->fire_price;
        $update->active              = $request->active;
        $update->fire_location       = $request->fire_location; 
        $update->fire_size           = $request->fire_size;  
        $update->fire_color          = $request->fire_color; 
        $update->fire_date_pdd       = $request->fire_date_pdd; 
        $update->fire_date_exp       = $request->fire_date_exp; 

        $update->fire_qty            = '1'; 
        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $update->fire_brand = $bransave->brand_name;
        } else { 
            $update->fire_brand = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();             
            $update->fire_unit = $unisave->unit_name;
        } else {         
            $update->fire_unit = '';
        }
 
        if ($request->hasfile('fire_imgname')) {

            $description = 'storage/fire/' . $update->fire_imgname;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('fire_imgname'); 
            // $image_64 = $data['fire_imgname']; //your base64 encoded data
            // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[0])[0];   // .jpg .png .pdf            
            // $replace = substr($image_64, 0, strpos($image_64, ',')+1);             
            // // find substring fro replace here eg: data:image/png;base64,      
            // $image = str_replace($replace, '', $image_64);             
            // $image = str_replace(' ', '+', $image);             
            // $imageName = Str::random(10).'.'.$extension;
            // Storage::disk('public')->put($imageName, base64_decode($image));

            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $fire_num. '.' . $extention;
            $request->fire_imgname->storeAs('fire', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $update->fire_img            = $filename;
            $update->fire_imgname        = $filename;
            // $update->fire_imgname = $destinationPath . $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            }
            // $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
            // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
  
            $update->fire_img_base       = $file64;
            // $update->fire_img_base_name  = $file65;
        }
 
        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }

    public function fire_destroy(Request $request,$id)
    {
        $del = Fire::find($id);  
        $description = 'storage/fire/'.$del->fire_imgname;
        if (File::exists($description)) {
            File::delete($description);
        }
        $del->delete(); 
        // Fire::whereIn('fire_id',explode(",",$id))->delete();

        return response()->json(['status' => '200']);
    }
    
    public function fire_report_day(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $year = date('Y'); 
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $iduser = Auth::user()->id;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $datashow = DB::select(
                'SELECT c.fire_num,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$newDate.'" AND "'.$date.'"
                GROUP BY c.check_date,c.fire_num                
                '); 
        } else {
            $datashow = DB::select(
                'SELECT c.fire_num,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY c.check_date,c.fire_num                
            ');  
        }
         
        return view('support_prs.fire.fire_report_day',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
 
    public function fire_qrcode(Request $request, $id)
    {

            $dataprint = Fire::where('fire_id', '=', $id)->first();
            // $dataprint = Fire::where('fire_id', '=', $id)->get();

        return view('support_prs.fire.fire_qrcode', [
            'dataprint'  =>  $dataprint
        ]);

    }
    public function fire_qrcode_all(Request $request)
    {  
            $dataprint = Fire::get();

        return view('support_prs.fire.fire_qrcode_all', [
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
    public function fire_qrcode_detail_all(Request $request)
    {  
            $dataprint_main = Fire::get();
            // $dataprint_main = Fire::paginate();
            // $dataprint_main = Fire::paginate(12);
            // $dataprint = Fire::where('fire_id', '=', $id)->first();
            // foreach ($dataprint_main as $key => $value) {
            //     $data_detail  = Fire_check::where('fire_num', '=', $value->fire_num)->get();
            // }
            // $data_detail_ = $data_detail;
        // dd($dataprint_main);
        return view('support_prs.fire.fire_qrcode_detail_all', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }
    public function fire_pramuan_admin(Request $request)
    {  
        $dataprint_main = Fire::get();
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * from fire WHERE active="Y" ORDER BY fire_id DESC'); 
            
        return view('support_prs.fire.fire_pramuan_admin', [
            'startdate'       => $startdate,
            'enddate'         => $enddate, 
            'datashow'        => $datashow,
        ]);

    }
    public function fire_pramuan(Request $request)
    {  
            $dataprint_main = Fire::get();
            $datashow = DB::select('SELECT * from fire_pramuan ORDER BY fire_pramuan_id ASC'); 

        return view('support_prs.fire.fire_pramuan', [
            'dataprint_main'  =>  $dataprint_main, 
            'datashow'        =>  $datashow, 
        ]);

    }
    public function fire_pramuan_save(Request $request)
    {
        // $this->validate($request, [
        //     'student_id'   => 'required',
        //     'book_id'      => 'required',
        //     'quantity'     => 'required',
        // ]);

        // $student_id    = $request->input('student[]');
        // $book_id       = $request->input('book[]');
        // $quantity      = $request->input('quantity[]');  

        // for ($i = 0; $i < count($student_id); $i++) {
        //     $data = [
        //         'student_id' => $student_id[$i],
        //         'book_id' => $book_id[$i],
        //         'quantity' => $quantity[$i], 
        //     ];
        //     Fire_pramuan_sub::create($data);
        // }
        dd($request->all());
        $checked_array = $request->fire_pramuan_id;
        foreach ($request->fire_pramuan_name as $key => $value) {
            if (in_array($request->fire_pramuan_name[$key],$checked_array)) {
                $add                    = new Fire_pramuan_sub;
                $add->fire_pramuan_name = $request->fire_pramuan_name[$key];
                $add->pramuan_5         = $request->pramuan_5[$key];
                $add->pramuan_4         = $request->pramuan_4[$key];
                $add->pramuan_3         = $request->pramuan_3[$key];
                $add->pramuan_2         = $request->pramuan_2[$key];
                $add->pramuan_1         = $request->pramuan_1[$key];
                $add->pramuan_0         = $request->pramuan_0[$key];
                $add->save();
            }
            // return response()->json([
            //     'status'    => '200'
            // ]);
        }


        // $id      = $request->join_selected_values;
        // $name      = $request->join_selected_name;        
        // $startcount = '1'; 
        // $row_range = Fire_pramuan::whereIn('fire_pramuan_id',explode(",",$id))->get();
        // $data = array();
        // foreach ($row_range as $row ) {
        //     $data[] = [
        //         'fire_pramuan_id'            =>$row->fire_pramuan_id,
        //         'fire_pramuan_name'          =>$row->fire_pramuan_name,
        //         'fire_pramuan_name_number'   =>$name,
        //     ]; 
        //     $startcount++;
        // }
        // $for_insert = array_chunk($data, length:1000);
        // foreach ($for_insert as $key => $data_) { 
        //     Fire_pramuan_sub::insert($data_);  
        // }



        // $subs = [];
        // $id      = $request->ids;
        // $data = Fire_pramuan::where('fire_pramuan_id',$id)->get();
        // foreach ($data as $index => $unit) {
        //     $subs[] = [ 
        //         "fire_pramuan_id" => $fire_pramuan_id[$index], 
        //         "unit_title" => $unit_title[$index]
        //     ];
        // }
        
        // $created = Fire_pramuan_sub::insert($subs);

        // dd($id);
        // $name    = $request->join_selected_name;
        // $iduser = Auth::user()->id;
        // $data = Fire_pramuan::where('fire_pramuan_id',$id)->get();
            // Fire_pramuan::whereIn('acc_debtor_id',explode(",",$id))
            //         ->update([
            //             'stamp' => 'Y'
            //         ]);
        // foreach ($data as $key => $value) {
        // //         $date = date('Y-m-d H:m:s'); 
        //         Fire_pramuan_sub::insert([
        //             'fire_pramuan_id'                 => $value->fire_pramuan_id,
        //             'fire_pramuan_sub_name'           => $value->fire_pramuan_name,
        //             // 'fire_pramuan_name_number'        => $name, 
        //         ]);
        
        // }
        // dd($data);
        // return response()->json([
        //     'status'    => '200'
        // ]);
    }

    public function fire_qrcode_all๘๘๘๘(Request $request)
    {
      
        $dataprint = Fire::get();

        // $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate('string'));
        // $pdf = PDF::loadView('main.inventory.view_pdf', compact('qrcode'));
        // return $pdf->stream();
    
        $pdf = PDF::loadView('support_prs.fire.fire_qrcode_all',['dataprint'  =>  $dataprint]);
        return @$pdf->stream();
    }
    
 

 }