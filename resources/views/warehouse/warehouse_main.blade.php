{{-- @extends('layouts.accpk') --}}
@extends('layouts.warehouse_new')
@section('title', 'PK-OFFICER || คลังวัสดุ')
@section('content')

    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function warehouse_destroy(warehouse_rep_id) {
            Swal.fire({
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('warehouse/warehouse_destroy') }}" + '/' + warehouse_rep_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + warehouse_rep_id).remove();
                                    window.location.reload();
                                }
                            })
                        }
                    })
                }
            })
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
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SuppliesController;
    use App\Http\Controllers\StaticController;
    $refnumber = SuppliesController::refnumber();
    $count_product = StaticController::count_product();
    $count_service = StaticController::count_service();
    ?>
    <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
               }
               .cv-spinner {
               height: 100%;
               display: flex;
               justify-content: center;
               align-items: center;
               }
               .spinner {
               width: 250px;
               height: 250px;
               border: 10px #ddd solid;
               border-top: 10px #1fdab1 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% {
                   transform: rotate(390deg);
               }
               }
               .is-hide{
               display:none;
               }
    </style>
    <div class="container-fluid">

        <div class="row ">
            @foreach ($warehouse_inven as $item)
                
                @if ($item->warehouse_inven_id == '1')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(236, 188, 198)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(236, 188, 198)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($item->warehouse_inven_id == '2')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(107, 189, 202)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(107, 189, 202)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($item->warehouse_inven_id == '3')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color:rgba(245, 164, 209, 0.452)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgba(245, 164, 209, 0.452)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($item->warehouse_inven_id == '4')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(207, 248, 253)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(207, 248, 253)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($item->warehouse_inven_id == '5')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(182, 157, 240)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(182, 157, 240)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($item->warehouse_inven_id == '6')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgba(187, 192, 187, 0.781)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgba(210, 211, 210, 0.781)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($item->warehouse_inven_id == '7')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(209, 178, 250)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(209, 178, 250)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: palevioletred"></i> --}}
                @elseif ($item->warehouse_inven_id == '8')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(141, 185, 218)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(141, 185, 218)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(216, 53, 107)"></i> --}}
                @elseif ($item->warehouse_inven_id == '9')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(245, 180, 150)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(245, 180, 150)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(2, 78, 44)"></i> --}}
                @elseif ($item->warehouse_inven_id == '10')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(252, 177, 210)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(252, 177, 210)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(241, 48, 0)"></i> --}}
                @elseif ($item->warehouse_inven_id == '11')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgba(237, 199, 247, 0.781)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgba(237, 199, 247, 0.781)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(132, 6, 144)"></i> --}}
                @elseif ($item->warehouse_inven_id == '12')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgba(247, 242, 173, 0.781)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgba(247, 242, 173, 0.781)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(138, 112, 216)"></i> --}}
                @elseif ($item->warehouse_inven_id == '13')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgba(210, 211, 210, 0.781)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgba(210, 211, 210, 0.781)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(39, 8, 38)"></i> --}}
                @elseif ($item->warehouse_inven_id == '14')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(155, 230, 243)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(155, 230, 243)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(229, 237, 10)"></i> --}}
                @elseif ($item->warehouse_inven_id == '15')
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(107, 189, 202)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                    {{-- <i class="fa-solid fa-3x fa-user-tie font-size-25 mt-3" style="color: rgb(234, 157, 172)"></i> --}}
                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(107, 189, 202)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(11, 88, 99)"></i> --}}
                @else

                @endif
                {{-- <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card shadow-lg" style="background-color: rgb(107, 189, 202)">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                    <h5 class="text-start mb-2">{{$item->warehouse_inven_name}}</h5>
                                                </div>
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" target="_blank">
                                                        <span class="avatar-title bg-white text-primary rounded-3">
                                                            <p style="font-size: 10px;">
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">

                                                                    <i class="fa-solid fa-3x fa-warehouse font-size-25 mt-3" style="color: rgb(107, 189, 202)"></i>
                                                                </button>
                                                            </p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                @endforeach
            </div>


        </div>
    </div>


@endsection
