@extends('layouts.accountpk')
@section('title', 'PK-BACKOFFice || ACCOUNT')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
 
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        <div class="row ms-3 me-3">
            <div class="col-md-4">
                <h4 class="card-title">Dashboard Account </h4>
                <p class="card-title-desc">รายละเอียดข้อมูล</p>
            </div>
            <div class="col"></div>
            {{-- <div class="col-md-1 text-end mt-2">วันที่</div>
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
                <div class="col-md-2 text-start">
                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                    </button> 
                </div> --}}
        </div>
        <div class="row p-3">
            <div class="col-xl-12 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                    <div id="linechart"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-3">
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                    <div id="chart"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                    <div id="chart2"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                    <div id="chart3"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                    <div id="chart4"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> 

        <div class="row ms-2 me-3">
            <div class="col-xl-3 col-md-3">
                <div class="main-card card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="no-shadow rm-border bg-transparent widget-chart text-start card">
                                        <div class="progress-circle-wrapper">
                                            <div class="circle-progress circle-progress-gradient-lg">
                                                <small></small>
                                            </div>
                                        </div>
                                        <div class="widget-chart-content">
                                            <div class="widget-subheading">Capital Gains</div>
                                            <div class="widget-numbers text-success">
                                                <span>$563</span>
                                            </div>
                                            <div class="widget-description text-focus">
                                                Increased by
                                                <span class="text-warning ps-1">
                                                    <i class="fa fa-angle-up"></i>
                                                    <span class="ps-1">7.35%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       

    </div>
    @apexchartsScripts
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
    <script>
        var options1 = {
            chart: {
                height: 350,
                type: "radialBar",
            },
            series: [32, 98, 70, 61],
            plotOptions: {
                radialBar: {
                dataLabels: {
                    total: {
                            show: true,
                            label: 'TOTAL'
                    }
                }
                }
            },
            labels: ['401', '402', '403', '404']
            };

            new ApexCharts(document.querySelector("#chart4"), options1).render();
    </script>
    <script>
         var options7 = {
          series: [{
                // data: data.slice()
                data: [1523,2562,2555,2240]
                }],
                chart: {
                id: 'realtime',
                height: 350,
                type: 'line',
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                    speed: 1000
                    }
                },
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
                },
                dataLabels: {
                enabled: false
                },
                stroke: {
                curve: 'smooth'
                },
                title: {
                text: 'Dynamic Updating Chart',
                align: 'left'
                },
                markers: {
                size: 0
                },
                xaxis: {
                type: 'datetime',
                range: XAXISRANGE,
                },
                yaxis: {
                max: 100
                },
                legend: {
                show: false
                },
            };

        var chart = new ApexCharts(document.querySelector("#linechart"), options7);
        chart.render();
      
      
        window.setInterval(function () {
        getNewSeries(lastDate, {
          min: 10,
          max: 90
        })
      
        chart.updateSeries([{
          data: data
        }])
      }, 1000)
    </script>
    <script>
        //  var options = {
        //   series: [{
        //   data: [1205,2542]
        // //   data: series.monthDataSeries1.prices
        // }],
        //   chart: {
        //   height: 350,
        //   type: 'line',
        //   id: 'areachart-2'
        // },
        // annotations: {
        //   yaxis: [{
        //     y: 8200,
        //     borderColor: '#00E396',
        //     label: {
        //       borderColor: '#00E396',
        //       style: {
        //         color: '#fff',
        //         background: '#00E396',
        //       },
        //       text: 'Support',
        //     }
        //   }, {
        //     y: 8600,
        //     y2: 9000,
        //     borderColor: '#000',
        //     fillColor: '#FEB019',
        //     opacity: 0.2,
        //     label: {
        //       borderColor: '#333',
        //       style: {
        //         fontSize: '10px',
        //         color: '#333',
        //         background: '#FEB019',
        //       },
        //       text: 'Y-axis range',
        //     }
        //   }],
        //   xaxis: [{
        //     x: new Date('23 Nov 2017').getTime(),
        //     strokeDashArray: 0,
        //     borderColor: '#775DD0',
        //     label: {
        //       borderColor: '#775DD0',
        //       style: {
        //         color: '#fff',
        //         background: '#775DD0',
        //       },
        //       text: 'Anno Test',
        //     }
        //   }, {
        //     x: new Date('26 Nov 2017').getTime(),
        //     x2: new Date('28 Nov 2017').getTime(),
        //     fillColor: '#B3F7CA',
        //     opacity: 0.4,
        //     label: {
        //       borderColor: '#B3F7CA',
        //       style: {
        //         fontSize: '10px',
        //         color: '#fff',
        //         background: '#00E396',
        //       },
        //       offsetY: -10,
        //       text: 'X-axis range',
        //     }
        //   }],
        //   points: [{
        //     x: new Date('01 Dec 2017').getTime(),
        //     y: 8607.55,
        //     marker: {
        //       size: 8,
        //       fillColor: '#fff',
        //       strokeColor: 'red',
        //       radius: 2,
        //       cssClass: 'apexcharts-custom-class'
        //     },
        //     label: {
        //       borderColor: '#FF4560',
        //       offsetY: 0,
        //       style: {
        //         color: '#fff',
        //         background: '#FF4560',
        //       },
        
        //       text: 'Point Annotation',
        //     }
        //   }, {
        //     x: new Date('08 Dec 2017').getTime(),
        //     y: 9340.85,
        //     marker: {
        //       size: 0
        //     },
        //     image: {
        //       path: '../../assets/images/ico-instagram.png'
        //     }
        //   }]
        // },
        // dataLabels: {
        //   enabled: false
        // },
        // stroke: {
        //   curve: 'straight'
        // },
        // grid: {
        //   padding: {
        //     right: 30,
        //     left: 20
        //   }
        // },
        // title: {
        //   text: 'Line with Annotations',
        //   align: 'left'
        // },
        // // labels: series.monthDataSeries1.dates,
        // labels: ['ss','dd'],
        // xaxis: {
        //   type: 'datetime',
        // },
        // };

        // var chart = new ApexCharts(document.querySelector("#linechart"), options);
        // chart.render(); 

        var options = {
            chart: {
                height: 350,
                type: "radialBar",
            },

            series: [67],
            colors: ["#20E647"],
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "70%",
                        background: "#293450"
                    },
                    track: {
                        dropShadow: {
                            enabled: true,
                            top: 2,
                            left: 0,
                            blur: 4,
                            opacity: 0.15
                        }
                    },
                    dataLabels: {
                        name: {
                            offsetY: -10,
                            color: "#fff",
                            fontSize: "13px"
                        },
                        value: {
                            color: "#fff",
                            fontSize: "30px",
                            show: true
                        }
                    }
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    shade: "dark",
                    type: "vertical",
                    gradientToColors: ["#87D4F9"],
                    stops: [0, 100]
                }
            },
            stroke: {
                lineCap: "round"
            },
            labels: ["Progress"]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


        var options2 = {
            chart: {
                height: 350,
                type: 'radialBar',
            },
            series: [
                87
            ],
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 15,
                        size: "70%"
                    },

                    dataLabels: {
                        showOn: "always",
                        name: {
                            offsetY: -10,
                            show: true,
                            color: "#888",
                            fontSize: "13px"
                        },
                        value: {
                            color: "#111",
                            fontSize: "30px",
                            show: true
                        }
                    }
                }
            },
            stroke: {
                lineCap: "round",
            },
            labels: ['Progress'],
        }
        var chart = new ApexCharts(document.querySelector("#chart2"), options2);
        chart.render();

        var options3 = {
            chart: {
                height: 350,
                type: 'radialBar',
            },
            series: [
                15
            ],
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 15,
                        size: "70%"
                    },

                    dataLabels: {
                        showOn: "always",
                        name: {
                            offsetY: -10,
                            show: true,
                            color: "#888",
                            fontSize: "13px"
                        },
                        value: {
                            color: "#111",
                            fontSize: "30px",
                            show: true
                        }
                    }
                }
            },

            stroke: {
                lineCap: "round",
            },
            labels: ['Progress'],
        }
        var chart = new ApexCharts(document.querySelector("#chart3"), options3);
        chart.render();
    </script>
@endsection
