<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Biguser;
use App\Models\Fire_check;
use App\Models\Fire;
use ZanySoft\Zip\Zip;
use ZipArchive;
use Storage;
use File;
use Artisan;
use Exception;
use Illuminate\Support\Facades\DB;

class MobileController extends Controller
{  
    public function gleave_register()
    {
        // return response()->json([           
        //     Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME')
        //     ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        //     ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        //     ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        //     ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
        //     ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        //     ->where(function($q){
        //         $q->where('LEAVE_STATUS_CODE','=','Verify');    
        //     }) 
        //     ->orderBy('gleave_register.ID', 'desc')    
        //     ->get()
        //     ]);
        $gleave = Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        // ->where(function($q){
        //     $q->where('LEAVE_STATUS_CODE','=','Verify');    
        // }) 
        ->orderBy('gleave_register.ID', 'desc')    
        ->get();
       
       return response([$gleave]);
    }
    public function checkUser_app(Request $request)
    {     
         $Username = $request->username;
       
        //  $user = Biguser::where('username','=', $request->username)->first();
         $user = Biguser::first();
       $uget = Biguser::select('fullname','username','password','email','status')
         ->get();
         return response([$user, $uget]);
                // return response()->json([
                //     Biguser::select('fullname','username','password','email','status')
        
                //     ->get()
                // ]);
           
        // return response()->json([
            // Biguser::select('fullname','username','password','email','status')->where('username','=',$Username)
        //     Biguser::select('fullname','username','password','email','status')

        //     ->get()
        // ]);
    }
    public function zapuser(Request $request)
    {
        $zapuser =  Zapuser::all();
        return response([$zapuser]);
    }
    public function getfire(Request $request,$firenum)
    {    
        $firedata = Fire::where('fire_num','=', $firenum)->first();      
        $fire_ = Fire::where('fire_id','=', $firedata->fire_id)->get();
        // $fire_ = Fire::get();
         return response([$fire_]);
          
    }
    public function store(Request $request)
    {
    
        $add= new Zapuser();
        $add->zap_fullname = $request->zap_fullname;
        $add->zap_email = $request->zap_email;
        $add->zap_username = $request->zap_username;
        $add->zap_password = $request->zap_password;
        $add->save();

        $zapuser =  Zapuser::all();
        return response([$zapuser]);

    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
