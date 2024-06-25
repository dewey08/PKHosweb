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
    
    /* // Set the select field height, background color etc ... */
    .select2-selection
    {    
        height: 50px !important
        background-color: $light-color
    }

    /* // Set selected value position, color , font size, etc ... */
    .select2-selection__rendered
    { 
        line-height: 35px !important
        color: yellow !important
    }
</style>
<?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_land = StaticController::count_land();
    $count_building = StaticController::count_building();
    $count_article = StaticController::count_article();
?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                    $('#add_upload_preview').attr('src', e.target.result);

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
  
    <form action="{{ route('prs.air_repiare_update') }}" id="update_Form" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="row"> 
        <div class="col-md-4">
            <h4 class="card-title" style="color:rgb(10, 151, 85)">UPADTE AIR</h4>
            <p class="card-title-desc">แก้ไขทะเบียนซ่อม-เครื่องปรับอากาศ</p>
        </div>
        <div class="col"></div>
        <div class="col-md-2 text-end">
        <a href="{{url('air_main_repaire')}}" class="ladda-button me-2 btn-pill btn btn-warning cardacc"> 
            <i class="fa-solid fa-arrow-left me-2"></i> 
           ย้อนกลับ
        </a> 
    </div>
    </div> 
   
        <div class="row">
            <div class="col-md-12">
                <div class="card card_prs_4 p-2">
                   
                    <div class="card-body">

                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        
                        <div class="row">

                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col text-start"> 
                                        <p style="font-size: 15px;color:rgb(4, 119, 113)">ส่วนที่ 1 : รายละเอียด </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($data_detail_->air_imgname == null)
                                        <img src="{{ asset('assets/images/defailt_img.jpg') }}" width="250px" height="220px" alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/air/' . $data_detail_->air_imgname) }}" height="170px"
                                            width="220px" alt="Image" class="img-thumbnail">
                                    @endif 
                                </div>
                                <div class="form-group mt-3">
                                    <p>รหัส : {{ $data_detail_->air_list_num }}</p>
                                    <p>ชื่อ : {{ $data_detail_->air_list_name }}</p>
                                    <p>Btu : {{ $data_detail_->btu }}</p>
                                    <p>serial_no : {{ $data_detail_->serial_no }}</p>
                                    <p>ที่ตั้ง : {{ $data_detail_->air_location_name }}</p>
                                    <p>หน่วยงาน : {{ $data_detail_->detail }}</p> 
                                </div>
                            </div>
                            

                            <div class="col-md-9"> 

                                 <div class="row"> 
                                        <div class="col-md-9">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" style="font-size: 15px;color:rgb(4, 129, 123)" role="tablist">
                                                <li class="nav-item" >
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#detail1" role="tab" style="background-color: #e8fcfa">
                                                        <span class="d-block d-sm-none"><i class="fas fa-detail"></i></span>
                                                        <span class="d-none d-sm-block" >
                                                            
                                                            <p>ส่วนที่ 2 : ช่างซ่อม(นอก รพ.) </p>
                                                        </span>    
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#detail2" role="tab" style="background-color: #fcf8e8">
                                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                        <span class="d-none d-sm-block"> <p>ส่วนที่ 3 : เจ้าหน้าที่ </p></span>    
                                                    </a>
                                                </li> 
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#detail3" role="tab" style="background-color: #D0FDE0">
                                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                        <span class="d-none d-sm-block"> <p>ส่วนที่ 4 : ช่างซ่อม(รพ.) </p></span>    
                                                    </a>
                                                </li> 
                                            </ul>
                                            <div class="tab-content text-muted">
                                                <div class="tab-pane active" id="detail1" role="tabpanel" style="background-color: #e8fcfa">
                                                    <p class="mb-0">
                                                        <div class="row ms-3 me-3"> 
                                                            <div class="col-md-6">  
                                                                <p style="font-size:17px;color:rgb(245, 21, 51)">
                                                                    <input class="form-check-input dcheckbox me-2" type="checkbox" id="air_2" name="air_2"/> แก้ไขเฉพาะ ส่วนที่ 2
                                                                </p>
                                                                <p style="font-size:14px;color:rgb(9, 119, 209)">- รายการซ่อม(ตามปัญหา) </p>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_1 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_1" name="air_problems_1" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_1" name="air_problems_1"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(50, 51, 53)" >น้ำหยด</p> 
                                                                    </div> 
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_2 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_2" name="air_problems_2" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_2" name="air_problems_2"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(35, 35, 36)" >ไม่เย็นมีแต่ลม</p>  
                                                                    </div> 
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_3 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_3" name="air_problems_3" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_3" name="air_problems_3"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(41, 42, 43)" >มีกลิ่นเหม็น</p>  
                                                                    </div>   
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_4 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_4" name="air_problems_4" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_4" name="air_problems_4"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(50, 51, 53)" >เสียงดัง</p> 
                                                                    </div> 
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_5 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_5" name="air_problems_5" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_5" name="air_problems_5"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(33, 33, 34)" >ไม่ติด/ติดๆ ดับๆ</p>  
                                                                    </div> 
                                                                     
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_orther == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_orther" name="air_problems_orther" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_orther" name="air_problems_orther"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >อื่นๆ</p>  
                                                                    </div>  
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea class="form-control form-control-sm" id="air_problems_orthersub" name="air_problems_orthersub" rows="2">{{$data_edit->air_problems_orthersub}}</textarea>
                                                                </div>

                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">- การบำรุงรักษา ประจำปี ครั้ง 1 </p>                                                             
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_6 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_6" name="air_problems_6" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_6" name="air_problems_6"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ถอดล้างพัดลมกรงกระรอก</p>  
                                                                    </div>  
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_7 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_7" name="air_problems_7" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_7" name="air_problems_7"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างถาดหลังแอร์</p>  
                                                                    </div>  
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_8 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_8" name="air_problems_8" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_8" name="air_problems_8"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างแผงคอยล์เย็น</p>  
                                                                    </div>  
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_9 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_9" name="air_problems_9" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_9" name="air_problems_9"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างแผงคอยล์ร้อน</p>  
                                                                    </div>  
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_10 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_10" name="air_problems_10" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_10" name="air_problems_10"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ตรวจเช็คน้ำยา</p>  
                                                                    </div>  
                                                                </div>

                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">- การบำรุงรักษา ประจำปี ครั้ง 2 </p>                                                             
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_11 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_11" name="air_problems_11" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_11" name="air_problems_11"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ถอดล้างพัดลมกรงกระรอก</p>  
                                                                    </div>  
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_12 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_12" name="air_problems_12" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_12" name="air_problems_12"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างถาดหลังแอร์</p>  
                                                                    </div>  
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_13 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_13" name="air_problems_13" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_13" name="air_problems_13"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างแผงคอยล์เย็น</p>  
                                                                    </div>  
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_14 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_14" name="air_problems_14" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_14" name="air_problems_14"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างแผงคอยล์ร้อน</p>  
                                                                    </div>  
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_15 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_15" name="air_problems_15" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_15" name="air_problems_15"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ตรวจเช็คน้ำยา</p>  
                                                                    </div>  
                                                                </div>
 
                                                            </div> 
                                                            <div class="col-md-6"> 
                                                                <p style="font-size:14px;color:rgb(9, 119, 209)">เลขที่แจ้งซ่อม </p>
                                                                <div class="form-group"> 
                                                                    <select class="custom-select custom-select-sm" id="air_repaire_no" name="air_repaire_no" style="width: 100%">
                                                                        @foreach ($air_no as $item_no) 
                                                                            @if ($data_edit->air_repaire_no == $item_no->REPAIR_ID) 
                                                                                <option value="{{ $item_no->ID }}" class="text-center" selected> {{ $item_no->REPAIR_ID }} {{ $item_no->REPAIR_NAME }}</option>
                                                                            @else
                                                                                <option value="{{ $item_no->ID }}" class="text-center"> {{ $item_no->REPAIR_ID }} {{ $item_no->REPAIR_NAME }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                  
                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">- การบำรุงรักษา ประจำปี ครั้ง 3 </p>                                                             
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_16 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_16" name="air_problems_16" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_16" name="air_problems_16"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ถอดล้างพัดลมกรงกระรอก</p>  
                                                                    </div>  
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_17 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_17" name="air_problems_17" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_17" name="air_problems_17"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างถาดหลังแอร์</p>  
                                                                    </div>  
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_18 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_18" name="air_problems_18" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_18" name="air_problems_18"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างแผงคอยล์เย็น</p>  
                                                                    </div>  
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_19 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_19" name="air_problems_19" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_19" name="air_problems_19"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ล้างแผงคอยล์ร้อน</p>  
                                                                    </div>  
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-check form-check-inline"> 
                                                                        @if ($data_edit->air_problems_20 == 'on')
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_20" name="air_problems_20" checked/>
                                                                        @else
                                                                        <input class="form-check-input dcheckbox" type="checkbox" id="air_problems_20" name="air_problems_20"/>
                                                                        @endif
                                                                        <p class="mt-2 ms-3" style="font-size:13px;color:rgb(43, 44, 46)" >ตรวจเช็คน้ำยา</p>  
                                                                    </div>  
                                                                </div>

                                                                <p style="font-size:14px;color:rgb(9, 119, 209)">สถานะซ่อม </p>
                                                                <div class="form-group"> 
                                                                    <select class="custom-select custom-select-sm" id="air_status_techout" name="air_status_techout" style="width: 100%">
                                                                        @if ($data_edit->air_status_techout == 'Y')
                                                                            <option value="Y" class="text-center" selected>- พร้อมใช้งาน -</option>
                                                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                                                        @else
                                                                            <option value="Y" class="text-center">- พร้อมใช้งาน -</option>
                                                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">ชื่อ-นามสกุล </p>
                                                                <div class="form-group"> 
                                                                    <input type="text" class="form-control form-control-sm" id="air_techout_name" name="air_techout_name" value="{{ $data_edit->air_techout_name }}">
                                                                </div>
                                                                
                                                                <div class="form-group text-center mt-2"> <img src="data:image/png;base64,{{ $signature }}" alt="" height="50px" width="auto"> </div>
                                                                <div class="form-group mb-3"> 
                                                                    <div id="signature-pad" class="mt-2 text-center">
                                                                        <div style="border:solid 1px teal;height:120px;">
                                                                            <div id="note" onmouseover="my_function();" class="text-center">The signature should be inside box</div>
                                                                            <canvas id="the_canvas" width="320px" height="120px"> </canvas>
                                                                        </div>                                
                                                                        <input type="hidden" id="signature" name="signature">                                
                                                                        <button type="button" id="clear_btn" class="btn btn-secondary btn-sm mt-3 ms-2 me-2" data-action="clear">
                                                                            <span class="glyphicon glyphicon-remove"></span> Clear
                                                                        </button> 
                                                                        <button type="button" id="save_btn"
                                                                            class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png"
                                                                            onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                                                            Create
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>  
                                                        </div>  
                                                    </p>
                                                </div> 
                                                <div class="tab-pane" id="detail2" role="tabpanel" style="background-color: #fcf8e8">
                                                    <p class="mb-0">
                                                        <div class="row ms-3 me-3"> 
                                                            <div class="col-md-12">   
                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">สถานะซ่อม </p>
                                                                <div class="form-group"> 
                                                                    <select class="custom-select custom-select-sm" id="air_status_staff" name="air_status_staff" style="width: 100%">
                                                                        @if ($data_edit->air_status_staff == 'Y')
                                                                            <option value="Y" class="text-center" selected>- พร้อมใช้งาน -</option>
                                                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                                                        @else
                                                                            <option value="Y" class="text-center">- พร้อมใช้งาน -</option>
                                                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">ชื่อ-นามสกุล </p>
                                                                <div class="form-group"> 
                                                                    <select class="custom-select custom-select-sm" id="air_staff_id" name="air_staff_id" style="width: 100%">
                                                                        @foreach ($users as $item_u)
                                                                            @if ($data_edit->air_staff_id == $item_u->id)
                                                                                <option value="{{ $item_u->id }}" class="text-center" selected>{{ $item_u->fname }} {{ $item_u->lname }}</option>
                                                                            @else
                                                                                <option value="{{ $item_u->id }}" class="text-center">{{ $item_u->fname }} {{ $item_u->lname }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group text-center mt-2"> <img src="data:image/png;base64,{{ $signature2 }}" alt="" height="50px" width="auto"> </div>
                                                                <div class="form-group mb-3"> 
                                                                    <div id="signature-pad2" class="mt-2 text-center">
                                                                        <div style="border:solid 1px teal;height:120px;">
                                                                            <div id="note2" onmouseover="my_function2();" class="text-center">The
                                                                                signature should be inside box</div>
                                                                            <canvas id="the_canvas2" width="320px" height="120px"> </canvas>
                                                                        </div>
                                
                                                                        <input type="hidden" id="signature2" name="signature2">
                                                                        <button type="button" id="clear_btn2"
                                                                            class="btn btn-secondary btn-sm mt-3 ms-2 me-2" data-action="clear2"><span
                                                                                class="glyphicon glyphicon-remove"></span>
                                                                            Clear</button>
                                
                                                                        <button type="button" id="save_btn2"
                                                                            class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png2"
                                                                            onclick="create2()"><span class="glyphicon glyphicon-ok"></span>
                                                                            Create
                                                                        </button>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                        </div> 
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="detail3" role="tabpanel" style="background-color: #D0FDE0">
                                                    <p class="mb-0">
                                                        <div class="row ms-3 me-3"> 
                                                            <div class="col-md-12">   
                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">สถานะซ่อม </p>
                                                                <div class="form-group"> 
                                                                    <select class="custom-select custom-select-sm" id="air_status_tech" name="air_status_tech" style="width: 100%">
                                                                        @if ($data_edit->air_status_tech == 'Y')
                                                                            <option value="Y" class="text-center" selected>- พร้อมใช้งาน -</option>
                                                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                                                        @else
                                                                            <option value="Y" class="text-center">- พร้อมใช้งาน -</option>
                                                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                                                        @endif
                                                                    </select>
                                                                </div>

                                                                <p class="mt-3" style="font-size:14px;color:rgb(9, 119, 209)">ชื่อ-นามสกุล </p>
                                                                <div class="form-group"> 
                                                                    <select class="custom-select custom-select-sm" id="air_tech_id" name="air_tech_id" style="width: 100%">
                                                                        @foreach ($air_tech as $item_ut)
                                                                        @if ($data_edit->air_tech_id == $item_ut->air_user_id)
                                                                            <option value="{{ $item_ut->air_user_id }}" class="text-center" selected> {{ $item_ut->air_user_name }}</option>
                                                                        @else
                                                                            <option value="{{ $item_ut->air_user_id }}" class="text-center"> {{ $item_ut->air_user_name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group"> 
                                                                    <div class="form-group text-center mt-2"> <img src="data:image/png;base64,{{ $signature3 }}" alt="" height="50px" width="auto"> </div>
                                                                    <div class="form-group mb-3"> 
                                                                        <div id="signature-pad3" class="mt-2 text-center">
                                                                            <div style="border:solid 1px teal;height:120px;">
                                                                                <div id="note3" onmouseover="my_function3();" class="text-center">The
                                                                                    signature should be inside box</div>
                                                                                <canvas id="the_canvas3" width="320px" height="120px"> </canvas>
                                                                            </div>
                                    
                                                                            <input type="hidden" id="signature3" name="signature3">
                                                                            <button type="button" id="clear_btn3"
                                                                                class="btn btn-secondary btn-sm mt-3 ms-2 me-2" data-action="clear3"><span
                                                                                    class="glyphicon glyphicon-remove"></span>
                                                                                Clear</button>
                                    
                                                                            <button type="button" id="save_btn3"
                                                                                class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png3"
                                                                                onclick="create3()"><span class="glyphicon glyphicon-ok"></span>
                                                                                Create
                                                                            </button> 
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                        </div> 
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                       
                                        <div class="col-md-2 text-end">
                                            <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                                <i class="pe-7s-diskette btn-icon-wrapper"></i>แก้ไขข้อมูล 
                                            </button>  
                                        </div>
                                    </div>
 
                                
  
                            </div>
                        </div> 
                    </div>

                    <input type="hidden" name="air_repaire_id" id="air_repaire_id"
                    value="{{ $data_edit->air_repaire_id }}">
                <input type="hidden" name="air_list_id" id="air_list_id"
                    value="{{ $data_detail_->air_list_id }}">
                <input type="hidden" name="air_list_num" id="air_list_num"
                    value="{{ $data_detail_->air_list_num }}">
                <input type="hidden" name="air_list_name" id="air_list_name"
                    value="{{ $data_detail_->air_list_name }}">
                <input type="hidden" name="btu" id="btu" value="{{ $data_detail_->btu }}">
                <input type="hidden" name="serial_no" id="serial_no"
                    value="{{ $data_detail_->serial_no }}">
                <input type="hidden" name="air_location_id" id="air_location_id"
                    value="{{ $data_detail_->air_location_id }}">
                <input type="hidden" name="air_location_name" id="air_location_name"
                    value="{{ $data_detail_->air_location_name }}">
                   
                    
                </div>
            </div>
        </div>
        {{-- <div class="row mt-3">
            <div class="col"></div>
            <div class="col-md-4 text-end">
                <div class="form-group">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        แก้ไขข้อมูล
                    </button>
                    <a href="{{ url('air_main_repaire') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
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
        $(document).ready(function() {
            $('select').select2();
        });
    </script>
    <script>
        //ช่างซ่อมนอก
        var wrapper = document.getElementById("signature-pad");
        var clearButton = wrapper.querySelector("[data-action=clear]");
        var savePNGButton = wrapper.querySelector("[data-action=save-png]");
        var canvas = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note");
        var signaturePad;
        signaturePad = new SignaturePad(canvas);
        clearButton.addEventListener("click", function(event) {
            document.getElementById("note").innerHTML = "The signature should be inside box";
            signaturePad.clear();
        });
        savePNGButton.addEventListener("click", function(event) {
            if (signaturePad.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    position: "top-end",
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function() {
            document.getElementById("note").innerHTML = "";
        }

        // เจ้าหน้าที่
        var wrapper = document.getElementById("signature-pad2");
        var clearButton2 = wrapper.querySelector("[data-action=clear2]");
        var savePNGButton2 = wrapper.querySelector("[data-action=save-png2]");
        var canvas2 = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note2");
        var signaturePad2;
        signaturePad2 = new SignaturePad(canvas2);
        clearButton2.addEventListener("click", function(event) {
            document.getElementById("note2").innerHTML = "The signature should be inside box";
            signaturePad2.clear();
        });
        savePNGButton2.addEventListener("click", function(event) {
            if (signaturePad2.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas2");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature2").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    position: "top-end",
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function2() {
            document.getElementById("note2").innerHTML = "";
        }

        // ช่างซ่อมใน รพ 
        var wrapper = document.getElementById("signature-pad3");
        var clearButton3 = wrapper.querySelector("[data-action=clear3]");
        var savePNGButton3 = wrapper.querySelector("[data-action=save-png3]");
        var canvas3 = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note3");
        var signaturePad3;
        signaturePad3 = new SignaturePad(canvas3);
        clearButton3.addEventListener("click", function(event) {
            document.getElementById("note3").innerHTML = "The signature should be inside box";
            signaturePad3.clear();
        });
        savePNGButton3.addEventListener("click", function(event) {
            if (signaturePad3.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas3");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature3").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    position: "top-end",
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function3() {
            document.getElementById("note3").innerHTML = "";
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#update_Form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) { 

                        if (data.status == 0) {

                        } else if (data.status == 50) {
                            Swal.fire(
                                'กรุณาลงลายชื่อช่างภายนอก !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else if (data.status == 60) {
                            Swal.fire(
                                'กรุณาลงลายชื่อเจ้าหน้าที่ !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else if (data.status == 70) {
                            Swal.fire(
                                'กรุณาลงลายชื่อช่าง รพ !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else {
                            Swal.fire({
                                position: "top-end",
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Update data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    // window.location.reload();
                                    window.location = "{{ url('air_main_repaire') }}";
                                    $('#spinner')
                                .hide(); //Request is complete so hide spinner
                                    setTimeout(function() {
                                        $("#overlay").fadeOut(300);
                                    }, 500);
                                }
                            })
                        }
                    }
                });
            });
 
        });
    </script>
@endsection