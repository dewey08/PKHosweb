@extends('layouts.supplies')

@section('title', 'ZOFFice || พัสดุ')

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
    use App\Http\Controllers\SuppliesController;
    $refnumber = SuppliesController::refnumber();
    ?>
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">

                    <div class="px-3 py-2 border-bottom">
                        <div class="container d-flex flex-wrap justify-content-center">
                            <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-dark me-2">
                                {{ __('เพิ่มข้อมูลวัสดุ') }}</a>

                            <div class="text-end">
                                <a href="{{ url('supplies/supplies_index') }}" class="btn btn-warning"> <i
                                        class="fa-solid fa-angles-left text-white"> ย้อนกลับ</i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('sup.supplies_index_save') }}" method="POST"
                            id="insert_productForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/default-image.JPG') }}" id="add_upload_preview"
                                        alt="Image" class="img-thumbnail" width="300px" height="250px">
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="img"></label>
                                        <input type="file" class="form-control" id="img" name="img"
                                            onchange="addproducts(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="product_code" type="text" class="form-control"
                                                    name="product_code" value="{{ $refnumber }}"
                                                    autocomplete="product_code" autofocus placeholder="รหัสวัสดุ">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input id="product_name" type="text" class="form-control"
                                                    name="product_name" required autocomplete="product_name" autofocus
                                                    placeholder="รายการวัสดุ">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="product_attribute" type="text" class="form-control"
                                                    name="product_attribute" autocomplete="product_attribute" autofocus
                                                    placeholder="คุณลักษณะ">
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="product_groupid" name="product_groupid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($product_group as $progroup)
                                                        <option value="{{ $progroup->product_group_id }}">
                                                            {{ $progroup->product_group_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <select id="product_typeid" name="product_typeid"
                                                        class="form-select form-select-lg" style="width: 100%">
                                                        <option value=""></option>
                                                        @foreach ($product_type as $protype)
                                                            <option value="{{ $protype->sub_type_id }}">
                                                                {{ $protype->sub_type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_spypriceid" name="product_spypriceid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($product_spyprice as $prospy)
                                                        <option value="{{ $prospy->spyprice_id }}">
                                                            {{ $prospy->spyprice_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <select id="product_unit_bigid" name="product_unit_bigid"
                                                        class="form-select form-select-lg" style="width: 100%">
                                                        <option value=""></option>
                                                        @foreach ($product_unit as $prounit)
                                                            <option value="{{ $prounit->unit_id }}">
                                                                {{ $prounit->unit_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                    <div class="card">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary mb-2 mt-2 me-3">
                                <i class="fa-solid fa-floppy-disk me-3"></i>บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>


@endsection
