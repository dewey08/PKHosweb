@extends('layouts.crm')
   
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">


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

label{
            font-family: 'Kanit', sans-serif;
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
<br>
<br>
<center>    
     <div class="block" style="width: 95%;">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B><i class="fas fa-plus"></i> เพิ่มทะเบียนผู้บริจาค</B></h3>
               

            </div>
        <div class="block-content block-content-full">
            <form action="{{ route('mcradle.infocradle_save') }}" method="post">
                @csrf       

            <div class="row push">
                <div class="col-sm-1 text-right">
                    <label>ชื่อ-นามสกุล :</label>
                </div> 
                <div class="col-lg-2">            
                    <input name="CRADLE_HR_NAME" id="CRADLE_HR_NAME" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;"  >
                </div>               
                <div class="col-sm-2 text-right">
                    <label>ภารกิจ :</label>
                </div> 
                <div class="col-lg-7">
                    <input name="CRADLE_DETAIL" id="CRADLE_DETAIL" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                </div>
            </div>

            <div class="row push">
                <div class="col-sm-1 text-right">
                    <label>วันที่ :</label>
                </div> 
                <div class="col-lg-2">            
                <input  name = "CRADLE_DATE"  id="CRADLE_DATE"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  readonly>
                </div>               
                <div class="col-sm-2 text-right">
                    <label>เวลาไป :</label>
                </div> 
                <div class="col-lg-2">
                <input name = "CRADLE_TIME_BEGIN"  id="CRADLE_TIME_BEGIN"  class="js-masked-time form-control" >
                </div>
                <div class="col-sm-2 text-right">
                    <label>เวลากลับ :</label>
                </div> 
                <div class="col-lg-2">
                <input  name = "CRADLE_TIME_END"  id="CRADLE_TIME_END"  class="js-masked-time form-control">
                </div>
            </div>
            <div class="row push">
                <div class="col-sm-1 text-right">
                    <label>อุปกรณ์เคลื่อนย้าย :</label>
                </div> 
                <div class="col-lg-11">            
                <input  name = "CRADLE_TOOL"  id="CRADLE_TOOL"  class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                </div>               
            </div>
            <hr>
        <div class="footer">
            <div align="right">
                <button type="submit"  class="btn btn-sm btn-info btn-lg" >บันทึกข้อมูล</button>
                    <a href="{{ url('manager_cradle/infocradle')}}" class="btn btn-sm btn-danger btn-lg" onclick="return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')" >ยกเลิก</a>
            </div>
        </div>
        </div>
    </div>
</div>


@endsection

@section('footer')

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>


 <script>
   $(document).ready(function () {
            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true                         //Set เป็นปี พ.ศ.
            });  //กำหนดเป็นวันปัจุบัน
    });

   

    function chkmunny(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9' )&& (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
    
  
</script>



@endsection