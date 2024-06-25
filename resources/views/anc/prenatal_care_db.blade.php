@extends('layouts.anc')
@section('title', 'PK-OFFICER || ทาลัสซีเมีย')
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
        

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="main-card card p-2">
                    
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
