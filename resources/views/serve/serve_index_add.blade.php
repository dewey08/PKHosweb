@extends('layouts.supplies')
@section('title', 'PK-OFFICER || ข้อมูลบริการ')

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
<style>
    .btn {
        font-size: 15px;
    }
</style>
<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
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
    <?php
    use App\Http\Controllers\ServeController;
    $refserve = ServeController::refserve();
    ?>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <label for="">เพิ่มข้อมูลบริการ</label>
                    </div>

                    <div class="card-body shadow">

                        <form class="custom-validation" action="{{ route('serve.serve_index_save') }}" method="POST"
                            id="insert_serveForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                            <div class="row ">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                            alt="Image" class="img-thumbnail" width="350px" height="250px">
                                        <br>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="img"></label>
                                            <input type="file" class="form-control" id="img" name="img"
                                                onchange="addserve(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="product_code" type="text" class="form-control"
                                                    name="product_code" value="{{ $refserve }}"
                                                    autocomplete="product_code" autofocus placeholder="รหัสวัสดุ" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="product_name" type="text" class="form-control"
                                                    name="product_name" required autocomplete="product_name" autofocus
                                                    placeholder="รายการบริการ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="product_attribute" type="text" class="form-control"
                                                    name="product_attribute" autocomplete="product_attribute" autofocus
                                                    placeholder="คุณลักษณะ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="product_groupids" type="hidden" class="form-control"
                                                    name="product_groupid" value="4">
                                                <input id="w" type="text" class="form-control" name="w"
                                                    autocomplete="w" autofocus placeholder="บริการ" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="product_typeids" type="hidden" class="form-control"
                                                    name="product_typeid" value="3">
                                                <input id="s" type="text" class="form-control" name="s"
                                                    autocomplete="s" autofocus placeholder="จ้างเหมา" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="product_categoryids" type="hidden" class="form-control"
                                                    name="product_categoryid" value="23">
                                                <input id="ss" type="text" class="form-control" name="ss"
                                                    autocomplete="ss" autofocus placeholder="จ้างเหมาอื่นๆ" readonly>
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
                                <a href="{{ url('serve/serve_index') }}" class="btn btn-danger btn-sm">
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
