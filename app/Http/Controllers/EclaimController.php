<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\m_registerdata;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class EclaimController extends Controller
{
    public function eclaim_check(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        $claimcode = $request->claimcode;
        $hn = $request->hn;
        // $data = DB::select('select ci_code,ci_hn,ci_pid,ci_fullname from karn_ci where created_at between "'.$newDate.'" and "'.$date.'"');
       $data['claim'] =  DB::connection('mysql4')->select('SELECT * FROM m_registerdata 
                    WHERE HN ="'.$hn.'" 
                    ');
// AND ECLAIM_NO = "'.$claimcode.'"
        return view('eclaim.eclaim_check', $data,[
            'claimcode' =>   $claimcode,
            'hn'        =>   $hn
            ]);
    }
    public function eclaim_check_update(Request $request)
    {
            // $claimcode = $request->ECLAIM_NO;
            $hn = $request->HN;
            // $update = m_registerdata::find($claimcode);
            // $update->STATUS = $request->ECLAIM_STATUS;
            // $update->save;

            DB::connection('mysql4')->table('m_registerdata')
            ->where('HN','=', $hn)
            ->update([
                'STATUS' => $request->ECLAIM_STATUS 
            ]);   

            return response()->json([
                'status'             => '200'
            ]);
    }
    public function eclaim_check_edit(Request $request,$id)
    {  
        $code = m_registerdata::find($id);         
        return response()->json([
            'status'     => '200',
            'code'      =>  $code, 
            ]);
    }
}

