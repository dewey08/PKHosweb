@extends('layouts.article')
@section('title', 'PK-OFFICER || ข้อมูลครุภัณฑ์')

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
            var fileInput = document.getElementById('article_img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#add_upload_preview').attr('src', e.target.result);
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

    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="">
                                <label for="">เพิ่มข้อมูลครุภัณฑ์</label>
                            </div>
                            <div class="ms-auto">
                                <form class="custom-validation" action="{{ route('art.article_index_save') }}" method="POST"
                                    id="insert_articleForm" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="article_claim"
                                                    id="article_claim" value="CLAIM">
                                                <label class="form-check-label" for="article_claim">
                                                    เคลม
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="article_claim"
                                                    id="article_claim" value="NOCLAIM" checked>
                                                <label class="form-check-label" for="article_claim">
                                                    ไม่เคลม
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="article_used"
                                                    id="article_used" value="YES" >
                                                <label class="form-check-label" for="article_used">
                                                    ใช้บ่อย
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="article_used"
                                                    id="article_used" value="NO" checked>
                                                <label class="form-check-label" for="article_used">
                                                    ไม่ใช้บ่อย
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col me-5"></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg">

                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        <input type="hidden" name="article_typeid" id="PRODUCT_TYPEID" value="2">
                        <input type="hidden" name="article_groupid" id="PRODUCT_GROUPID" value="3">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                        alt="Image" class="img-thumbnail" width="450px" height="350px">
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="article_img">Upload</label>
                                        <input type="file" class="form-control" id="article_img" name="article_img"
                                            onchange="addarticle(this)">
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
                                            <select id="article_year" name="article_year" class="form-select form-select-lg"
                                                style="width: 100%">
                                                <option value="">ปีงบประมาณ</option>
                                                @foreach ($budget_year as $year)
                                                    <option value="{{ $year->leave_year_id }}">
                                                        {{ $year->leave_year_id }} </option>
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
                                                class="form-control form-control-sm" name="article_recieve_date">
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
                                                name="article_num">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="article_name">ชื่อครุภัณฑ์ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="article_name" type="text" class="form-control form-control-sm"
                                                name="article_name">
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
                                                class="form-control form-control-sm" name="article_attribute">
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
                                                    <option value="{{ $vendor->vendor_id }}">
                                                        {{ $vendor->vendor_name }}
                                                    </option>
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
                                                name="article_price">
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
                                                    <option value="{{ $buy->buy_id }}">{{ $buy->buy_name }}
                                                    </option>
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
                                                    <option value="{{ $procat->category_id }}">
                                                        {{ $procat->category_name }}
                                                    </option>
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
                                                    <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}">
                                                        {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
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
                                                    <option value="{{ $prodecli->decline_id }}">
                                                        {{ $prodecli->decline_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <label for="article_status_id">สถานะ :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="article_status_id" name="article_status_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($article_status as $te)
                                                    <option value="{{ $te->article_status_id }}">
                                                        {{ $te->article_status_name }} </option>
                                                @endforeach
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
                                                    <option value="{{ $uni->unit_id }}">
                                                        {{ $uni->unit_name }}
                                                    </option>
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
                                                    <option value="{{ $bra->brand_id }}">
                                                        {{ $bra->brand_name }}
                                                    </option>
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
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addbrand();">
                                                เพิ่ม
                                            </button>
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
                                <a href="{{ url('article/article_index') }}" class="btn btn-danger btn-sm">
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




@endsection
