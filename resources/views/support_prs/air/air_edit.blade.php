@extends('layouts.support_prs')
@section('title', 'PK-OFFICER || Air-Service')

<style>
    .btn {
        font-size: 15px;
    }

    .bgc {
        background-color: #264886;
    }

    .bga {
        background-color: #fbff7d;
    }
</style>
<?php
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\DB;
$count_land = StaticController::count_land();
$count_building = StaticController::count_building();
$count_article = StaticController::count_article();
?>


@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function addarticle(input) {
            var fileInput = document.getElementById('air_imgname');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#edit_upload_preview').attr('src', e.target.result);

                    // var wrapper = document.getElementById("signature-pad");
                    // // var clearButton = wrapper.querySelector("[data-action=clear]");
                    // var savePNGButton = fileInput.querySelector("[data-action=save-png]");
                    // var canvas = fileInput.querySelector("canvas");

                    // // var wrapper = document.getElementById("signature-pad"); 
                    // // var savePNGButton = wrapper.querySelector("[data-action=save-png]");
                    // var signaturePad;
                    // signaturePad = new SignaturePad(canvas);
                    // savePNGButton.addEventListener("click", function(event) {
                    // if (signaturePad.isEmpty()) {
                    //     // alert("Please provide signature first.");
                    //     Swal.fire(
                    //         'กรุณาลงลายเซนต์ก่อน !',
                    //         'You clicked the button !',
                    //         'warning'
                    //     )
                    //     event.preventDefault();
                    // } else {
                    //     var canvas = document.getElementById("fire_imgname");
                    //     var dataUrl = canvas.toDataURL();
                    //     document.getElementById("signature").value = dataUrl;

                    //     // ข้อความแจ้ง
                    //     Swal.fire({
                    //         title: 'สร้างสำเร็จ',
                    //         text: "You create success",
                    //         icon: 'success',
                    //         showCancelButton: false,
                    //         confirmButtonColor: '#06D177',
                    //         confirmButtonText: 'เรียบร้อย'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {}
                    //     })
                    // }
                    // });


                }
                reader.readAsDataURL(input.files[0]); 

            } else {
                alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                fileInput.value = '';
                return false;
            }
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    date_default_timezone_set('Asia/Bangkok');
$date = date('Y') + 543;
$datefull = date('Y-m-d H:i:s');
$time = date("H:i:s");
$loter = $date.''.$time
    
    ?>

