@extends('layouts.backend')
   
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
            font-size: 14px;
      }   

      
   .text-pedding{
   padding-left:10px;
                    }

        .text-font {
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
?>       
                    <!-- Advanced Tables -->
                    <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">{{ $inforpersonusertrain -> HR_PREFIX_NAME }}   {{ $inforpersonusertrain -> HR_FNAME }}  {{ $inforpersonusertrain -> HR_LNAME }}</h1>
                            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="content">
                <div class="block block-rounded block-bordered">

               
                <div class="block-content">    
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">ข้อมูลการอบรมเฉพาะทาง</h2>
                        <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add" ><i class="fas fa-plus"></i> เพิ่มข้อมูลการอบรมเฉพาะทาง</button>
                        <div class="mt-3">
                        <div class="table-responsive">      
                
                  <table class="gwt-table table-striped table-vcenter" width="100%">
                  <thead style="background-color: #FFEBCD;">
                  
                   <tr  height="40">
        <th  class="text-font" width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">วันเริ่มอบรม</th>
        <th  class="text-font" width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">วันที่สิ้นสุดอบรม</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หลักสูตร</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">สถาบัน</th>
        <th  class="text-font" width="8%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">คำสั่ง</th> 
        
     
                   </tr>
                   </thead>
                   <tbody>
                   @foreach ($infotrainspacials as $infotrainspacial)
                   <tr  height="20">
                     <td class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ DateThai($infotrainspacial-> DATE_BEGIN)}} </td> 
                     <td class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ DateThai($infotrainspacial-> DATE_END)}} </td> 
                     <td class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ $infotrainspacial-> TRAIN_NAME }}</td> 
                     <td class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ $infotrainspacial-> SCHOOL_NAME }}</td> 

                      <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                     <div class="dropdown">
                     <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 12px;font-weight:normal;">
                                                    ทำรายการ
                                                </button>
                                                <div class="dropdown-menu" style="width:10px">
                                                    <a class="dropdown-item" href="#edit_modal{{ $infotrainspacial -> ID }}" data-toggle="modal" style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">แก้ไขข้อมูล</a>
                                                    <a class="dropdown-item" href="{{ url('addpersoninfousertrainspacial/destroy/'.$infotrainspacial->ID.'/'.$infotrainspacial->PERSON_ID)  }}" onclick="return confirm('ต้องการที่จะลบข้อมูลหลักสูตรอบรม ?')" style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">ลบข้อมูล</a>
                                                  
                                                </div>
                    </div>
                     </td>                        

                   </tr> 

                   
<div id="edit_modal{{ $infotrainspacial -> ID }}" class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
     
          <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;">แก้ไขข้อมูลการอบรมเฉพาะทาง</h2>
        </div>
        <div class="modal-body">
        <body>
        <form  method="post" id="form_edit{{ $infotrainspacial -> ID }}" action="{{ route('addtrain.edit') }}" >
        @csrf
        <input type="hidden" name="ID" value="{{ $infotrainspacial -> ID }}"/>
        <div class="form-group">
        <div class="row">
      <div class="col-sm-3 text-left">
      <label >วันเริ่มศึกษา</label>
      </div>
      <div class="col-sm-9">
      <input  name = "DATE_BEGIN_edit"  id="DATE_BEGIN_edit"  class="form-control input-lg datepicker3 {{ $errors->has('DATE_BEGIN_edit') ? 'is-invalid' : '' }}" data-date-format="mm/dd/yyyy" value="{{ formate($infotrainspacial -> DATE_BEGIN) }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;" readonly>
      </div>
      </div>
      </div>
      <div class="form-group">
      <div class="row">
      <div class="col-sm-3 text-left">
      <label >วันสำเร็จการศึกษา</label>
      </div>
      <div class="col-sm-9">
      <input  name = "DATE_END_edit"  id="DATE_END_edit"  class="form-control input-lg datepicker4 {{ $errors->has('DATE_END_edit') ? 'is-invalid' : '' }}" data-date-format="mm/dd/yyyy" value="{{ formate($infotrainspacial -> DATE_END) }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;" readonly>
      </div>
      </div>
      </div>
   
      <div class="form-group">
      <div class="row">
      <div class="col-sm-3 text-left">
      <label >หลักสูตร</label>
      </div>
      <div class="col-sm-9">
      <input  name = "TRAIN_NAME_edit"  id="TRAIN_NAME_edit" class="form-control input-lg {{ $errors->has('TRAIN_NAME_edit') ? 'is-invalid' : '' }}" value="{{ $infotrainspacial -> TRAIN_NAME }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
      </div>
      </div>
      </div>
      <div class="form-group">
      <div class="row">
      <div class="col-sm-3 text-left">
      <label >สถาบัน</label>
      </div>
      <div class="col-sm-9">
      <input  name = "SCHOOL_NAME_edit"  id="SCHOOL_NAME_edit" class="form-control input-lg {{ $errors->has('SCHOOL_NAME_edit') ? 'is-invalid' : '' }}" value="{{ $infotrainspacial -> SCHOOL_NAME }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
      </div>
      </div>
      </div>
      

      <input type="hidden" name = "PERSON_ID"  id="PERSON_ID"  value="{{ $inforpersonusertrainid ->ID }} ">
      <input type="hidden" name = "USER_EDIT_ID"  id="USER_EDIT_ID" value="{{ $id_user }} ">


      </div>
        <div class="modal-footer">
        <div align="right">
        <span type="button"  class="btn btn-hero-sm btn-hero-info btn-submit-edit" onclick="editnumber({{ $infotrainspacial -> ID }});"><i class="fas fa-save"></i> &nbsp;บันทึกแก้ไขข้อมูล</span>
        <span type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal" ><i class="fas fa-window-close"></i> &nbsp;ยกเลิก</span>
        </div>
        </div>
        </form>  
