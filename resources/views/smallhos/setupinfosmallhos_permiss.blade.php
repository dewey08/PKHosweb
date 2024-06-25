@extends('layouts.backend_admin')
<link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" /> 
<style>
.center {
  margin: auto;
  width: 100%;
  padding: 10px;
}
body {
      font-family: 'Kanit', sans-serif;
      font-size: 10px;
      font-size: 1.0rem;
      }

label{
            font-family: 'Kanit', sans-serif;
            font-size: 10px;
            font-size: 1.0rem;
      } 

      
      .text-pedding{
   padding-left:10px;
                    }

        .text-font {
    font-size: 14px;
                  }   

</style>

@section('content')
<script>
  function checklogin(){
   window.location.href = '{{route("index")}}'; 
  }
  </script>
<?php
if(Auth::check()){
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;   
}else{
    
    echo "<body onload=\"checklogin()\"></body>";
    exit();
} 

$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos); 

if($status=='USER' and $user_id != $id_user  ){
    echo "You do not have access to data.";
    exit();
}
?>


           
                    <!-- Advanced Tables -->
                  
                <div class="content">
                <div class="block block-rounded block-bordered">

               
                <div class="block-content">    
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">
                <div class="row">
                <div class="col-md-5">
                สิทธิ์การเข้าถึงคลังของ {{$infosmall->WAREHOUSE_SMALLHOS_NAME}}
                </div>
                
             
               <div class="col-md-5">
               </div>
               <div class="col-md-2">
               <a href="{{ url('admin_warehouse/setupsuppliesinven') }}"  class="btn btn-success btn-lg"  >ย้อนกลับ</a>
             
               </div>
               </div>
                
                
                </h2> 
                       
                        <div class="row">
                            <div class="col-lg-8">
                               
                        <a href="" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add" ><i class="fas fa-plus"></i> เพิ่มข้อมูลคลัง</a>

                              </div>
                      
                      </div>   
                       
                        <div class="mt-3">
                        <div class="table-responsive">      
                
                  <table class="gwt-table table-striped table-vcenter js-dataTable-full" width="100%">
                  <thead style="background-color: #FFEBCD;">
                  
        <tr height="40">
        <th class="text-font" width="5%" style="border-color:#F0FFFF;text-align: center;">รหัส</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">คลังที่สามารถเข้าถึงได้</th>
            
        <th  class="text-font" width="5%" style="border-color:#F0FFFF;text-align: center;">ลบ</th>
        
        
      </tr>
                   </tr>
                   </thead>
                   <tbody id="myTable">
                   @foreach ($infopermissinvens as $infopermissinven)
                   <tr height="40">
                     <td class="text-font" align="center">{{ $infopermissinven->INVEN_SMALLHOS_ID }} </td>                 
                     <td class="text-font text-pedding">{{$infopermissinven->INVEN_SMALLHOS_NAMEINVEN}}</td> 
                   
                   
                     <td align="center">
                     <a href="{{ url('admin_smallhos/setupsmallhosinven_permis/destroyinvenpermis/'.$infopermissinven->INVEN_SMALLHOS_ID.'/'.$infopermissinven->INVEN_SMALLHOS_IDSMALL)  }}" class="btn btn-danger" onclick="return confirm('ต้องการที่จะลบข้อมูล {{$infopermissinven->INVEN_SMALLHOS_NAMEINVEN}} ?')"><i class=" fa fa-times"></i></a>
                     </td>   
                    
                   </tr> 
 
                   @endforeach 
                   </tbody>
                  </table>

                  


                  <div class="modal fade add" >
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                            <div class="modal-header">
                                  
                                  <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;"><i class="fas fa-plus"></i> เพิ่มข้อมูลคลัง</h2>
                                </div>
                                <div class="modal-body">
                                <body>
                                <form  method="post" action="{{ route('setsmallhos.saveinvenpermis') }}" >
                                @csrf
                                <div class="row">
                              <div class="col-lg-2">
                              <label >คลัง</label>
                              </div>
                              <div class="col-lg-5">
                              <select name="INVEN_SMALLHOS_IDINVEN" id="INVEN_SMALLHOS_IDINVEN" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" required>
                                            <option value="">--กรุณาเลือกคลัง--</option>
                                                @foreach ($infoinvens as $infoinven)                                                           
                                                  <option value="{{ $infoinven->INVEN_ID  }}">{{$infoinven->INVEN_NAME}}</option>  
                                                @endforeach 
                            </select>
                            <div style="color: red; font-size: 16px;" id="hr_id"></div>
                            </div>
                              </div>
                          
                              <input type="hidden" name="INVEN_SMALLHOS_IDSMALL" id="INVEN_SMALLHOS_IDSMALL" value="{{$infosmall->WAREHOUSE_SMALLHOS_ID}}">
                              
                              
                              </div>
                                <div class="modal-footer">
                                <div align="right">
                                <button type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึกข้อมูล</button>
                                <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal" >ยกเลิก</button>
                                </div>
                                </div>
                                </form>  
                        </body>
     
     
    </div>
  </div>
</div>

<br>
                       
                   </div>
               
                </div>
                 
                  
      
                      

@endsection

@section('footer')
<script src="{{ asset('select2/select2.min.js') }}"></script>
<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

<script>
  $(document).ready(function() {
    $('select').select2({
    width: '100%'
});


    });

 </script>
 

@endsection