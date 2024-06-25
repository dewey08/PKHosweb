@extends('layouts.car')
@section('title', 'PK-OFFICER || ยานพาหนะ')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
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
  
    <?php
        use App\Http\Controllers\StaticController;
        use Illuminate\Support\Facades\DB;   
        $count_article_car = StaticController::count_article_car();
    ?>

<style>
    body {
        font-size: 13px;
    }
   
    .btn {
        font-size: 13px;
    }
    .form-control{
        font-size: 13px;
    }
    .bgc {
        background-color: #264886;
    }

    .bga {
        background-color: #fbff7d;
    }

    .boxpdf {
        /* height: 1150px; */
        height: auto;
    }

    .page {
        width: 90%;
        margin: 10px;
        box-shadow: 0px 0px 5px #000;
        animation: pageIn 1s ease;
        transition: all 1s ease, width 0.2s ease;
    }

    @keyframes pageIn {
        0% {
            transform: translateX(-300px);
            opacity: 0;
        }

        100% {
            transform: translateX(0px);
            opacity: 1;
        }
    }

    @media (min-width: 500px) {
        .modal {
            --bs-modal-width: 500px;
        }
    }

    @media (min-width: 950px) {
        .modal-lg {
            --bs-modal-width: 950px;
        }
    }

    @media (min-width: 1500px) {
        .modal-xls {
            --bs-modal-width: 1500px;
        }
    }

    @media (min-width: auto; ) {
        .container-fluids {
            width: auto;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: auto;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right
        }

        .dataTables_wrapper .dataTables_length {
            float: left
        }

        .dataTables_info {
            float: left;
        }

        .dataTables_paginate {
            float: right
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
        }

        .table thead tr th {
            font-size: 14px;
        }

        .table tbody tr td {
            font-size: 13px;
        }

        .menu {
            font-size: 13px;
        }
    }

    .hrow {
        height: 2px;
        margin-bottom: 9px;
    }

    .custom-tooltip {
        --bs-tooltip-bg: var(--bs-primary);
    }

    .colortool {
        background-color: red;
    }
