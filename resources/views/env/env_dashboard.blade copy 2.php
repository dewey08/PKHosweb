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
            border-top: 10px rgb(11, 170, 165) solid;
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
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    
    //********************* */ แสดงผล  ***********************************
    
    ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="block-header block-header-default">
                    <h4 class="text-center mb-sm-0">ข้อมูลสิ่งแวดล้อมและความปลอดภัย</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                    {{-- <div id="myChart"> </div> --}}
                                    {{-- <canvas id="myChart" height="500px" width="1000px"></canvas> --}}
                                    <div id="linechart" style="width: 900px; height: 500px; margin-left: 235px"></div>
                                </div>                                           
                            </div>  
                        </div>                                           
                    </div> 
                </div> 
            </div> 

        {{-- <div class="row mt-3">
            <div class="col-xl-12 col-md-3">
                <div class="main-card card" style="height: 150px">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12" style="background-color: rgb(165, 226, 255)">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="d-flex" style="background-color: rgb(165, 226, 255)">
                                        <div class="flex-grow-1">
                                            <p class="text-white mb-2"> ระบบบำบัดน้ำเสีย <br><span>(จำนวนนับรวมเช็ค 1
                                                    วัน)</span></p>
                                            <p class="text-white mb-0" style="font-size: 2.25rem;">
                                              
                                            </p>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <canvas id="myChart" height="500px" width="1000px"></canvas>
                </div>  
            </div> 
        </div> --}}

        {{-- <div class="row mt-3">
            <div class="col-xl-6 col-md-3">
                <div class="main-card card" style="height: 150px">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12" style="background-color: rgb(165, 226, 255)">
                                <div class="widget-chart widget-chart-hover" style="background-color: rgb(165, 226, 255)">
                                    <div class="d-flex">
                                        อัตราส่วนน้ำบ่อบำบัด
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-3">
                <div class="main-card card" style="height: 150px">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12" style="background-color: rgb(145, 228, 163)">
                                <div class="widget-chart widget-chart-hover" style="background-color: rgb(145, 228, 163)">
                                    <div class="d-flex">
                                        อัตราส่วนประเภทขยะ
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}

    </div>
    </div>


@endsection
@section('footer')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<script>
     <script type="text/javascript">
        var phone_count_18 = <?php echo $phone_count_18; ?>;
        var phone_count_19 = <?php echo $phone_count_19; ?>;
        var phone_count_20 = <?php echo $phone_count_20; ?>;

        var laptop_count_18 = <?php echo $laptop_count_18; ?>;
        var laptop_count_19 = <?php echo $laptop_count_19; ?>;
        var laptop_count_20 = <?php echo $laptop_count_20; ?>;

        var tablet_count_18 = <?php echo $tablet_count_18; ?>;
        var tablet_count_19 = <?php echo $tablet_count_19; ?>;
        var tablet_count_20 = <?php echo $tablet_count_20; ?>;

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
             var data = google.visualization.arrayToDataTable([
          ['Year', 'Phone', 'Laptop', 'Tablet'],
          ['2018',  phone_count_18, laptop_count_18, tablet_count_18],
          ['2019',  phone_count_19, laptop_count_19, tablet_count_19],
          ['2020',  phone_count_20, laptop_count_20, tablet_count_20]
        ]);
            var options = {                
                curveType: 'function',
                legend: { position: 'bottom' }
            };
            var chart = new google.visualization.BarChart(document.getElementById('barchart'));
            chart.draw(data, options);
        }
    </script>
 
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            var labels = {{ Js::from($labels) }};
            var users = {{ Js::from($data) }};

            const data = {
                labels: labels,
                datasets: [{
                    label: 'My First dataset',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: users,
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
 


        });

        <script type="text/javascript">
        var phone_count_18 = <?php echo $phone_count_18; ?>;
        var phone_count_19 = <?php echo $phone_count_19; ?>;
        var phone_count_20 = <?php echo $phone_count_20; ?>;

        var laptop_count_18 = <?php echo $laptop_count_18; ?>;
        var laptop_count_19 = <?php echo $laptop_count_19; ?>;
        var laptop_count_20 = <?php echo $laptop_count_20; ?>;

        var tablet_count_18 = <?php echo $tablet_count_18; ?>;
        var tablet_count_19 = <?php echo $tablet_count_19; ?>;
        var tablet_count_20 = <?php echo $tablet_count_20; ?>;

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
             var data = google.visualization.arrayToDataTable([
          ['Year', 'Phone', 'Laptop', 'Tablet'],
          ['2018',  phone_count_18, laptop_count_18, tablet_count_18],
          ['2019',  phone_count_19, laptop_count_19, tablet_count_19],
          ['2020',  phone_count_20, laptop_count_20, tablet_count_20]
        ]);
            var options = {                
                curveType: 'function',
                legend: { position: 'bottom' }
            };
            var chart = new google.visualization.BarChart(document.getElementById('barchart'));
            chart.draw(data, options);
        }
    </script>
 
    </script>
@endsection
