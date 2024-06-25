@extends('layouts.report_font')
@section('title', 'PK-OFFICER || DASHBOARD')
 
@section('content')
   
    <?php  
        $ynow = date('Y')+543;
        $mo =  date('m');
    ?>  
     
     <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{	
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
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
               .is-hide{
               display:none;
               }
    </style>
      <?php
      use App\Http\Controllers\StaticController;
      use Illuminate\Support\Facades\DB;   
      $count_meettingroom = StaticController::count_meettingroom();
  ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>  
        
        {{-- <div class="row">
            
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">OPD ThaiRefer ในปีงบประมาณ</p>   
                                                    <h4 class="text-start mb-2">{{$refer}} Visit</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url('report_refer_thairefer_detail/'.$start.'/'.$end)}}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
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
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">ข้อสะโพกย้อนหลัง ในปีงบประมาณ</p>                                                    
                                                    <h4 class="text-start mb-2">{{$countsaphok}} Visit</h4>                                                        
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url('check_khosaphokdetail/'.$start.'/'.$end)}}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
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
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">แผ่นโลหะกระดูกย้อนหลัง ในปีงบประมาณ</p>                                                    
                                                    <h4 class="text-start mb-2">{{$countkradook}} Visit</h4>                                                        
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url('check_kradookdetail/'.$start.'/'.$end)}}" target="_blank">
                                                        <span class="avatar-title bg-light text-danger rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
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
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">ข้อเข่าย้อนหลัง ในปีงบประมาณ</p>                                                    
                                                    <h4 class="text-start mb-2">{{$dataknee}} Visit</h4>                                                        
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{url('check_knee_ipddetail/'.$start.'/'.$end)}}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
                                    </div>                                           
                                </div>  
                            </div>                                           
                        </div> 
                    </div> 
                </div>                     
                            
        </div> --}}

        {{-- <div class="row">
            
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">อุปกรณ์ในการบำบัดรักษา(9104) ในปีงบประมาณ</p>   
                                                <h4 class="text-start mb-2">{{$count9140}} Visit</h4>                                                         
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="{{url('check_bumbat_detail/'.$start.'/'.$end)}}" target="_blank">
                                               
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                Detail
                                                            </button> 
                                                        </p>
                                                    </span> 
                                                </a>
                                            </div>
                                        </div> 
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
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">Laparoscopic appendectomy(4701) ในปีงบประมาณ</p>                                                    
                                                <h4 class="text-start mb-2">{{$count4701}} Visit</h4>                                                        
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="{{url('check_lapo_detail/'.$start.'/'.$end)}}" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger avatar-title bg-light text-primary rounded-3">
                                                                <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                Detail
                                                            </button> 
                                                        </p>
                                                    </span> 
                                                </a>
                                            </div>
                                        </div> 
                                </div>                                           
                            </div>  
                        </div>                                           
                    </div> 
                </div> 
            </div>
         
        </div> --}}
        <div class="row">
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
                                    {{-- @apexchartsScripts
                                    {!! $chart->container() !!}
                                    {!! $chart->script() !!} --}}
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
                                    {{-- @apexchartsScripts
                                    {!! $chart->container() !!}
                                    {!! $chart->script() !!} --}}
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
    {{-- <script src="{{ asset('apexcharts/report.js') }}"></script> --}}
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
        });
        
    </script>
    <script>
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