</body>
     
     
    </div>
  </div>
</div>

                   @endforeach 
                   </tbody>
                  </table>

                  
                  <div class="modal fade add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    <div class="modal-header">
          
          <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;"> เพิ่มข้อมูลการอบรมเฉพาะทาง</h2>
        </div>
        <div class="modal-body">
        <body>
        <form  method="post" id="form_add" action="{{ route('addtrain.save') }}" >
        @csrf
        <div class="form-group">
        <div class="row">
      <div class="col-sm-3 text-left">
      <label >วันเริ่มศึกษา</label>
      </div>
      <div class="col-sm-9">
      <input  name = "DATE_BEGIN"  id="DATE_BEGIN"  class="form-control input-lg datepicker {{ $errors->has('DATE_BEGIN') ? 'is-invalid' : '' }}" data-date-format="mm/dd/yyyy" style=" font-family: 'Kanit', sans-serif;font-size: 14px;" readonly>
      </div>
      </div>
      </div>
      <div class="form-group">
      <div class="row">
      <div class="col-sm-3 text-left">
      <label >วันสำเร็จการศึกษา</label>
      </div>
      <div class="col-sm-9">
      <input  name = "DATE_END"  id="DATE_END"  class="form-control input-lg datepicker2 {{ $errors->has('DATE_END') ? 'is-invalid' : '' }}" data-date-format="mm/dd/yyyy"  style=" font-family: 'Kanit', sans-serif;font-size: 14px;" readonly>
      </div>
      </div>
      </div>
   
      <div class="form-group">
      <div class="row">
      <div class="col-sm-3 text-left">
      <label >หลักสูตร</label>
      </div>
      <div class="col-sm-9">
      <input  name = "TRAIN_NAME"  id="TRAIN_NAME" class="form-control input-lg {{ $errors->has('TRAIN_NAME') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
      </div>
      </div>
      </div>
      <div class="form-group">
      <div class="row">
      <div class="col-sm-3 text-left">
      <label >สถาบัน</label>
      </div>
      <div class="col-sm-9">
      <input  name = "SCHOOL_NAME"  id="SCHOOL_NAME" class="form-control input-lg {{ $errors->has('SCHOOL_NAME') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif;">
      </div>
      </div>
      </div>
      <input type="hidden" name = "PERSON_ID"  id="PERSON_ID"  value="{{ $inforpersonusertrainid ->ID }} ">
      <input type="hidden" name = "USER_EDIT_ID"  id="USER_EDIT_ID" value="{{ $id_user }} ">

      </div>
        <div class="modal-footer">
        <div align="right">
        <span type="button"  class="btn btn-hero-sm btn-hero-info btn-submit-add" ><i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล</span>
        <span type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal" ><i class="fas fa-window-close"></i> &nbsp;ยกเลิก</span>
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

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

<script>
  $('#edit_modal').on('show.bs.modal', function(e) {
    var Id = $(e.relatedTarget).data('id');
    var VUTId = $(e.relatedTarget).data('vutid');
    $(e.currentTarget).find('input[name="ID"]').val(Id);
    $(e.currentTarget).find('select[id="VUT_ID_edit[]"]').val(VUTId);

});

</script>

<script>
   $(document).ready(function () {
            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true               //Set เป็นปี พ.ศ.
            }).datepicker("setDate", 0);  //กำหนดเป็นวันปัจุบัน
    });

    $(document).ready(function () {
            
            $('.datepicker2').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true               //Set เป็นปี พ.ศ.
            }).datepicker("setDate", 0);  //กำหนดเป็นวันปัจุบัน
    });

    $(document).ready(function () {
            
            $('.datepicker3').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true               //Set เป็นปี พ.ศ.
            });  //กำหนดเป็นวันปัจุบัน
    });

    $(document).ready(function () {
            
            $('.datepicker4').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true               //Set เป็นปี พ.ศ.
            });  //กำหนดเป็นวันปัจุบัน
    });


    function chkmunny(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9' )&& (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
    

    $('body').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});




$('.btn-submit-add').click(function (e) { 



var form = $('#form_add');
formSubmit(form)
       
});

function editnumber(number){ 
            var form = $('#form_edit'+number);
            formSubmit(form)      
            }

  
</script>



@endsection