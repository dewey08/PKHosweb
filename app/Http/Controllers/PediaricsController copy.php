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
use App\Models\Check_sit;
use App\Models\Ssop_stm;
use App\Models\Ssop_session;
use App\Models\Ssop_opdx;
use App\Models\Pang_stamp_temp;
use App\Models\Ssop_token;
use App\Models\Ssop_opservices;
use App\Models\Ssop_dispenseditems;
use App\Models\Ssop_dispensing;
use App\Models\Ssop_billtran;
use App\Models\Ssop_billitems;
use App\Models\Claim_ssop;
use App\Models\Claim_sixteen_dru;
use App\Models\claim_sixteen_adp;
use App\Models\Claim_sixteen_cha;  
use App\Models\Claim_sixteen_cht;
use App\Models\Claim_sixteen_oop;
use App\Models\Claim_sixteen_odx;
use App\Models\Claim_sixteen_orf;
use App\Models\Claim_sixteen_pat;
use App\Models\Claim_sixteen_ins;
use App\Models\Claim_temp_ssop;
use App\Models\Claim_sixteen_opd;
use Auth;
use ZipArchive;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location; 
use SoapClient; 
use SplFileObject;
use App\Models\D_dru;
use App\Models\D_adp;
use App\Models\D_aer;
use App\Models\D_cha;  
use App\Models\D_cht;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_opd;
use App\Models\D_oop;
use App\Models\D_odx;
use App\Models\D_orf;
use App\Models\D_pat;
use App\Models\D_ins; 
use App\Models\D_irf;
use App\Models\D_lvd;
use App\Models\Export_temp;
 
 

class PediaricsController extends Controller
{
  
    public function prenatal_care(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate =='') {
            $data['data_anc'] = DB::connection('mysql2')->select('   
                SELECT w.ward,w.`name` as wardname
                ,count(distinct(i.an)) as total_an
                ,sum(i.adjrw)as sum_adjrw
                ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                ,count(DISTINCT(ii.an))as total_noadjre 
                FROM ipt i
                LEFT JOIN an_stat a  on  i.an=a.an
                LEFT JOIN ward  w  on  i.ward=w.ward
                #LEFT JOIN ward_backup1872566  ww on  i.ward=ww.ward
                LEFT JOIN ipt  ii  on  i.an=ii.an  and  ii.adjrw = ""
                WHERE i.dchdate  BETWEEN "'.$start.'" AND "'.$end.'"
                GROUP BY i.ward
            '); 
        } else {
            $data['data_anc'] = DB::connection('mysql2')->select('   
                SELECT w.ward,w.`name` as wardname
                ,count(distinct(i.an))as total_an
                ,sum(i.adjrw)as sum_adjrw
                ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                ,count(DISTINCT(ii.an))as total_noadjre 
                FROM ipt i
                LEFT JOIN an_stat a  on  i.an=a.an
                LEFT JOIN ward  w  on  i.ward=w.ward
                #LEFT JOIN ward_backup1872566  ww on  i.ward=ww.ward
                LEFT JOIN ipt  ii  on  i.an=ii.an  and  ii.adjrw = ""
                WHERE i.dchdate  BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY i.ward
            '); 
        }
         
        return view('anc.prenatal_care',$data,[
            'startdate'   => $startdate,
            'enddate'     => $enddate, 
            'start'       => $start,
            'end'         => $end, 
        ]);
    }

    public function prenatal_care_sub(Request $request,$ward,$startdate,$enddate)
    {  
            $data['data_anc'] = DB::connection('mysql2')->select('   
                SELECT  d.name as doctor,w.ward,w.`name` as wardname
                    ,count(distinct(i.an))as total_an
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre 
                    FROM  ipt i
                    LEFT JOIN an_stat a on  i.an=a.an
                    LEFT JOIN ward w on i.ward=w.ward
                    LEFT JOIN doctor d on i.incharge_doctor=d.`code`
                    #LEFT JOIN ward_backup1872566 ww on i.ward=ww.ward
                    LEFT JOIN ipt ii on i.an=ii.an and ii.adjrw = ""

                    WHERE 
                    i.ward = "'.$ward.'"
                    AND i.dchdate  BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    GROUP BY  i.incharge_doctor
 
            '); 
         
         
        return view('anc.prenatal_care_sub',$data,[
            'startdate'   => $startdate,
            'enddate'     => $enddate, 
        ]);
    }
   
     

}
