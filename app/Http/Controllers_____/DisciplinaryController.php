<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Hrddisciplinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplinaryController extends Controller
{
    public function infouserdiscip(Request $request,$iduser)
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

        $disciplinary= Hrddisciplinary::where('PERSON_ID','=',$id)
        ->orderBy('DISCIPLINARY_ID', 'desc')  
        ->get();
      

        return view('person.personinfouserdisciplinary',[
            'inforpersonuserexpert' => $inforpersonuserexpert,
            'inforpersonuserid' => $inforpersonuserid,
            'disciplinarys' => $disciplinary 
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
            'DISCIPLINARY_DATE' => 'required',
            'DISCIPLINARY_DETAIL' => 'required',
            'DISCIPLINARY_BLAME' => 'required',
            'DISCIPLINARY_NUMBER' => 'required',
            'DISCIPLINARY_REMARK' => 'required'
         
        ]);

       $checksdate= $request->DISCIPLINARY_DATE;

       if($checksdate != ''){

           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checksdate)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $discipdate= $y_st."-".$m_st."-".$d_st;
     

        }else{
        $discipdate= null;
    }


            $adddiscip = new Hrddisciplinary(); 
            $adddiscip->DISCIPLINARY_DATE = $discipdate;
            $adddiscip->PERSON_ID = $request->PERSON_ID;
            $adddiscip->DISCIPLINARY_DETAIL = $request->DISCIPLINARY_DETAIL;
            $adddiscip->DISCIPLINARY_BLAME = $request->DISCIPLINARY_BLAME;
            $adddiscip->DISCIPLINARY_NUMBER = $request->DISCIPLINARY_NUMBER;
            $adddiscip->DISCIPLINARY_REMARK = $request->DISCIPLINARY_REMARK;
          
            $adddiscip->save();

        return response()->json([
            'status' => 1,
            'url' => url('person/personinfouserdisciplinary/'.$request->PERSON_ID)
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
            'DISCIPLINARY_DATE_edit' => 'required',
            'DISCIPLINARY_DETAIL_edit' => 'required',
            'DISCIPLINARY_BLAME_edit' => 'required',
            'DISCIPLINARY_NUMBER_edit' => 'required',
            'DISCIPLINARY_REMARK_edit' => 'required'
         
        ]);
        $id = $request->ID; 
     
        $checksdate= $request->DISCIPLINARY_DATE_edit;

        if($checksdate != ''){
 
            
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $checksdate)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $discipdate= $y_st."-".$m_st."-".$d_st;
      
 
         }else{
         $discipdate= null;
     }

        $editdiscip = Hrddisciplinary::find($id);
        $editdiscip->DISCIPLINARY_DATE = $discipdate;
        $editdiscip->PERSON_ID = $request->PERSON_ID;
        $editdiscip->DISCIPLINARY_DETAIL = $request->DISCIPLINARY_DETAIL_edit;
        $editdiscip->DISCIPLINARY_BLAME = $request->DISCIPLINARY_BLAME_edit;
        $editdiscip->DISCIPLINARY_NUMBER = $request->DISCIPLINARY_NUMBER_edit;
        $editdiscip->DISCIPLINARY_REMARK = $request->DISCIPLINARY_REMARK_edit;
          
            $editdiscip->save();


            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserdisciplinary/'.$request->PERSON_ID)
            ]);

    }


    public function destroy($id,$iduser) { 
                
        Hrddisciplinary::destroy($id);           
        return redirect()->route('person.infouserdiscip',['iduser'=>  $iduser]); 
    }
}
