<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Permislist;
use App\Models\Meetingroomservice;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
//--------------------------------------------check permis-------------------------------------

    public static function checkbook($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GMB001')
                           ->count();   
    
     return $count;
    }

    
    public static function checkhr($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GHR001')
                           ->count();   
    
     return $count;
    }

    public static function checkcar($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GCA001')
                           ->count();   
    
     return $count;
    }

    public static function checksafe($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GSA001')
                           ->count();   
    
     return $count;
    }

    public static function checkrenomal($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GRP001')
                           ->count();   
    
     return $count;
    }

    public static function checkrecom($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GRC001')
                           ->count();   
    
     return $count;
    }
    public static function checkremedical($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GRM001')
                           ->count();   
    
     return $count;
    }

    public static function checkleave($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GLE004')
                           ->count();   
    
     return $count;
    }

    public static function checkmeet($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GME002')
                           ->count();   
    
     return $count;
    }


    public static function checkasset($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GAS001')
                           ->count();   
    
     return $count;
    }


    public static function checksuplies($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GSU001')
                           ->count();   
    
     return $count;
    }


    public static function checkin($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GTS001')
                           ->count();   
    
     return $count;
    }


    public static function checkhorg($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','HORG')
                           ->count();   
     return $count;
    }
    
    public static function checkhhealth($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','HEAL')
                           ->count();   
    
     return $count;
    }
    

    public static function checkhdep($id_user)
    {
     $count =  DB::table('gleave_leader')->where('LEADER_ID','=',$id_user)->count();   
    
     return $count;
    }


    public static function checkhgroupdep($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GLE005')
        ->count();
     return $count;
    }

    public static function checkrisk($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMR001')
        ->count();    
    
     return $count;
    }
    public static function checkaccount($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMA001')
        ->count();    
    
     return $count;
    }
    public static function checkplan($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMP001')
        ->count();    
    
     return $count;
    }
    public static function checkwherehouse($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMW001')
        ->count();    
    
     return $count;
    }
    public static function checkmpay($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMP002')
        ->count();    
    
     return $count;
    }
    public static function checklaunder($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GML001')
        ->count();    
    
     return $count;
    }
    public static function checkguesthouse($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMG001')
        ->count();    
    
     return $count;
    }
    public static function checkenv($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMN001')
        ->count();    
    
     return $count;
    }
    public static function checkfood($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMF001')
        ->count();    
    
     return $count;
    }
    public static function checkcrm($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMC001')
        ->count();    
    
     return $count;
    }
    public static function checkcompensation($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMC002')
        ->count();    
    
     return $count;
    }

    public static function checkmedical($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','GMM001')
        ->count();    
    
     return $count;
    }
    public static function checkhappy_re($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','HAPPY01')
        ->count();    
    
     return $count;
    }
    public static function checkhappy_ed($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','HAPPY02')
        ->count();    

     return $count;
    }

    public function carcalendar()
    {


        $infocarnimal1 = DB::table('vehicle_car_reserve')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_reserve.STATUS','=','REGROUP')
        ->orwhere('vehicle_car_reserve.STATUS','=','SUCCESS')
        ->orwhere('vehicle_car_reserve.STATUS','=','LASTAPP')
        ->orwhere('vehicle_car_reserve.STATUS','=','RECERVE')
        ->get();


        $infocarnimal2 = DB::table('vehicle_car_reserve')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_reserve.STATUS','=','RECERVE')
        ->get();

        $infocarrefer = DB::table('vehicle_car_refer')
        ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_refer.STATUS','<>','CANCEL')
        ->get();
        
    
        return view('carcalendar_car',[
            'infocarnimal1s' => $infocarnimal1,
            'infocarnimal2s' => $infocarnimal2,
            'infocarrefers' => $infocarrefer   
        ]);
    }



         
  public function meetcalendar()
  {      
              $infoservice =  Meetingroomservice::leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
              ->leftJoin('meetingroom_service_status','meetingroom_service_status.STATUS_CODE','=','meetingroom_service.STATUS')
              ->where('meetingroom_service.STATUS','<>','CANCEL')
              ->orderBy('meetingroom_service.ID', 'desc')  
              ->get();
        return view('meetcalendar',[           
            'infoservices' => $infoservice
            
        ]);
  }


}
