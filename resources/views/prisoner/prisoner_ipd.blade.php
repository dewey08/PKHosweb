@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Prisoner')

@section('content')
    
    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

   <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
        <form action="{{ route('prisoner.prisoner_ipd') }}" method="GET">
            @csrf
            <div class="row"> 
                <div class="col-md-4">
                    <h4 class="card-title">Detail Prisoner</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูลนักโทษที่มารักษา IPD บ้านเลขที่ 438</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-3 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            data-date-language="th-th" value="{{ $enddate }}" required/>  
                    </div> 
                </div>
                <div class="col-md-1 text-start">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                    </button>
                </div>
            </div>
        </form>  
        <div class="row "> 
            @foreach ($datashow as $item)   
            <div class="col-xl-3 col-md-6">
                <div class="main-card mb-3 card">   
                    @if ($startdate == '')
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                        <a href="{{url('prisoner_ipd_detail/'.$item->months.'/'.$newyear.'/'.$date)}}" target="_blank"> 
                                            <div class="d-flex text-start">
                                                <div class="flex-grow-1 ">
                                                    <?php 
                                                        $y = $item->year; 
                                                        $ynew = $y +543;
                                                    ?>                                            
                                                    <p class="text-truncate font-size-14 mb-2">เดือน {{$item->MONTH_NAME}} {{$ynew}}</p>
                                                    <h4 class="mb-2">{{$item->an}} Visit</h4> 
                                                    <p class="text-muted mb-0"><span class="text-info fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ number_format($item->income, 2) }}</span>บาท</p>
                                                    {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="fa-solid fa-hand-holding-dollar me-1 align-middle"></i>{{ number_format($item->AMOUNTPAY, 2) }}</span>บาท</p> --}}
                                                </div>                                      
                                            
                                                <div class="avatar-sm me-2 me-2" style="height: 120px"> 
                                                    <span class="avatar-title bg-light mt-3" style="height: 70px">
                                                    
                                                        <p style="font-size: 10px;">
                                                            <button type="button" style="height: 100px;width: 100px"
                                                                class="mt-5 mb-3 me-4 btn-icon btn-shadow btn-dashed btn btn-outline-warning avatar-title bg-light text-primary rounded-3">                                                            
                                                                <i class="fa-solid fa-3x fa-building-user text-info"></i>
                                                                <br><br>
                                                                Detail
                                                            </button>
                                                        </p>
                                                    </span>
                                            
                                            </div>
                                            </div>  
                                        </a>
                                    </div> 
                                </div> 
                            </div>                                           
                        </div> 
                    @else
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                        <a href="{{url('prisoner_ipd_detail/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank"> 
                                            <div class="d-flex text-start">
                                                <div class="flex-grow-1 ">
                                                    <?php 
                                                        $y = $item->year; 
                                                        $ynew = $y +543;
                                                    ?>                                            
                                                    <p class="text-truncate font-size-14 mb-2">เดือน {{$item->MONTH_NAME}} {{$ynew}}</p>
                                                    <h4 class="mb-2">{{$item->an}} Visit</h4> 
                                                    <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ number_format($item->income, 2) }}</span>บาท</p>
                                                    {{-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="fa-solid fa-hand-holding-dollar me-1 align-middle"></i>{{ number_format($item->AMOUNTPAY, 2) }}</span>บาท</p> --}}
                                                </div>                                      
                                            
                                                <div class="avatar-sm me-2 me-2" style="height: 120px"> 
                                                    <span class="avatar-title bg-light mt-3" style="height: 70px">
                                                    
                                                        <p style="font-size: 10px;">
                                                            <button type="button" style="height: 100px;width: 100px"
                                                                class="mt-5 mb-3 me-4 btn-icon btn-shadow btn-dashed btn btn-outline-danger avatar-title bg-light text-primary rounded-3">                                                            
                                                                <i class="fa-solid fa-3x fa-building-user text-info"></i>
                                                                <br><br>
                                                                Detail
                                                            </button>
                                                        </p>
                                                    </span>
                                            
                                            </div>
                                            </div>  
                                        </a>
                                    </div> 
                                </div> 
                            </div>                                           
                        </div> 
                    @endif                 
                       
                   
                </div> 
            </div> 
            @endforeach
        </div>

    </div>

@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
