<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Operatetype;
use App\Models\Operatejob;


class SetupoperateController extends Controller
{


     public function infooperatetype()
    {
   
    $infooperatetype = Operatetype::orderBy('OPERATE_TYPE_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_operate.setupinfooperatetype',[
        'infooperatetypes' => $infooperatetype
    ]);
    }   

    public function createoperatetype(Request $request)
    {
  
        return view('admin_operate.setupinfooperatetype_add');

    }

    public function saveoperatetype(Request $request)
    {
        //return $request->all();

            $addoperatetype = new Operatetype(); 
            $addoperatetype->OPERATE_TYPE_NAME = $request->OPERATE_TYPE_NAME; 
            $addoperatetype->OPERATE_TYPE_UNIT_OT = $request->OPERATE_TYPE_UNIT_OT; 
            $addoperatetype->save();


            return redirect()->route('setup.indexoperatetype'); 
    }

    public function editoperatetype(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
       $infooperatetype = Operatetype::where('OPERATE_TYPE_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_operate.setupinfooperatetype_edit',[
        'infooperatetype' => $infooperatetype 
        ]);

    }



    public function updateoperatetype(Request $request)
    {
        $id = $request->OPERATE_TYPE_ID; 

        $updateoperatetype = Operatetype::find($id);
        $updateoperatetype->OPERATE_TYPE_NAME = $request->OPERATE_TYPE_NAME;
        $updateoperatetype->OPERATE_TYPE_UNIT_OT = $request->OPERATE_TYPE_UNIT_OT; 
           
           //dd($addbudgetyear);
 
        $updateoperatetype->save();


        return redirect()->route('setup.indexoperatetype'); 

    }

    
    public function destroyoperatetype($id) { 

        Operatetype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexoperatetype');   
    }

    //=======================ตั้งค่าเวร=======================================================

    
    public function infooperatejob()
    {
   
    $infooperatejob = Operatejob::leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')
    ->orderBy('OPERATE_JOB_ID', 'asc')  
    ->get();                     
      
   //dd($inforoom);
    return view('admin_operate.setupinfooperatejob',[
        'infooperatejobs' => $infooperatejob
    ]);
    }   

    public function createoperatejob(Request $request)
    {
        $hrd_department = DB::table('hrd_department_sub_sub')->get();
        $operatetype = DB::table('operate_type')->get();
        $operatecolor = DB::table('operate_color')->get();
  
  
        return view('admin_operate.setupinfooperatejob_add',[
            'hrd_departments' => $hrd_department,
            'operatetypes' => $operatetype,
            'operatecolors' => $operatecolor
        ]);

    }

    public function saveoperatejob(Request $request)
    {
        //return $request->all();

            $addoperatejob = new Operatejob(); 
            $addoperatejob->OPERATE_JOB_NAME = $request->OPERATE_JOB_NAME; 
            $addoperatejob->OPERATE_JOB_TIMEBIGEN = $request->OPERATE_JOB_TIMEBIGEN; 
            $addoperatejob->OPERATE_JOB_TIMEEND = $request->OPERATE_JOB_TIMEEND; 
            $addoperatejob->OPERATE_JOB_MONEY = $request->OPERATE_JOB_MONEY; 
            $addoperatejob->OPERATE_JOB_TYPE_ID = $request->OPERATE_JOB_TYPE_ID; 
            $addoperatejob->OPERATE_JOB_DETAIL = $request->OPERATE_JOB_DETAIL; 
            $addoperatejob->OPERATE_DEPARTMENT_SUB_SUB_ID = $request->OPERATE_DEPARTMENT_SUB_SUB_ID; 
            $addoperatejob->OPERATE_JOB_COLOR = $request->OPERATE_JOB_COLOR; 
            
            $addoperatejob->save();


            return redirect()->route('setup.indexoperatejob'); 
    }

    public function editoperatejob(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
       $infooperatejob = Operatejob::where('OPERATE_JOB_ID','=',$id_in)
       ->first();
        
       $hrd_department = DB::table('hrd_department_sub_sub')->get();
       $operatetype = DB::table('operate_type')->get();
       $operatecolor = DB::table('operate_color')->get();
  
  
 

        //dd($inforbudget);
        return view('admin_operate.setupinfooperatejob_edit',[
        'infooperatejob' => $infooperatejob,
        'hrd_departments' => $hrd_department,
        'operatetypes' => $operatetype,
        'operatecolors' => $operatecolor 
        ]);

    }



    public function updateoperatejob(Request $request)
    {
        $id = $request->OPERATE_JOB_ID; 

        $updateoperatejob = Operatejob::find($id);
        $updateoperatejob->OPERATE_JOB_NAME = $request->OPERATE_JOB_NAME; 
        $updateoperatejob->OPERATE_JOB_TIMEBIGEN = $request->OPERATE_JOB_TIMEBIGEN; 
        $updateoperatejob->OPERATE_JOB_TIMEEND = $request->OPERATE_JOB_TIMEEND; 
        $updateoperatejob->OPERATE_JOB_MONEY = $request->OPERATE_JOB_MONEY; 
        $updateoperatejob->OPERATE_JOB_TYPE_ID = $request->OPERATE_JOB_TYPE_ID; 
        $updateoperatejob->OPERATE_JOB_DETAIL = $request->OPERATE_JOB_DETAIL; 
        $updateoperatejob->OPERATE_DEPARTMENT_SUB_SUB_ID = $request->OPERATE_DEPARTMENT_SUB_SUB_ID; 
        $updateoperatejob->OPERATE_JOB_COLOR = $request->OPERATE_JOB_COLOR; 
        $updateoperatejob->save();
    
           
           //dd($addbudgetyear);
 
        $updateoperatejob->save();


        return redirect()->route('setup.indexoperatejob'); 

    }

    
    public function destroyoperatejob($id) { 

        Operatejob::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexoperatejob');   
    }


    
}
