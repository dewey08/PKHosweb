<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function infousersalary(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonusersalaryid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonusersalaryid->ID;

        
        $inforpersonusersalary =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $infosalary= Salary::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_salary.ID', 'desc')  
        ->get();

      
       $infoposition = DB::table('hrd_position')->get();

       $infolevel = DB::table('hrd_level')->get();


        return view('person.personinfousersalary',[
            'infolevels' => $infolevel,
            'infopositions' => $infoposition,
            'inforpersonusersalary' => $inforpersonusersalary,
            'inforpersonusersalaryid' => $inforpersonusersalaryid,
            'infosalarys' => $infosalary 
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
        'SALARY_NUMBER' => 'required',
        'DATE_CHANGE' => 'required',
        'POSITION_ID' => 'required',
        'LAVEL_ID' => 'required',
        'SALARYNEW' => 'required'
     
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
        
      

            $addsalary = new Salary(); 
            $addsalary->PERSON_ID = $request->PERSON_ID;
            $addsalary->DATE_CHANGE = $displaystartdate;

            $addsalary->SALARY_NUMBER = $request->SALARY_NUMBER;   
            $addsalary->SALARYNEW = $request->SALARYNEW; 
            $addsalary->COMMENT = $request->COMMENT;

            
            $addsalary->POSITION_ID = $request->POSITION_ID;
            $nameposition = DB::table('hrd_position')->where('HR_POSITION_ID','=',$request->POSITION_ID)->first();
            $addsalary->POSITION_IN_WORK = $nameposition->HR_POSITION_NAME;

            $addsalary->LAVEL_ID = $request->LAVEL_ID;
            $namelevel = DB::table('hrd_level')->where('HR_LEVEL_ID','=',$request->LAVEL_ID)->first();
            $addsalary->LAVEL_NAME = $namelevel->HR_LEVEL_NAME;


            $addsalary->USER_EDIT_ID = $request->USER_EDIT_ID;
          
            $addsalary->save();

           // dd($addedu);
            //return redirect()->action('SalaryController@infousersalary'); 
            // return redirect()->route('person.inforsalary',['iduser'=>  $request->PERSON_ID]); 

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfousersalary/'.$request->PERSON_ID)
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
            'SALARY_NUMBER_edit' => 'required',
            'DATE_CHANGE_edit' => 'required',
            'POSITION_ID_edit' => 'required',
            'LAVEL_ID_edit' => 'required',
            'SALARYNEW_edit' => 'required'
            
    
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
    
 
      

        $salaryedit = Salary::find($id);
    
        $salaryedit->DATE_CHANGE = $displaystartdate;

        $salaryedit->SALARY_NUMBER = $request->SALARY_NUMBER_edit; 
        $salaryedit->SALARYNEW = $request->SALARYNEW_edit; 
        $salaryedit->COMMENT = $request->COMMENT;

          
        $salaryedit->POSITION_ID = $request->POSITION_ID_edit;
        $nameposition = DB::table('hrd_position')->where('HR_POSITION_ID','=',$request->POSITION_ID_edit)->first();
        $salaryedit->POSITION_IN_WORK = $nameposition->HR_POSITION_NAME;

        $salaryedit->LAVEL_ID = $request->LAVEL_ID_edit;
        $namelevel = DB::table('hrd_level')->where('HR_LEVEL_ID','=',$request->LAVEL_ID_edit)->first();
        $salaryedit->LAVEL_NAME = $namelevel->HR_LEVEL_NAME;


        $salaryedit->USER_EDIT_ID = $request->USER_EDIT_ID;
      
       
        //dd($educationedit);
    
        $salaryedit->save();
        
            //
            //return redirect()->action('SalaryController@infousersalary'); 
            // return redirect()->route('person.inforsalary',['iduser'=>  $request->PERSON_ID]);

            return response()->json([
                'status' => 1,
                'url' => url('person/personinfousersalary/'.$request->PERSON_ID)
            ]);

    }


    public function destroy($id,$iduser) { 
                
        Salary::destroy($id);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('person.inforsalary',['iduser'=>  $iduser]);    
    }


    //------------------------ฟังชันรายละเอียดเงินเดือน---

    public function salarydetail() { 

   
    $output='    
    <div id="detail_saraly" class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      <div class="modal-header">
       
      <div class="row">
      <div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียดประจำเดือน ตุลาคม 2562</h4></div>
      </div>
          </div>
          <div class="modal-body" >
             
  
                 
                         &nbsp;&nbsp;รายละเอียดรายรับ
                                <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;font-size: 13px;" >
                                  <thead style="background-color: #FFEBCD;">
                                  <tr height="20">
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                      <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                      <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                            
                                      <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">หน่วย</th>
                                      <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">ช่วงเวลา</th>
                              
                                  </tr >
                              </thead>
                              <tbody>     
                              
                         
                              </tbody>   
                              </table></div>  </div> 
                                
                                <div class="row push" align="right">
                                <div class="col-lg-10" align="left"> 
                                <br>
                                &nbsp;&nbsp;รายละเอียดรายจ่าย
                                
                                &nbsp;&nbsp;<table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;font-size: 13px;" >
                                <thead style="background-color: #FFEBCD;">
                                <tr height="20">
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                          
                        
                                </tr >
                            </thead>
                            <tbody>     
                            
                            </tbody>   
                          </table>
                      <BR>
                  
                      
       
             
          </div>
          <div class="modal-footer">
          <div align="right">
       
          <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">ปิดหน้าต่าง</button>
          </div>
          </div>
          </form>  
  </body>
       
       
      </div>
    </div>
  </div>
    ';

    echo $output;
                    }

}
