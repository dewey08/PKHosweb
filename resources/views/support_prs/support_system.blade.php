@extends('layouts.support_prs')
@section('title', 'PK-OFFICER || Support-System')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
        {{-- <form action="{{ route('tec.techservice') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title">Detail Tecnical Service</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Service</p>
                </div>
                <div class="col"></div>
                  
                <div class="col-md-5 text-start">

                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control inputacc" name="startdate" id="datepicker"
                            placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker"
                            data-date-autoclose="true" autocomplete="off" data-date-language="th-th"
                            value="{{ $startdate }}" required />
                        <input type="text" class="form-control inputacc" name="enddate" placeholder="End Date"
                            id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker"
                            data-date-autoclose="true" autocomplete="off" data-date-language="th-th"
                            value="{{ $enddate }}" required />
                        <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardacc"
                            data-style="expand-left">
                            <span class="ladda-label"> <i
                                    class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>

                </div>
            </div>
        </form> --}}
        <div class="row"> 
            <div class="col-xl-4 col-md-12">
                <div class="card cardacc" style="background-color: rgb(246, 235, 247)">


                </div>
            </div> 
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
