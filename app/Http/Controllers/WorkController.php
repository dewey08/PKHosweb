<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    public function infouserwork(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserworkid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserworkid->ID;

        
        $inforpersonuserwork =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $infowork= Work::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_work.DATEDO_WORK', 'desc')  
        ->get();



       //dd($infoeducation);
      

        return view('person.personinfouserwork',[
            'inforpersonuserwork' => $inforpersonuserwork,
            'inforpersonuserworkid' => $inforpersonuserworkid,
            'infoworks' => $infowork 
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
        'DATEDO_WORK' => 'required',
        'DATEDO_EXIT' => 'required',
        'BECOURSE_EXIT' => 'required',
        'POSITION_WORK' => 'required',
        'LOCATION_WORK' => 'required',
        'SALARY' => 'required',
    ]);
    
       $checkstart= $request->DATEDO_WORK;
       $checkcon= $request->DATEDO_EXIT;

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

            $addwork = new Work(); 
            $addwork->PERSON_ID = $request->PERSON_ID;

            $addwork->DATEDO_WORK = $displaystartdate;
            $addwork->DATEDO_EXIT = $condate;

            $addwork->BECOURSE_EXIT = $request->BECOURSE_EXIT;
            $addwork->POSITION_WORK = $request->POSITION_WORK; 
            $addwork->LOCATION_WORK = $request->LOCATION_WORK;
            $addwork->USER_EDIT_ID = $request->USER_EDIT_ID;
            $addwork->SALARY = $request->SALARY;
          
            
   
            $addwork->save();

           // dd($addedu);
            //return redirect()->action('WorkController@infouserwork');
            // return redirect()->route('person.infowork',['iduser'=>  $request->PERSON_ID]);  

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserwork/'. $request->PERSON_ID)
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
            'DATEDO_WORK_edit' => 'required',
            'DATEDO_EXIT_edit' => 'required',
            'BECOURSE_EXIT_edit' => 'required',
            'POSITION_WORK_edit' => 'required',
            'LOCATION_WORK_edit' => 'required',
            'SALARY_edit' => 'required',
        ]);

        $id = $request->ID; 

        $checkstart= $request->DATEDO_WORK_edit;
        $checkcon= $request->DATEDO_EXIT_edit;

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
 
        $workedit = Work::find($id);
            $workedit->DATEDO_WORK = $displaystartdate;
            $workedit->DATEDO_EXIT = $condate;

            $workedit->BECOURSE_EXIT = $request->BECOURSE_EXIT_edit;
            $workedit->POSITION_WORK = $request->POSITION_WORK_edit; 
            $workedit->LOCATION_WORK = $request->LOCATION_WORK_edit;
            $workedit->USER_EDIT_ID = $request->USER_EDIT_ID;
            $workedit->SALARY = $request->SALARY_edit;
       
        //dd($educationedit);
    
            $workedit->save();
        
            //
            //return redirect()->action('WorkController@infouserwork'); 
            // return redirect()->route('person.infowork',['iduser'=>  $request->PERSON_ID]); 

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserwork/'. $request->PERSON_ID)
            ]);

    }
    public function destroy($id,$iduser) { 
                
        Work::destroy($id);         
        //return redirect()->action('WorkController@infouserwork');  
        return redirect()->route('person.infowork',['iduser'=>  $iduser]);    
    }



}
