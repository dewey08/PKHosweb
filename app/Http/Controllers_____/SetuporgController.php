<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Org;

class SetuporgController extends Controller
{
    public function infoorg()
    {
       
        $infoorg = Org::first();
        $infoperson = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')
        ->where('hrd_person.HR_STATUS_ID', '=',1)
        ->get();

       //dd($infoorg);
        return view('admin.setuporg',[
            'infoorg' => $infoorg,
            'infopersons' =>$infoperson 
        ]);
    }

    
    function updatedate(Request $request)
    {  
      
    

        //return $request->all(); 
        $id = $request->ORG_ID;
        $orgactive = Org::find($id);
        $orgactive->ORG_NAME = $request->ORG_NAME;
        $orgactive->ORG_INITIALS = $request->ORG_INITIALS;
        $orgactive->ORG_LEADER_ID = $request->ORG_LEADER_ID;
        $infopersonleader = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$orgactive->ORG_LEADER_ID)
        ->first(); 
       // dd($infopersonleader);
     
        $orgactive->ORG_LEADER = $infopersonleader->HR_PREFIX_NAME.' '.$infopersonleader->HR_FNAME.' '.$infopersonleader->HR_LNAME;


        $orgactive->ORG_ADDRESS = $request->ORG_ADDRESS;
        $orgactive->ORG_PHONE = $request->ORG_PHONE;
        $orgactive->ORG_EMAIL = $request->ORG_EMAIL;
        $orgactive->ORG_WEBSITE = $request->ORG_WEBSITE;
        $orgactive->ORG_FAX = $request->ORG_FAX;
        $orgactive->ORG_PCODE = $request->ORG_PCODE;
        $orgactive->ORG_LEADER = $request->ORG_LEADER;
        $orgactive->YEAR_NOW_ID = $request->YEAR_NOW_ID;
        $orgactive->ORG_POPULAR = $request->ORG_POPULAR;
        
        $orgactive->CHECK_HR_ID = $request->CHECK_HR_ID; 
        $infoperson_CHECK_HR_ID = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$orgactive->CHECK_HR_ID)
        ->first();   
        $orgactive->CHECK_HR_NAME = $infoperson_CHECK_HR_ID->HR_PREFIX_NAME.' '.$infoperson_CHECK_HR_ID->HR_FNAME.' '.$infoperson_CHECK_HR_ID->HR_LNAME;


        $orgactive->ORG_AMPHUR = $request->ORG_AMPHUR;
        $orgactive->ORG_AMPHUR_LEADER = $request->ORG_AMPHUR_LEADER;
        $orgactive->TYPE = $request->TYPE;
        $orgactive->ORG_LEADER_POSITION = $request->ORG_LEADER_POSITION;
        $orgactive->PROVINCE = $request->PROVINCE;
        $orgactive->DISTRICT = $request->DISTRICT;
        $orgactive->PROVINCE_DR_NAME = $request->PROVINCE_DR_NAME;
        $orgactive->PROVINCE_DR_POSITION = $request->PROVINCE_DR_POSITION;


        if($request->hasFile('picture')){
          
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $orgactive->img_logo = $contents;   
         
        }


        $orgactive->save();

        return redirect()->route('setup.indexhoorg');
    }
}
