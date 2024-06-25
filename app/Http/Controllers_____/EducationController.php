<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{

    
    public function infousereducat(Request $request,$iduser)
    {
        $infoprevut =  DB::table('hrd_vut')->get();
        $inforpersonusereducatid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonusereducatid->ID;

        $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $infoeducation = Education::leftJoin('hrd_vut','hrd_tr_edu.VUT_ID','=','hrd_vut.VUT_ID')
                                     ->where('PERSON_ID','=',$iduser)
                                     ->orderBy('hrd_tr_edu.ID', 'desc')  
                                     ->get();

       //dd($infoeducation);
        return view('person.personinfousereducat',[
            'inforpersonusereducat' => $inforpersonusereducat,
            'inforpersonusereducatid' => $inforpersonusereducatid,
            'infoprevuts' => $infoprevut,
            'infoeducations' => $infoeducation 
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
            'VUT_ID' => 'required',
            'UNIVER_NAME' => 'required',
            'FAUCULTY' => 'required',
            'LAVEL' => 'required',
            'GRADE' => 'required',
            'START_DATE' => 'required',
            'CON_DATE' => 'required',
        ]);
    
       $checkstart= $request->START_DATE;
       $checkcon= $request->CON_DATE;

        if($checkstart != ''){

           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $displaystartdate= $y_st."-".$m_st."-".$d_st;
         

            }else{
            $displaystartdate= null;
        }
        
        if($checkcon != ''){
            $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
            $date_arrary=explode("-",$CONDAY); 
            
            $y_sub = $date_arrary[0]; 
            
            if($y_sub >= 2500){
                $y = $y_sub-543;
            }else{
                $y = $y_sub;
            }
               
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $condate= $y."-".$m."-".$d;
            }else{
            $condate= null;
            }

            $addedu = new Education(); 
            $addedu->PERSON_ID = $request->PERSON_ID;
            $addedu->VUT_ID = $request->VUT_ID;
            $addedu->LAVEL = $request->LAVEL; 
            $addedu->GRADE = $request->GRADE;
            $addedu->UNIVER_NAME = $request->UNIVER_NAME;
            $addedu->START_DATE = $displaystartdate;
            $addedu->CON_DATE = $condate;
            $addedu->USER_EDIT_ID = $request->USER_EDIT_ID;
            $addedu->FAUCULTY = $request->FAUCULTY;
            $addedu->save();

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfousereducat/'.$request->PERSON_ID)
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
            'VUT_ID_edit' => 'required',
            'UNIVER_NAME_edit' => 'required',
            'FAUCULTY_edit' => 'required',
            'LAVEL_edit' => 'required',
            'GRADE_edit' => 'required',
            'START_DATE_edit' => 'required',
            'CON_DATE_edit' => 'required',
        ]);

        $id = $request->ID; 

        $checkstart= $request->START_DATE_edit;
        $checkcon= $request->CON_DATE_edit;

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    if($checkcon != ''){
        $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
        $date_arrary=explode("-",$CONDAY); 
        $y_sub = $date_arrary[0]; 
        if($y_sub < 2500){
            $y = $y_sub;    
        }else{
            $y = $y_sub-543;
        }     
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $condate= $y."-".$m."-".$d;
        }else{
        $condate= null;
        }
 
      

        $educationedit = Education::find($id);
        $educationedit->START_DATE = $displaystartdate;
        $educationedit->CON_DATE = $condate;
        $educationedit->VUT_ID = $request->VUT_ID_edit;
        $educationedit->LAVEL = $request->LAVEL_edit; 
        $educationedit->GRADE = $request->GRADE_edit;
        $educationedit->UNIVER_NAME = $request->UNIVER_NAME_edit;
        $educationedit->USER_EDIT_ID = $request->USER_EDIT_ID;
        $educationedit->FAUCULTY = $request->FAUCULTY_edit;
    
        $educationedit->save();
        

           return response()->json([
            'status' => 1,
            'url' => url('person/personinfousereducat/'.$request->PERSON_ID)
        ]);

    }


    public function destroy($id,$iduser) { 
                
        Education::destroy($id);         
        return redirect()->route('person.infoedu',['iduser'=>  $iduser]);     
    }




}
