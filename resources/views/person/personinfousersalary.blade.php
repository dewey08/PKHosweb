@extends('layouts.backend')
   
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
            font-size: 14px;
      } 

      
   .text-pedding{
   padding-left:10px;
   padding-right:10px;
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
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">{{ $inforpersonusersalary -> HR_PREFIX_NAME }}   {{ $inforpersonusersalary -> HR_FNAME }}  {{ $inforpersonusersalary -> HR_LNAME }}</h1>
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
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">ข้อมูลการเลื่อนขั้นเงินเดือน</h2>   
                        <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add" ><i class="fas fa-plus"></i> เพิ่มข้อมูลการเลื่อนขั้นเงินเดือน</button>
                        <div class="mt-3">
                  <div class="table-responsive"> 
                      <table class="gwt-table table-striped table-vcenter" width="100%">
                          <thead style="background-color: #FFEBCD;">                  
                              <tr height="40">
                                    <th class="text-font" width="20%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">เลขที่คำสั่ง</th>
                                    <th class="text-font" width="8%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ลงวันที่</th>
                                    <th class="text-font" width="15%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ตำแหน่ง</th>
                                    <th class="text-font" width="15%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ระดับ</th>
                                    <th class="text-font" width="15%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">เงินเดือนใหม่</th>   
                                    <th class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หมายเหตุ</th>     
                                    <th  class="text-font" width="8%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">คำสั่ง</th>                         
                                </tr>                  
                          </thead>
                          <tbody>
                          @foreach ($infosalarys as $infosalary)
                            <tr height="20">
                                  <td  class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ $infosalary-> SALARY_NUMBER }}</td>
                                  <td class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ DateThai($infosalary-> DATE_CHANGE)}} </td> 
                                  <td  class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ $infosalary-> POSITION_IN_WORK }}</td> 
                                  <td  class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ $infosalary-> LAVEL_NAME }}</td> 
                                  <td  class="text-font text-pedding" style="border-color:#F0FFFF;text-align: right;border: 1px solid black;">{{ number_format($infosalary-> SALARYNEW,2) }}</td> 
                                  <td class="text-font text-pedding" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ $infosalary-> COMMENT }}</td> 
                                  <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                                      <div class="dropdown">
                                          <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 12px;font-weight:normal;">
                                                                          ทำรายการ
                                          </button>
                                                    <div class="dropdown-menu" style="width:10px">
                                                      <a class="dropdown-item" href="#edit_modal{{ $infosalary -> ID }}" data-toggle="modal" style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">แก้ไขข้อมูล</a>
                                                      <a class="dropdown-item" href="{{ url('addpersoninfousersalary/destroy/'.$infosalary->ID.'/'.$infosalary->PERSON_ID)  }}" onclick="return confirm('ต้องการที่จะลบข้อมูลการเลือนขั้นเงินเดือน ?')" style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">ลบข้อมูล</a>
                                                    
                                                  </div>
                                      </div>
                                  </td>  
                            </tr>
                             <!--select2 modal form edit  -->
                            <script>
                              $(document).ready(function() {
                                $("#POSITION_ID_edit{{ $infosalary -> ID }}").select2({ 
                                  dropdownParent: $("#edit_modal{{ $infosalary -> ID }}") 
                                });
                                $("#LAVEL_ID_edit{{ $infosalary -> ID }}").select2({ 
                                  dropdownParent: $("#edit_modal{{ $infosalary -> ID }}") 
                                });
                              });
                            </script>
                            <!--end select2 modal form edit  -->
                                  <div id="edit_modal{{ $infosalary -> ID }}" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                      <div class="modal-header">
                                      
                                            <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;">แก้ไขข้อมูลการเลือนขั้นเงินเดือน</h2>
                                          </div>
                                          <div class="modal-body">
                                          <body>
                                          <form  method="post" id="form_edit{{ $infosalary -> ID }}"  action="{{ route('addsalary.edit') }}" >
                                          @csrf
                                          <input type="hidden" name="ID" value="{{ $infosalary -> ID }}"/>

                                          <div class="form-group">
                                          <div class="row">
                                        <div class="col-sm-3 text-left">
                                        <label >เลขที่คำสั่ง</label>
                                        </div>
                                        <div class="col-sm-9">
                                        <input  name = "SALARY_NUMBER_edit"  id="SALARY_NUMBER_edit"  class="form-control input-lg {{ $errors->has('SALARY_NUMBER_edit') ? 'is-invalid' : '' }}"  value="{{$infosalary-> SALARY_NUMBER}}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
                                        </div>
                                        </div>
                                        </div>

                                          <div class="form-group">
                                          <div class="row">
                                        <div class="col-sm-3 text-left">
                                        <label >ลงวันที่</label>
                                        </div>
                                        <div class="col-sm-9">
                                        <input  name = "DATE_CHANGE_edit"  id="DATE_CHANGE_edit"  class="form-control input-lg datepicker3 {{ $errors->has('DATE_CHANGE_edit') ? 'is-invalid' : '' }}" data-date-format="mm/dd/yyyy" value="{{ formate($infosalary-> DATE_CHANGE) }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;" readonly>
                                        </div>
                                        </div>
                                        </div>
                                      
                                        <div class="form-group">
                                        <div class="row">
                                        <div class="col-sm-3 text-left">
                                        <label >ตำแหน่ง</label>
                                        </div>
                                        <div class="col-sm-9">
                                      
                                        <select name="POSITION_ID_edit" id="POSITION_ID_edit{{ $infosalary -> ID }}" class="form-control input-lg {{ $errors->has('POSITION_ID_edit') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif; width: 100%;" >
                                                <option value="">--กรุณาเลือก--</option>
                                              @foreach ($infopositions as $infoposition) 

                                                  @if($infosalary-> POSITION_ID == $infoposition ->HR_POSITION_ID)
                                                  <option value="{{ $infoposition ->HR_POSITION_ID  }}" selected>{{ $infoposition->HR_POSITION_NAME }}</option>
                                                  @else
                                                  <option value="{{ $infoposition ->HR_POSITION_ID  }}">{{ $infoposition->HR_POSITION_NAME }}</option>
                                                  @endif
                                              
                                              @endforeach 
                                      </select>
                                        
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <div class="row">
                                        <div class="col-sm-3 text-left">
                                        <label >ระดับ</label>
                                        </div>
                                        <div class="col-sm-9">
                                    
                                        
                                        <select name="LAVEL_ID_edit" id="LAVEL_ID_edit{{ $infosalary -> ID }}" class="form-control input-lg {{ $errors->has('LAVEL_ID_edit') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif; width: 100%;" >
                                              <option value="">--กรุณาเลือก--</option>
                                              @foreach ($infolevels as $infolevel) 

                                                  @if($infosalary-> LAVEL_ID == $infolevel ->HR_LEVEL_ID)
                                                  <option value="{{ $infolevel ->HR_LEVEL_ID  }}" selected>{{ $infolevel->HR_LEVEL_NAME  }}</option>
                                                  @else
                                                  <option value="{{ $infolevel ->HR_LEVEL_ID  }}">{{ $infolevel->HR_LEVEL_NAME  }}</option>
                                                  @endif
                                            
                                              @endforeach 
                                        </select>
                                        
                                        </div>
                                        </div>
                                        </div>
                                    
                                        <div class="form-group">
                                        <div class="row">
                                        <div class="col-sm-3 text-left">
                                        <label >เงินเดือนใหม่</label>
                                        </div>
                                        <div class="col-sm-9">
                                        <input  name = "SALARYNEW_edit"  id="SALARYNEW_edit" OnKeyPress="return chkmunny(this)" class="form-control input-lg {{ $errors->has('SALARYNEW_edit') ? 'is-invalid' : '' }}" value="{{ $infosalary -> SALARYNEW }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <div class="row">
                                        <div class="col-sm-3 text-left">
                                        <label >หมายเหตุ</label>
                                        </div>
                                        <div class="col-sm-9">
                                        <input  name = "COMMENT"  id="COMMENT" class="form-control input-lg" value="{{ $infosalary -> COMMENT }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
                                        </div>
                                        </div>
                                        </div>

                                        <input type="hidden" name = "PERSON_ID"  id="PERSON_ID"  value="{{ $inforpersonusersalaryid ->ID }} ">
                                        <input type="hidden" name = "USER_EDIT_ID"  id="USER_EDIT_ID" value="{{ $id_user }} ">


                                        </div>
                                          <div class="modal-footer">
                                          <div align="right">
                                          <span type="button"  class="btn btn-hero-sm btn-hero-info btn-submit-edit" onclick="editnumber({{ $infosalary -> ID }});"><i class="fas fa-save"></i> &nbsp;บันทึกแก้ไขข้อมูล</span>
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

                  <div class="modal fade add" id="add_salary" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                        <div class="modal-header">
                              
                              <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;">เพิ่มข้อมูลการเลือนขั้นเงินเดือน</h2>
                            </div>
                            <div class="modal-body">
                            <body>
                            <form  method="post" id="form_add"  action="{{ route('addsalary.save') }}" >
                            @csrf

                            
                            <div class="form-group">
                            <div class="row">
                          <div class="col-sm-3 text-left">
                          <label >เลขที่คำสั่ง</label>
                          </div>
                          <div class="col-sm-9">
                          <input  name = "SALARY_NUMBER"  id="SALARY_NUMBER"  class="form-control input-lg {{ $errors->has('SALARY_NUMBER') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;" >
                          </div>
                          </div>
                          </div>

                            <div class="form-group">
                            <div class="row">
                          <div class="col-sm-3 text-left">
                          <label >ลงวันที่</label>
                          </div>
                          <div class="col-sm-9">
                          <input  name = "DATE_CHANGE"  id="DATE_CHANGE"  class="form-control input-lg datepicker {{ $errors->has('DATE_CHANGE') ? 'is-invalid' : '' }}" data-date-format="mm/dd/yyyy"  style=" font-family: 'Kanit', sans-serif;font-size: 14px;" readonly>
                          </div>
                          </div>
                          </div>
                        
                          <div class="form-group">
                          <div class="row">
                          <div class="col-sm-3 text-left">
                          <label >ตำแหน่ง</label>
                          </div>
                          <div class="col-sm-9">
                        
                          <select name="POSITION_ID" id="POSITION_ID" class="js-select2 form-control input-lg department_sub_sub {{ $errors->has('POSITION_ID') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif; width: 100%;" >
                                  <option value="">--กรุณาเลือก--</option>
                                @foreach ($infopositions as $infoposition) 
                                  <option value="{{ $infoposition ->HR_POSITION_ID  }}">{{ $infoposition->HR_POSITION_NAME }}</option>
                                @endforeach 
                        </select>
                          
                          </div>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="row">
                          <div class="col-sm-3 text-left">
                          <label >ระดับ</label>
                          </div>
                          <div class="col-sm-9">
                      
                          
                          <select name="LAVEL_ID" id="LAVEL_ID" class="js-select2 form-control input-lg department_sub_sub {{ $errors->has('LAVEL_ID') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif; width: 100%;" >
                                <option value="">--กรุณาเลือก--</option>
                                @foreach ($infolevels as $infolevel) 
                                  <option value="{{ $infolevel ->HR_LEVEL_ID  }}">{{ $infolevel->HR_LEVEL_NAME  }}</option>
                                @endforeach 
                          </select>
                          
                          </div>
                          </div>
                          </div>
                        <div class="form-group">
                          <div class="row">
                          <div class="col-sm-3 text-left">
                          <label >เงินเดือนใหม่</label>
                          </div>
                          <div class="col-sm-9">
                          <input  name = "SALARYNEW"  id="SALARYNEW" OnKeyPress="return chkmunny(this)"  class="form-control input-lg {{ $errors->has('SALARYNEW') ? 'is-invalid' : '' }}" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
                          </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                          <div class="col-sm-3 text-left">
                          <label >หมายเหตุ</label>
                          </div>
                          <div class="col-sm-9">
                          <input  name = "COMMENT"  id="COMMENT" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
                          </div>
                          </div>
                        </div>
                    
                        <input type="hidden" name = "PERSON_ID"  id="PERSON_ID"  value="{{ $inforpersonusersalaryid ->ID }} ">
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


<script src="{{ asset('select2/select2.min.js') }}"></script>
<script>
$(document).ready(function() {
   $(".js-select2 ").select2({ 
	dropdownParent: $("#add_salary") 
	});
});
</script>


@endsection