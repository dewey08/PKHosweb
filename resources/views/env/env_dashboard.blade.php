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
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        {{-- <div class="tabs-animation"> 
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div> 
            </div> --}}

        <div class="row ">
            <div class="col-12">
                <div class="block-header block-header-default">
                    <h4 class="text-center mb-sm-0">ข้อมูลสิ่งแวดล้อมและความปลอดภัย</h4>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-8 col-md-8">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">

                        <div class="row p-5">
                            <div class="col-sm-12">
                                <h2 style="margin:10px 0px 0px 0px;text-align: center;">ระบบบ่อบำบัดน้ำเสีย</h2>
                                <div id="barchart_material" style="width: auto; height: 660px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="row p-5">
                            <div class="col-sm-12">
                                <h2 style="margin:10px 0px 0px 0px;text-align: center;">ระบบบ่อบำบัดน้ำเสีย</h2>
                                <div id="piechart_3d" style="width: auto; height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="row p-5">
                            <div class="col-sm-12">
                                <h2 style="margin:10px 0px 0px 0px;text-align: center;">ระบบบ่อบำบัดน้ำเสีย</h2>
                                <div id="piechart_3ds" style="width: auto; height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-xl-12 col-md-8">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">

                        <div class="row p-5">
                            <div class="col-sm-12">
                                <h2 style="margin:10px 0px 0px 0px;text-align: center;">ระบบบริหารจัดการขยะ</h2>
                                <div id="chart_div" style="width: auto; height: 660px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer')
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script> --}}



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'บ่อปรับเสถียร', 'บ่อคลองวนเวียน', 'บ่อสัมผัสคลอลีน'],
                ['2021', <?php echo $e1_count_21; ?>, <?php echo $e2_count_21; ?>, <?php echo $e3_count_21; ?>],
                ['2022', <?php echo $e1_count_22; ?>, <?php echo $e2_count_22; ?>, <?php echo $e3_count_22; ?>],
                ['2023', <?php echo $e1_count_23; ?>, <?php echo $e2_count_23; ?>, <?php echo $e3_count_23; ?>],
                ['2024', <?php echo $e1_count_24; ?>, <?php echo $e2_count_24; ?>, <?php echo $e3_count_24; ?>]
            ]);

            var options = {
                chart: {
                    title: 'การลงข้อมูลวิเคราะห์คุณภาพน้ำ',
                    subtitle: 'ช่วงปี คศ.: 2021-2024',
                },
                bars: 'horizontal' // Required for Material Bar Charts.
            };

            var chart = new google.charts.Bar(document.getElementById('barchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'ปกติ'],
                ['BOD', <?php echo $w7_1; ?>],
                ['COD', <?php echo $w7_2; ?>],
                ['TDS', <?php echo $w7_3; ?>],
                ['SS', <?php echo $w7_4; ?>],
                ['Settleable ', <?php echo $w7_5; ?>],
                ['TKN ', <?php echo $w7_6; ?>],
                ['pH ', <?php echo $w7_7; ?>],
                ['Sulfide ', <?php echo $w7_8; ?>],
                ['Oil and Grease ', <?php echo $w7_9; ?>],
                ['โคลิฟอร์มแบคทีเรีย ', <?php echo $w7_10; ?>],
                ['ฟิคัลโคลิฟอร์มแบคทีเรีย ', <?php echo $w7_11; ?>],
                ['ไข่หนอนพยาธิ ', <?php echo $w7_12; ?>],
                ['E. coli ', <?php echo $w7_13; ?>],
                ['DO ', <?php echo $w7_14; ?>],
                ['SV30 ', <?php echo $w7_15; ?>],
                ['cl ', <?php echo $w7_16; ?>]
            ]);

            var options = {
                title: 'แยกตามรายการพารามิเตอร์ ปกติ',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'ผิดปกติ'],
                ['BOD', <?php echo $wm7_1; ?>],
                ['COD', <?php echo $wm7_2; ?>],
                ['TDS', <?php echo $wm7_3; ?>],
                ['SS', <?php echo $wm7_4; ?>],
                ['Settleable ', <?php echo $wm7_5; ?>],
                ['TKN ', <?php echo $wm7_6; ?>],
                ['pH ', <?php echo $wm7_7; ?>],
                ['Sulfide ', <?php echo $wm7_8; ?>],
                ['Oil and Grease ', <?php echo $wm7_9; ?>],
                ['โคลิฟอร์มแบคทีเรีย ', <?php echo $wm7_10; ?>],
                ['ฟิคัลโคลิฟอร์มแบคทีเรีย ', <?php echo $wm7_11; ?>],
                ['ไข่หนอนพยาธิ ', <?php echo $wm7_12; ?>],
                ['E. coli ', <?php echo $wm7_13; ?>],
                ['DO ', <?php echo $wm7_14; ?>],
                ['SV30 ', <?php echo $wm7_15; ?>],
                ['cl ', <?php echo $wm7_16; ?>]
            ]);

            var options = {
                title: 'แยกตามรายการพารามิเตอร์ ผิดปกติ',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3ds'));
            chart.draw(data, options);
        }
    </script>
    <html>
 
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Month', 'ขยะทั่วไป(Kg)', 'ขยะติดเชื้อ(Kg)', 'ขยะเคมีบำบัด(Kg)'],
          ['มกราคม',   <?php echo $tra_1; ?>,<?php echo $tra_21; ?>,<?php echo $tra_31; ?>],
          ['กุมภาพัน',  <?php echo $tra_2; ?>,<?php echo $tra_22; ?>,<?php echo $tra_32; ?>],
          ['มีนาคม',   <?php echo $tra_3; ?>,<?php echo $tra_23; ?>,<?php echo $tra_33; ?>],
          ['เมษายน',  <?php echo $tra_4; ?>,<?php echo $tra_24; ?>,<?php echo $tra_34; ?>],
          ['พฤษภาคม', <?php echo $tra_5; ?>,<?php echo $tra_25; ?>,<?php echo $tra_35; ?>],
          ['มิถุนายน',   <?php echo $tra_6; ?>,<?php echo $tra_26; ?>,<?php echo $tra_36; ?>],
          ['กรกฎาคม',  <?php echo $tra_7; ?>,<?php echo $tra_27; ?>,<?php echo $tra_37; ?>],
          ['สิงหาคม',   <?php echo $tra_8; ?>,<?php echo $tra_28; ?>,<?php echo $tra_38; ?>],
          ['กันยายน',   <?php echo $tra_9; ?>,<?php echo $tra_29; ?>,<?php echo $tra_39; ?>],
          ['ตุลาคม',    <?php echo $tra_10; ?>,<?php echo $tra_210; ?>,<?php echo $tra_310; ?>],
          ['พฤษจิกายน', <?php echo $tra_11; ?>,<?php echo $tra_211; ?>,<?php echo $tra_311; ?>],
          ['ธันวาคม',   <?php echo $tra_12; ?>,<?php echo $tra_212; ?>,<?php echo $tra_312; ?>],
        ]);


        var options = {
          title : 'การลงข้อมูลในระบบบริหารขยะ',
          vAxis: {title: 'KG.'},
          hAxis: {title: 'Month'},
          seriesType: 'bars',
        //   series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
 




@endsection