<div class="tabs-animation">
    <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div> 
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div>
    <form class="custom-validation" action="{{ route('prs.air_update') }}" method="POST" id="update_Form" enctype="multipart/form-data">
        @csrf
    <div class="row"> 
        <div class="col-md-4">
            <h4 class="card-title" style="color:rgb(10, 151, 85)">UPDATE AIR LIST</h4>
            <p class="card-title-desc">แก้ไขข้อมูลทะเบียนครุภัณฑ์แอร์</p>
        </div>
        <div class="col"></div>
        <div class="col-md-2 text-end">
        <a href="{{url('air_main')}}" class="ladda-button me-2 btn-pill btn btn-warning cardacc"> 
            <i class="fa-solid fa-arrow-left me-2"></i> 
           ย้อนกลับ
        </a> 
    </div>
    </div> 
   
        <div class="row fsize12">
            <div class="col-md-12">
                <div class="card card_prs_4 p-3">
                   
                    <div class="card-body">

                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        <input type="hidden" name="air_list_id" id="air_list_id" value=" {{ $data_edit->air_list_id }}">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                
                                        @if ($data_edit->air_img == null)
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="edit_upload_preview"
                                            height="450px" width="380px" alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/air/' . $data_edit->air_img) }}"
                                            id="edit_upload_preview" height="450px" width="350px" alt="Image"
                                            class="img-thumbnail">
                                            {{-- <img src="data:image/png;base64,{{ $pic_fire }}" id="edit_upload_preview" height="450px" width="350px" alt="Image"> --}}
                                    @endif
                                    <br>
                                    <div class="input-group mt-3">
                                    
                                        <input type="file" class="form-control" id="air_imgname" name="air_imgname"
                                            onchange="addarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                   
                                    </div>
                                </div>
                            </div>
 

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="air_year">ปีงบประมาณ</label>
                                            </div>
                                            <select class="js-example-basic-single" id="air_year" name="air_year" style="width: 75%" > 
                                                @foreach ($budget_year as $ye)
                                                @if ($ye->leave_year_id == $data_edit->air_year)
                                                    <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }}</option>
                                                @else
                                                    <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="air_recive_date">วันที่รับเข้า </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="air_recive_date" type="date"
                                                class="form-control" name="air_recive_date" value="{{$data_edit->air_recive_date}}">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6"> 
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">วันที่รับเข้า</span>
                                            </div>
                                            <input type="date" style="font-size: 13px" type="text" class="form-control" id="air_recive_date" name="air_recive_date" aria-label="air_recive_date" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->air_recive_date}}">
                                        </div>
                                    </div>
                                </div>
 

                                <div class="row mt-3">
                                    <div class="col-md-6"> 
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">รหัสแอร์</span>
                                            </div>
                                            <input style="font-size: 13px" type="text" class="form-control" id="air_list_num" name="air_list_num" aria-label="air_list_num" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->air_list_num}}">
                                        </div>
                                    </div>
                                    <div class="col-md-5"> 
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">ราคา</span>
                                            </div>
                                            <input style="font-size: 13px" type="text" class="form-control" id="air_price" name="air_price" aria-label="air_price" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->air_price}}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="air_list_num">รหัสแอร์</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="air_list_num" type="text" class="form-control"
                                                name="air_list_num" value="{{$data_edit->air_list_num}}">
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="air_price">ราคา </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input id="air_price" type="text" class="form-control form-control-sm"
                                                name="air_price" value="{{$data_edit->air_price}}">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-1">
                                        <label for="air_price">บาท</label>
                                    </div>

                                </div>

                               
                                <div class="row mt-3">
                               
                                    <div class="col-md-6"> 
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">ชื่อครุภัณฑ์</span>
                                            </div>
                                            <input type="text" style="font-size: 14px" class="form-control" id="air_list_name" name="air_list_name" aria-label="air_list_name" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->air_list_name}}">
                                        </div>
                                    </div>
                             
                                    <div class="col-md-6"> 
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Serial no</span>
                                            </div>
                                            <input type="text" style="font-size: 13px" class="form-control" id="serial_no" name="serial_no" aria-label="serial_no" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->serial_no}}">
                                        </div>
                                    </div> 
                                </div>


                                <div class="row mt-3"> 
                                    <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <label class="input-group-text" for="bran_id">สถานที่ตั้ง</label>
                                        </div>
                                        <select class="js-example-basic-single" id="air_location_id" name="air_location_id" style="width: 85%" >

                                    {{-- <div class="col-md-2 text-end">
                                        <label for="air_location_id">สถานที่ตั้ง </label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group"> 
                                            <select id="air_location_id" name="air_location_id" class="form-select form-select-lg show_brand" style="width: 100%">
                                            <option value=""></option> --}}
                                            @foreach ($building_data as $bra)
                                            @if ($data_edit->air_location_id == $bra->building_id)
                                            <option value="{{ $bra->building_id }}" selected>{{ $bra->building_id }} {{ $bra->building_name }} </option>
                                            @else
                                            <option value="{{ $bra->building_id }}">{{ $bra->building_id }} {{ $bra->building_name }} </option>
                                            @endif
                                               
                                            @endforeach
                                        </select>
                                        </div>
                                    </div> 
                                </div>

                                <div class="row mt-3"> 
                                    
                                    <div class="col-md-12">
                                       
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">แผนก/ห้อง</span>
                                            </div>
                                            <input type="text" style="font-size: 14px" class="form-control" id="detail" name="detail" aria-label="detail" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->detail}}">
                                        </div>
                                    </div> 
                                </div>

                                <div class="row mt-3">                                    
                                    <div class="col-md-6">                                      
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">ขนาด(BTU)</span>
                                            </div>
                                            <input type="text" style="font-size: 13px" class="form-control" id="btu" name="btu" aria-label="btu" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->btu}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <label class="input-group-text" for="active">สถานะ</label>
                                            </div>
                                            <select class="js-example-basic-single" id="active" name="active" style="width: 85%">
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="active">สถานะ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="active" name="active" class="form-select form-select-lg" style="width: 100%"> --}}
                                                @if ($data_edit->active == 'Y')
                                                <option value="Y" selected>พร้อมใช้งาน</option>
                                                <option value="N">ไม่พร้อมใช้งาน</option> 
                                                @else
                                                <option value="Y">พร้อมใช้งาน</option>
                                                <option value="N" selected>ไม่พร้อมใช้งาน</option> 
                                                @endif
                                            </select>
                                        </div>
                                    </div> 
                                </div> 

                               <div class="row mt-3">
                                <div class="col-md-6"> 
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">ชั้น</span>
                                        </div>
                                        <input type="text" class="form-control" id="air_room_class" name="air_room_class" aria-label="air_room_class" aria-describedby="inputGroup-sizing-sm" value="{{$data_edit->air_room_class}}">
                                    </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <label class="input-group-text" for="bran_id">ยี่ห้อ</label>
                                        </div>
                                        <select class="js-example-basic-single" id="bran_id" name="bran_id" style="width: 85%">
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="bran_id">ยี่ห้อ </label>
                                    </div> --}}
                                    {{-- <div class="col-md-4"> --}}
                                        {{-- <div class="form-group"> --}}
                                            {{-- <select id="bran_id" name="bran_id" --}}
                                                {{-- class="form-select form-select-lg show_brand" style="width: 100%"> --}}
                                                {{-- <option value=""></option> --}}
                                                @foreach ($product_brand as $bra)
                                                @if ($data_edit->bran_id == $bra->brand_id)
                                                <option value="{{ $bra->brand_id }}" selected> {{ $bra->brand_name }} </option>
                                                @else
                                                <option value="{{ $bra->brand_id }}"> {{ $bra->brand_name }} </option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 text-end">
                                        <label for="air_room_class">ชั้น </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="air_room_class" type="text" class="form-control form-control-sm" name="air_room_class" value="{{$data_edit->air_room_class}}">
                                            
                                        </div>
                                    </div> --}}


                                </div>
  
                            </div>
                        </div>

                    </div>
                   
                    
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col"></div>
            <div class="col-md-4 text-end">
                <div class="form-group">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        แก้ไขข้อมูล
                    </button>
                    <a href="{{ url('fire_main') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script>

<script>
     $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.js-example-basic-multiple').select2();
            $("#js-example-responsive").select2({
                width: 'resolve' 
            });
            $("#js-example-theme-multiple").select2({
                theme: "classic"
            });
          $('#example').DataTable();
          $('#example2').DataTable();
          $('#example3').DataTable();
          $('#example4').DataTable();
          $('#example5').DataTable();  
          $('#table_id').DataTable();
         
          $('#air_location_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#air_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#active').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          
          $('#bran_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
        
          
          
          $('#update_Form').on('submit',function(e){
                  e.preventDefault();
              
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {
                        
                      } else {          
                        Swal.fire({
                            position: "top-end",
                          title: 'แก้ไขข้อมูลสำเร็จ',
                          text: "You Edit data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            // window.location.reload();  
                            window.location="{{url('air_main')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            
          
      });
</script>
@endsection