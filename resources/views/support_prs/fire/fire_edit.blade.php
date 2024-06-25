@extends('layouts.support_prs')
@section('title', 'PK-OFFICER || Fire')

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
            var fileInput = document.getElementById('fire_imgname');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#edit_upload_preview').attr('src', e.target.result);
  
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
    <form class="custom-validation" action="{{ route('prs.fire_update') }}" method="POST" id="update_Form" enctype="multipart/form-data">
        @csrf
    <div class="row"> 
        <div class="col-md-3">
            <h4 class="card-title" style="color:rgb(10, 151, 85)">UPDATE FIRE</h4>
            <p class="card-title-desc">แก้ไขข้อมูลถังดับเพลิง</p>
        </div>
        <div class="col"></div>
        <div class="col-md-4 text-end">
            <div class="form-group">
                <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    {{-- <i class="fa-solid fa-floppy-disk me-2"></i> --}}
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    แก้ไขข้อมูล
                </button>
                <a href="{{ url('fire_main') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                    <i class="fa-solid fa-xmark me-2"></i>
                    ยกเลิก
                </a>
            </div>
        </div>
        
       
    </div> 
   
        <div class="row">
            <div class="col-md-12">
                <div class="card card_prs_4 p-3">
                   
                    <div class="card-body">

                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        <input type="hidden" name="fire_id" id="fire_id" value="{{ $data_edit->fire_id }}">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                
                                    @if ($data_edit->fire_img == null)
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="edit_upload_preview"
                                            height="450px" width="350px" alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/fire/' . $data_edit->fire_imgname) }}"
                                            id="edit_upload_preview" height="450px" width="350px" alt="Image"
                                            class="img-thumbnail">
                                            {{-- <img src="data:image/png;base64,{{ $pic_fire }}" id="edit_upload_preview" height="450px" width="350px" alt="Image"> --}}
                                    @endif
                                    <br>
                                    <div class="input-group mt-3">
                                        <label class="input-group-text" for="fire_imgname">Upload</label>
                                     
                                        <input type="file" class="form-control-sm" id="fire_imgname" name="fire_imgname"
                                            onchange="addarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       
                                 
                                    </div>
                                </div>
                            </div>
 

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-2 text-end">
                                        <label for="fire_year">ปีงบประมาณ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="fire_year" name="fire_year" class="form-select form-select-lg" style="width: 100%">
                                                <option value="">ปีงบประมาณ</option> 
                                                @foreach ($budget_year as $ye)
                                                    @if ($ye->leave_year_id == $data_edit->fire_year)
                                                        <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }}</option>
                                                    @else
                                                        <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="fire_date">วันที่รับเข้า </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="fire_date" type="date" class="form-control form-control-sm" name="fire_date" value="{{$data_edit->fire_date}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="fire_year">วันที่ผลิต </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="fire_date" type="date" class="form-control form-control-sm" name="fire_date_pdd" value="{{$data_edit->fire_date_pdd}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="fire_date">วันที่หมดอายุ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="fire_date" type="date" class="form-control form-control-sm" name="fire_date_exp" value="{{$data_edit->fire_date_exp}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="fire_num">เลขครุภัณฑ์ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="fire_num" type="text" class="form-control form-control-sm" name="fire_num"  value="{{$data_edit->fire_num}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="fire_name">ชื่อครุภัณฑ์ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="fire_name" type="text" class="form-control form-control-sm" name="fire_name"  value="{{$data_edit->fire_name}}">
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="fire_price">ราคา </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input id="fire_price" type="text" class="form-control form-control-sm" name="fire_price"  value="{{$data_edit->fire_price}}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="fire_price">บาท</label>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="active">สถานะ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="active" name="active" class="form-select form-select-lg" style="width: 100%">
                                                @if ($data_edit->active == 'Y')
                                                <option value="Y" selected>ปกติ</option>
                                                <option value="N">ชำรุด</option> 
                                                @else
                                                <option value="Y">ปกติ</option>
                                                <option value="N" selected>ชำรุด</option> 
                                                @endif
                                                
                                            </select>
                                        </div>
                                    </div>


                                </div>


                                <div class="row mt-3">
                                    
                                    <div class="col-md-2 text-end">
                                        <label for="fire_location">สถานที่ตั้ง </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="fire_location" type="text" class="form-control form-control-sm" name="fire_location" value="{{$data_edit->fire_location}}">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="fire_size">ขนาด(ปอนด์) </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="fire_size" type="text" class="form-control form-control-sm" name="fire_size" value="{{$data_edit->fire_size}}">
                                            
                                        </div>
                                    </div>

                                </div>
 

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_unit_id">หน่วยนับ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_unit_id" name="article_unit_id"
                                                class="form-select form-select-lg show_unit" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_unit as $uni)
                                                @if ($data_edit->fire_unit == $uni->unit_name)
                                                <option value="{{ $uni->unit_id }}" selected> {{ $uni->unit_name }} </option>
                                                @else
                                                <option value="{{ $uni->unit_id }}"> {{ $uni->unit_name }} </option>
                                                @endif
                                                   
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-outline bga">
                                            <input type="text" id="UNIT_INSERT" name="UNIT_INSERT"
                                                class="form-control form-control-sm shadow" />
                                            {{-- <label class="form-label" for="UNIT_INSERT">เพิ่มหน่วยนับ</label> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info btn-sm" onclick="addunit();">
                                                <i class="fa-solid fa-square-plus me-2"></i>
                                                เพิ่ม
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_brand_id">ยี่ห้อ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_brand_id" name="article_brand_id"
                                                class="form-select form-select-lg show_brand" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_brand as $bra)
                                                @if ($data_edit->fire_brand == $bra->brand_name)
                                                <option value="{{ $bra->brand_id }}" selected> {{ $bra->brand_name }} </option>
                                                @else
                                                <option value="{{ $bra->brand_id }}"> {{ $bra->brand_name }} </option>
                                                @endif
                                                   
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-outline bga">
                                            <input type="text" id="BRAND_INSERT" name="BRAND_INSERT"
                                                class="form-control form-control-sm shadow" />
                                            {{-- <label class="form-label" for="BRAND_INSERT">เพิ่มยี่ห้อ</label> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info btn-sm" onclick="addbrand();">
                                                <i class="fa-solid fa-square-plus me-2"></i>
                                                เพิ่ม
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    
                                    <div class="col-md-2 text-end">
                                        <label for="fire_color">ถังสี </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            
                                            <select id="fire_color" name="fire_color" class="form-select form-select-lg" style="width: 100%">
                                               
                                                @if ($data_edit->fire_color == 'green')
                                                <option value="green" selected>เขียว</option>
                                                <option value="red">แดง</option> 
                                                <option value="yellow">เหลือง</option> 
                                                @elseif ($data_edit->fire_color == 'red')
                                                <option value="green">เขียว</option>
                                                <option value="red" selected>แดง</option> 
                                                <option value="yellow">เหลือง</option> 
                                                @else
                                                <option value="green">เขียว</option>
                                                <option value="red">แดง</option> 
                                                <option value="yellow" selected>เหลือง</option> 
                                                @endif
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="col"></div>

                                </div>

                            </div>
                        </div>

                    </div>
                   
                    
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col"></div>
            <div class="col-md-4 text-end">
                <div class="form-group">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        บันทึกข้อมูล
                    </button>
                    <a href="{{ url('fire_main') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div> --}}

    </div>
</form>
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script>

<script>
     $(document).ready(function () {
          $('#example').DataTable();
          $('#example2').DataTable();
          $('#example3').DataTable();
          $('#example4').DataTable();
          $('#example5').DataTable();  
          $('#table_id').DataTable();
         
          $('#article_unit_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#fire_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#active').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          
          $('#article_brand_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
          $('#fire_color').select2({
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
                            window.location="{{url('fire_main')}}";  
                          }
                        })      
                      }
                    }
                  });
            });
            
          
      });
</script>
@endsection