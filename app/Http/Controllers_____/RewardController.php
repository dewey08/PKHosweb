<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Reward;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function infouserreward(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserrewardid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserrewardid->ID;

        
        $inforpersonuserreward =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $inforeward= Reward::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_reward.ID', 'desc')  
        ->get();



       //dd($infoeducation);
      

        return view('person.personinfouserreward',[
            'inforpersonuserreward' => $inforpersonuserreward,
            'inforpersonuserrewardid' => $inforpersonuserrewardid,
            'inforewards' => $inforeward 
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
            'REWARD_NAME' => 'required',
            'DATE_RECEIVE' => 'required',
            'START_DATE' => 'required',
            'END_DATE' => 'required',
      
        ]);

       // return $request->all();
       $checkgive= $request->DATE_RECEIVE;
       $checkstart= $request->START_DATE;
       $checkcon= $request->END_DATE;

       if($checkgive != ''){
    
        $GIVEDAY = Carbon::createFromFormat('d/m/Y', $checkgive)->format('Y-m-d');
        $date_arrary_g=explode("-",$GIVEDAY);  
        $y_sub_g = $date_arrary_g[0]; 
        
        if($y_sub_g >= 2500){
            $y_g = $y_sub_g-543;
        }else{
            $y_g = $y_sub_g;
        }
        $m_g = $date_arrary_g[1];
        $d_g = $date_arrary_g[2];  
        $displaygivedate= $y_g."-".$m_g."-".$d_g;
     

        }else{
        $displaygivedate= null;
    }

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

            $addreward = new Reward(); 
            $addreward->PERSON_ID = $request->PERSON_ID;

            $addreward->REWARD_NAME = $request->REWARD_NAME;
          
            $addreward->DATE_RECEIVE = $displaygivedate;
            $addreward->START_DATE = $displaystartdate;
            $addreward->END_DATE = $condate;
          
            $addreward->COMMENTS = $request->COMMENTS;
        
            $addreward->USER_EDIT_ID = $request->USER_EDIT_ID;
          
            $addreward->save();

           // dd($addedu);
           // return redirect()->action('RewardController@infouserreward'); 
            // return redirect()->route('person.inforeward',['iduser'=>  $request->PERSON_ID]); 

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserreward/'.$request->PERSON_ID)
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
            'REWARD_NAME_edit' => 'required',
            'DATE_RECEIVE_edit' => 'required',
            'START_DATE_edit' => 'required',
            'END_DATE_edit' => 'required',
      
        ]);
        $id = $request->ID; 
 
        $checkgive= $request->DATE_RECEIVE_edit;
        $checkstart= $request->START_DATE_edit;
        $checkcon= $request->END_DATE_edit;
 
        if($checkgive != ''){
     
         $GIVEDAY = Carbon::createFromFormat('d/m/Y', $checkgive)->format('Y-m-d');
         $date_arrary_g=explode("-",$GIVEDAY);  
         $y_sub_g = $date_arrary_g[0]; 
         
         if($y_sub_g < 2500){
            $y_g = $y_sub_g;    
         }else{
            $y_g = $y_sub_g-543;
         }
         $m_g = $date_arrary_g[1];
         $d_g = $date_arrary_g[2];  
         $displaygivedate= $y_g."-".$m_g."-".$d_g;
      
 
         }else{
         $displaygivedate= null;
     }

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
 
        $rewardedit = Reward::find($id);
       
            $rewardedit->REWARD_NAME = $request->REWARD_NAME_edit; 
            $rewardedit->DATE_RECEIVE = $displaygivedate;
            $rewardedit->START_DATE = $displaystartdate;
            $rewardedit->END_DATE = $condate;
            $rewardedit->COMMENTS = $request->COMMENTS;
        
            $rewardedit->save();
       
      // dd($request->PERSON_ID);
    
 
            //
            //return redirect()->action('RewardController@infouserreward'); 
            // return redirect()->route('person.inforeward',['iduser'=>  $request->PERSON_ID]);

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfouserreward/'.$request->PERSON_ID)
            ]);

    }
    public function destroy($id,$iduser) { 
                
        Reward::destroy($id);         
        //return redirect()->action('RewardController@infouserreward');   
        return redirect()->route('person.inforeward',['iduser'=>  $iduser]);   
    }




}