</style>
   
    <div class="container-fluid " >
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                       
                        <div class="row">
                            <div class="col-md-2 text-left">
                                <h6>เพิ่มข้อมูลยานพาหนะ</h6>
                            </div>
                            <div class="col"></div>
                           
                          
                        </div>

                    </div>
                    <div class="card-body shadow-lg">
                        <form action="{{ route('car.car_data_index_save') }}" method="POST" id="insert_carForm" enctype="multipart/form-data">
                            @csrf

                        <div class="row">                          

                            <div class="col-md-4">
                                <div class="form-group">
                                  <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                  alt="Image" class="img-thumbnail" width="450px" height="350px">
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="article_img"></label>
                                        <input type="file" class="form-control" id="article_img" name="article_img"
                                            onchange="addarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-8"> 

                                <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/> 
                                <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/> 
                                <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/> 
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                                <div class="row">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_num">เลขครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_num" type="text" class="form-control"
                                                name="article_num" required autocomplete="article_num">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_name">ชื่อครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_name" type="text" class="form-control"
                                                name="article_name" required autocomplete="article_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_attribute">คุณลักษณะ :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_attribute" type="text" class="form-control"
                                                name="article_attribute" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_register">ทะเบียนรถ :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_register" type="text" class="form-control"
                                                name="article_register" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_recieve_date">วันที่รับเข้า :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_recieve_date" type="date" class="form-control" name="article_recieve_date">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_price">ราคา :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_price" type="text" class="form-control" name="article_price">
                                        </div>
                                    </div>
                                </div> 

                                <div class="row ">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_user_id">ผู้รับผิดชอบ :</label>
                                    </div>
                                    <div class="col-md-4 text-center mt-3"> 
                                        <div class="form-group"> 
                                                <select id="article_user_id" name="article_user_id" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($users as $item )
                                                        <option value="{{ $item->id}}">{{ $item->fname}} {{ $item->lname}}</option>
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_status_id">สถานะ :</label>
                                    </div>
                                    <div class="col-md-4 text-center mt-3"> 
                                        <div class="form-group"> 
                                                <select id="article_status_id" name="article_status_id" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($article_status as $status )
                                                        <option value="{{ $status->article_status_id}}">{{ $status->article_status_name}} </option>
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_car_type_id">ประเภทรถ :</label>
                                    </div>
                                    <div class="col-md-4 mt-3 text-center"> 
                                        <div class="form-group"> 
                                                <select id="article_car_type_id" name="article_car_type_id" class="form-control show_type" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($car_type as $car )
                                                        <option value="{{ $car->car_type_id}}">{{ $car->car_type_name}}</option>
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_status_id">เพิ่มประเภทรถ :</label>
                                    </div>
                                    <div class="col-md-3 text-center mt-3"> 
                                        <div class="form-group "> 
                                            <input type="text" id="CAR_TYPE_INSERT" name="CAR_TYPE_INSERT" class="form-control form-control-sm bga" placeholder=" ถ้าไม่มีประเภทให้เพิ่ม "/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-3 text-end"> 
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addcartype();">
                                                เพิ่ม
                                            </button> 
                                        </div>
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_brand_id">ยี่ห้อ :</label>
                                    </div>
                                    <div class="col-md-4 text-center mt-3"> 
                                        <div class="form-group"> 
                                                <select id="article_brand_id" name="article_brand_id" class="form-control show_brand" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($product_brand as $brand )
                                                        <option value="{{ $brand->brand_id}}">{{ $brand->brand_name}}</option>
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_status_id">เพิ่มยี่ห้อ :</label>
                                    </div>
                                    <div class="col-md-3 text-center mt-3"> 
                                        <div class="form-group "> 
                                            <input type="text" id="CAR_MODEL_INSERT" name="CAR_MODEL_INSERT" class="form-control form-control-sm bga" placeholder=" ถ้าไม่มียี่ห้อให้เพิ่ม "/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-end mt-3"> 
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addcarbrand();">
                                                เพิ่ม
                                            </button> 
                                        </div>
                                    </div> 
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_color_id">สี :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group"> 
                                                <select id="article_color_id" name="article_color_id" class="form-control show_color" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($product_color as $color )
                                                        <option value="{{ $color->color_id}}">{{ $color->color_name}}</option>
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="">เพิ่มสี :</label>
                                    </div>
                                    <div class="col-md-3 text-center mt-3"> 
                                        <div class="form-group "> 
                                            <input type="text" id="CAR_COLOR_INSERT" name="CAR_COLOR_INSERT" class="form-control form-control-sm bga" placeholder=" ถ้าไม่มีสีให้เพิ่ม"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-end mt-3"> 
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addcarcolor();">
                                                เพิ่ม
                                            </button> 
                                        </div>
                                    </div> 
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_year">ปี พ.ศ. :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_year" type="text" class="form-control"
                                                name="article_year" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_car_gas">เลขถังแก๊ส :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_car_gas" type="text" class="form-control"
                                                name="article_car_gas">
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_car_number">เลขตัวรถ :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_car_number" type="text" class="form-control"
                                                name="article_car_number">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_serial_no">เลขเครื่อง :</label>
                                    </div>
                                    <div class="col-md-4 mt-3"> 
                                        <div class="form-group">
                                            <input id="article_serial_no" type="text" class="form-control"
                                                name="article_serial_no">
                                        </div>
                                    </div>
                                </div>                              

                                <div class="row ">                                   
                                    <div class="col-md-2 mt-3"> 
                                        <label for="article_status_id">หน่วยงาน :</label>
                                    </div>
                                    <div class="col-md-4 text-center mt-3"> 
                                        <div class="form-group"> 
                                            <select id="article_deb_subsub_id" name="article_deb_subsub_id" class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($department_sub_sub as $deb_subsub)
                                                    <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}"> {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                                @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>

                            </div>                                               
                        </div> 
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end"> 
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-circle-check text-white me-2"></i>
                                    บันทึกข้อมูล
                                </button> 
                                <a href="{{ url('car/car_data_index') }}"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>
                            </div>
                   
                        </div>   
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection
    @section('footer')   
<script>
       function addcarbrand() {
  var car_brandname = document.getElementById("CAR_MODEL_INSERT").value;
  // alert(car_brandname);
  var _token = $('input[name="_token"]').val();
  $.ajax({
      url: "/car/add_carbrand",
      method: "GET",
      data: {
        car_brandname: car_brandname,
          _token: _token
      },
      success: function (result) {
          $('.show_brand').html(result);
      }
  })
}
function addcarcolor() {
  var car_colorname = document.getElementById("CAR_COLOR_INSERT").value;
  // alert(car_brandname);
  var _token = $('input[name="_token"]').val();
  $.ajax({
      url: "/car/add_carcolor",
      method: "GET",
      data: {
        car_colorname: car_colorname,
          _token: _token
      },
      success: function (result) {
          $('.show_color').html(result);
      }
  })
}
</script>
@endsection
