@extends('layouts.article')
@section('title', 'ZOFFice || ข้อมูลครุภัณฑ์')

@section('menu')
    <style>
        .btn {
            font-size: 15px;
        }
    </style>
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_article_car = StaticController::count_article_car();
 ?>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
          
            <a href="{{ url('article/article_dashboard') }}" class="btn btn-secondary btn-sm text-white me-2">dashboard <span class="badge bg-danger ms-2">0</span></a>
            <a href="{{url("land/land_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลที่ดิน</a>
            <a href="{{url("building/building_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลอาคาร</a>   
            <a href="{{url("article/article_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลครุภัณฑ์</a>           
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลค่าเสื่อม</a>
            <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ขายทอดตลาด</a>  
            <div class="text-end">
                {{-- <a href="{{url("car/car_report")}}" class="btn btn-success btn-rounded">ออกเลขหนังสือรับ</a> --}}
               
            </div>
        </div>
    </div>
@endsection

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
