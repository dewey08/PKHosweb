@extends('layouts.hosing')
@section('title', 'ZOFFice || บ้านพัก')

@section('menu')
    <style>
        .btn {
            font-size: 15px;
        }
    </style>
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
           
            <a href="{{ url('housing/housing_dashboard') }}" class="btn btn-info btn-sm text-dark me-2">dashboard  </a>
            <a href="{{ url('housing/housing_index') }}" class="btn btn-light btn-sm text-dark me-2">รายการบ้านพัก <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('housing/housing_request') }}" class="btn btn-light btn-sm text-dark me-2">รายการขอเข้าพัก <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('housing/housing_appeal') }}" class="btn btn-light btn-sm text-dark me-2">ร้องเรียนปัญหา <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('housing/housing_report') }}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-info btn-sm text-white me-2">รายงาน</a>

            <div class="text-end">
                {{-- <a href="{{url("car/car_report")}}" class="btn btn-info btn-rounded">ออกเลขหนังสือรับ</a> --}}
               
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
            {{-- <div class="col-md-3">  
        </div> --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                        


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('js/book.js') }}"></script>

@endsection
