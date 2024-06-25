@extends('layouts.backend_small')
    
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

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
            font-size: 20px;
           
      } 
</style>


@section('content')

<style>
.center {
  margin: auto;
  width: 100%;
  padding: 10px;
}
body {
      font-family: 'Kanit', sans-serif;
      font-size: 14px;
    
      }

      label{
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
           
      } 

      @media only screen and (min-width: 1200px) {
label {
    float:right;
  }

      }

      .text-pedding{
   padding-left:10px;
                    }

        .text-font {
    font-size: 13px;
                  }   
                  .form-control {
    font-size: 13px;
                  }
                  table, td, th {
            border: 1px solid black;
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
    $idsmallhos = Auth::user()->SMALL_ID;   
}else{    
    echo "<body onload=\"checklogin()\"></body>";
    exit();
} 

$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos); 

$iduser = Auth::user()->id;



?>


           
                    <!-- Advanced Tables -->
                 
                <div class="content">
                <div class="block block-rounded block-bordered">

                <div class="block-content"> 
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">แก้ไขรหัสผ่าน {{ Auth::user()->name}}</h2>    

    
        <form  method="post" action="{{ route('smallhos.updatechangpasswordsmall') }}"  onSubmit="return checkpass()">
        @csrf 
        

        <input type="hidden"  name = "ID"  id="ID" value="{{ Auth::user()->id }}" >
       <?php $iduser = Auth::user()->SMALL_ID ?>

        <div style="color: red;" id="text"></div><br>
      <div class="row push">
      <div class="col-lg-2" >
      <label >รหัสผ่านใหม่</label>
      </div>
      <div class="col-lg-3">
      <input type="password"  name = "NEWPASSWORD"  id="NEWPASSWORD" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" >
      </div>
      </div>
      <div class="row push">
      <div class="col-lg-2" >
      <label >ยืนยันรหัสผ่าน</label>
      </div>
      <div class="col-lg-3">
      <input type="password" name = "CHECK_NEWPASSWORD"  id="CHECK_NEWPASSWORD" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;" >
      </div>
      </div>
    
      </div>
        <div class="modal-footer">
        <div align="right">
        <button  type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึกแก้ไขข้อมูล</button>
         <a href="{{ url('smalldashboard/?iduser='.$iduser)  }}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการแก้ไขข้อมูล ?')" >ยกเลิก</a> 
         </div>    
         </form> 
        </div>
      

   
   
      
@endsection



@section('footer')
<script>

function checkpass(){
  //  alert("Hello! I am an alert box!!");
var  text;
var  NEWPASSWORD = document.getElementById("NEWPASSWORD").value;
var  CHECK_NEWPASSWORD = document.getElementById("CHECK_NEWPASSWORD").value;




  if(NEWPASSWORD !== CHECK_NEWPASSWORD){
    document.getElementById("text").style.display = "";     
  text = "*กรุณาระบุรหัสผ่านให้ตรงกับยืนยันรหัสผ่าน";
  document.getElementById("text").innerHTML = text;
  

}


if(NEWPASSWORD !== CHECK_NEWPASSWORD){
   return false; 
}else if(NEWPASSWORD==null || NEWPASSWORD=='' || CHECK_NEWPASSWORD==null || CHECK_NEWPASSWORD==''){

  return false; 
}

}

</script>

@endsection