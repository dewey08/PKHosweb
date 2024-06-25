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
use App\Models\Medical_borrow;
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Building_level;
use App\Models\Building_level_room;
use App\Models\Building_room_type;
use App\Models\Building_type;
use App\Models\Car_location;
use App\Models\Carservice_signature;
use App\Models\Car_service_personjoin;
use App\Models\Car_drive;
use App\Models\Com_repaire;
use App\Models\Com_repaire_signature;
use App\Models\Com_repaire_speed;
use App\Models\Com_tec; 
use Auth;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class UserarticleController extends Controller
{ 
    
public function user_article(Request $request)
{   
    // $data['article_data'] = Article::where('article_categoryid','=','31')->orwhere('article_categoryid','=','63')->where('article_status_id','=','1')
    // $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','38')->where('article_status_id','=','1')
    // ->orderBy('article_id','DESC')
    // ->get(); 
    $iddebr = Auth::user()->dep_subsubtrueid;

    $data['article_data'] = DB::connection('mysql')->select('
            select a.article_id,a.article_num,a.article_attribute,a.article_price,a.article_year,a.article_name,pd.decline_name
            ,a.article_groupid,a.article_method_id,a.article_buy_id,a.article_decline_id,pc.category_name,pt.sub_type_name,pg.product_group_name
            ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME
            from article_data a 
            left outer join product_category pc on pc.category_id = a.article_categoryid 
            left outer join product_type pt on pt.sub_type_id = a.article_typeid
            left outer join product_group pg on pg.product_group_id = a.article_groupid
            left outer join product_decline pd on pd.decline_id = a.article_decline_id
            LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.article_deb_subsub_id   
            where a.article_deb_subsub_id = "'.$iddebr.'"
    ');  
    return view('user_article.user_article',$data);
} 
public function user_article_borrow(Request $request)
{   
    if(!empty($request->_token)){
        // $search = $request->search;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        session(['medical.med_borrow'=> $startdate]);
        session(['medical.med_borrow'=> $enddate]);
    }elseif(!empty(session('medical.med_borrow'))){
        $startdate = session('medical.med_borrow');
        $enddate = session('medical.med_borrow');
    }else{
        $startdate = '';
        $enddate = '';
    }
    
    $iddebr = Auth::user()->dep_subsubtrueid;
    $data['users'] = User::get();
    $data['article_data'] = Article::where('article_categoryid','=','31')->orwhere('article_categoryid','=','63')->where('article_status_id','=','1') 
    ->orderBy('article_id','DESC')
    ->get(); 

    $data['department_sub_sub'] = Department_sub_sub::get(); 
    $data['medical_borrow'] = DB::connection('mysql')->select('
                select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
                ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,m.medical_borrow_article_id
                ,m.medical_borrow_users_id,m.medical_borrow_backusers_id
                from medical_borrow m
                LEFT JOIN article_data a on a.article_id =m.medical_borrow_article_id
                LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id
                
                where m.medical_borrow_date between "'.$startdate.'" AND "'.$enddate.'"
                and m.medical_borrow_debsubsub_id = "'.$iddebr.'"
                
        '); 

    return view('user_article.user_article_borrow',$data,[
        'startdate'         =>  $startdate,
        'enddate'           =>  $enddate,
    ]);
}
public function user_article_borrowsave(Request $request)
{
        $date = date("Y-m-d H:i:s");
        $artcle = $request->medical_borrow_article_id;
        $artcleid = Article::where('article_id','=', $artcle)->first();

        DB::table('medical_borrow')->insert([
            'medical_borrow_date' => $request->medical_borrow_date,
            'medical_borrow_article_id' => $artcle,
            'medical_borrow_qty' => $request->medical_borrow_qty,

            // 'medical_borrow_fromdebsubsub_id' => $artcleid->article_deb_subsub_id,
            'medical_borrow_fromdebsubsub_id' => $artcleid->article_deb_subsub_id,

            'medical_borrow_debsubsub_id' => $request->medical_borrow_debsubsub_id,
            'medical_borrow_users_id' => $request->medical_borrow_users_id,
            'created_at' => $date,
            'updated_at' => $date
        ]);    
    return response()->json([
        'status'     => '200',
    ]);  
}
public function user_article_borrowupdate(Request $request)
{
    $id = $request->medical_borrow_id;
    $medical_borrowdate = $request->medical_borrow_date;
    $medical_borrow_qty = $request->medical_borrow_qty;
    $medical_borrowbackusers_id = $request->medical_borrow_backusers_id; 
    // $artcleid = Article::where('article_id','=', $id)->first();

    Medical_borrow::where('medical_borrow_id', $id) 
        ->update([
            'medical_borrow_date'                  => $request->medical_borrow_date,
            'medical_borrow_qty'                   => $request->medical_borrow_qty,
            'medical_borrow_debsubsub_id'          => $request->medical_borrow_debsubsub_id,
            'medical_borrow_article_id'            => $request->medical_borrow_article_id
        ]);

    // $article = Medical_borrow::where('medical_borrow_id', $id)->first();
   
    // $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$article->medical_borrow_fromdebsubsub_id)->first();
     
    // Article::where('article_id', $id) 
    // ->update([ 
    //     'article_deb_subsub_id'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_ID,
    //     'article_deb_subsub_name'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME
    // ]);

    return response()->json([
        'status'     => '200'
    ]);
}
public function med_index(Request $request)
{  
    $data['product_buy'] = Product_buy::get();
    $data['building_data'] = Building::leftjoin('product_decline','product_decline.decline_id','=','building_data.building_decline_id')->where('building_type_id','!=','1')->where('building_type_id','!=','5')->orderBy('building_id','DESC')->get();
    $data['article_data'] = Article::where('article_status_id','=','1')
    // $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','38')->where('article_status_id','=','1')
    ->orderBy('article_id','DESC')
    ->get(); 
   
    return view('medical.med_index',$data);
}
public function med_repair(Request $request)
{   
    $data['building_data'] = Building::leftjoin('product_decline','product_decline.decline_id','=','building_data.building_decline_id')->where('building_type_id','!=','1')->where('building_type_id','!=','5')->orderBy('building_id','DESC')->get();
    return view('medical.med_repair',$data);
}
public function med_report(Request $request)
{   
   
    $data['building_data'] = Building::leftjoin('product_decline','product_decline.decline_id','=','building_data.building_decline_id')->where('building_type_id','!=','1')->where('building_type_id','!=','5')->orderBy('building_id','DESC')->get();
    return view('medical.med_report',$data);
}
public function med_calenda(Request $request)
{  
    $ye = date('Y');
    $y = date('Y') + 543;
    $m = date('m');
    $d = date('d');
    $lotthai = $y . '-' . $m . '-' . $d;
    $loten = $ye . '-' . $m . '-' . $d;
    $data['budget_year'] = Budget_year::where('leave_year_id', '=', $y)->get(); 
    $data['users'] = User::get();
   
    $event = array();
    $medical = Medical_borrow::leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','medical_borrow.medical_borrow_debsubsub_id')
    ->get();

    foreach ($medical as $item) {
        if ($item->medical_borrow_active == 'REQUEST') {
            $color = 'rgb(235, 81, 10)';
        } elseif ($item->medical_borrow_active == 'SENDEB') {
            $color = 'rgb(89, 10, 235)';
        } elseif ($item->medical_borrow_active == 'APPROVE') {
            $color = 'rgb(10, 235, 160)';
        } elseif ($item->medical_borrow_active == 'cancel') {
            $color = '#ff0606';        
        } else {
            $color = '#499BFA';
        }
        $datestart = $item->medical_borrow_date;
        $backdate = $item->medical_borrow_backdate;
        $showtitle = $item->DEPARTMENT_SUB_SUB_NAME;
        $event[] = [
            'id' => $item->medical_borrow_id,
            'title' => $showtitle,
            'start' => $datestart,
            'end' => $backdate,
            'color' => $color
        ];
    }

    return view('medical.med_calenda', $data, [
        'events'     =>  $event,
        // 'dataedits'  =>  $dataedit
    ]);
}
public function med_borrow(Request $request)
{   
    if(!empty($request->_token)){
        // $search = $request->search;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        session(['medical.med_borrow'=> $startdate]);
        session(['medical.med_borrow'=> $enddate]);
    }elseif(!empty(session('medical.med_borrow'))){
        $startdate = session('medical.med_borrow');
        $enddate = session('medical.med_borrow');
    }else{
        $startdate = '';
        $enddate = '';
    }
    // $startdate = $request->startdate;
    // $enddate = $request->enddate;
  
    $data['users'] = User::get();
    $data['article_data'] = Article::where('article_categoryid','=','31')->orwhere('article_categoryid','=','63')->where('article_status_id','=','1') 
    ->orderBy('article_id','DESC')
    ->get(); 

    $data['department_sub_sub'] = Department_sub_sub::get();
    // $data['medical_borrow'] = DB::table('medical_borrow')
    // ->leftjoin('article_data','article_data.article_id','=','medical_borrow.medical_borrow_article_id')
    // ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','medical_borrow.medical_borrow_debsubsub_id')
    // ->orderBy('medical_borrow_id','DESC')->get();
    $data['medical_borrow'] = DB::connection('mysql')->select('
                select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
                ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,m.medical_borrow_article_id
                ,m.medical_borrow_users_id,m.medical_borrow_backusers_id
                from medical_borrow m
                LEFT JOIN article_data a on a.article_id =m.medical_borrow_article_id
                LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id
                
                where m.medical_borrow_date between "'.$startdate.'" AND "'.$enddate.'"
                
        '); 

    return view('medical.med_borrow',$data,[
        'startdate'         =>  $startdate,
        'enddate'           =>  $enddate,
    ]);
}
public function med_borrowsave(Request $request)
{
        $date = date("Y-m-d H:i:s");
        $artcle = $request->medical_borrow_article_id;
        $artcleid = Article::where('article_id','=', $artcle)->first();

        DB::table('medical_borrow')->insert([
            'medical_borrow_date' => $request->medical_borrow_date,
            'medical_borrow_article_id' => $request->medical_borrow_article_id,
            'medical_borrow_qty' => $request->medical_borrow_qty,

            'medical_borrow_fromdebsubsub_id' => $artcleid->article_deb_subsub_id,

            'medical_borrow_debsubsub_id' => $request->medical_borrow_debsubsub_id,
            'medical_borrow_users_id' => $request->medical_borrow_users_id,
            'created_at' => $date,
            'updated_at' => $date
        ]);    
    return response()->json([
        'status'     => '200',
    ]);      
    
}
public function med_borrowedit(Request $request,$id)
{
    $borrow =  Medical_borrow::leftjoin('article_data','article_data.article_id','=','medical_borrow.medical_borrow_article_id')
    ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','medical_borrow.medical_borrow_debsubsub_id')
    ->leftjoin('users','users.id','=','medical_borrow.medical_borrow_backusers_id')
    ->find($id);

    return response()->json([
        'status'     => '200',
        'borrow'      =>  $borrow,
    ]);
}
public function med_borrowupdate(Request $request)
{
    $id = $request->medical_borrow_id;
    $medical_borrowdate = $request->medical_borrow_date;
    $medical_borrowbackdate = $request->medical_borrow_backdate;
    $medical_borrowbackusers_id = $request->medical_borrow_backusers_id; 
    Medical_borrow::where('medical_borrow_id', $id) 
        ->update([
            'medical_borrow_date'                  => $medical_borrowdate,
            'medical_borrow_backdate'              => $medical_borrowbackdate,
            'medical_borrow_backusers_id'          => $medical_borrowbackusers_id,    
            'medical_borrow_active'                => 'SENDEB'
        ]);

    $article = Medical_borrow::where('medical_borrow_id', $id)->first();
   
    $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$article->medical_borrow_fromdebsubsub_id)->first();
     
    Article::where('article_id', $article->medical_borrow_article_id) 
    ->update([ 
        'article_deb_subsub_id'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_ID,
        'article_deb_subsub_name'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME
    ]);

    return response()->json([
        'status'     => '200'
    ]);
}
public function med_borrowupdate_status(Request $request,$id)
{
   
    Medical_borrow::where('medical_borrow_id', $id) 
        ->update([ 
            'medical_borrow_active'  => 'APPROVE'
        ]);

    $article = Medical_borrow::where('medical_borrow_id', $id)->first();
   
    $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$article->medical_borrow_debsubsub_id)->first();
     
    Article::where('article_id', $article->medical_borrow_article_id) 
    ->update([ 
        'article_deb_subsub_id'  => $article->medical_borrow_debsubsub_id,
        'article_deb_subsub_name'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME
    ]);


    return response()->json([
        'status'     => '200'
    ]);
}
 
 
}







