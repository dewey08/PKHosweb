<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Cid;
use Illuminate\Support\Facades\Auth;

class CidController extends Controller
{
    public function infousercid(Request $request,$iduser)
    {
        $inforpersonusercidid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonusercidid->ID;

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

        $inforcid = Cid::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_cid_card.ID', 'desc')  
        ->get();

        return view('person.personinfousercid',[
            'inforpersonusereducat' => $inforpersonusereducat,
            'inforpersonusercidid' => $inforpersonusercidid,
            'inforcids' => $inforcid 
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$iduser)
    {
        $inforpersonusercid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonusercid->ID;

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

        return view('person.personinfousercid_add',[
            'inforpersonusereducat' => $inforpersonusereducat,
            'inforpersonusercid' => $inforpersonusercid
          
        ]);

    }
    public function save(Request $request)
    {
    
       $checkstart= $request->DATE_RECEIVE;
       $checkcon= $request->DATE_END;

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

            $addcid = new Cid(); 
            $addcid->PERSON_ID = $request->PERSON_ID;
            $addcid->CARD_CODE = $request->CARD_CODE;
       
            $addcid->DATE_RECEIVE = $displaystartdate;
            $addcid->DATE_END = $condate;
            $addcid->COMMENT = $request->COMMENT;

            $addcid->USER_EDIT_ID = $request->USER_EDIT_ID;

            if($request->hasFile('picture')){
                
                $file = $request->file('picture');  
                $contents = $file->openFile()->fread($file->getSize());
                $addcid->IMG = $contents;   

            }
       
            $addcid->save();


           return redirect()->route('person.inforcid',['iduser'=>  $request->PERSON_ID]);

    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id,$iduser)
    {
    
       $id_in= $request->id;
       $inforpersonusercid =  Person::where('ID','=',$iduser)->first();
      

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

       $inforcid = Cid::where('ID','=',$id_in)
       ->first();

        return view('person.personinfousercid_edit',[
        'inforpersonusereducat' => $inforpersonusereducat,
        'inforpersonusercid' => $inforpersonusercid,
        'inforcid' => $inforcid 
        ]);

    }

    public function update(Request $request)
    {
        $id = $request->ID; 

        $checkstart= $request->DATE_RECEIVE;
        $checkcon= $request->DATE_END;

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
 
      

        $cidedit = Cid::find($id);
        $cidedit->CARD_CODE = $request->CARD_CODE;
       
        $cidedit->DATE_RECEIVE = $displaystartdate;
        $cidedit->DATE_END = $condate;
        $cidedit->COMMENT = $request->COMMENT;

        $cidedit->USER_EDIT_ID = $request->USER_EDIT_ID;

        if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $cidedit->IMG = $contents;   
        }
    
        $cidedit->save();
        
           return redirect()->route('person.inforcid',['iduser'=>  $request->PERSON_ID]);

    }
 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$iduser) { 
                
        Cid::destroy($id);         
        return redirect()->route('person.inforcid',['iduser'=>  $iduser]);   
    }


}
