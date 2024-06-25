<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Budgetyear;

class SetupbudgetController extends Controller
{
    public function infobudget()
    {
       
        $infobudget = Budgetyear::orderBy('LEAVE_YEAR_ID', 'desc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin.setupbudgetyear',[
            'infobudgets' => $infobudget 
        ]);
    }




    function switchactive(Request $request)
    {  
        //return $request->all(); 
        $id = $request->budget;
        $budgetactive = Budgetyear::find($id);
        $budgetactive->ACTIVE = $request->onoff;
        $budgetactive->save();
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin.setupbudgetyear_add');

    }

    public function save(Request $request)
    {
        //return $request->all();
    
       $checkstart= $request->DATE_BEGIN;
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

            $addbudgetyear = new Budgetyear(); 
            $addbudgetyear->LEAVE_YEAR_ID = $request->LEAVE_YEAR_ID;
            $addbudgetyear->LEAVE_YEAR_NAME = $request->LEAVE_YEAR_NAME;
            $addbudgetyear->DATE_BEGIN = $displaystartdate;
            $addbudgetyear->DATE_END = $condate;
            $addbudgetyear->DAY_PER_YEAR = $request->DAY_PER_YEAR;
            $addbudgetyear->ACTIVE = $request->ACTIVE;
           //dd($addbudgetyear);
 
            $addbudgetyear->save();


            return redirect()->route('setup.indexbudget'); 
    }

    public function edit(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $request->id;
     
       $inforbudget = Budgetyear::where('LEAVE_YEAR_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin.setupbudgetyear_edit',[
        'inforbudget' => $inforbudget 
        ]);

    }



    public function update(Request $request)
    {
        $id = $request->LEAVE_YEAR_ID; 

        $checkstart= $request->DATE_BEGIN;
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
 
      

        $updatebudgetyear = Budgetyear::find($id);
        $updatebudgetyear->LEAVE_YEAR_ID = $request->LEAVE_YEAR_ID;
        $updatebudgetyear->LEAVE_YEAR_NAME = $request->LEAVE_YEAR_NAME;
        $updatebudgetyear->DATE_BEGIN = $displaystartdate;
        $updatebudgetyear->DATE_END = $condate;
        $updatebudgetyear->DAY_PER_YEAR = $request->DAY_PER_YEAR;
        $updatebudgetyear->ACTIVE = $request->ACTIVE;
        $updatebudgetyear->save();
        
        
            return redirect()->route('setup.indexbudget'); 
    }

    
    public function destroy($id) { 
                
        Budgetyear::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexbudget');   
    }



    //-----------------------------ค้นหาเลือกปีงบ----


    function selectbudget(Request $request)
    {
                    function formate($strDate)
                    {
                    $strYear = date("Y",strtotime($strDate));
                    $strMonth= date("m",strtotime($strDate));
                    $strDay= date("d",strtotime($strDate));
                
                
                    return $strDay."/".$strMonth."/".$strYear;
                    }
        $yearbudget = $request->get('select');

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        

        $output = ' <div class="row">
        <div class="col-sm">
        วันที่
        </div>
  
        <div class="col-sm-4">
         
                <input  name = "DATE_BIGIN"  id="DATE_BIGIN"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  value="'.formate($displaydate_bigen).'" readonly>     
           
        </div>
        <div class="col-sm">
        ถึง 
        </div>
        <div class="col-sm-4">
   
        <input  name = "DATE_END"  id="DATE_END"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  value="'.formate($displaydate_end).'" readonly>
       
        </div>
        </div>';

        echo $output;

    }

    function selectyear(Request $request)
    {
        function formate($strDate)
        {
            $strYear = date("Y",strtotime($strDate));
            $strMonth= date("m",strtotime($strDate));
            $strDay= date("d",strtotime($strDate));
            return $strDay."/".$strMonth."/".$strYear;
        }
        $year = $request->get('select')-543;

        $displaydate_bigen = $year.'-01-01';
        $displaydate_end = $year.'-12-31';


        $output = ' <div class="row">
            <div class="col-sm">
                วันที่
            </div>

            <div class="col-sm-4">

                <input name="DATE_BIGIN" id="DATE_BIGIN" class="form-control input-lg datepicker"
                    data-date-format="mm/dd/yyyy" value="'.formate($displaydate_bigen).'" readonly>

            </div>
            <div class="col-sm">
                ถึง
            </div>
            <div class="col-sm-4">

                <input name="DATE_END" id="DATE_END" class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"
                    value="'.formate($displaydate_end).'" readonly>

            </div>
        </div>';

        echo $output;
    }


}
