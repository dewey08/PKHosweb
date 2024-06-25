<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Adduser;
use App\Models\Hrd_regalia;
use Illuminate\Support\Facades\Auth;

class PersonRegaliaController extends Controller
{
    public function viewMain(){
        $hrd_regalias = Hrd_regalia::get();
        $budget = DB::table('budget_year')->get();
        return view('person.regalia.main',[
            'hrd_regalias' => $hrd_regalias,
            'budget' => $budget
        ]);
    }

    public function addConfig(Request $req){

        $person_id = Auth::user()->PERSON_ID;

        $insertRegalia = Hrd_regalia::create([
            'HRD_REGALIA_ID' => $person_id,
            'YEAR_OF_RECEIPT' => $req->yearOfReceipt,
            'DAY_OF_RECEIPT' => $req->dayOfReceipt,
            'POSITION' => $req->position,
            'BADGE' => $req->badge,
            'BADGE_R_G_L' => $req->badgeRgl,
            'BADGE_R_G_D' => $req->badgeRgd,
            'ANNOUNCEMENT_DATE' => $req->announcementDate,
            'VOLUME' => $req->volume,
            'DUTY' => $req->duty,
            'NO' => $req->no,
            'AGENCY' => $req->agency
        ]);
    }

    public function viewEdit($id){

        $regalia = DB::table('hrd_regalias')->where('id', $id)->first();
        $budget = DB::table('budget_year')->get();
        // dd($regalias);
        return view('person.regalia.view_edit', [
            'regalia' => $regalia,
            'budget' => $budget
        ]);
    }

    public function editConfig(Request $req){
    
        $id = $req->id;


        $checkdayOfReceipt =  $req->dayOfReceipt;
        if($checkdayOfReceipt != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdayOfReceipt)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dayOfReceipt = $y_st."-".$m_st."-".$d_st;
            }else{
            $dayOfReceipt = null;
        }

        $checkeannouncementDate =  $req->announcementDate;

        if($checkeannouncementDate != ''){
            $VCODEDAY = Carbon::createFromFormat('d/m/Y', $checkeannouncementDate)->format('Y-m-d');
            $date_arrary_v=explode("-",$VCODEDAY);  
            $y_sub_v = $date_arrary_v[0]; 
            
            if($y_sub_v >= 2500){
                $y_v = $y_sub_v-543;
            }else{
                $y_v = $y_sub_v;
            }
             $m_v = $date_arrary_v[1];
             $d_v = $date_arrary_v[2];  
             $announcementDate= $y_v."-".$m_v."-".$d_v;
                }else{
             $announcementDate= null;
        }
  
        $updateRegalia = DB::table('hrd_regalias')->where('id', $id)->update([
            'YEAR_OF_RECEIPT' => $req->yearOfReceipt,
            'DAY_OF_RECEIPT' => $dayOfReceipt,
            'ANNOUNCEMENT_DATE' => $announcementDate ,
            'POSITION' => $req->position,
            'BADGE' => $req->badge,
            'BADGE_R_G_L' => $req->badgeRgl,
            'BADGE_R_G_D' => $req->badgeRgd,     
            'VOLUME' => $req->volume,
            'DUTY' => $req->duty,
            'NO' => $req->no,
            'AGENCY' => $req->agency
        ]);

        return redirect()->route('person.inforegalia.main',['id'=>$id]);

    }

    public function deleteConfig(Request $request,$id){
        
        $delete = DB::table('hrd_regalias')->where('id','=', $id)->delete();
        return redirect()->route('person.inforegalia.main',['id'=>$id]);
    }

}
