@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
 
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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
    ?>
     
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
            border-top: 10px #ff8897 solid;
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
    <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div> 
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div>
       
        <div class="row"> 
            @foreach ($datashow as $item)   
            <div class="col-xl-3 col-md-3">
                @if ($item->hospcode == '10978')
                    <div class="card cardacc" style="background-color: rgb(243, 203, 253)"> 
                @else
                    <div class="card cardacc" style="background-color: rgb(235, 247, 243)"> 
                @endif
               
 
                
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="d-flex text-start">
                                        <div class="flex-grow-1 ">
                                            
                                            <div class="row">
                                                <div class="col-md-3 text-start mt-4 ms-4">
                                                    <h5 >{{$item->hospcode}}</h5>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-7 text-end mt-2 me-2"> 
                                                        <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                            <h6 class="text-end">{{$item->hname}}</h6>
                                                        </div> 
                                                </div>
                                            </div>
                                         
                                            <div class="row">
                                                <div class="col-md-1 text-start mt-2 ms-4">
                                                    <i class="fa-brands fa-bitcoin align-middle text-danger"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-2">
                                                    <p class="text-muted mb-0" >
                                                        ตั้งลูกหนี้
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    {{-- <a href="{{url('account_203_hcode_detail/'.$item->months.'/'.$item->years.'/'.$item->hospcode)}}" target="_blank"> --}}
                                                    <a href="{{url('account_203_hcode_group/'.$item->months.'/'.$item->years.'/'.$item->hospcode)}}" target="_blank">                                                      
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$item->Cvn}} Visit">
                                                                {{ number_format($item->S_debit_total, 2) }}
                                                                    <i class="fa-brands fa-btc text-danger ms-2 me-2"></i>
                                                            </p>                                                    
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start mt-2 ms-4">
                                                    <i class="fa-brands fa-bitcoin me-2 align-middle text-success"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-2">
                                                    <p class="text-muted mb-0">
                                                            Statement
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    {{-- <a href="{{url('account_203_stm/'.$item->months.'/'.$item->year)}}" target="_blank"> --}}                                                       
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement 10Visit">
                                                                ยังเฮดบ่อแร้วว 
                                                                    <i class="fa-brands fa-btc text-success ms-2 me-2"></i>
                                                            </p>                                                      
                                                    {{-- </a> --}}
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-1 text-start mt-2 ms-4">
                                                    <i class="fa-brands fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-2">
                                                    <p class="text-muted mb-0">
                                                            ยกยอดไปเดือนนี้
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    {{-- <a href="" target="_blank"> --}}                                                       
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement 33 Visit">                                                                
                                                           ยังเฮดบ่อแร้วว                                                                
                                                                    <i class="fa-brands fa-btc ms-2 me-2" style="color: rgb(160, 12, 98)"></i>
                                                            </p>                                                     
                                                    {{-- </a> --}}
                                                </div>
                                            </div>
    

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                   
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
