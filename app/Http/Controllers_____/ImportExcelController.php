<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\Hrdperson;
use App\Imports\Suppliesimport;
use App\Imports\Gleaveoverimport;
use App\Imports\Assetimport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon;
use App\Users;

date_default_timezone_set("Asia/Bangkok");

class ImportExcelController extends Controller
{
 
    public function hrdperson_excel(Request $request)
    {      
        $file = $request->HRD_PERSON_EXCEL;
        Excel::import(new Hrdperson,$file);
       return redirect()->route('person.all')->with('success','นำเข้าข้อมูลเรียบร้อยแล้ว');
    }
    public function hrdperson_excel_save(Request $request)
      {
        $person_id = $request->id;
        $fname = $request->hr_fname;
        $lname = $request->hr_lname;
        $email = $request->hr_email;
        $status = 'USER';
        $password = '$2y$10$F6X89Zc07fVsjyY1dZkaB.BzB49YXRCIykw0u8b9Lt/uvQc94OYbm';
       
        $number =count($person_id);
        $count = 0;
        for($count = 0; $count< $number; $count++)
        {        
            $add= new Users();
            $add->PERSON_ID = $person_id[$count];
            $add->name = $fname[$count];
            $add->password = $password;
            $add->email = $email[$count];           
            $add->status = $status;            
            $add->save();
         }
         return redirect()->route('person.all')->with('success','นำเข้า Users เรียบร้อยแล้ว');
     }

     public function importusers(Request $request)
     {
       $person = DB::table('users')
       ->leftJoin('hrd_person','users.PERSON_ID','=','hrd_person.ID')
       ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->get();
       return view('importusers',[
         'persons' => $person,
       ]);
     }


     public function supplies(Request $request)
     {
       $sup = DB::table('supplies')
        ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
      ->leftJoin('supplies_unit','supplies_unit.SUP_UNIT_ID','=','supplies.SUP_UNIT_ID')
      ->leftJoin('supplies_type_sub','supplies_type_sub.SUP_TYPE_SUP_ID','=','supplies.SUP_TYPE_SUP_ID')
       ->get();
       return view('supplies',[
         'sups' => $sup,
       ]);
     }

     function supplies_excel(Request $request)
     {      
         $file = $request->SUPPLIES_EXCEL;
         Excel::import(new Suppliesimport,$file);
        return redirect()->route('supplies')->with('success','นำเข้าข้อมูลวัสดุเรียบร้อยแล้ว');
     }

     function asset_excel(Request $request)
     {      
         $file = $request->ASSET_EXCEL;
         Excel::import(new Assetimport,$file);
        return redirect()->route('asset_article')->with('success','นำเข้าข้อมูลครุภัณฑ์เรียบร้อยแล้ว');
     }
     public function asset_article(Request $request)
     {
       $asset = DB::table('asset_article')->get();
       return view('asset_article',[
         'assets' => $asset,
       ]);
     }

     function leaveover_excel(Request $request)
     {      
         $file = $request->GLEAVEOVER_EXCEL;
         Excel::import(new Gleaveoverimport,$file);
        return redirect()->route('leaveover')->with('success','นำเข้าข้อมูลวันลาพักผ่อนเรียบร้อยแล้ว');
     }

     public function leaveover(Request $request)
     {
       $leaveover = DB::table('gleave_over')
       ->leftJoin('hrd_person','hrd_person.ID','=','gleave_over.PERSON_ID')
       ->leftJoin('hrd_status','hrd_status.HR_STATUS_ID','=','gleave_over.HR_PERSON_TYPE_ID')
       ->get();
       return view('leaveover',[
         'leaveovers' => $leaveover,
       ]);
     }
   
}
