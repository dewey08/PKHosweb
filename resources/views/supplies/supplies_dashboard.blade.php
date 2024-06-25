@extends('layouts.supplies')
@section('title','PK-OFFICER || พัสดุ')
{{-- @section('menu') --}}
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
    {{-- <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">   
            <a href="{{ url('supplies/supplies_dashboard') }}" class="btn btn-success btn-sm text-white me-2">dashboard </a>
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-light btn-sm text-dark me-2">ขอซื้อขอจ้าง<span class="badge bg-danger ms-2">12</span></a>
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-light btn-sm text-dark me-2">จัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">14</span></a>   
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลวัสดุ<span class="badge bg-danger ms-2">10</span></a>   
            <a href="{{url("serve/serve_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ข้อมูลบริการ<span class="badge bg-danger ms-2">{{$count_service}}</span></a>  
        <div class="text-end">
            <a href="{{ url('article/article_index_add') }}" class="btn btn-outline-danger btn-sm text-dark me-2">ตั้งค่า </a>
        </div>
        </div>
    </div>
@endsection --}}
@section('content')
    <div class="container-fluid " style="width: 97%">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                        


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


@endsection
