<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpertController extends Controller
{
    public function infouserexpert(Request $request,$iduser)
    {
    
        $inforpersonuserexpertid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserexpertid->ID;

        
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

        $infoexpert= Expert::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_expert.ID', 'desc')  
        ->get();



      

        return view('person.personinfouserexpert',[
            'inforpersonuserexpert' => $inforpersonuserexpert,
            'inforpersonuserexpertid' => $inforpersonuserexpertid,
            'infoexperts' => $infoexpert 
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
       // return $request->all();
    
            $request->validate([
                'EXPERT_NAME' => 'required',
                'EXPERT_DETAIL' => 'required',
                'EXPERT_EXAM' => 'required',
              
            ]);


            $addexpert = new Expert(); 
            $addexpert->PERSON_ID = $request->PERSON_ID;

            $addexpert->EXPERT_NAME = $request->EXPERT_NAME;
            $addexpert->EXPERT_DETAIL = $request->EXPERT_DETAIL; 
            $addexpert->EXPERT_EXAM = $request->EXPERT_EXAM;
            $addexpert->USER_EDIT_ID = $request->USER_EDIT_ID;
            $addexpert->save();


            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserexpert/'.$request->PERSON_ID)
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
            'EXPERT_NAME_edit' => 'required',
            'EXPERT_DETAIL_edit' => 'required',
            'EXPERT_EXAM_edit' => 'required',
          
        ]);


        $id = $request->ID; 


        $expertedit = Expert::find($id);
        $expertedit->EXPERT_NAME = $request->EXPERT_NAME_edit;
        $expertedit->EXPERT_DETAIL = $request->EXPERT_DETAIL_edit; 
        $expertedit->EXPERT_EXAM = $request->EXPERT_EXAM_edit;
        $expertedit->USER_EDIT_ID = $request->USER_EDIT_ID;
        $expertedit->save();
        

        return response()->json([
            'status' => 1,
            'url' => url('person/personinfouserexpert/'.$request->PERSON_ID)
        ]);

    }


    public function destroy($id,$iduser) { 
                
        Expert::destroy($id);         
        return redirect()->route('person.inforexp',['iduser'=>  $iduser]);  
    }


}
