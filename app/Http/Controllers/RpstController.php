<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
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
use App\Models\Users_prefix;
use App\Models\Users_kind_type;
use App\Models\Users_group;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class RpstController extends Controller
{
    public function home_rpst(Request $request)
    {
        $client = new Client();
        $headers = [
          'Cookie' => 'MDFlYmFiOTktYTMzMi00OTNjLWI3NTItYTNlOTNkNmVjZmZm'
        ];
        // $request = new Request('GET', 'https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=2022-12-18&page=0&size=100&sort=claimDate,desc', $headers);
        // $res = $client->sendAsync($request)->wait();
        // echo $res->getBody();
        // $response = Http::get('https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=2022-12-18&page=0&size=100&sort=claimDate,desc&pid=1361000188847', $headers);
        // $response = Http::get('https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=2022-12-19&page=0&size=10&sort=claimDate,desc');

        // $response = Http::get('http://localhost:8189/api/smartcard/read?readImageFlag=true');

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();

        // $jsonData = $response->json();
        // echo "<pre> status:";
    	// print_r($response->status());
    	// echo "<br/> ok:";
    	// print_r($response->ok());
        // echo "<br/> successful:";
        // print_r($response->successful());
        // echo "<br/> serverError:";
        // print_r($response->serverError());
        // echo "<br/> clientError:";
        // print_r($response->clientError());
        // echo "<br/> headers:";
        // print_r($response->headers());
        // dd($response->body());
        // return $response;
        return view('rpst.home_rpst', $data );
    }
    public function p4p_activity (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();

        return view('p4p.p4p_activity ', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
     
 
}
