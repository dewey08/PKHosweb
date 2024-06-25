@extends('layouts.car')
@section('title', 'ZOFFice || ยานพาหนะ')
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
                reader.onload = function (e) {
                    $('#edit_upload_preview').attr('src', e.target.result);
                }    
                reader.readAsDataURL(input.files[0]);
            }else{    
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
<style>
        .btn {
            font-size: 15px;
        }
        .bgc{
    background-color: #264886;
   }
   .bga{
    background-color: #faf7c8;
   }
    </style>
    <?php
        use App\Http\Controllers\StaticController;
        use Illuminate\Support\Facades\DB;   
        $count_article_car = StaticController::count_article_car();
     $count_car_service = StaticController::count_car_service();
    ?>
 
   
    <div class="container-fluid " style="width: 97%">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                        <form action="{{ route('car.car_data_index_update') }}" method="POST" id="update_carForm" enctype="multipart/form-data">
                            @csrf

                        <div class="row">                          

                            <div class="col-md-4">
                                <div class="form-group"> 
                                  

                                  @if ( $dataedits->article_img == Null )
                                            <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="450px" width="350px" alt="Image" class="img-thumbnail">
                                            @else
                                            <img src="{{asset('storage/article/'.$dataedits->article_img)}}" id="edit_upload_preview" height="450px" width="350px" alt="Image" class="img-thumbnail">                                 
                                            @endif
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="article_img"></label>
                                        <input type="file" class="form-control" id="article_img" name="article_img"
                                            onchange="editarticle(this)">
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
                                <input type="hidden" name="article_id" id="article_id" value="{{$dataedits->article_id}}">

                                <div class="row">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_num">เลขครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_num" type="text" class="form-control"
                                                name="article_num" required autocomplete="article_num" value="{{$dataedits->article_num}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_name">ชื่อครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_name" type="text" class="form-control"
                                                name="article_name" required autocomplete="article_name" value="{{$dataedits->article_name}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_attribute">คุณลักษณะ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_attribute" type="text" class="form-control"
                                                name="article_attribute" value="{{$dataedits->article_attribute}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_register">ทะเบียนรถ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_register" type="text" class="form-control"
                                                name="article_register" value="{{$dataedits->article_register}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_recieve_date">วันที่รับเข้า :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_recieve_date" type="date" class="form-control" name="article_recieve_date" value="{{$dataedits->article_recieve_date}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_price">ราคา :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_price" type="text" class="form-control" name="article_price" value="{{$dataedits->article_price}}">
                                        </div>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_user_id">ผู้รับผิดชอบ :</label>
                                    </div>
                                    <div class="col-md-4 text-center mt-2"> 
                                        <div class="form-group"> 
                                                <select id="article_user_id" name="article_user_id" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($users as $item )
                                                      @if ($dataedits->article_user_id == $item->id)
                                                      <option value="{{ $item->id}}" selected>{{ $item->fname}} {{ $item->lname}}</option>
                                                      @else
                                                      <option value="{{ $item->id}}">{{ $item->fname}} {{ $item->lname}}</option>
                                                      @endif
                                                        
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_status_id">สถานะ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group"> 
                                                <select id="article_status_id" name="article_status_id" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($article_status as $status )
                                                      @if ($dataedits->article_status_id == $status->article_status_id)
                                                      <option value="{{ $status->article_status_id}}" selected>{{ $status->article_status_name}} </option>
                                                      @else
                                                      <option value="{{ $status->article_status_id}}">{{ $status->article_status_name}} </option>
                                                      @endif
                                                        
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_car_type_id">ประเภทรถ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group"> 
                                                <select id="article_car_type_id" name="article_car_type_id" class="form-control show_type" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($car_type as $car )
                                                      @if ($dataedits->article_car_type_id == $car->car_type_id)
                                                      <option value="{{ $car->car_type_id}}" selected>{{ $car->car_type_name}}</option>
                                                      @else
                                                      <option value="{{ $car->car_type_id}}">{{ $car->car_type_name}}</option>
                                                      @endif
                                                       
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_status_id">เพิ่มประเภทรถ :</label>
                                    </div>
                                    <div class="col-md-3 mt-2"> 
                                        <div class="form-group "> 
                                            <input type="text" id="CAR_TYPE_INSERT" name="CAR_TYPE_INSERT" class="form-control shadow bga" placeholder="ถ้าไม่มีประเภทให้เพิ่ม"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-2"> 
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addcartype();">
                                                เพิ่ม
                                            </button> 
                                        </div>
                                    </div> 
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_brand_id">ยี่ห้อ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group"> 
                                                <select id="article_brand_id" name="article_brand_id" class="form-control show_brand" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($product_brand as $brand )
                                                      @if ($dataedits->article_brand_id == $brand->brand_id)
                                                      <option value="{{ $brand->brand_id}}" selected>{{ $brand->brand_name}}</option>
                                                      @else
                                                      <option value="{{ $brand->brand_id}}">{{ $brand->brand_name}}</option>
                                                      @endif
                                                       
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_status_id">เพิ่มยี่ห้อ :</label>
                                    </div>
                                    <div class="col-md-3 mt-2"> 
                                        <div class="form-group "> 
                                            <input type="text" id="CAR_MODEL_INSERT" name="CAR_MODEL_INSERT" class="form-control shadow bga" placeholder="ถ้าไม่มียี่ห้อให้เพิ่ม"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-2"> 
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addcarbrand();">
                                                เพิ่ม
                                            </button> 
                                        </div>
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_color_id">สี :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group"> 
                                                <select id="article_color_id" name="article_color_id" class="form-control show_color" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($product_color as $color )
                                                      @if ($dataedits->article_color_id ==$color->color_id)
                                                      <option value="{{ $color->color_id}}" selected>{{ $color->color_name}}</option>
                                                      @else
                                                      <option value="{{ $color->color_id}}">{{ $color->color_name}}</option>
                                                      @endif
                                                        
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="">เพิ่มสี :</label>
                                    </div>
                                    <div class="col-md-3 mt-2"> 
                                        <div class="form-group "> 
                                            <input type="text" id="CAR_COLOR_INSERT" name="CAR_COLOR_INSERT" class="form-control shadow bga" placeholder="ถ้าไม่มีสีให้เพิ่ม"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-2"> 
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addcarcolor();">
                                                เพิ่ม
                                            </button> 
                                        </div>
                                    </div> 
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_year">ปี พ.ศ. :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_year" type="text" class="form-control" name="article_year" value="{{$dataedits->article_year}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_car_gas">เลขถังแก๊ส :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_car_gas" type="text" class="form-control"
                                                name="article_car_gas" value="{{$dataedits->article_car_gas}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_car_number">เลขตัวรถ :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_car_number" type="text" class="form-control"
                                                name="article_car_number" value="{{$dataedits->article_car_number}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_serial_no">เลขเครื่อง :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group">
                                            <input id="article_serial_no" type="text" class="form-control"
                                                name="article_serial_no" value="{{$dataedits->article_serial_no}}">
                                        </div>
                                    </div>
                                </div>                              

                                <div class="row ">                                   
                                    <div class="col-md-2 mt-2"> 
                                        <label for="article_status_id">หน่วยงาน :</label>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                        <div class="form-group"> 
                                            <select id="article_deb_subsub_id" name="article_deb_subsub_id" class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>                                               
                                                @foreach ($department_sub_sub as $deb_subsub)
                                                @if ($dataedits->article_deb_subsub_id ==$deb_subsub->DEPARTMENT_SUB_SUB_ID )
                                                <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}" selected> {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                                @else
                                                <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}"> {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                                @endif
                                                    
                                                @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>

                            </div>                                               
                        </div> 
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 mt-3 mt-2 text-end"> 
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-circle-check text-white me-2"></i>
                                    แก้ไขข้อมูล
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
