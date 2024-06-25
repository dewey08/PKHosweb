@extends('layouts.authen')
@section('title', 'PK-OFFICER || authen')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    .chartMenu {
        width: 100vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(255, 26, 104, 1);
    }

    .chartMenu p {
        padding: 10px;
        font-size: 20px;
    }

    .chartCard {
        width: 100vw;
        height: calc(100vh - 40px);
        background: rgba(255, 26, 104, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(255, 26, 104, 1);
        background: white;
    }
    .chartgooglebar{
          width:auto;
          height:auto;        
      }
      .chartgoogle{
          width:auto;
          height:auto;        
      }
</style>  
    <div class="tabs-animation">

        <div class="row">
            <div class="col-lg-12 col-xl-8">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Authen Report</h5>
                        <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                            <div style="height: auto;"> 
                                <canvas id="canvasshow"></canvas>
                            </div>
                        </div>
                        {{-- <h5 class="card-title">Target Sales</h5>
                        <div class="mt-3 row">
                            <div class="col-sm-12 col-md-4">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-numbers text-dark">65%</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="65"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
                                                </div>
                                            </div>
                                            <div class="progress-sub-label">
                                                <div class="sub-label-left font-size-md">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-numbers text-dark">22%</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="22"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 22%;">
                                                </div>
                                            </div>
                                            <div class="progress-sub-label">
                                                <div class="sub-label-left font-size-md">Profiles</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-numbers text-dark">83%</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="83"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 83%;">
                                                </div>
                                            </div>
                                            <div class="progress-sub-label">
                                                <div class="sub-label-left font-size-md">Tickets</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-4">
                <div class="main-card mb-3 card">
                    <div class="grid-menu grid-menu-2col">
                        <div class="g-0 row">
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-primary"></div>
                                        <i class="lnr-screen text-primary"></i>
                                    </div>
                                    <div class="widget-numbers">{{ $countalls }} </div>
                                    <div class="widget-subheading">Total</div>
                                    <div class="widget-description text-success">
                                        <i class="fa fa-angle-up"></i>
                                        @if ($countalls == '0')
                                        <span class="ps-1">0 %</span>
                                        @else
                                        <span class="ps-1">100 %</span>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-info"></div>
                                        <i class="lnr-graduation-hat text-info"></i>
                                    </div>
                                    <div class="widget-numbers">{{$count_authen_success}}</div>
                                    <div class="widget-subheading">Success</div>
                                    <div class="widget-description text-info">
                                        <i class="fa fa-arrow-right"></i>
                                        @if ($count_authen_success == '0')
                                        <span class="pe-1">0 %</span>
                                        @else
                                        <span class="ps-1">{{ number_format($count_authen_successt, 2) }} %</span>
                                        @endif
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-danger"></div>
                                        <i class="lnr-screen"></i>
                                    </div>
                                    <div class="widget-numbers">{{ $countkiosalls }}</div>
                                    <div class="widget-subheading">Kios</div>
                                    <div class="widget-description text-primary">
                                        @if ($countkiosalls == '0')
                                        <span class="pe-1">0 %</span>
                                        @else
                                        <span class="pe-1">{{ number_format($countkiosallst, 2) }} %</span>
                                        @endif
                                        
                                        <i class="fa fa-angle-left"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="widget-chart widget-chart-hover br-br">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-success"></div>
                                        <i class="lnr-users"></i>
                                    </div>
                                    <div class="widget-numbers">{{ $countonusers }}</div>
                                    <div class="widget-subheading">เจ้าหน้าที่</div>
                                    <div class="widget-description text-warning">
                                        @if ($countonuserst == '0')
                                        <span class="pe-1">0 %</span>
                                        @else
                                        <span class="pe-1">{{ number_format($countonuserst, 2) }} %</span>
                                        @endif
                                        
                                        <i class="fa fa-arrow-left"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="grid-menu grid-menu-2col">
                                <div class="g-0 row">
                                    <div class="col-sm-12">
                                        <div class="widget-chart widget-chart-hover" id="countalls_show" style="background-color: rgb(50, 117, 206)">  
                                            <div class="widget-numbers">
                                                <label for="" style="font-size: 30px;color:rgb(255, 255, 255)">
                                                    {{$countalls}} 
                                            </label>
                                            </div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(253, 253, 253)">คนไข้วันนี้ทั้งหมด(คน)</label></div>
                                            <div class="widget-description text-white">
                                                <i class="fa fa-angle-up"></i>
                                                <span class="ps-1">
                                                    <label for="" style="font-size: 15px;color:rgb(255, 255, 255)">
                                                    100 %
                                                </label>
                                                </span>
                                            </div>                                
                                        </div>
                                    </div> 
                                </div>
                                <div class="g-0 row">
                                    <div class="col-sm-12">
                                        <div class="widget-chart widget-chart-hover" id="countalls_success_show" style="background-color: rgb(23, 206, 121)">
                                                                               
                                            <div class="widget-numbers">                                               
                                                  <label for="" style="font-size: 30px;color:rgb(255, 255, 255)">
                                                   100
                                                </label> 
                                            </div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(255, 255, 255)" >Success (คน)</label></div>
                                            <div class="widget-description text-white">
                                                <i class="fa fa-angle-up"></i>
                                                <span class="ps-1">
                                                    <label for="" style="font-size: 15px;color:rgb(255, 255, 255)">10 %
                                                    </label></span>
                                            </div>                                            
                                        </div>
                                    </div> 
                                </div>
                                <div class="g-0 row">
                                    <div class="col-sm-12">
                                        <div class="widget-chart widget-chart-hover" id="countalls_nosuccess_show222222" style="background-color: rgb(228, 24, 24)">
                                                                                     
                                            <div class="widget-numbers">    
                                                <label for="" style="font-size: 30px;color:rgb(255, 255, 255)">
                                               10
                                                </label>
                                            </div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(255, 255, 255)">No Success (คน)</label></div>
                                            <div class="widget-description text-white">
                                                <i class="fa fa-angle-up"></i>
                                                <span class="ps-1">
                                                    <label for="" style="font-size: 15px;color:rgb(255, 255, 255)">
                                                    10 %
                                                </label>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div> 
                                </div> 
                            </div> --}}
                </div>            
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="card-body table-responsive">
                        <div class="card-title">ApexCharts Sparklines</div>
                        <table class="table table-bordered table-hover table-stripe">
                            <thead>
                                <th>Total Value</th>
                                <th>Percentage of Portfolio</th>
                                <th>Last 10 days</th>
                                <th>Volume</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>$32,554</td>
                                    <td>15%</td>
                                    <td>
                                        <div id="sparkline-chart1"></div>
                                    </td>
                                    <td>
                                        <div id="sparkline-chart5"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>$23,533</td>
                                    <td>7%</td>
                                    <td>
                                        <div id="sparkline-chart2"></div>
                                    </td>
                                    <td>
                                        <div id="sparkline-chart6"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>$54,276</td>
                                    <td>9%</td>
                                    <td>
                                        <div id="sparkline-chart3"></div>
                                    </td>
                                    <td>
                                        <div id="sparkline-chart7"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>$11,533</td>
                                    <td>2%</td>
                                    <td>
                                        <div id="sparkline-chart4"></div>
                                    </td>
                                    <td>
                                        <div id="sparkline-chart8"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3 widget-chart widget-chart2 bg-warm-flame text-start">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content text-white">
                            <div class="widget-chart-flex">
                                <div class="widget-title">คนไข้ที่มาใช้บริการ </div>
                                <div class="widget-subtitle text-white">วันนี้</div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers">                                   
                                    1283
                                    <small>คน</small>
                                </div>
                                <div class="widget-description ms-auto text-white">
                                    <i class="fa fa-angle-up "></i>
                                    <span class="ps-1">175.5%</span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper">
                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                <div class="progress-bar bg-success"
                                    role="progressbar" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
                                </div>
                            </div>
                            <div class="progress-sub-label text-white">YoY Growth</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3 widget-chart widget-chart2 bg-tempting-azure text-start">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content text-dark">
                            <div class="widget-chart-flex">
                                <div class="widget-title">Profiles</div>
                                <div class="widget-subtitle text-dark">Active Users</div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers">368</div>
                                <div class="widget-description ms-auto text-dark">
                                    <span class="pe-1">66.5%</span>
                                    <i class="fa fa-arrow-left "></i>
                                </div>
                            </div>
                        </div>
                       
                        <div class="widget-progress-wrapper">
                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                <div class="progress-bar bg-danger"
                                    role="progressbar" aria-valuenow="85"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
                                </div>
                            </div>
                            <div class="progress-sub-label text-white">Monthly Subscribers</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3 widget-chart widget-chart2 bg-plum-plate text-start">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content text-white">
                            <div class="widget-chart-flex">
                                <div class="widget-title">Clients</div>
                                <div class="widget-subtitle text-white opacity-7">Returning</div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers">
                                    87
                                    <small>%</small>
                                </div>
                                <div class="widget-description ms-auto text-white">
                                    <span class="pe-1">45</span>
                                    <i class="fa fa-angle-up "></i>
                                </div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper">
                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="47"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 47%;">
                                </div>
                            </div>
                            <div class="progress-sub-label text-white">Successful Payments</div>
                        </div>
                        
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="card mb-3 widget-chart widget-chart2 bg-mixed-hopes text-start">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content text-white">
                            <div class="widget-chart-flex">
                                <div class="widget-title">Reports</div>
                                <div class="widget-subtitle text-white">Bugs Fixed</div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers text-warning">1621</div>
                                <div class="widget-description ms-auto text-white">
                                    <i class="fa fa-arrow-right "></i>
                                    <span class="ps-1">27.2%</span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper">
                            <div class="progress-bar-xs progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="91"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 91%;">
                                </div>
                            </div>
                            <div class="progress-sub-label text-white">Severe Reports</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3 widget-chart widget-chart2 bg-slick-carbon text-start">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content text-white">
                            <div class="widget-chart-flex">
                                <div class="widget-title opacity-5">Sales</div>
                                <div class="widget-subtitle opacity-5 text-white">Monthly Goals</div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers">
                                    <small>$</small>
                                    1283
                                </div>
                                <div class="widget-description ms-auto text-white">
                                    <i class="fa fa-angle-up "></i>
                                    <span class="ps-1">175.5%</span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper">
                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
                                </div>
                            </div>
                            <div class="progress-sub-label text-white">YoY Growth</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3 widget-chart widget-chart2 bg-asteroid text-start">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content text-white">
                            <div class="widget-chart-flex">
                                <div class="widget-title opacity-5">Payments</div>
                                <div class="widget-subtitle opacity-5 text-white">Totals</div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers">
                                    <small>$</small>
                                    653
                                </div>
                                <div class="widget-description ms-auto text-white">
                                    <i class="fa fa-angle-up "></i>
                                    <span class="ps-1">$4596</span>
                                </div>
                            </div>
                        </div>
                        <div class="widget-progress-wrapper">
                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="65"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
                                </div>
                            </div>
                            <div class="progress-sub-label text-white">YoY Growth</div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="card-body table-responsive">
                        <div class="card-title">รายงานแยกตามแผนก</div>
                        <table class="table table-bordered table-hover table-stripe">
                            <thead>
                                <th>ลำดับ</th>
                                <th>แผนก</th>
                                <th>จำนวน</th>
                                <th>Authen Code</th>
                                <th>No Authen Code</th>                               
                            </thead>
                            <tbody>
                                <?php $i = 1; 
                                $date = date('Y-m-d');
                                ?>
                                @foreach ($data_dep as $item)  
                                <?php 
                                // $count_authen_no = DB::connection('mysql3')->table('visit_pttype_authen')
                                // ->select('ovst.main_dep','visit_pttype_authen.visit_pttype_authen_vn')
                                // ->leftjoin('ovst','ovst.vn','=','visit_pttype_authen.visit_pttype_authen_vn' )
                                // ->where('ovst.main_dep','=',$item->main_dep)
                                // ->where('visit_pttype_authen.visit_pttype_authen_auth_code','=','')                              
                                // ->count(); 

                                $count_authen_code = DB::connection('mysql3')->table('visit_pttype_authen')
                                ->select('main_dep','visit_pttype_authen_auth_code')
                                // ->leftjoin('ovst','ovst.vn','=','visit_pttype_authen.visit_pttype_authen_vn' )
                                ->where('main_dep','=',$item->main_dep)
                                ->where('visit_pttype_authen_auth_code','!=','')   
                                ->where('vstdate','=',$date)                         
                                ->count(); 
                                // $count_authen = DB::connection('mysql3')->select('                                        
                                //         SELECT o.vstdate,o.main_dep,COUNT(o.vn) as CVN  
                                //         FROM visit_pttype_authen vp 
                                //         LEFT JOIN ovst o on o.vn = vp.visit_pttype_authen_vn 
                                //         WHERE o.vstdate = CURDATE()  
                                //         and o.main_dep = "'.$item->main_dep.'"                                     
                                // ');
                                // foreach ($count_authen as $key => $value) {
                                //     $count_vn = $value->CVN;
                                // }
                                ?> 
                                  {{-- AND o.main_dep ="'.$item->main_dep.'" --}}
                                 {{-- SELECT o.main_dep,sk.department,COUNT(o.vn) as VN   
                                 FROM ovst o 
                                 LEFT JOIN visit_pttype v on v.vn=o.vn
                                 LEFT JOIN vn_stat vs on vs.vn=o.vn
                                 LEFT JOIN visit_pttype_authen vpa on vpa.visit_pttype_authen_vn=o.vn
                                 LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                                 WHERE o.vstdate = CURDATE()  
                                 and o.main_dep = "'.$item->main_dep.'"    
                                 GROUP BY o.main_dep --}}
                                <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->department }}</td>
                                        <td>{{ $item->VN }}</td>
                                        <td>
                                           
                                            {{$count_authen_code}}
                                            {{-- <div id="sparkline-chart1"></div> --}}
                                        </td>
                                        <td>
                                            {{($item->VN) - ($count_authen_code)}}
                                         
                                            {{-- <div id="sparkline-chart5"></div> --}}
                                        </td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row"> 
                    <div class="col-lg-12 col-xl-12">
                        <div class="main-card mb-3 card">
                            <div class="grid-menu grid-menu-3col"> 
                                <div class="g-0 row">
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" id="count_kios_all_show" style="background-image: url('{{ asset('assets/images/kios.png')}}');">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-primary"></div> 
                                                <i class="lnr-screen text-primary"></i>
                                            </div>
                                            
                                            
                                            <div class="widget-numbers">{{$countkiosalls}}</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(17, 141, 243)">ผ่านตู้ KIOS(คน)</label></div>
                                            <div class="widget-description text-info">
                                                <i class="fa fa-arrow-right"></i> 
                                                <span class="ps-1"> {{number_format($countkiosallst,2)}} %</span> 
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" id="count_kios_success_show">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-info"></div>
                                                <i class="lnr-screen text-success"></i>
                                            </div>
                                            
                                            <div class="widget-numbers">20</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:green">ผ่านตู้ KIOS SUCCESS(คน)</label></div>
                                            <div class="widget-description text-success">
                                                <i class="fa fa-arrow-right"></i> 
                                                <span class="ps-1">10 %</span> 
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" id="count_kios_nosuccess_show">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-info"></div>
                                                <i class="lnr-screen text-danger"></i>
                                            </div>
                                                
                                            <div class="widget-numbers">22</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:red">ผ่านตู้ KIOS NO SUCCESS(คน)</label></div>
                                            <div class="widget-description text-danger">
                                                <i class="fa fa-arrow-right"></i>
                                                
                                                <span class="ps-1">10 %</span>
                                                
                                            </div>
                                        
                                        </div>
                                    </div>
                                        
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" style="background-image: url('{{ asset('assets/images/info.png')}}');">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-primary"></div>
                                                <i class="lnr-users text-info"></i>
                                            </div>
                                            
                                            <div class="widget-numbers">{{$countonusers}}</div>
                                            <div class="widget-subheading"> <label for="" style="font-size: 22px;color:rgb(17, 141, 243)">ออกโดยเจ้าหน้าที่(คน)</label></div>
                                            <div class="widget-description text-primary">
                                                <span class="pe-1">{{number_format($countonuserst,2)}} %</span>
                                                <i class="fa fa-arrow-left"></i>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover br-br" id="count_userssuccess_show">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-success"></div>
                                                <i class="lnr-users text-success"></i>
                                            </div>
                                            
                                            
                                            <div class="widget-numbers">11</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:green">ออกโดยเจ้าหน้าที่ SUCCESS(คน)</label></div>
                                            <div class="widget-description text-success">
                                                <span class="pe-1">10 %</span>
                                                <i class="fa fa-arrow-left"></i>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover br-br" id="count_usersnosuccess_show222222222">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-success"></div>
                                                <i class="lnr-users text-danger"></i>
                                            </div>
                                            
                                            
                                            <div class="widget-numbers"> FFF</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:red">ออกโดยเจ้าหน้าที่ NO SUCCESS(คน)</label></div>
                                            <div class="widget-description text-success">
                                                <span class="pe-1">11 %</span>
                                                <i class="fa fa-arrow-left"></i>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
    </div>



@endsection
@section('footer')
{{-- <script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/dist-chart.min.js') }}"></script> --}}
<script>
     window.onload = function() {
            if (document.getElementById("canvasshow")) {
                var ctx = document.getElementById("canvasshow").getContext("2d");
                window.myBar = new Chart(ctx, {
                    type: "bar",
                    data: barChartDatashow,
                    options: {
                        responsive: true,
                        legend: {
                            position: "top",
                        },
                        title: {
                            display: false,
                            text: "Chart.js Bar Chart",
                        },
                    },
                });
            }
        }
        var barChartDatashow = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                    label: "Dataset 1",
                    backgroundColor: chartColors.red,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                },
                {
                    label: "Dataset 2",
                    backgroundColor: chartColors.blue,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                },
                {
                    label: "Dataset 3",
                    backgroundColor: chartColors.green,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                },
            ],
        };
</script>
@endsection
