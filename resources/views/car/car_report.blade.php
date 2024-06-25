@extends('layouts.car')
@section('title', 'ZOFFice || ยานพาหนะ')

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
           
            <a href="{{ url('car/car_narmal_index') }}" class="btn btn-light btn-sm text-dark me-2">รถยนต์ทั่วไป <span class="badge bg-danger ms-2">0</span></a>
            <a href="{{ url('car/car_ambulance') }}" class="btn btn-light btn-sm text-dark me-2">รถพยาบาล <span class="badge bg-danger ms-2">0</span></a>
            <a href="{{ url('car/car_data_index') }}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลยานพาหนะ <span class="badge bg-danger ms-2">{{$count_article_car}}</span></a>
            <a href="{{ url('car/car_report') }}"
                class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-info btn-sm text-white me-2">รายงาน</a>

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
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example">
                                {{-- <table class="table table-hover table-bordered border-primary" style="width: 100%;" id="table_id"> เส้นสีฟ้า --}}
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">ความเร่งด่วน</th>
                                        <th class="text-center">ทะเบียน</th>
                                        <th class="text-center">วันที่ไป-เวลา</th>
                                        {{-- <th class="text-center">เวลา</th> --}}
                                        <th class="text-center">ผุ็ร้องขอ</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('js/book.js') }}"></script>

@endsection
