@extends('layouts.article')
@section('title', 'PK-OFFICER || ข้อมูลที่ดิน')

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

    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex">
                            <div class="">
                                <label for="">แก้ไขข้อมูลที่ดิน </label>
                            </div>
                            <div class="ms-auto">

                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <form class="custom-validation" action="{{ route('land.land_index_update') }}" method="POST"
                            id="update_landForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="land_id" id="land_id" value="{{ $dataedits->land_id }}">

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">

                                        @if ($dataedits->land_img == null)
                                            <img src="{{ asset('assets/images/default-image.jpg') }}"
                                                id="edit_upload_preview" height="350px" width="350px" alt="Image"
                                                class="img-thumbnail">
                                        @else
                                            <img src="{{ asset('storage/land/' . $dataedits->land_img) }}"
                                                id="edit_upload_preview" height="350px" width="350px" alt="Image"
                                                class="img-thumbnail">
                                        @endif
                                        <br>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="land_img"></label>
                                            <input type="file" class="form-control" id="land_img" name="land_img"
                                                onchange="editland(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">

                                    <!-- <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                    <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/>
                                    <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/>
                                    <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/>
                                    <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> -->

                                    <div class="row">
                                        <div class="col-md-2 text-end">
                                            <label for="land_tonnage_number">หมายเลขระวาง :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_tonnage_number" type="text"
                                                    class="form-control form-control-sm" name="land_tonnage_number"
                                                    value="{{ $dataedits->land_tonnage_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="article_name">เลขที่ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_no" type="text" class="form-control form-control-sm"
                                                    name="land_no" value="{{ $dataedits->land_no }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="land_tonnage_no">เลขโฉนดที่ดิน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_tonnage_no" type="text"
                                                    class="form-control form-control-sm" name="land_tonnage_no"
                                                    value="{{ $dataedits->land_tonnage_no }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="land_explore_page">หน้าสำรวจ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_explore_page" type="text"
                                                    class="form-control form-control-sm" name="land_explore_page"
                                                    value="{{ $dataedits->land_explore_page }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="land_farm_area">เนื้อที่ไร่ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_farm_area" type="text"
                                                    class="form-control form-control-sm" name="land_farm_area"
                                                    value="{{ $dataedits->land_farm_area }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="land_work_area">เนื้อที่งาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_work_area" type="text"
                                                    class="form-control form-control-sm" name="land_work_area"
                                                    value="{{ $dataedits->land_work_area }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="land_square_wah_area">เนื้อที่ตารางวา :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_square_wah_area" type="text"
                                                    class="form-control form-control-sm" name="land_square_wah_area"
                                                    value="{{ $dataedits->land_square_wah_area }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="land_date">วันถือครอง :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_date" type="date" class="form-control form-control-sm"
                                                    name="land_date" value="{{ $dataedits->land_date }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="land_holder_name">ผู้ถือครอง :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_holder_name" type="text"
                                                    class="form-control form-control-sm" name="land_holder_name"
                                                    value="{{ $dataedits->land_holder_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="land_house_number">ที่ตั้งบ้านเลขที่ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="land_house_number" type="text"
                                                    class="form-control form-control-sm" name="land_house_number"
                                                    value="{{ $dataedits->land_house_number }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="land_house_number">จังหวัด :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="land_province_location" name="land_province_location"
                                                    class="form-select form-select-lg provice" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($data_province as $province)
                                                        @if ($dataedits->land_province_location == $province->ID)
                                                            <option value="{{ $province->ID }}" selected>
                                                                {{ $province->PROVINCE_NAME }} </option>
                                                        @else
                                                            <option value="{{ $province->ID }}">
                                                                {{ $province->PROVINCE_NAME }} </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="land_house_number">อำเภอ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="land_district_location" name="land_district_location"
                                                    class="form-select form-select-lg amphures" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($data_amphur as $amper)
                                                        @if ($dataedits->land_district_location == $amper->ID)
                                                            <option value="{{ $amper->ID }}" selected>
                                                                {{ $amper->AMPHUR_NAME }} </option>
                                                        @else
                                                            <option value="{{ $amper->ID }}">
                                                                {{ $amper->AMPHUR_NAME }} </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="land_house_number">ตำบล :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="land_tumbon_location" name="land_tumbon_location"
                                                    class="form-select form-select-lg tumbon" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($data_tumbon as $tum)
                                                        @if ($dataedits->land_tumbon_location == $tum->ID)
                                                            <option value="{{ $tum->ID }}" selected>
                                                                {{ $tum->TUMBON_NAME }} </option>
                                                        @else
                                                            <option value="{{ $tum->ID }}"> {{ $tum->TUMBON_NAME }}
                                                            </option>
                                                        @endif
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="article_status_id">ผู้รับผิดชอบ :</label>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <select id="land_user_id" name="land_user_id" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($users as $item)
                                                        @if ($dataedits->land_user_id == $item->id)
                                                            <option value="{{ $item->id }}" selected>
                                                                {{ $item->fname }} {{ $item->lname }}</option>
                                                        @else
                                                            <option value="{{ $item->id }}">{{ $item->fname }}
                                                                {{ $item->lname }}</option>
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
                        <div class="col-md-12 text-end">
                            <div class="form-group">

                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>

                                <a href="{{ url('land/land_index') }}" class="btn btn-danger btn-sm">
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
        function editland(input) {
            var fileInput = document.getElementById('land_img');
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
        $('.provice').change(function() {
            if ($(this).val() != '') {
                var select = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('fect.province_fect') }}",
                    //   url:'/province_fect/',
                    method: "GET",
                    data: {
                        select: select,
                        _token: _token
                    },
                    success: function(result) {
                        $('.amphures').html(result);
                    }
                })
            }
        });

        $('.amphures').change(function() {
            if ($(this).val() != '') {
                var select = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('fect.district_fect') }}",
                    //   url:'/district_fect/',
                    method: "GET",
                    data: {
                        select: select,
                        _token: _token
                    },
                    success: function(result) {
                        $('.tumbon').html(result);
                    }
                })
            }
        });
    </script>
@endsection
