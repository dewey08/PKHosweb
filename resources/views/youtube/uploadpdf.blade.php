@extends('layouts.youtube')
    
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

@section('content')

<?php
$status = Auth::user()->status; 
$id_user = Auth::user()->PERSON_ID; 
$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos); 
?>
<?php

?>

<center>
    <div class="block mt-5" style="width: 95%;" >
        <div class="block-header block-header-default" >
            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>Upload Pdf</B></h3>
        </div>
        <div class="block-content block-content-full" >          
            <form  method="post" action="{{ route('you.uploadpdf_file') }}" enctype="multipart/form-data">
            @csrf
      
                <div class="row push">   
                    <div class="col-lg-2">
                        <label for="">Name</label>
                    </div> 
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="Name" name="PDF_FILENAME" id="PDF_FILENAME">
                    </div> 
                    <div class="col-lg-2">
                        <label for="">File</label>
                    </div> 
                    <div class="col-lg-2">
                        <input type="file" class="form-control" name="file" id="file">
                    </div> 

                </div>


                <div class="modal-footer">
                    <div align="right">
                        <button type="submit"  class="btn btn-hero-sm btn-hero-info foo15" ><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>                       
                    </div>            
                </div>
            </form> 

            <hr>

            <div class="row">
                @foreach ($datashow as $data)
                    <div class="col-md-4 ">
                            <div class="card mb-4" style="width:100%">
                                <img id="image_upload_preview" src="data:image/png;base64,{{ chunk_split(base64_encode($data->file_imgs)) }}" height="350px" width="260px"> 
                                {{-- <iframe src="{{ asset('storage/youtube/'.$data->file_pdf ) }}" height="350" width="260"></iframe> --}}
                                <div class="card-body ">
                                    <h5 class="card-title">#Ep 1.PNG</h5>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 ">
                        <div class="card mb-4" style="width:100%">
                            {{-- <iframe width="350" height="260" src="{{'storage/app/public/youtube/'.$data->file_img}}" frameborder="0" allowfullscreen ng-show="showvideo"></iframe> --}}
                            <iframe src="{{ asset('storage/youtube/'.$data->file_pdf ) }}" height="350" width="260"></iframe>
                            <div class="card-body ">
                                <h5 class="card-title">#Ep 2.PDF</h5>
                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </a>
                </div>

                @endforeach  
            </div>

        </div>            
    </div>
       
</center>   
               
                      

@endsection

@section('footer')


<script src="{{ asset('asset/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script>jQuery(function(){ Dashmix.helpers(['masked-inputs']); });</script>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

<script>
  

$(document).ready(function () {
            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true                    //Set เป็นปี พ.ศ.
            }).datepicker("setDate", 0);  //กำหนดเป็นวันปัจุบัน
    });



function chkNumber(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9')) return false;
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





  
</script>


@endsection