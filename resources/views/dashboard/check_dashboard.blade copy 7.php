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
                            <div class="card-header">
                                <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">บริการ</h4>  
                                <div class="btn-actions-pane-right">
                                    <div role="group" class="btn-group-sm btn-group">
                                        <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">ขอ Authen Code</h4>  
                                    </div>
                                </div>
                            </div>
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
                            <div class="card-header">
                                <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">สิทธิ์หลัก</h4>  
                                <div class="btn-actions-pane-right">
                                    <div role="group" class="btn-group-sm btn-group">
                                        <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">ขอ Authen Code</h4>  
                                    </div>
                                </div>
                            </div> 
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

                        <div class="main-card card p-2">
                            <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">Report แยกตามเจ้าหน้าที่</h4>  
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th> 
                                        <th class="text-center">Staff</th>
                                        <th class="text-center">Visit</th>
                                        <th class="text-center">ขอ Authen Code</th>
                                        <th class="text-center">ไม่ขอ Authen Code</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $jj = 1; ?>
                                    @foreach ($data_staff as $item2)
                                    <?php 
                                        $Authenper_s = 100 * $item2->Authen / $item2->countvn;
                                        $noAuthenper_s = 100 * $item2->Noauthen / $item2->countvn;
                                    
                                    ?>
                                        <tr > <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
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

                        <div class="main-card card p-2">
                            <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">Report แยกตามวันที่</h4> 
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">วันที่</th> 
                                            <th class="text-center">Visit</th>
                                            <th class="text-center">ขอ Authen Code</th>
                                            <th class="text-center">ไม่ขอ Authen Code</th> 
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

                    <div class="col-xl-7 col-md-6">
                        {{-- <div class="row">
                            <div class="col-md-2"> ปีงบประมาณ :  </div>
                            <div class="col-md-2">
                                <select name="yearbudget_select" id="STATUS_CODE" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
                                    @foreach($year_ as $year)
                                    @if($year == $yearbudget_select )
                                        <option value="{{$year}}" selected>พ.ศ. {{$year}}</option>
                                    @else
                                        <option value="{{$year}}">พ.ศ. {{$year}}</option>
                                    @endif
                                    @endforeach
                                </select> 
                            </div>
                            <div class="col-md-1">
                                    <span>
                                        <button type="submit" class="btn btn-hero-sm btn-hero-info" >แสดง</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div> --}}

                        {{-- <form action="{{ route('claim.check_dashboard') }}" method="GET">
                            @csrf --}}
                            <div class="row"> 
                                <div class="col"></div>
                                <div class="col-md-2 text-end">ปีงบประมาณ</div>
                                <div class="col-md-2 text-center">
                                    <select name="yearbudget_select" id="yearbudget" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
                                        @foreach($year_ as $year)
                                        @if($year == $yearbudget_select )
                                            <option value="{{$year}}" selected>พ.ศ. {{$year}}</option>
                                        @else
                                            <option value="{{$year}}">พ.ศ. {{$year}}</option>
                                        @endif
                                        @endforeach
                                    </select> 
                                    {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $startdate }}" required/>
                                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $enddate }}" />
                                    </div> --}}
                                </div>                            
                                <div class="col-md-2">
                                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                    </button> 
                                </div> 
                            </div>
                        {{-- </form> --}}
                        <div class="row mt-5">
                            <div class="col-md-12"> 
                                <div class="main-card card">
                                    <h6 class="card-title mt-2 ms-2">Authen Report Month ปี พ.ศ.{{ $ynow }}</h6> 
                                    <div id="chart_div" style="height:auto;width: auto;"></div>
                                        {{-- <div style="height:auto;width: auto;" class="p-2">
                                        <canvas id="Mychart"  class="p-2"></canvas>
                                        <br>
                                        <h6 class="text-center" style="color:rgb(241, 137, 155)">คนไข้ที่มารับบริการ OPD ยกเว้นแผนก 011,036,107 และยกเว้นสิทธิ์ M1-M6,13,23,91,X7</h6> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card card">
                                    <h6 class="card-title mt-2 ms-2">Authen Report Month ปี พ.ศ.{{ $ynow }}</h6> 
                                        <div style="height:auto;" class="p-2"> 
                                            <canvas id="myChartNew"></canvas>
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
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-md-10">
                                           
                                            <div style="height:710px;width: 650px;" > 
                                                <canvas id="myChartTuaton" ></canvas>
                                                <br> 
                                                <h6 class="text-center" style="color:rgb(241, 137, 155)">คนไข้ที่มารับบริการ OPD แยกตามวิธีการพิสูจน์ตัวตน</h6>
                                            </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                </div>
                            </div> 
                        </div>

                        {{-- <div class="row">
                            
                            @foreach ($data_dep as $item3)
                            <div class="col-md-6 col-xl-6">
                                
                                <div class="card-shadow-primary mb-2 widget-chart widget-chart2 text-start card">
                                    <div class="widget-chat-wrapper-outer">
                                        <div class="widget-chart-content">
                                            <h6 class="widget-subheading">แผนก{{ $item3->department }}</h6>
                                            <div class="widget-chart-flex">
                                                <div class="widget-numbers mb-0 w-100">
                                                    <div class="widget-chart-flex">
                                                        <div class="fsize-3 text-warning">
                                                            <small class="opacity-3 text-muted">Visit All</small>
                                                            {{ $item3->countvn }}
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                                <span class="text-warning ps-2">
                                                                     
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-chart-flex">
                                                <div class="widget-numbers mb-0 w-100">
                                                    <div class="widget-chart-flex">
                                                        <div class="fsize-3 text-success">
                                                            <small class="opacity-3 text-muted">ขอAuthen Code</small>
                                                            {{ $item3->countvn }}
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                                <span class="text-success ps-2">
                                                                    <span class="pe-1">
                                                                        <i class="fa fa-angle-up"></i>
                                                                    </span>
                                                                    8%
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
                            @endforeach
                            
                        </div> --}}
                        {{-- <div class="row"> 
                            <div class="col-xl-12 col-md-12">
                                <div class="main-card card p-2">
                                    <h6 class="card-title mt-2 ms-2">Report Group By Department เดือน {{ $mo_ }} ปี พ.ศ.{{ $ynow }}</h6>
                                    <div class="table-responsive mt-3">
                                        <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr> 
                                                    <th class="text-center">department</th>
                                                    <th class="text-center">Visit</th>
                                                    <th class="text-center">ขอ Authen Code</th>
                                                    <th class="text-center">ไม่ขอ Authen Code</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $s = 1; ?>
                                                @foreach ($data_dep as $item3)
                                                    <tr> 
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
                        </div> --}}


                        
                    </div>
                    
                  
                </div>
            </div>
        </div>

        {{-- <div class="row">
                            
            @foreach ($data_dep as $item3)
            <div class="col-md-6 col-xl-3">
                
                <div class="card-shadow-primary mb-2 widget-chart widget-chart2 text-start card">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content">
                            <h6 class="widget-subheading">แผนก{{ $item3->department }}</h6>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 w-100">
                                    <div class="widget-chart-flex">
                                        <div class="fsize-3 text-warning" >
                                            <small class="opacity-3 text-muted">คนไข่ที่มารับบริการ</small>
                                            {{ $item3->countvn }}
                                        </div>
                                        <div class="ms-auto">
                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                <span class="text-warning ps-2">
                                                     
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 w-100">
                                    <div class="widget-chart-flex">
                                        <div class="fsize-3 text-success">
                                            <small class="opacity-3 text-muted">ขอAuthen Code</small>
                                            {{ $item3->countvn }}
                                        </div>
                                        <div class="ms-auto">
                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                <span class="text-success ps-2">
                                                    <span class="pe-1">
                                                        <i class="fa fa-angle-up"></i>
                                                    </span>
                                                    8%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 w-100">
                                    <div class="widget-chart-flex">
                                        <div class="fsize-3 text-danger">
                                            <small class="opacity-3 text-muted">ไม่ขอAuthen Code</small>
                                            {{ $item3->Noauthen }}
                                        </div>
                                        <div class="ms-auto">
                                            <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                <span class="text-danger ps-2">
                                                    <span class="pe-1">
                                                        <i class="fa fa-angle-up"></i>
                                                    </span>
                                                    8%
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
            @endforeach
            
        </div> --}}

        {{-- <div class="row">
 
            <div class="col-xl-6 col-md-6">
                <div class="main-card card p-2">
                    <h6 class="card-title mt-2 ms-2">Report Group By Department เดือน {{ $mo_ }} ปี พ.ศ.{{ $ynow }}</h6>
                    <div class="table-responsive mt-3">
                        <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr> 
                                    <th class="text-center">department</th>
                                    <th class="text-center">Visit</th>
                                    <th class="text-center">ขอ Authen Code</th>
                                    <th class="text-center">ไม่ขอ Authen Code</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $s = 1; ?>
                                @foreach ($data_dep as $item3)
                                    <tr> 
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
        </div> --}}

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
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

 <script src="https://www.gstatic.com/charts/loader.js"></script>
 <script>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);
 
    //   data.addRows([
    //     [{'ต.ค.', 1}, .25],
    //     [{'พ.ย.', 2}, .5],
    //     [{'ธ.ค.', 3}, 1],
    //     [{'ม.ค.', 4}, 2.25],
    //     [{'ก.พ.', 5}, 2.25],
    //     [{'มี.ค.', 6}, 3],
    //     [{'เม.ย.', 7}, 4],
    //     [{'พ.ค.', 8}, 5.25],
    //     [{'มิ.ย.', 9}, 7.5],
    //     [{'ก.ค.', 10}, 10],
    //     [{'ส.ค.', 10}, 10],
    //     [{'ก.ย.', 10}, 10],
    //   ]);

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            ['เดือน', 'Visit ALL', 'ขอ Authen', 'Madagascar'],
            ['ต.ค.',  <?php echo $count_all[10] ; ?>,  <?php echo $count_authen[10] ; ?>,  <?php echo $count_authen_null[10] ; ?>],
            ['พ.ย.',  <?php echo $count_all[11] ; ?>,  <?php echo $count_authen[11] ; ?>,  <?php echo $count_authen_null[11] ; ?>],
            ['ธ.ค.',  <?php echo $count_all[12] ; ?>,  <?php echo $count_authen[12] ; ?>,  <?php echo $count_authen_null[12] ; ?>],
            ['ม.ค.',  <?php echo $count_all[1] ; ?>,  <?php echo $count_authen[1] ; ?>, <?php echo $count_authen_null[1] ; ?>],
            ['ก.พ.',  <?php echo $count_all[2] ; ?>,  <?php echo $count_authen[2] ; ?>,  <?php echo $count_authen_null[2] ; ?>],
            ['มี.ค.',  <?php echo $count_all[3] ; ?>, <?php echo $count_authen[3] ; ?>,  <?php echo $count_authen_null[3] ; ?>],
            ['เม.ย.', <?php echo $count_all[4] ; ?>, <?php echo $count_authen[4] ; ?>,  <?php echo $count_authen_null[4] ; ?>],
            ['พ.ค.', <?php echo $count_all[5] ; ?>, <?php echo $count_authen[5] ; ?>,  <?php echo $count_authen_null[5] ; ?>],
            ['มิ.ย.', <?php echo $count_all[6] ; ?>, <?php echo $count_authen[6] ; ?>,  <?php echo $count_authen_null[6] ; ?>],
            ['ก.ค.', <?php echo $count_all[7] ; ?>, <?php echo $count_authen[7] ; ?>,  <?php echo $count_authen_null[7] ; ?>],
            ['ส.ค.', <?php echo $count_all[8] ; ?>, <?php echo $count_authen[8] ; ?>,  <?php echo $count_authen_null[8] ; ?>],
            ['ก.ย.', <?php echo $count_all[9] ; ?>, <?php echo $count_authen[9] ; ?>,  <?php echo $count_authen_null[9] ; ?>]
        ]);
        
        var options = {
          title : 'คนไข้ที่มารับบริการ OPD ยกเว้นแผนก 011,036,107 และยกเว้นสิทธิ์ M1-M6,13,23,91,X7',
          vAxis: {title: 'จำนวน Visit'},
          hAxis: {title: 'เดือน'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  
 </script>


    {{-- <script>
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
                                label: ['ขอ Authen Code'],
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
                            scales: { 
                                y: {
                                    beginAtZero: true 
                                }
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


            // const ctx2 = document.getElementById('myChartTuaton'); 
            
            // new Chart(ctx2, {
            //     type: 'doughnut',
            //     data: {
            //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            //         datasets: [{
            //             label: '# of Votes',
            //             data: [65, 59, 80 ],
            //             backgroundColor: [
            //             'rgb(255, 99, 132)',
            //             'rgb(54, 162, 235)',
            //             'rgb(255, 205, 86)'
            //             ], 
            //         }]
            //     },
            //     options: {
            //         responsive: true,
            //         plugins: {
            //         legend: {
            //             position: 'top',
            //         },
            //         title: {
            //             display: true,
            //             text: 'Chart.js Doughnut Chart'
            //         }
            //         }
            //     },
            //     plugins:[ChartDataLabels],
            // });
        

            // var ctxbuble = document.getElementById("myChartTuaton").getContext("2d");

            // fetch("{{ route('claim.check_buble') }}")
            //     .then(response => response.json())
            //     .then(json => {
            //         const myChartTuaton = new Chart(ctxbuble, {
            //             type: 'doughnut',
            //             data: {
            //                 labels: json.label,
            //                 datasets: json.Dataset3,

            //             },
            //             options: {
            //                 responsive: true,
            //                 plugins: {
            //                 legend: {
            //                     position: 'top',
            //                 },
            //                 title: {
            //                     display: true,
            //                     text: 'Chart.js Bubble Chart'
            //                 }
            //                 }
            //             },
            //             plugins:[ChartDataLabels],
            //         })
            //     });

        });
    </script>
    <script>
        var xmlshttp = new XMLHttpRequest();
            var url = "{{ route('claim.check_buble') }}";
            xmlshttp.open("GET", url, true);
            xmlshttp.send();
            xmlshttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas);
                    count = datas.Dataset3.map(function(e) {
                        return e.count;
                    });

                    label = datas.Dataset3.map(function(e) {
                        return e.label;
                    });
                   // setup 
                   const data = {
                        labels: label ,
                        datasets: [                        
                            { 
                                data: count,
                                backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(247, 161, 195)',
                                'rgb(198, 227, 52)',
                                'rgb(52, 227, 198)',
                                'rgb(63, 87, 209)',
                                'rgb(102, 94, 242)',
                                'rgb(143, 94, 242)',
                                'rgb(250, 101, 90)',
                                'rgb(209, 207, 63)'
                                ], 
                     
                            } 
                            
                        ]
                    };
             
                    const config = {
                        type: 'doughnut',
                        data,
                        options: {
                            responsive: true,
                            plugins: {
                            legend: {
                                position: 'top',
                            },
                            // title: {
                            //     display: true,
                            //     text: 'แยกตามวิธีการพิสูจน์ตัวตน'
                            // }
                            }
                        },
                        
                        plugins:[ChartDataLabels],
                        
                    };
                    
                    // render init block
                    const myChart = new Chart(
                        document.getElementById('myChartTuaton'),
                        config
                    );
                }
             }
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
                    },
                    plugins:[ChartDataLabels],
                })
            });
            
    </script> --}}
     
    
@endsection
