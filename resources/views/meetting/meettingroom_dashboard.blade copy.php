@extends('layouts.meetting')
@section('title', 'ZOFFice || ห้องประชุม')

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
     $count_meettinservice = StaticController::count_meettinservice();
 ?>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
           
            <a href="{{ url('meetting/meettingroom_dashboard') }}" class="btn btn-success btn-sm text-white me-2">dashboard  </a>
            <a href="{{ url('meetting/meettingroom_index') }}" class="btn btn-light btn-sm text-dark me-2">รายการห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('meetting/meettingroom_check') }}" class="btn btn-light btn-sm text-dark me-2">ตรวจสอบการจองห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettinservice}}</span></a>
            <a href="{{ url('meetting/meettingroom_report') }}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รายงาน</a>

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
