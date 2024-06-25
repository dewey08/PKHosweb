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

        .chartgooglebar {
            width: auto;
            height: auto;
        }

        .chartgoogle {
            width: auto;
            height: auto;
        }
    </style>

    
    <div class="tabs-animation">

        


        <div class="row">
            <div class="col-md-6">
                <div class="main-card mb-3 card">
                    <div class="card-body" >
                        <h5 class="card-title">Authen Report Month</h5>
                        <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                            <div style="height: auto;">
                                {{-- <canvas id="Mychart"></canvas> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3 widget-chart widget-chart2 bg-warm-flame text-start">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content text-white">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title">คนไข้ที่มาใช้บริการ/วัน</div>
                                        <div class="widget-subtitle text-white">คิดเป็นเปอร์เซ็นต์</div>
                                    </div>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers">
                                            {{ $vn }} 
                                            <small> </small>
                                        </div>
                                        <div class="widget-description ms-auto text-white">
                                            <i class="fa fa-angle-up "></i>
                                            @if ($vn == '0')
                                                <span class="ps-1">0 %</span>
                                            @else
                                                <span class="ps-1">100 %</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-sm progress-bar-animated-alt progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="65" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="progress-sub-label text-white">นับรวมทุก Visit</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3 widget-chart widget-chart2 bg-plum-plate text-start">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content text-white">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title">KIOSK / วัน</div>
                                        <div class="widget-subtitle text-white opacity-7">คิดเป็นเปอร์เซ็นต์</div>
                                    </div>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers">
                                            {{ $Kios }} 
                                            <small> </small>
                                        </div>
                                        <div class="widget-description ms-auto text-white">
        
                                            @if ($Kios == '0')
                                                <span class="pe-1">0 %</span>
                                            @else
                                                {{-- <span class="pe-1">{{ number_format($countkiosallst, 2) }} %</span> --}}
                                            @endif
                                            <i class="fa fa-angle-up "></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-sm progress-bar-animated-alt progress">
                                        {{-- @if ($countkiosalls == '0')
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            </div>
                                        @else
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                aria-valuenow="{{ number_format($countkiosallst, 0) }}" aria-valuemin="0"
                                                aria-valuemax="100" style="width:{{ number_format($countkiosallst, 0) }}%;">
                                            </div>
                                        @endif --}}
        
                                    </div>
                                    <div class="progress-sub-label text-white">นับรวมทุก Visit</div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3 widget-chart widget-chart2 bg-mixed-hopes text-start">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content text-white">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title">เจ้าหน้าที่ / วัน</div>
                                        <div class="widget-subtitle text-white">คิดเป็นเปอร์เซ็นต์</div>
                                    </div>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers text-warning">
                                            {{($vn - $Kios) }}
                                            <small> </small>
                                        </div>
                                        <div class="widget-description ms-auto text-white">
                                            <i class="fa fa-arrow-right "></i>
                                            @if ($vn - $Kios == '0')
                                                <span class="ps-1">0 %</span>
                                            @else
                                                {{-- <span class="ps-1">{{ number_format($countonuserst, 2) }} %</span> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-sm progress-bar-animated-alt progress">
        
                                        {{-- @if ($countonuserst == '0')
                                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                            </div>
                                        @else
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                aria-valuenow="{{ number_format($countonuserst, 0) }}" aria-valuemin="0"
                                                aria-valuemax="100" style="width: {{ number_format($countonuserst, 0) }}%;">
                                            </div>
                                        @endif --}}
                                    </div>
                                    <div class="progress-sub-label text-white">นับรวมทุก Visit</div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="card mb-3 widget-chart widget-chart2 bg-tempting-azure text-start">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content text-dark">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title">Authen Success</div>
                                        <div class="widget-subtitle text-dark">คิดเป็นเปอร์เซ็นต์</div>
                                    </div>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers">
                                            {{ $Success }}
                                            <small> </small>
                                        </div>
                                        <div class="widget-description ms-auto text-dark">
        
                                            {{-- @if ($Success == '0')
                                                <span class="pe-1">0 %</span>
                                            @else
                                                <span class="ps-1">{{ number_format($count_successt, 0) }} %</span>
                                            @endif --}}
                                            <i class="fa fa-arrow-left "></i>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="widget-progress-wrapper">
                                    <div class="progress-bar-sm progress-bar-animated-alt progress">
        
                                        {{-- @if ($count_success == '0')
                                            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                                            </div>
                                        @else
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                aria-valuenow="{{ number_format($count_successt, 0) }}" aria-valuemin="0"
                                                aria-valuemax="100"
                                                style="width: {{ number_format($count_successt, 0) }}%;">
                                            </div>
                                        @endif --}}
                                    </div>
                                    <div class="progress-sub-label text-white">นับรวมทุก Visit</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

       
    </div>

    <div class="row">
 
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Authen Report Days</h5>
                    <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                        <div style="height: auto;">
                            {{-- <canvas id="MychartDays"></canvas> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card">
                <div class="card-body table-responsive">
                    <div class="card-title">รายงานแยกตามแผนก</div>
                    <table class="table table-bordered table-hover table-stripe">
                        <thead>
                            <th class="text-center">ลำดับ</th>
                            <th class="text-center">แผนก</th>
                            <th class="text-center">จำนวน</th> 
                            <th class="text-center">
                                <label for="" style="color:green"> Authen Code Success</label>
                            </th>
                            <th class="text-center">
                                <label for="" style="color:red"> Authen Code Unsuccessful</label>
                            </th>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $date = date('Y-m-d');
                            ?>
                            @foreach ($data_dep as $item)
                                <?php
                                $count_authen_codedata = DB::connection('mysql3')->select('
                                    SELECT COUNT(DISTINCT o.vn) as VN                                       
                                        FROM ovst o 
                                        LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                                        LEFT OUTER JOIN patient p on p.hn=o.hn
                                        LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = p.cid and wr.claimDate = o.vstdate
                                        LEFT OUTER JOIN opduser op on op.loginname = o.staff
                                        WHERE o.vstdate = CURDATE() and sk.depcode = "'.$item->main_dep.'"
                                        AND wr.claimCode is not null
                                        AND wr.tel is not null
                                ');
                                foreach ($count_authen_codedata as $key => $value) {
                                    $count_authen_codes = $value->VN;
                                }
                                $count_authen_code = $count_authen_codes;
                                 
                                $count_authen_codeunsuccess = $item->VN - $count_authen_code;
                                ?>
                                <tr id="sid{{ $item->main_dep }}">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="p-2">
                                        <button type="button" class="btn authen_detail" value="{{ $item->main_dep }}">{{ $item->department }}</button>                                            
                                    </td>
                                    <td class="text-center">{{ $item->VN }}</td> 
                                    <td class="text-center"> 
                                            <label for="" style="color:green"> {{ $count_authen_code }}</label>
                                    </td>
                                    <td class="text-center" >
                                        <label for="" style="color:red;">
                                            {{ $count_authen_codeunsuccess }} </label>
                                    </td>
                                </tr>
 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('footer')
    <script>
         $(document).on('click', '.authen_detail', function() {
            var dep = $(this).val(); 
            $('#authen_detailModal').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ url('authen_detail') }}" + '/' + dep,
                success: function(result) { 
                    $('#detail').html(result);
                },
            });
        });
 
    </script>
        {{-- <script>
            var ctx = document.getElementById("Mychart").getContext("2d");
    
                fetch("{{ route('authen_getbar') }}")
                    .then(response => response.json())
                    .then(json => {
                        const Mychart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: json.labels,
                                    datasets: json.datasets,
                                
                                },
                                options:{
                                    scales:{
                                        y:{
                                            beginAtZero:true
                                        }
                                    }
                                }
                            }) 
                    });        
     
        </script>
         <script>
            var ctx2 = document.getElementById("MychartDays").getContext("2d");
    
                fetch("{{ route('authen_getbar_days') }}")
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
                                            // beginAtZero:true
                                            stacked: true
                                        }
                                    }
                                }
                            }) 
                    });        
     
        </script> --}}
        
@endsection

   