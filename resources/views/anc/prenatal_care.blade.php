@extends('layouts.anc')
@section('title', 'PK-OFFICER || ANC')
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
        $tel_ = Auth::user()->tel;
        $debsubsub = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 544;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SoteController;
    $refnumber = SoteController::refnumber();
    ?>
    <style>
        body {
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }

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
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
        <form action="{{ url('prenatal_care') }}" method="GET">
            @csrf
            <div class="row ">
                <div class="col-md-3">
                    <h4 class="card-title">รายละเอียดข้อมูล ปี 
                        @if ($dabyear =='')
                            {{$y }}
                        @else
                        {{$dabyear}}
                        @endif
                        
                    </h4>
                    {{-- <p class="card-title-desc">รายละเอียดข้อมูล </p> --}}
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-2 text-end">
                    <select name="dabyear" id="dabyear" class="form-control" style="width: 100%">
                        @foreach ($dabyears as $item)
                        @if ($dabyear == '')
                            @if ($y == $item->leave_year_id)
                                <option value="{{ $item->leave_year_id }}" selected>{{ $item->leave_year_id }}</option>
                            @else
                                <option value="{{ $item->leave_year_id }}">{{ $item->leave_year_id }}</option>
                            @endif
                        @else
                            @if ($dabyear == $item->leave_year_id)
                                <option value="{{ $item->leave_year_id }}" selected>{{ $item->leave_year_id }}</option>
                            @else
                                <option value="{{ $item->leave_year_id }}">{{ $item->leave_year_id }}</option>
                            @endif
                        @endif
                            
                        @endforeach

                    </select>
                    {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>  
                    </div>  --}}
                </div>
                <div class="col-md-1 text-start">
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                </div>
            </div>
        </form>
        {{-- <div class="row mt-2">
            <div class="col-md-12">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2"> Report Month ปี พ.ศ.{{ $y }}</h6>
                    <div style="height:auto;width: auto;" class="p-2">
                        <canvas id="Mychart" class="p-2"></canvas>
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">คนไข้ที่มารับบริการ OPD ยกเว้นแผนก
                            011,036,107 และยกเว้นสิทธิ์ M1-M6,13,23,91,X7</h6>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="main-card card p-2">
                   
                        <table id="example" class="table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">Doctor</th>
                                    <th class="text-center">จำนวนผู้ป่วย</th>
                                    <th class="text-center">adjrw</th>
                                    <th class="text-center">cmi</th>
                                    <th class="text-center">adjrw = 0</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($data_anc as $item)
                                    <?php $number++; ?> 
                                    <tr id="#sid{{ $item->ward }}">
                                            <td class="text-center text-muted">{{ $number }}</td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left me-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="text-start" style="font-size: 13px">
                                                                
                                                                @if ($dabyear == '')
                                                                <a href="{{url('prenatal_care_doctor/'.$item->incharge_doctor.'/'.$y)}}">{{ $item->doctor }}</a>
                                                                @else
                                                                <a href="{{url('prenatal_care_doctor/'.$item->incharge_doctor.'/'.$dabyear)}}">{{ $item->doctor }}</a>
                                                                @endif
                                                            </div> 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_an }}</td>
                                            <td class="text-start" style="font-size: 13px">
                                                <div>{{ $item->sum_adjrw }}</div>
                                            </td>
                                            <td class="text-start" style="width: 150px;font-size: 13px">
                                                <div class="pie-sparkline">{{ $item->total_cmi }}</div>
                                            </td>
                                            <td class="text-start" style="font-size: 13px">
                                                <div >{{ $item->total_noadjre }}</div> 
                                            </td>
                                    </tr>

                                @endforeach
                                

                            </tbody>
                        </table>
                   {{-- {{$dabyear}} --}}
                </div>
            </div>
        </div>


    </div>

@endsection
@section('footer')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('select').select2();
            // dabyear

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // var xmlhttp = new XMLHttpRequest();
            // var url = "{{ route('claim.check_line') }}";
            // xmlhttp.open("GET", url, true);
            // xmlhttp.send();
            // xmlhttp.onreadystatechange = function() {
            //     if (this.readyState == 4 && this.status == 200) {
            //         var datas = JSON.parse(this.responseText);
            //         console.log(datas);
            //         Authen = datas.Dataset1.map(function(e) {
            //             return e.Authen;
            //         });

            //         count = datas.Dataset1.map(function(e) {
            //             return e.count;
            //         });
            //         Noauthen = datas.Dataset1.map(function(e) {
            //             return e.Noauthen;
            //         });
            //          // setup 
            //         const data = {
            //             labels: ["ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"] ,
            //             // labels: [0] ,
            //             datasets: [                        
            //                 {
            //                     label: ['คนไข้ที่มารับบริการ OPD'],
            //                     // data: [0],
            //                     data: count,
            //                     fill: false,
            //                     borderColor: 'rgba(255, 205, 86)',
            //                     lineTension: 0.4

            //                 },
            //                 {
            //                     label: ['ขอ Authen Code'],
            //                     // data: [0],
            //                     data: Authen,
            //                     fill: false,
            //                     borderColor: 'rgba(75, 192, 192)',
            //                     lineTension: 0.4

            //                 },
            //                 {
            //                     label: ['ไม่ Authen Code'],
            //                     // data: [0],
            //                     data: Noauthen,
            //                     fill: false,
            //                     borderColor: 'rgba(255, 99, 132)',
            //                     lineTension: 0.4

            //                 }, 

            //             ]
            //         };

            //         const config = {
            //             type: 'line',
            //             data:data,
            //             options: { 
            //                 scales: { 
            //                     y: {
            //                         beginAtZero: true 
            //                     }
            //                 } 
            //             },                        
            //             plugins:[ChartDataLabels],

            //         };

            //         // render init block
            //         const myChart = new Chart(
            //             document.getElementById('myChartNew'),
            //             config
            //         );

            //     }
            //  }
            var ctx = document.getElementById("Mychart").getContext("2d");

            fetch("{{ route('anc.prenatal_care_bar') }}")
                .then(response => response.json())
                .then(json => {
                    const Mychart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: json.labels,
                            datasets: json.datasets,

                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins: [ChartDataLabels],
                    })
                });



        });
    </script>

@endsection
