@extends('layouts.backend_admin')
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
<?php
  function Month($strMonth)
  {  

    $strMonthCut = Array("","มกราคม","กุมพาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strMonthThai";
    }


    function formate($strDate)
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
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">ตั้งค่าบริการอื่นฯ</h2>  
                    <a href="{{ url('admin_repair/Setupservicelist/add') }}"  class="btn btn-hero-sm btn-hero-info" ><i class="fas fa-plus"></i> เพิ่มข้อมูลบริการอื่นฯ</a>
            <div class="block-content">
                <div class="table-responsive">    
                  <table class="table-bordered table-striped table-vcenter js-dataTable-simple" width="100%">
                      <thead style="background-color: #FFEBCD;">
                          <tr  height="40">
                                <th  class="text-font" width="10%" style="border-color:#F0FFFF;text-align: center;">รหัส</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">บริการอื่นฯ</th>
                                <th  class="text-font" width="10%" style="border-color:#F0FFFF;text-align: center;">คำสั่ง</th>
                            </tr>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($infoservicelistT as $infoservicelist)
                              <tr  height="40">
                                    <td class="text-font" align="center" >{{ $infoservicelist-> SERVICE_LIST_ID }}</td> 
                                    <td class="text-font text-pedding" >{{ $infoservicelist-> SERVICE_LIST_NAME }}</td>
                                      
                                    <td align="center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 15px;font-weight:normal;">ทำรายการ</button>
                                        <div class="dropdown-menu" style="width:10px">
                                                <a class="dropdown-item" href="{{ url('admin_repair/Setupservicelist/edit/'.$infoservicelist-> SERVICE_LIST_ID )}}" style="font-family: 'Kanit', sans-serif; font-size: 15px;font-weight:normal;">แก้ไขข้อมูล</a>
                                                <a class="dropdown-item" href="{{ url('admin_repair/Setupservicelist/destroy/'.$infoservicelist-> SERVICE_LIST_ID )  }}" onclick="return confirm('ต้องการที่จะลบข้อมูลรหัส {{ $infoservicelist-> SERVICE_LIST_ID  }} ?')" style="font-family: 'Kanit', sans-serif; font-size: 15px;font-weight:normal;">ลบข้อมูล</a>                                
                                        </div>
                                      </div>
                                    </td>   
                              </tr> 
                          @endforeach 
                      </tbody>
                  </table>
            <br>
@endsection

@section('footer')

 <!-- Page JS Plugins -->
 <script src="{{ asset('asset/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
<!-- Page JS Code -->
 <script src="{{ asset('asset/js/pages/be_tables_datatables.min.js') }}"></script>

@endsection