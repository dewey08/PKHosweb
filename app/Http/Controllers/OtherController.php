<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtherController extends Controller
{
    public function infouserother(Request $request,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuserexpert =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $infofamily= Family::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_family.ID', 'desc')  
        ->get();



       //dd($infoeducation);
      

        return view('person.personinfouserother',[
            'inforpersonuserexpert' => $inforpersonuserexpert,
            'inforpersonuserid' => $inforpersonuserid,
            'infofamilys' => $infofamily 
        ]);
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {

       $request->validate([
        'NAME' => 'required',
        'TYPE' => 'required',
        'CID' => 'required',
        'ADDRESS' => 'required',
        'PHONE' => 'required'
    ]);


            $addfamily = new Family(); 
            $addfamily->PERSON_ID = $request->PERSON_ID;

            $addfamily->NAME = $request->NAME;
            $addfamily->TYPE = $request->TYPE; 
            $addfamily->CID = $request->CID;
            $addfamily->ADDRESS = $request->ADDRESS;
            $addfamily->PHONE = $request->PHONE;
            $addfamily->USER_EDIT_ID = $request->USER_EDIT_ID;
           
            $addfamily->save();


        return response()->json([
            'status' => 1,
            'url' => url('person/personinfouserother/'.$request->PERSON_ID)
        ]);

    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'NAME_edit' => 'required',
            'TYPE_edit' => 'required',
            'CID_edit' => 'required',
            'ADDRESS_edit' => 'required',
            'PHONE_edit' => 'required'
        ]);

        $id = $request->ID; 


        $familyedit = Family::find($id);
        $familyedit->NAME = $request->NAME_edit;
        $familyedit->TYPE = $request->TYPE_edit; 
        $familyedit->CID = $request->CID_edit;
        $familyedit->ADDRESS = $request->ADDRESS_edit;
        $familyedit->PHONE = $request->PHONE_edit;
        $familyedit->USER_EDIT_ID = $request->USER_EDIT_ID;
    
        $familyedit->save();
        
        

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserother/'.$request->PERSON_ID)
            ]);

    }


    public function destroy($id,$iduser) { 
                
        Family::destroy($id);         
        return redirect()->route('person.inforother',['iduser'=>  $iduser]); 
    }
}
