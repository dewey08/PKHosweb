@extends('layouts.admindashboard')
@section('title', 'PK-OFFICER  || ผู้ดูแลระบบ')

@section('content')
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
    .popic {
        position: absolute;
        width: 180px;
        height: 170px;
        /* background:
            url(/pkbackoffice/public/images/ponews.png)no-repeat 100%; */
        /* url(/sky16/images/logo250.png)no-repeat 25%; */
        /* background-size: cover; */
        top: 70%;
        right: 1%;
        z-index: -1;
        animation: float 2s ease-in-out infinite;
    }
</style>

{{-- headerZ --}}
 <br>
    {{-- <div class="container mt-3"> --}}
        <div class="container-fluid mt-3 mb-4">
            {{-- <div class="circle1"> </div> --}}
            <div class="popic hover-shadow"> <img src="{{ asset('storage/person/'.Auth::user()->img) }}" width="150" height="150" alt="" style="border-radius: 50%;"></div>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(236, 188, 198)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('person/person_index') }}" target="_blank">   <h5 class="text-start mb-2">บุคคลากร</h5>   </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('person/person_index') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-user-tie font-size-25" style="color: rgb(234, 157, 172)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2"> 
                    <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(152, 226, 224)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('time_dashboard') }}" target="_blank"> <h5 class="text-start mb-2">ระบบลงเวลา</h5>         </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('time_dashboard') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-danger rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">

                                                                <i class="fa-regular fa-3x fa-clock font-size-25 " style="color: rgb(119, 218, 215)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(199, 181, 240)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('otone') }}" target="_blank"> <h5 class="text-start mb-2">โอที</h5>      </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('otone') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-people-line font-size-25" style="color: rgb(171, 149, 223)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgba(255, 255, 255, 0.452)">
                    {{-- <div class="main-card mb-3 card shadow-lg" style="background-color: rgba(245, 164, 209, 0.452)"> --}}
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">ระบบการลา</h5>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a>
                                                    {{-- <a href="{{ url('gleave') }}" target="_blank"> --}}
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                 <i class="fa-solid fa-3x fa-hospital-user font-size-25" style="color: rgba(240, 161, 204, 0.945)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(245, 176, 250)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">สารบรรณ</h5>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a >
                                                    {{-- <a href="{{ url('book/bookmake_index') }}" target="_blank"> --}}
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-book-open-reader font-size-25" style="color: rgb(194, 137, 199)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(207, 248, 253)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">ยานพาหนะ</h5>    
                                            </div>
                                            <div class="avatar ms-2">
                                                <a >
                                                    {{-- <a href="{{ url('car/car_narmal_calenda') }}" target="_blank"> --}}
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-truck-medical font-size-25" style="color: rgb(152, 239, 248)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">ห้องประชุม</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('meetting/meettingroom_dashboard') }}" target="_blank">
                                                    <span class="avatar-title bg-white text-primary rounded-3">
                                                        <p style="font-size: 10px;">
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                 <i class="fa-solid fa-3x fa-house-laptop font-size-25 mt-3" style="color: rgb(118, 223, 176)"></i>
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
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">ซ่อมบำรุง</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('repaire_narmal') }}" target="_blank">
                                                    <span class="avatar-title bg-white text-primary rounded-3">
                                                        <p style="font-size: 10px;">
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                <i class="fa-solid fa-3x fa-screwdriver-wrench font-size-25 mt-3" style="color: rgb(90, 160, 212)"></i>
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
        </div>

        <div class="row">
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(247, 217, 217)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('plan') }}" target="_blank"><h5 class="text-start mb-2">แผนงาน</h5>     </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                {{-- <a > --}}
                                                    <a href="{{ url('plan') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-clipboard font-size-25" style="color: rgb(248, 182, 182)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgba(174, 180, 177, 0.781)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('article/article_index') }}" target="_blank"> <h5 class="text-start mb-2">ทรัพย์สิน</h5>    </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('article/article_index') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-building-shield font-size-25" style="color: rgba(131, 150, 140, 0.692)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(255, 222, 161)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('supplies/supplies_index') }}" target="_blank">  <h5 class="text-start mb-2">พัสดุ</h5>    </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('supplies/supplies_index') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                 <i class="fa-solid fa-3x fa-paste font-size-25 " style="color: rgb(252, 212, 138)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(171, 175, 173)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('computer/com_staff_calenda') }}" target="_blank"><h5 class="text-start mb-2">คอมพิวเตอร์</h5>    </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('computer/com_staff_calenda') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-computer font-size-25" style="color: rgb(143, 145, 144)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(170, 167, 250)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('medical/med_calenda') }}" target="_blank"> <h6 class="text-start mb-2">เครื่องมือแพทย์</h6>        </a>
                                            </div>
                                            <div class="avatar">
                                                <a href="{{ url('medical/med_calenda') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                 <i class="fa-solid fa-3x fa-notes-medical font-size-25" style="color: rgb(137, 134, 236)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(190, 223, 248)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('repaire_narmal') }}" target="_blank"> <h5 class="text-start mb-2">ซ่อมบำรุง</h5>      </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('repaire_narmal') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-screwdriver-wrench font-size-25" style="color: rgb(140, 189, 226)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(145, 220, 231)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('warehouse/warehouse_index') }}" target="_blank"> <h5 class="text-start mb-2">คลังวัสดุ</h5>   </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('warehouse/warehouse_index') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-warehouse font-size-25" style="color: rgb(107, 189, 202)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(209, 178, 250)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('meetting/meettingroom_dashboard') }}" target="_blank"> <h5 class="text-start mb-2">ห้องประชุม</h5>      </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('meetting/meettingroom_dashboard') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                 <i class="fa-solid fa-3x fa-house-laptop font-size-25" style="color: rgb(184, 147, 226)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(141, 185, 218)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('housing/housing_dashboard') }}" target="_blank"> <h5 class="text-start mb-2">บ้านพัก</h5>    </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('housing/housing_dashboard') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-house-chimney-user font-size-25" style="color: rgb(103, 153, 192)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">คลังยา</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('') }}" target="_blank">
                                                    <span class="avatar-title bg-white text-primary rounded-3">
                                                        <p style="font-size: 10px;">
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                <i class="fa-solid fa-3x fa-prescription font-size-25 mt-3" style="color: rgb(63, 128, 128)"></i>
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
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">จ่ายกลาง</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('') }}" target="_blank">
                                                    <span class="avatar-title bg-white text-primary rounded-3">
                                                        <p style="font-size: 10px;">
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                <i class="fa-solid fa-3x fa-person-booth font-size-25 mt-3" style="color: rgb(187, 115, 115)"></i>
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
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(247, 198, 176)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('pkclaim_info') }}" target="_blank"> <h5 class="text-start mb-2">งานประกัน</h5>     </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('pkclaim_info') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                 <i class="fa-solid fa-3x fa-sack-dollar font-size-25" style="color: rgb(245, 180, 150)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(252, 177, 210)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('account_info') }}" target="_blank"> <h5 class="text-start mb-2">การเงิน</h5>      </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('account_info') }}" target="_blank"> 
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-money-check-dollar font-size-25" style="color: rgb(223, 136, 173)"></i>
                                                            </button> 
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgba(237, 199, 247, 0.781)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('account_pk_dash') }}" target="_blank"> <h5 class="text-start mb-2">การบัญชี</h5>    </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('account_pk_dash') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-file-invoice-dollar font-size-25 mt-3" style="color: rgb(237, 199, 247, 0.781)"></i>
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgba(247, 242, 173, 0.781)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('p4p') }}" target="_blank"> <h5 class="text-start">P4P</h5>   </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('p4p') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <span class="avatar-title bg-white rounded-3 mt-2" style="height: 10px"> --}}
                                                        {{-- <p > --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill" >
                                                                <i class="fa-solid fa-p fa-3x text-danger font-size-25"></i>
                                                                {{-- <i class="fa-solid fa-4 text-warning font-size-20"></i> --}}
                                                                {{-- <i class="fa-solid fa-p text-info font-size-20"></i> --}}
                                                            </button>
                                                        {{-- </p> --}}
                                                    {{-- </span> --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgba(210, 211, 210, 0.781)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('medicine_salt') }}" target="_blank"> <h5 class="text-start mb-2">แพทย์แผนไทย</h5>   </a>
                                            </div>
                                            <div class="avatar">
                                                <a href="{{ url('medicine_salt') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                 <i class="fa-solid fa-3x fa-square-person-confined font-size-25 " style="color: rgb(210, 211, 210, 0.781)"></i>
                                                            </button>
                                                        {{-- </p> --}}
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
            {{-- <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">ระบบลงเวลา</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('time_dashboard') }}" target="_blank">
                                                    <span class="avatar-title bg-white text-danger rounded-3">
                                                        <p style="font-size: 10px;">
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">

                                                                <i class="fa-regular fa-3x fa-clock font-size-25 mt-3" style="color: rgb(119, 218, 215)"></i>
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
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">โอที</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('otone') }}" target="_blank">
                                                    <span class="avatar-title bg-white text-primary rounded-3">
                                                        <p style="font-size: 10px;">
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                <i class="fa-solid fa-3x fa-people-line font-size-25 mt-3" style="color: rgb(131, 105, 192)"></i>
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
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(93, 218, 114)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('env_dashboard') }}" target="_blank"><h5 class="text-start mb-2">ENV</h5>   </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('env_dashboard') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-hand-holding-droplet font-size-25" style="color: rgb(90, 197, 215)"></i>
                                                            </button>
                                                        {{-- </p> --}}
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
            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(243, 212, 155)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('dental') }}" target="_blank"> <h5 class="text-start mb-2">DENTAL</h5>   </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('dental') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-3"> --}}
                                                        {{-- <p style="font-size: 10px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-tooth font-size-25" style="color: rgb(241, 188, 90)"></i>
                                                            </button>
                                                        {{-- </p> --}}
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

            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(125, 148, 252)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('audiovisual_admin') }}" target="_blank"><h5 class="text-start mb-2">งานโสต</h5>   </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('audiovisual_admin') }}" target="_blank">
                                                    {{-- <span class="avatar-title bg-white text-primary rounded-pill"> --}}
                                                        {{-- <p style="font-size: 15px;"> --}}
                                                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                                <i class="fa-solid fa-3x fa-camera-retro font-size-25" style="color: rgb(123, 146, 250)"></i>
                                                            </button> 
                                                        {{-- </p> --}}
                                                    {{-- </span>  --}}
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="col-xl-2 col-md-2">
                <div class="main-card mb-3 card shadow-lg rounded-pill" style="background-color: rgb(245, 116, 165)">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover rounded-pill">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-12 mb-2">PK-OFFICER</p>
                                                <a href="{{ url('prenatal_care') }}" target="_blank"><h5 class="text-start mb-2">Prenatal care</h5>   </a>
                                            </div>
                                            <div class="avatar ms-2">
                                                <a href="{{ url('prenatal_care') }}" target="_blank"> 
                                                        <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">
                                                            <i class="fa-solid fa-3x fa-person-breastfeeding font-size-25" style="color: rgb(245, 116, 165)"></i>
                                                        </button>  
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            {{-- <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start font-size-13 mb-2">PK-OFFICER</p>
                                                <h5 class="text-start mb-2">แพทย์แผนไทย</h5>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('medicine_salt') }}" target="_blank">
                                                    <span class="avatar-title bg-white text-primary rounded-3">
                                                        <p style="font-size: 10px;">
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-3">
                                                                 <i class="fa-solid fa-3x fa-square-person-confined font-size-25 mt-3" style="color: rgb(159, 9, 197)"></i>
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
            </div>               --}}

        </div>


    </div>


    <?php
    $datadetail = DB::connection('mysql')->select('
                                select * from orginfo
                                where orginfo_id = 1
                                 ');
    ?>

  @endsection
