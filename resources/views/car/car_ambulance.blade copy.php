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
            <a href="{{ url('car/car_ambulance') }}" class="btn btn-info btn-sm text-white me-2">รถพยาบาล <span class="badge bg-danger ms-2">0</span></a>
            <a href="{{ url('car/car_data_index') }}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลยานพาหนะ <span class="badge bg-danger ms-2">{{$count_article_car}}</span></a>
            <a href="{{ url('car/car_report') }}"
                class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รายงาน</a>

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
                                    <?php $i = 1; $date = date('Y'); ?>
                                    @foreach ($car_index as $item)
                                        <tr id="sid{{ $item->car_index_id }}">
                                            <td class="text-center" width="3%">{{ $i++ }}</td>

                                            @if ($item->car_index_status == '4')
                                                <td class="font-weight-medium text-center" width="10%">
                                                    <div class="badge bg-danger shadow">
                                                        {{ $item->car_status_name }}</div>
                                                </td>
                                            @elseif ($item->car_index_status == '2')
                                                <td class="font-weight-medium text-center" width="10%">
                                                    <div class="badge bg-success shadow">
                                                        {{ $item->car_status_name }}</div>
                                                </td>
                                            @elseif ($item->car_index_status == '1')
                                                <td class="font-weight-medium text-center" width="10%">
                                                    <div class="badge bg-info shadow">{{ $item->car_status_name }}
                                                    </div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="10%">
                                                    <div class="badge bg-warning shadow">
                                                        {{ $item->car_status_name }}</div>
                                                </td>
                                            @endif

                                            <td class="font-weight-bold">{{ $item->car_index_register }}</td>
                                            {{-- <td class="p-2" width="10%">{{ $item->bookrep_usersend_name }}</td> --}}
                                            <td class="p-2" width="17%">
                                                {{ dateThaifromFull($item->car_index_length_godate) }}&nbsp;
                                                {{ $item->car_index_length_gotime }} น.</td>

                                            {{-- @if ($item->bookrep_send_code == 'waitsend')
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-danger shadow"> รอดำเนินการ</div>
                                                </td>
                                            @elseif ($item->bookrep_send_code == 'senddep')
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-warning shadow">ส่งหน่วยงาน</div>
                                                </td>
                                            @elseif ($item->bookrep_send_code == 'allows')
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-info shadow">ผอ.อนุมัติ</div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-secondary shadow">ลงรับ</div>
                                                </td>
                                            @endif --}}

                                            <td class="p-2">{{ $item->car_index__user_name }}</td>
                                            <td class="text-center" width="10%">
                                                <a href="{{ url('book/bookmake_index_send/' . $item->car_index_id) }}"
                                                    class="text-primary me-3" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                </a>
                                                <a href="{{ url('book/bookmake_index_edit/' . $item->car_index_id) }}"
                                                    class="text-warning me-3" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="car_destroy({{ $item->car_index_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

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
