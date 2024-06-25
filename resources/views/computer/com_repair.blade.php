@extends('layouts.com')
@section('title', 'ZOFFice || computer')

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
           
            <a href="{{ url('computer/com_dashboard') }}" class="btn btn-light btn-sm text-dark me-2">dashboard  </a>
            <a href="{{ url('computer/com_index') }}" class="btn btn-light btn-sm text-dark me-2">ทะเบียนคอมพิวเตอร์ <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('computer/com_repair') }}" class="btn btn-secondary btn-sm text-white me-2">ทะเบียนซ่อมคอมพิวเตอร์ <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('computer/com_report') }}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รายงาน</a>

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
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example2"> 
                                <thead>
                                    <tr height="10px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ชื่ออาคาร</th>
                                        <th width="12%" class="text-center">งบประมาณที่สร้าง</th>
                                        <th width="12%" class="text-center">วันที่เริ่มสร้าง</th>
                                        <th width="12%" class="text-center">วันที่แล้วเสร็จ</th>
                                        <th width="7%" class="text-center">อายุใช้งาน</th>
                                        <th width="12%" class="text-center">งบประมาณ</th>
                                        {{-- <th width="12%" class="text-center">Manage</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($building_data as $item)
                                        <tr id="sid{{ $item->building_id }}">
                                            <td class="text-center" width="5%">{{ $i++ }}</td>
                                            <td class="p-2">{{ $item->building_name }} </td>
                                            <td class="text-center" width="12%">{{ number_format($item->building_budget_price ),2}}</td>
                                            <td class="text-center" width="12%">{{ DateThai($item->building_creation_date) }}</td>
                                            <td class="text-center" width="12%">{{ DateThai($item->building_completion_date) }}</td>
                                            <td class="text-center" width="7%">{{ $item->old_year }}</td>
                                            <td class="p-2" width="12%">{{ $item->building_budget_name }}</td>
                                            {{-- <td class="text-center" width="12%">
                                                <a href="{{ url('building/building_index_edit/' .$item->building_id) }}"
                                                    class="text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข" >
                                                    <i class="fa-solid fa-pen-to-square me-3"></i>
                                                </a>                                               
                                                <a href="{{ url('building/building_addlevel/' .$item->building_id) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="เพิ่มชั้นห้อง" >
                                                    <i class="fa-solid fa-file-circle-plus"></i>
                                                </a>                                              
                                            </td> --}}
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
    <script src="{{ asset('js/com.js') }}"></script>

@endsection
