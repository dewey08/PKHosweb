@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
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
            border-top: 10px #1fdab1 solid;
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
    </style>
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>

    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
        <form action="{{ route('env.env_water_rep') }}" method="GET">
            @csrf
        <div class="row mb-2">
            <div class="col"></div>
            <div class="col-md-2">
                <select name="pond_id" id="pond_id" class="form-control" style="width: 100%" required>
                    <option value="">-Choose-</option>
                    @foreach ($env_pond as $item_po)
                    @if ($pond_id == $item_po->pond_id)
                    <option value="{{$item_po->pond_id}}" selected>{{$item_po->pond_name}}</option>
                    @else
                    <option value="{{$item_po->pond_id}}">{{$item_po->pond_name}}</option>
                    @endif
                        
                    @endforeach

                </select>
            </div>
            <div class="col-md-4">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                        autocomplete="off" data-date-language="th-th" value="{{ $startdate }}" required />
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                        autocomplete="off" data-date-language="th-th" value="{{ $enddate }}" required />
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                        ค้นหา
                    </button>
                </div> 
            </div>
            <div class="col"></div>
        </div>
    </form>

        <div class="main-card mb-2 card">
            <div class="card-header">
                รายงานคุณภาพน้ำทิ้ง

                <div class="btn-actions-pane-right">
                   
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p>
                        @if ($pond_id == '1') 
                            {{-- <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center"width="2%">ลำดับ</th>
                                        <th class="text-center"width="2%">วันที่บันทึก</th> 
                                        <th class="text-center"width="5%">PH</th>
                                        <th class="text-center"width="4%">DO</th> 

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow as $item)
                                        <?php
    
                                            $qty_ph_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "pH" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_ph_ as $key => $item_ph) { 
                                                    $qtyph = $item_ph->water_qty; 
                                                    $statusph = $item_ph->status_; 
                                            }
                                    
                                            $qty_do_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "DO" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_do_ as $key => $item_do) {
                                                $qtydo = $item_do->water_qty;
                                                $statusdo = $item_do->status_; 
                                            }

                                            
                                        ?>
                                            
                                        <tr>
                                            <td class="text-center">{{ $ia++ }}</td>
                                            <td class="text-center">{{ $item->water_date }}</td>
                                            <td class="text-center"> {{$qtyph}} /
                                                @if ($statusph =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statusph}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statusph}} </span>
                                                @endif
                                                 
                                                </td>
                                            <td class="text-center">  {{$qtydo}}  /
                                                @if ($statusdo =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statusdo}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statusdo}} </span>
                                                @endif
                                               
                                                </td> 
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @elseif($pond_id == '2') 
                            {{-- <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center"width="2%">ลำดับ</th>
                                        <th class="text-center"width="2%">วันที่บันทึก</th> 
                                        <th class="text-center"width="5%">PH</th>
                                        <th class="text-center"width="4%">DO</th>
                                        <th class="text-center"width="5%">SV30</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow as $item)
                                        <?php

                                            $qty_ph_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "pH" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_ph_ as $key => $item_ph2) { 
                                                    $qtyph2 = $item_ph2->water_qty; 
                                                    $statusph2 = $item_ph2->status_;
                                            }
                                    
                                            $qty_do_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "DO" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_do_ as $key => $item_do2) {
                                                $qtydo2 = $item_do2->water_qty;
                                                $statusdo2 = $item_do2->status_;
                                            }

                                            $qty_sv_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "SV30" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_sv_ as $key => $item_sv2) {
                                                $qtysv2 = $item_sv2->water_qty;
                                                $statussv2 = $item_sv2->status_;
                                            }
                                        ?>
                                            
                                        <tr>
                                            <td class="text-center">{{ $ia++ }}</td>
                                            <td class="text-center">{{ $item->water_date }}</td>
                                            <td class="text-center"> {{$qtyph2}} /
                                                @if ($statusph2 =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statusph2}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statusph2}} </span>
                                                @endif
                                            
                                            </td>
                                            <td class="text-center"> {{$qtydo2}} /
                                                @if ($statusdo2 =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statusdo2}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statusdo2}} </span>
                                                @endif
                                            </td>
                                            <td class="text-center"> {{$qtysv2}} /
                                                @if ($statussv2 =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statussv2}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statussv2}} </span>
                                                @endif
                                            
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            {{-- <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center"width="2%">ลำดับ</th>
                                        <th class="text-center"width="2%">วันที่บันทึก</th> 
                                        <th class="text-center"width="5%">PH</th>
                                        <th class="text-center"width="4%">DO</th>
                                        <th class="text-center"width="5%">SV30</th>
                                        <th class="text-center"width="5%">TDS</th>
                                        <th class="text-center"width="5%">CL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow as $item)
                                        <?php

                                            $qty_ph3_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "pH" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_ph3_ as $key => $item_ph3) { 
                                                    $qtyph3 = $item_ph3->water_qty; 
                                                    $statusph3 = $item_ph3->status_;
                                            }
                                    
                                            $qty_do3_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "DO" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_do3_ as $key => $item_do3) {
                                                $qtydo3 = $item_do3->water_qty;
                                                $statusdo3 = $item_do3->status_;
                                            }

                                            $qty_sv3_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "SV30" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_sv3_ as $key => $item_sv3) {
                                                $qtysv3 = $item_sv3->water_qty;
                                                $statussv3 = $item_sv3->status_;
                                            }

                                            $qty_tds_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "TDS" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_tds_ as $key => $item_td) {
                                                $qtytds = $item_td->water_qty;
                                                $statustd = $item_td->status_;
                                            }

                                            $qty_cl_ = DB::connection('mysql')->select('
                                                    SELECT es.water_qty,e.water_date,DAY(e.water_date) as days,es.status as status_
                                                    FROM env_water_sub es
                                                    LEFT OUTER JOIN env_water e ON e.water_id = es.water_id
                                                    WHERE es.water_parameter_short_name = "CL" 
                                                    AND e.water_date = "' .$item->water_date .'"
                                                    GROUP BY days'                                                
                                            );                                             
                                            foreach ($qty_cl_ as $key => $item_cl) {
                                                $qtycl = $item_cl->water_qty;
                                                $statuscl = $item_cl->status_;
                                            }
                                        ?>
                                            
                                        <tr>
                                            <td class="text-center">{{ $ia++ }}</td>
                                            <td class="text-center">{{ $item->water_date }}</td>
                                            <td class="text-center"> {{$qtyph3}} /
                                                @if ($statusph3 =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statusph3}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statusph3}} </span>
                                                @endif
                                            </td>
                                            <td class="text-center"> {{$qtydo3}} /
                                                @if ($statusdo3 =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statusdo3}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statusdo3}} </span>
                                                @endif
                                            </td>
                                            <td class="text-center"> {{$qtysv3}} /
                                                @if ($statussv3 =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statussv3}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statussv3}} </span>
                                                @endif
                                            </td>
                                            <td class="text-center"> {{$qtytds}} /
                                                @if ($statustd =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statustd}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statustd}} </span>
                                                @endif
                                            </td>
                                            <td class="text-center"> {{$qtycl}} /
                                                @if ($statuscl =='ปกติ')
                                                    <span class="badge bg-success rounded-pill">{{$statuscl}} </span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill">{{$statuscl}} </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endif
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>


@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            // $("#overlay").fadeIn(300);　
            $('#pond_id').select2({
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


            $("#spinner-div").hide(); //Request is complete so hide spinner

        });
    </script>

@endsection
