<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Changename;
use Illuminate\Support\Facades\Auth;

class ChangenameController extends Controller
{
    public function infouserchangename(Request $request,$iduser)
    {
        $inforpersonuserchangeid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserchangeid->ID;

        
        $inforpersonuserchange =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $infochangename= Changename::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_changename.ID', 'desc')  
        ->get();
      

        return view('person.personinfouserchangename',[
            'inforpersonuserchange' => $inforpersonuserchange,
            'inforpersonuserchangeid' => $inforpersonuserchangeid,
            'infochangenames' => $infochangename 
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
        'DATE_CHANGE' => 'required',
        'NAMEOLD' => 'required',
        'NAMENEW' => 'required',
     
    ]);
    
       $checkstart= $request->DATE_CHANGE;


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
        
   

            $addchangname = new Changename(); 
            $addchangname->PERSON_ID = $request->PERSON_ID;
            $addchangname->DATE_CHANGE = $displaystartdate;
            $addchangname->NAMEOLD = $request->NAMEOLD; 
            $addchangname->NAMENEW = $request->NAMENEW;
           
            $addchangname->USER_EDIT_ID = $request->USER_EDIT_ID;
          
            $addchangname->save();

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserchangename/'.$request->PERSON_ID)
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
            'DATE_CHANGE_edit' => 'required',
            'NAMEOLD_edit' => 'required',
            'NAMENEW_edit' => 'required',
         
        ]);

        $id = $request->ID; 

        $checkstart= $request->DATE_CHANGE_edit;
    

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
    
  

        $changnameedit = Changename::find($id);
        $changnameedit->DATE_CHANGE = $displaystartdate;
        $changnameedit->NAMEOLD = $request->NAMEOLD_edit; 
        $changnameedit->NAMENEW = $request->NAMENEW_edit;
        $changnameedit->USER_EDIT_ID = $request->USER_EDIT_ID;
    
        $changnameedit->save();

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserchangename/'.$request->PERSON_ID)
            ]);
    }


    public function destroy($id,$iduser) { 
                
        Changename::destroy($id);         
        return redirect()->route('person.inforchangname',['iduser'=>  $iduser]);   
    }

      


}
