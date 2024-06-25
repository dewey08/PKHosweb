@extends('layouts.repairnomal')


@section('content')
<style>
.center {
  margin: auto;
  width: 100%;
  padding: 10px;
}
body {
      font-family: 'Kanit', sans-serif;
      font-size: 13px;
     
      }

      
      .text-pedding{
   padding-left:10px;
                    }

        .text-font {
    font-size: 13px;
                  }   

</style>
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
<?php
function RemoveDateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }


  function Removeformate($strDate)
{
  $strYear = date("Y",strtotime($strDate));
  $strMonth= date("m",strtotime($strDate));
  $strDay= date("d",strtotime($strDate));

  
  return $strDay."/".$strMonth."/".$strYear;
  }

  
?>

           
                    <!-- Advanced Tables -->
                   
                <div class="content">
                <div class="block block-rounded block-bordered">

    
                <div class="block-content">    
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">ตั้งค่าระบบที่ต้องการแจ้งซ่อม</h2>  
                       
                        <div class="row">
                            <div class="col-lg-8">
                                <a href="{{ url('manager_repairnomal/repairreinfosetting_typesystem/add') }}"  class="btn btn-hero-sm btn-hero-info" ><i class="fas fa-plus"></i> เพิ่มข้อมูล</a>
                      
                              </div>
                          
                      </div>   
                      
                      
                        <div class="mt-3">
                        <div class="table-responsive">      
                
                  <table class="gwt-table table-striped table-vcenter" width="100%">
                  <thead style="background-color: #FFEBCD;">
                  
                   <tr  height="40">
        <th  class="text-font" width="5%" style="border-color:#F0FFFF;text-align: center;">รหัส</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
        <th  class="text-font" width="8%" style="border-color:#F0FFFF;text-align: center;">คำสั่ง</th> 
        
        
      </tr>
                   </tr>
                   </thead>
                   <tbody id="myTable">
                   @foreach ($openforms as $openform)
                   <tr  height="40">
                     <td class="text-font" align="center" >{{ $openform-> OPENFORM_CODE }}</td> 
                     <td class="text-font text-pedding">{{ $openform-> OPENFORM_NAME }}</td>  
                     <td align="center" width="7%">
                      <div class="custom-control custom-switch custom-control-lg ">
                          @if($openform-> OPENFORM_STATUS == 'True' )
                              <input type="checkbox" class="custom-control-input" id="{{ $openform-> OPENFORM_ID }}" name="{{ $openform-> OPENFORM_ID }}" onchange="formrepairnormal_switchactive({{ $openform-> OPENFORM_ID }});" checked>
                          @else
                              <input type="checkbox" class="custom-control-input" id="{{ $openform-> OPENFORM_ID }}" name="{{ $openform-> OPENFORM_ID }}" onchange="formrepairnormal_switchactive({{ $openform-> OPENFORM_ID}});">
                          @endif
                              <label class="custom-control-label" for="{{ $openform-> OPENFORM_ID }}"></label>
                     </div>
                     </td>   
                                                           
                   </tr> 

    

                   @endforeach 
                   </tbody>
                  </table>
                 <br>
                      

@endsection

@section('footer')


<script>
 
 function switchactive(room){
      // alert(budget);
      var checkBox=document.getElementById(room);
      var onoff;

      if (checkBox.checked == true){
        onoff = "1";
  } else {
        onoff = "2";
  }
 //alert(onoff);

 var _token=$('input[name="_token"]').val();
      $.ajax({
              url:"{{route('setup.room')}}",
              method:"GET",
              data:{onoff:onoff,room:room,_token:_token}
      })
      }        
  
</script>

<script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>

@endsection