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
      font-size: 14px;
      }

label{
            font-family: 'Kanit', sans-serif;
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


?>       
                    <!-- Advanced Tables -->
                    <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2" style="font-family: 'Kanit', sans-serif;font-size: 1.3rem;">{{ $inforpersonusereducat -> HR_PREFIX_NAME }}   {{ $inforpersonusereducat -> HR_FNAME }}  {{ $inforpersonusereducat -> HR_LNAME }}</h1>
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
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">แก้ไขข้อมูลยานพาหนะ</h2> 
    
        <form  method="post" action="{{ route('addofficial.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden"  name="ID" value="{{ $inforofficial -> ID }}"/>
        <div class="row push">
        <div class="col-lg-4">
        <div class="form-group">
        <img src="data:image/png;base64,{{ chunk_split(base64_encode($inforofficial->IMG)) }}" id="image_upload_preview"   height="250px" width="100%"/>
     
        </div>                             
        <div class="form-group">
        <input style="font-family: 'Kanit', sans-serif;" type="file" name="picture" id="picture" class="form-control">
        </div>
         </div>
       
    <div class="col-lg-4">
      <div class="form-group">
      <div class="row">
       <div class="col-sm-3 text-left">
      <label >เลขทะเบียน</label>
      </div>
       <div class="col-sm-9"> 
      <input  name = "CARD_CODE"  id="CARD_CODE" class="form-control input-lg" value="{{ $inforofficial -> CARD_CODE }}" style=" font-family: 'Kanit', sans-serif;">
      </div>
      </div>
      </div>
     
      <input type="hidden" name = "DATE_RECEIVE"  id="DATE_RECEIVE"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy" value="{{ formate($inforofficial -> DATE_RECEIVE) }}" style=" font-family: 'Kanit', sans-serif;">
     
      <input type="hidden" name = "DATE_END"  id="DATE_END"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy" value="{{ formate($inforofficial -> DATE_END) }}" style=" font-family: 'Kanit', sans-serif;">
      
      <div class="form-group">
      <div class="row">
       <div class="col-sm-3 text-left">
      <label >หมายเหตุ</label>
      </div>
       <div class="col-sm-9"> 
      <input  name = "COMMENT"  id="COMMENT" class="form-control input-lg" value="{{ $inforofficial -> COMMENT }}" style=" font-family: 'Kanit', sans-serif;">
      </div>
      </div>
      </div>
   
   
      <input type="hidden" name = "PERSON_ID"  id="PERSON_ID"  value="{{ $inforpersonuserofficialid ->ID }} ">
      <input type="hidden" name = "USER_EDIT_ID"  id="USER_EDIT_ID" value="{{ $id_user }} ">

      </div></div>
        <div class="modal-footer">
        <div align="right">
        <button type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึกข้อมูล</button>
      
        <a href="{{ url('person/personinfouserofficial/'.$inforpersonuserofficialid -> ID)  }}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการแก้ไขข้อมูล ?')" >ยกเลิก</a> 
        </div>
       
        </div>
        </form>  
           
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

$('img').bind('contextmenu', function(e){
    return false;
}); 

</script>

<script>
   $(document).ready(function () {
            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,  //Set เป็นปี พ.ศ.
                autoclose: true 
            });  //กำหนดเป็นวันปัจุบัน

      
});
    

    

function readURL(input) {
        var fileInput = document.getElementById('picture');
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();    
        var numb = input.files[0].size/1024;
   
                    if(numb > 64){
                        alert('กรุณาอัปโหลดไฟล์ขนาดไม่เกิน 64KB');
                            fileInput.value = '';
                            return false;
                        }
    		
                    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                        var reader = new FileReader();
            
                        reader.onload = function (e) {
                            $('#image_upload_preview').attr('src', e.target.result);
                        }
            
                        reader.readAsDataURL(input.files[0]);
                    }else{
        
                                alert('กรุณาอัปโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                                fileInput.value = '';
                                return false;
       
                    }

                   


                }

            
                $("#picture").change(function () {
                    readURL(this);
                });


                function checkcancel() {
               
               var r = confirm("ต้องการยกเลิกการเพิ่มข้อมูล");
               if (r == true) {
                       window.location.href = "{{ url('person/personinfouserofficial')}}"
                 } else {
                       return false;   
                 }
                       }    
                  




</script>



@endsection