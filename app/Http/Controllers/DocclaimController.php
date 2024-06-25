<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ins_eclaimxxx;
use App\Models\D_claim_db_hipdata_code;
use App\Models\D_claim;

use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class DocclaimController extends Controller
{ 
    public function doc_eclaim(Request $request)
    {
        $datashow = DB::connection('mysql')->select('SELECT * FROM doc_claim'); 
       
        return view('pkclaim.doc_eclaim',[
            'datashow'   => $datashow, 
        ]);
    }
    
    public function fs_eclaim_instu_eclaim(Request $request,$income)
    {
        $data['com_tec'] = DB::table('com_tec')->get(); 

        $datashow = DB::connection('mysql')->select('SELECT * FROM doc_claim'); 
      
        return view('pkclaim.fs_eclaim_instu_eclaim',[
            'datashow'    => $datashow,            
        ]);
    }

    public function fs_eclaim_editable(Request $request)
    {
        if ($request->ajax())
         {
            if ($request->action == 'Edit') 
            {
               $data = array(
                'price'    =>   $request->price,
                'price2'   =>   $request->price2,
                'price3'   =>   $request->price3,
               );
               DB::connection('mysql10')->table('nondrugitems')
               ->where('icode',$request->icode)
               ->update($data);
            }
            return request()->json($request);
        }
    }
}
