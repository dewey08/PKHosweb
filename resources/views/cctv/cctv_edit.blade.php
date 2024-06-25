@extends('layouts.cctv')
@section('title', 'PK-OFFICE || CCTV')

<style>
    #button {
        display: block;
        margin: 20px auto;
        padding: 30px 30px;
        background-color: #eee;
        border: solid #ccc 1px;
        cursor: pointer;
    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 250px;
        height: 250px;
        border: 10px #ddd solid;
        border-top: 10px #1fdab1 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(390deg);
        }
    }

    .is-hide {
        display: none;
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

        function editarticle(input) {
            var fileInput = document.getElementById('article_img');
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

        <form class="custom-validation" action="{{ route('tec.cctv_update') }}" method="POST" id="update_Form" enctype="multipart/form-data">
            @csrf
        <div class="row"> 
            <div class="col-md-3">
                <h4 class="card-title" style="color:rgb(10, 151, 85)">UPDATE CCTV</h4>
                <p class="card-title-desc">แก้ไขข้อมูลครุภัณฑ์กล้องวงจรปิด</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="article_claim"
                        id="article_claim" value="CLAIM">
                    <label class="form-check-label" for="article_claim">
                        เคลม
                    </label>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="article_claim"
                        id="article_claim" value="NOCLAIM" checked>
                    <label class="form-check-label" for="article_claim">
                        ไม่เคลม
                    </label>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="article_used"
                        id="article_used" value="YES" >
                    <label class="form-check-label" for="article_used">
                        ใช้บ่อย
                    </label>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="article_used"
                        id="article_used" value="NO" checked>
                    <label class="form-check-label" for="article_used">
                        ไม่ใช้บ่อย
                    </label>
                </div>
            </div>
           
        </div> 

        <div class="row">
            <div class="col-md-12">
                <div class="card cardacc">
                   
                    <div class="card-body">

                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        <input type="hidden" name="article_typeid" id="PRODUCT_TYPEID" value="2">
                        <input type="hidden" name="article_groupid" id="PRODUCT_GROUPID" value="3">
                        <input type="hidden" name="article_id" id="article_id" value="{{ $dataedits->article_id }}">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">

                                    @if ($dataedits->article_img == null)
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="edit_upload_preview"
                                            height="450px" width="350px" alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/article/' . $dataedits->article_img) }}"
                                            id="edit_upload_preview" height="450px" width="350px" alt="Image"
                                            class="img-thumbnail">
                                    @endif
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="article_img">Upload</label>
                                        <input type="file" class="form-control" id="article_img" name="article_img"
                                            onchange="editarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-2 text-end">
                                        <label for="article_year">ปีงบประมาณ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_year" name="article_year"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">ปีงบประมาณ</option>
                                                @foreach ($budget_year as $year)
                                                    @if ($dataedits->article_year == $year->leave_year_id)
                                                        <option value="{{ $year->leave_year_id }}" selected>
                                                            {{ $year->leave_year_id }} </option>
                                                    @else
                                                        <option value="{{ $year->leave_year_id }}">
                                                            {{ $year->leave_year_id }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="article_recieve_date">วันที่รับเข้า :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="article_recieve_date" type="date"
                                                class="form-control form-control-sm"
                                                value="{{ $dataedits->article_recieve_date }}"
                                                name="article_recieve_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_num">เลขครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="article_num" type="text" class="form-control form-control-sm"
                                                value="{{ $dataedits->article_num }}" name="article_num">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="article_name">ชื่อครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="article_name" type="text" class="form-control form-control-sm"
                                                value="{{ $dataedits->article_name }}" name="article_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_attribute">คุณลักษณะ :</label>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <input id="article_attribute" type="text"
                                                class="form-control form-control-sm"
                                                value="{{ $dataedits->article_attribute }}" name="article_attribute">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="vendor_id">ตัวแทนจำหน่าย :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="vendor_id" name="vendor_id" class="form-select form-select-lg"
                                                style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($products_vendor as $vendor)
                                                    @if ($dataedits->article_vendor_id == $vendor->vendor_id)
                                                        <option value="{{ $vendor->vendor_id }}" selected>
                                                            {{ $vendor->vendor_name }} </option>
                                                    @else
                                                        <option value="{{ $vendor->vendor_id }}">
                                                            {{ $vendor->vendor_name }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_price">ราคา :</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input id="article_price" type="text" class="form-control form-control-sm"
                                                value="{{ $dataedits->article_price }}" name="article_price">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="article_price">บาท</label>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="article_buy_id">การจัดซื้อ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_buy_id" name="article_buy_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_buy as $buy)
                                                    @if ($dataedits->article_buy_id == $buy->buy_id)
                                                        <option value="{{ $buy->buy_id }}" selected>{{ $buy->buy_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $buy->buy_id }}">{{ $buy->buy_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_categoryid">หมวดครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_categoryid" name="article_categoryid"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_category as $procat)
                                                    @if ($dataedits->article_categoryid == $procat->category_id)
                                                        <option value="{{ $procat->category_id }}" selected>
                                                            {{ $procat->category_name }}</option>
                                                    @else
                                                        <option value="{{ $procat->category_id }}">
                                                            {{ $procat->category_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <label for="article_deb_subsub_id">ประจำหน่วยงาน :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_deb_subsub_id" name="article_deb_subsub_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($department_sub_sub as $deb_subsub)
                                                    @if ($dataedits->article_deb_subsub_id == $deb_subsub->DEPARTMENT_SUB_SUB_ID)
                                                        <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}" selected>
                                                            {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                                    @else
                                                        <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}">
                                                            {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_decline_id">ประเภทค่าเสื่อม :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_decline_id" name="article_decline_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_decline as $prodecli)
                                                    @if ($dataedits->article_decline_id == $prodecli->decline_id)
                                                        <option value="{{ $prodecli->decline_id }}" selected>
                                                            {{ $prodecli->decline_name }} </option>
                                                    @else
                                                        <option value="{{ $prodecli->decline_id }}">
                                                            {{ $prodecli->decline_name }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <label for="article_status_id">สถานะ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="cctv_status" name="cctv_status"
                                                class="form-select form-select-lg" style="width: 100%">
                                               
                                                @if ($dataedits->cctv_status == '0')
                                                    <option value="0" selected>ปกติ</option>
                                                    <option value="1">ชำรุด</option>
                                                @else
                                                    <option value="0">ปกติ</option>
                                                    <option value="1" selected>ชำรุด</option>
                                                @endif
                                                {{-- cctv_status --}}
                                                {{-- @foreach ($article_status as $te)
                                                    @if ($dataedits->article_status_id == $te->article_status_id)
                                                        <option value="{{ $te->article_status_id }}" selected>
                                                            {{ $te->article_status_name }} </option>
                                                    @else
                                                        <option value="{{ $te->article_status_id }}">
                                                            {{ $te->article_status_name }} </option>
                                                    @endif
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_unit_id">หน่วยนับ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_unit_id" name="article_unit_id"
                                                class="form-select form-select-lg show_unit" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_unit as $uni)
                                                    @if ($dataedits->article_unit_id == $uni->unit_id)
                                                        <option value="{{ $uni->unit_id }}" selected>
                                                            {{ $uni->unit_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $uni->unit_id }}">
                                                            {{ $uni->unit_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="" style="color: red">* ถ้าไม่มีให้เพิ่ม</label>
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
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addunit();">
                                                เพิ่ม
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end">
                                        <label for="article_brand_id">ยี่ห้อ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_brand_id" name="article_brand_id"
                                                class="form-select form-select-lg show_brand" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($product_brand as $bra)
                                                    @if ($dataedits->article_brand_id == $bra->brand_id)
                                                        <option value="{{ $bra->brand_id }}" selected>
                                                            {{ $bra->brand_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $bra->brand_id }}">
                                                            {{ $bra->brand_name }}
                                                        </option>
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
                                            <input type="text" id="BRAND_INSERT" name="BRAND_INSERT"
                                                class="form-control form-control-sm shadow" />
                                            {{-- <label class="form-label" for="BRAND_INSERT">เพิ่มยี่ห้อ</label> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addbrand();">
                                                เพิ่ม
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="submit"
                                    class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <a href="{{ url('cctv_list') }}"
                                    class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>
                            </div>

                        </div>
                    </div>
                    </form> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-4 text-end">
                <div class="form-group">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        แก้ไขข้อมูล
                    </button>
                    <a href="{{ url('cctv_list') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
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

    <script>
        $(document).ready(function() {

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#building_userid').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#article_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_tonnage_number').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_decline_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_buy_id').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_method_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#building_budget_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#medical_typecat_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          
  
          $('#article_deb_subsub_id').select2({
              placeholder:"--หน่วยงาน--",
              allowClear:true
          });
          $('#article_categoryid').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
        
          $('#article_decline_id').select2({
            placeholder:"--เลือก--",
              allowClear:true
          });
          $('#product_typeid').select2({
              placeholder:"ประเภทวัสดุ",
              allowClear:true
          });
          $('#article_unit_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#product_spypriceid').select2({
              placeholder:"ราคาสืบ",
              allowClear:true
          });
          $('#product_groupid').select2({
              placeholder:"ชนิดวัสดุ",
              allowClear:true
          });
          $('#article_buy_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#vendor_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#cctv_status').select2({
              placeholder:"--สถานะ--",
              allowClear:true
          });  
          $('#article_brand_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
          $('#room_type').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });  
          $('#building_type_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          }); 
          $('#land_province').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_province_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_district_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_tumbon_location').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#land_user_id').select2({
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
                            window.location="{{url('cctv_list')}}";  
                          }
                        })      
                      }
                    }
                  });
            }); 



        });
    </script>
@endsection
