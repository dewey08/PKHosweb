@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Dashboard')


@section('content')

    <?php
        $ynow = date('Y') + 543;
        $mo = date('m');
        $d = date('d');

        if ($mo == 1) {
            $mo_ = 'มกราคม';
        } elseif ($mo == 2) {
            $mo_ = 'กุมภาพันธ์';
        } elseif ($mo == 3) {
            $mo_ = 'มีนาคม';
        } elseif ($mo == 4) {
            $mo_ = 'เมษายน';
        } elseif ($mo == 5) {
            $mo_ = 'พฤษภาคม';
        } elseif ($mo == 6) {
            $mo_ = 'มิถุนายน';
        } elseif ($mo == 7) {
            $mo_ = 'กรกฎาคม';
        } elseif ($mo == 8) {
            $mo_ = 'สิงหาคม';
        } elseif ($mo == 9) {
            $mo_ = 'กันยายน';
        } elseif ($mo == 10) {
            $mo_ = 'ตุลาคม';
        } elseif ($mo == 11) {
            $mo_ = 'พฤษจิกายน';
        } else {
            $mo_ = 'ธันวาคม';
        }
        
        $dd = $d.' '.$mo_.' '.$ynow
    
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
            border-top: 10px rgb(212, 106, 124) solid;
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

    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="main-card card p-2">
                <div class="row">
                    <div class="col-xl-5 col-md-4">                        

                        <div class="main-card card p-2">
                            <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">บริการ</h4>  
                            <table class="table table-striped table-bordered " style="width: 100%;">
                                <tbody>
                                    @foreach ($data_type as $type)
                                    <?php
                                            $datas = DB::select('
                                                SELECT count(claimcode) as claimcode 
                                                    from check_sit_auto
                                                    WHERE claimtype="'.$type->checkauthen_type_code.'" 
                                                    AND claimcode <> ""
                                                    AND vstdate = CURDATE()
                                            ');
                                            foreach ($datas as $key => $val) {
                                                $count_type = $val->claimcode;
                                            }                                           
                                    ?>
                                    <tr height="10px;">
                                        <td>
                                            <h6>
                                                <a href="">{{$type->checkauthen_type_name}}</a> 
                                            </h6>
                                        </td>
                                        
                                        <td >{{$count_type}} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                      
                                
                        </div>
                       
                        <div class="main-card card p-2">
                            <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">สิทธิ์หลัก</h4>  
                            <table class="table table-striped table-bordered " style="width: 100%;">
                                <tbody>                      
                                    @foreach ($data_pttypegroup as $typegroup) 
                                    <?php
                                   
                                            $datas2 = DB::select('
                                                SELECT count(c.claimcode) as claimcode 
                                                    from check_sit_auto c
                                                    left join pttype p ON c.pttype = p.pttype
                                                    WHERE p.hipdata_code="'.$typegroup->hipdata_code.'" 
                                                    AND claimcode <> ""
                                                    AND vstdate = CURDATE()
                                            ');
                                            foreach ($datas2 as $key => $val2) {
                                                $count_type2 = $val2->claimcode;
                                            }
                                    ?>
                                        <tr height="10px;">
                                            <td>
                                                <h6 >
                                                    <a href="">({{$typegroup->hipdata_code}}) - {{$typegroup->typename}}</a> 
                                                </h6>
                                            </td>
                                            <td >{{$count_type2}} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                        </div>
                    </div>  

                    <div class="col-xl-7 col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card card">
                                    <h6 class="card-title mt-2 ms-2">Authen Report Month ปี พ.ศ.{{ $ynow }}</h6> 
                                        <div style="height:auto;width: auto;" class="p-2">
                                        <canvas id="Mychart"  class="p-2"></canvas>
                                        <br>
                                        <h6 class="text-center" style="color:rgb(241, 137, 155)">คนไข้ที่มารับบริการ OPD ยกเว้นแผนก 011,036,107 และยกเว้นสิทธิ์ M1-M6,13,23,91,X7</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card card">
                                    <h6 class="card-title mt-2 ms-2">Authen Report Month ปี พ.ศ.{{ $ynow }}</h6> 
                                        <div style="height:auto;" class="p-2">
                                            {{-- <div id="Mychartsline"></div> --}}
                                            <canvas id="myChartNew"></canvas>
                                        <br>
                                        <h6 class="text-center" style="color:rgb(241, 137, 155)">คนไข้ที่มารับบริการ OPD ยกเว้นแผนก 011,036,107 และยกเว้นสิทธิ์ M1-M6,13,23,91,X7</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                  
                </div>
            </div>
        </div>

        <div class="row">

          

            <div class="col-xl-6 col-md-6">
                <div class="main-card card p-2">
                    <h6 class="card-title mt-2 ms-2">Report Group By Day เดือน {{ $mo_ }} ปี พ.ศ.{{ $ynow }}</h6> 

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th> 
                                        <th class="text-center">Visit</th>
                                        <th class="text-center">Authen</th>
                                        <th class="text-center">No Authen</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $j = 1; ?>
                                    @foreach ($data_year3 as $item)
                                    <?php 
                                    $Authenper = 100 * $item->Authen / $item->VN;
                                    $noAuthenper = 100 * $item->Noauthen / $item->VN;
                                    
                                    ?>
                                        <tr >
                                            <td class="text-center" style="width: 5%">{{ $j++ }}</td>
                                            <td class="text-center">{{ $item->day }}</td> 
                                            <td class="text-center">{{ $item->VN }}</td>
                                            <td class="text-center text-success">
                                                <a class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-success" href="{{ url('check_dashboard_authen/' . $item->day.'/'. $item->month.'/'. $item->year) }}"  target="_blank">
                                                    {{ $item->Authen }} Visit 
                                                </a> 
                                                => {{ number_format($Authenper, 2) }}%
                                            </td> 
                                            <td class="text-center text-danger">
                                                <a class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-danger" href="{{ url('check_dashboard_noauthen/' . $item->day.'/'. $item->month.'/'. $item->year) }}"  target="_blank">
                                                    {{ $item->Noauthen }} Visit
                                                </a>  
                                                => {{ number_format($noAuthenper, 2) }}%
                                            </td> 
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div> 
                </div>

            </div>
            <div class="col-xl-6 col-md-6">
                <div class="main-card card p-2">
                    <h6 class="card-title mt-2 ms-2">Report Group By Staff เดือน {{ $mo_ }} ปี พ.ศ.{{ $ynow }}</h6>
                    <div class="table-responsive p-2">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    {{-- <th class="text-center">วันที่</th> --}}
                                    <th class="text-center">Staff</th>
                                    <th class="text-center">Visit</th>
                                    <th class="text-center">Authen</th>
                                    <th class="text-center">No Authen</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = 1; ?>
                                @foreach ($data_staff as $item2)
                                <?php 
                                    $Authenper_s = 100 * $item2->Authen / $item2->countvn;
                                    $noAuthenper_s = 100 * $item2->Noauthen / $item2->countvn;
                                
                                ?>
                                    <tr >
                                        <td class="text-center" style="width: 5%">{{ $j++ }}</td>
                                        {{-- <td class="text-center">{{ $item2->day }}</td> --}}
                                        <td class="p-2">{{ $item2->staff }}</td>
                                        <td class="text-center">{{ $item2->countvn }}</td>
                                        <td class="text-center text-success"> 
                                            <a class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-success" href="{{ url('check_dashboard_staff/' . $item2->staff.'/'. $item2->day.'/'. $item2->month.'/'. $item2->year) }}"  target="_blank">
                                                {{ $item2->Authen }} Visit
                                            </a>
                                            => {{ number_format($Authenper_s, 2) }}%
                                        </td> 
                                        <td class="text-center text-danger">
                                            <a class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-danger" href="{{ url('check_dashboard_staffno/' . $item2->staff.'/'. $item2->day.'/'. $item2->month.'/'. $item2->year) }}"  target="_blank">
                                                {{ $item2->Noauthen }} Visit
                                            </a>   
                                            => {{ number_format($noAuthenper_s, 2) }}%
                                        </td> 
                                    </tr>
                                @endforeach
    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
             
        </div>

    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="main-card card p-2">
                <h6 class="card-title mt-2 ms-2">Report Group By Department เดือน {{ $mo_ }} ปี พ.ศ.{{ $ynow }}</h6>
                <div class="table-responsive mt-3">
                    <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">department</th>
                                <th class="text-center">Visit</th>
                                <th class="text-center">Authen</th>
                                <th class="text-center">No Authen</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $s = 1; ?>
                            @foreach ($data_dep as $item3)
                                <tr>
                                    <td class="text-center" style="width: 5%">{{ $s++ }}</td>
                                    <td class="p-2">{{ $item3->department }}</td>
                                    <td class="text-center">{{ $item3->countvn }}</td>
                                    <td class="text-center">{{ $item3->Authen }}</td> 
                                    <td class="text-center">{{ $item3->Noauthen }}</td> 
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        <div class="col-xl-6 col-md-6">
            {{-- <div class="main-card card p-2">
            </div> --}}
        </div>
    </div>



    </div>


@endsection
@section('footer')
{{-- <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        
        ['Year', 'Authen Code', 'ไม่ Authen'],
        ['2004',  1000,      400],
        ['2005',  1170,      460],
        ['2006',  660,       1120],
        ['2007',  1030,      540]
      ]);
        

      var options = {
        title: 'Company Performance',
        curveType: 'function',
        legend: { position: 'bottom' }
      };

      var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

      chart.draw(data, options);
    }
</script> --}}
{{-- <script src="{{ asset('js/chart.min.js') }}"></script> --}}
 {{-- <script src="{{ asset('js/dist-chart.min.js') }}"></script> --}}
 <script type="text/lavascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script>
        var Linechart;
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            var xmlhttp = new XMLHttpRequest();
            var url = "{{ route('claim.check_line') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas);
                    Authen = datas.Dataset1.map(function(e) {
                        return e.Authen;
                    });
                    
                    count = datas.Dataset1.map(function(e) {
                        return e.count;
                    });
                    Noauthen = datas.Dataset1.map(function(e) {
                        return e.Noauthen;
                    });
                     // setup 
                    const data = {
                        labels: ["ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"] ,
                        datasets: [                        
                            {
                                label: ['คนไข้ที่มารับบริการ OPD'],
                                data: count,
                                fill: false,
                                borderColor: 'rgba(255, 205, 86)',
                                tension: 0.4
                               
                            },
                            {
                                label: ['Authen Code'],
                                data: Authen,
                                fill: false,
                                borderColor: 'rgba(75, 192, 192)',
                                tension: 0.4
                               
                            },
                            {
                                label: ['ไม่ Authen Code'],
                                data: Noauthen,
                                fill: false,
                                borderColor: 'rgba(255, 99, 132)',
                                tension: 0.4
                                
                            },
                            

                            
                        ]
                    };
             
                    const config = {
                        type: 'line',
                        data,
                        options: {
                            // indexAxis: 'y',
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    stacked:true
                                }
                            }

                            // animations: {
                            //     tension: {
                            //         duration: 100,
                            //         easing: 'linear',
                            //         from: 1,
                            //         to: 0,
                            //         loop: true
                            //         }
                            //     },
                            //     scales: {
                            //         y: { // defining min and max so hiding the dataset does not change scale range
                            //             min: 0,
                            //             max: 100
                            //         }
                                }   
                        },
                        plugins:[ChartDataLabels],
                        
                    };
                    
                    // render init block
                    const myChart = new Chart(
                        document.getElementById('myChartNew'),
                        config
                    );
                }
             }
            // const ctx2 = document.getElementById('myChartNew');

            // new Chart(ctx2, {
            //     type: 'line',
            //     data: {
            //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            //         datasets: [{
            //             label: '# of Votes',
            //             data: [65, 59, 80, 81, 56, 55, 40],
            //             fill: false,
            //             borderColor: 'rgb(75, 192, 192)',
            //             tension: 0.1
            //         }]
            //     }
                
            // });
            //  fetch("{{ route('claim.check_line') }}")
            //     .then(response => response.json())
            //     .then(json => {
            //         const myChartNew = new Chart(ctx2, { 
            //                 type: 'line',
            //                 data: {
            //                     labels: json.labels,
            //                     datasets: json.datasets,

            //                 },
            //                 options:{
            //                     scales:{
            //                         y:{ 
            //                             stacked: true
            //                         }
            //                     }
            //                 }
                             
            //             })
            // });

            // fetch("{{ route('claim.check_dashboard_line') }}")
            //     .then(response => response.json())
            //     .then(json => {
            //         const myChartNew = new Chart(ctx2, { 
            //                 type: 'line',
            //                 data: {
            //                     labels: json.labels,
            //                     datasets: json.datasets,

            //                 },
            //                 options:{
            //                     scales:{
            //                         y:{ 
            //                             stacked: true
            //                         }
            //                     }
            //                 }
                             
            //             })
            // }); 

        });
    </script>
    <script>
        var ctx = document.getElementById("Mychart").getContext("2d");

        fetch("{{ route('claim.check_dashboard_bar') }}")
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
                    }
                })
            });
            
    </script>
 
    {{-- <script>
        var ctx2 = document.getElementById("Mychartsline").getContext("2d");

            fetch("{{ route('claim.check_dashboard_line') }}")
                .then(response => response.json())
                .then(json => {
                    const Mychart = new Chart(ctx2, { 
                            type: 'line',
                            data: {
                                labels: json.labels,
                                datasets: json.datasets,

                            },
                            options:{
                                scales:{
                                    y:{
                                        beginAtZero:true
                                        // stacked: true
                                    }
                                }
                            }
                        })
                });

    </script> --}}

    
@endsection
