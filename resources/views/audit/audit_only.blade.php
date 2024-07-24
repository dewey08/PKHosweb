@extends('layouts.audit_nodata')
@section('title', 'PK-OFFICER || Audit Nodata')
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
            border: 10px #ddd solid;
            border-top: 10px #0dc79f solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
            }
        }

        .is-hide {
            display: none;
        }

        .modal-dis {
            width: 1350px;
            margin: auto;
        }

        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%;
            }
        }
    </style>

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

        <form action="{{ route('env.env_water') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <h4 style="color:rgb(250, 128, 124)">Detail Pre-Audit OFC</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Pre-Audit OFC</p>
                </div>
                <div class="col"></div> 
                <div class="col-md-4">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                        data-date-autoclose="true" data-provide="datepicker"
                                        data-date-container='#datepicker1'>
                                        <input type="text" class="form-control card_audit_4" name="startdate"
                                            id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $startdate }}" required />
                                        <input type="text" class="form-control card_audit_4" name="enddate"
                                            placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $enddate }}" />

                                        {{-- <button type="button"
                                            class="ladda-button me-2 btn-pill btn btn-primary cardacc Process_A"
                                            data-url="{{ url('pre_audit_process_a') }}">
                                            <i class="fa-solid fa-sack-dolla"></i>
                                            ประมวลผลใหม่
                                        </button> --}}
                                        <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardacc">
                                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                                            ค้นหา
                                        </button> 
                                    </div>
                </div>
            </div>
        </form> 

            <div class="row">
                <div class="col-xl-6">
                    <div class="card card_audit_4">
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col-md-3">
                                    <h4 class="card-title" style="color:rgb(241, 137, 155)"">APPROVE OFC</h4>
                                </div>
                                <div class="col-md-9 text-end">
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                        data-date-autoclose="true" data-provide="datepicker"
                                        data-date-container='#datepicker1'>
                                        <input type="text" class="form-control card_audit_4" name="startdate"
                                            id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $startdate }}" required />
                                        <input type="text" class="form-control card_audit_4" name="enddate"
                                            placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $enddate }}" />

                                        <button type="button"
                                            class="ladda-button me-2 btn-pill btn btn-primary cardacc Process_A"
                                            data-url="{{ url('pre_audit_process_a') }}">
                                            <i class="fa-solid fa-sack-dolla"></i>
                                            ประมวลผลใหม่
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row mt-2">
                                <div class="col-md-12"> 
                                    <div class="table-responsive">
                                        <table id="example5"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">Year</th>
                                                    <th class="text-center">Month</th>
                                                    <th class="text-center">Visit ทั้งหมด</th>
                                                    <th class="text-center">Debit-Approve</th>
                                                    <th class="text-center">Debit-ไม่ Approve</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $jj = 1; ?>
                                                @foreach ($fdh_ofc as $item)
                                                
                                                    <tr>
                                                        <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                        <td class="text-center" width="10%">{{ $item->years }}</td> 
                                                        
                                                        <td class="text-center" width="15%">ธันวาคม</td> 
                                                    
                                                        <td class="text-center text-primary" width="15%"> 11111</td>
                                                        <td class="text-center" width="15%" style="color:rgb(23, 121, 233)">22222</td> 
                                                         <td>33333</td>
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
            
    </div>


@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 100,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            var table = $('#example2').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            var table = $('#example3').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            }); 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#spinner-div").hide(); //Request is complete so hide spinner
 
        });
    </script>
@endsection
