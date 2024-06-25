@extends('layouts.backend_admin')
  
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />
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

label{
            font-family: 'Kanit', sans-serif;
            font-size: 13px;
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
            <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"> เพิ่มรายการ รพสต.</h2>     
        <form  method="post" action="{{ route('setsmallhos.savesetupsmallhos') }}" enctype="multipart/form-data">
            @csrf
                <div class="row push">   
                    <div class="col-lg-1">
                        <label >รหัส รพสต.</label>
                    </div>
                    <div class="col-lg-2">
                        <input  name = "WAREHOUSE_SMALLHOS_CODE"  id="WAREHOUSE_SMALLHOS_CODE" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" required>
           
                    </div>                    
                    <div class="col-lg-1">
                        <label >ชื่อ รพสต.</label>
                    </div>
                    <div class="col-lg-8">
                        <input  name = "WAREHOUSE_SMALLHOS_NAME"  id="WAREHOUSE_SMALLHOS_NAME" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" required>
                      
                    </div>
                </div>
                  
                        <div class="modal-footer">
                            <div align="right">
                                <button type="submit"  class="btn btn-hero-sm btn-hero-info" ><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>
                                <a href="{{ url('admin_smallhos/setupsmallhos')  }}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')" ><i class="fas fa-window-close mr-2"></i>ยกเลิก</a> 
                            </div>
                        </div>
                </form>  
           

@endsection

@section('footer')

<script src="{{ asset('select2/select2.min.js') }}"></script>

@endsection