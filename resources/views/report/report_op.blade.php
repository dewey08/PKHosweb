@extends('layouts.pkclaim')

@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    
</script>
<style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
</style>
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
<?php
    use App\Http\Controllers\karnController;
    use Illuminate\Support\Facades\DB;
?>
  <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">รายงานผู้ป่วยนอกแยกสิทธิ์การรักษา</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">รายงานผู้ป่วยนอกแยกสิทธิ์การรักษา</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">                     
                        <div class="card-body py-0 px-2 mt-2"> 
                                <div class="table-responsive">
                                    {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">   
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">ปี</th>
                                                <th class="text-center">จำนวนผู้ป่วยทั้งหมด(ครั้ง)</th>
                                                <th class="text-center">บัตรทอง UC</th>
                                                <th class="text-center">ข้าราชการ OFC</th>
                                                <th class="text-center">ข้าราชการ LGO</th>
                                                <th class="text-center">ประกันสังคม SSS</th>
                                                <th class="text-center">ต่างด้าว NRD</th>
                                                <th class="text-center">สถานะสิทธฺ์ STP</th>
                                                <th class="text-center">ครูเอกชน PVT</th>
                                                <th class="text-center">คนไทยในต่างประเทศFRG</th>
                                                <th class="text-center">ผู้ประกันตนคนพิการDIS</th>
                                                <th class="text-center">ชำระเงิน/สงเคราะห์</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($datashow as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->datesave }}</td>
                                                <td>{{ $item->totol }}</td>
                                                <td>{{ $item->ucs }}</td>
                                                <td>{{ $item->ofc }}</td>
                                                <td>{{ $item->lgo }}</td>
                                                <td>{{ $item->sss }}</td>
                                                <td>{{ $item->nrd }}</td>
                                                <td>{{ $item->stp }}</td>
                                                <td>{{ $item->pvt }}</td>
                                                <td>{{ $item->frg }}</td>
                                                <td>{{ $item->dis }}</td>
                                                <td>{{ $item->other }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> 
                        </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase"> Chart รายงานผู้ป่วยนอกแยกสิทธิ์การรักษา</h6>
                <hr />
                <div class="card shadow">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="chart-container-fluid">
                            {{-- <canvas id="myChart" width="400" height="400"></canvas> --}}
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> 
    @endsection
    @section('footer')
        <script src="{{ asset('js/chart.min.js') }}"></script>
        <script src="{{ asset('js/dist-chart.min.js') }}"></script>
    
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#btn-click').click(function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
            });
        </script>
    
        <script>
            var xmlhttp = new XMLHttpRequest();
            var url = "{{ route('rep.report_op_getbar') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas);
                    label = datas.chartData_year.map(function(e) {
                        return e.label;
                    });
                    console.log(label);

                    totol = datas.chartData_year.map(function(e) {
                        return e.totol;
                    }); 
                    ucs = datas.chartData_year.map(function(e) {
                        return e.ucs;
                    }); 
                    ofc = datas.chartData_year.map(function(e) {
                        return e.ofc;
                    });
                    console.log(ofc);

                    lgo = datas.chartData_year.map(function(e) {
                        return e.lgo;
                    }); 
                    sss = datas.chartData_year.map(function(e) {
                        return e.sss;
                    });
                    console.log(sss);

                    nrd = datas.chartData_year.map(function(e) {
                        return e.nrd;
                    }); 
                    stp = datas.chartData_year.map(function(e) {
                        return e.stp;
                    }); 
                    pvt = datas.chartData_year.map(function(e) {
                        return e.pvt;
                    }); 
                    frg = datas.chartData_year.map(function(e) {
                        return e.frg;
                    }); 
                    dis = datas.chartData_year.map(function(e) {
                        return e.dis;
                    }); 
                    other = datas.chartData_year.map(function(e) {
                        return e.other;
                    }); 
                    // setup 
                    const data = {
                        labels: label ,
                        datasets: [
                            {
                            label: ['จำนวนผู้ป่วยทั้งหมด(ครั้ง)'],
                            data: totol,
                            backgroundColor: [
                                'rgba(255, 26, 104, 0.2)'                               
                            ],
                            borderColor: [
                                'rgba(255, 26, 104, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                            {
                            label: 'บัตรทอง UC',
                            data: ucs,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.5)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1,
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น  
                        },
                        {
                            label: 'ข้าราชการ LGO',
                            data: lgo,
                            backgroundColor: [
                                'rgba(54, 12, 35, 0.5)'
                            ],
                            borderColor: [
                                'rgba(54, 12, 35, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                        {
                            label: 'ประกันสังคม SSS',
                            data: sss,
                            backgroundColor: [
                                'rgba(514, 162, 35, 0.5)'
                            ],
                            borderColor: [
                                'rgba(514, 162, 35, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                        {
                            label: 'ต่างด้าว NRD',
                            data: nrd,
                            backgroundColor: [
                                'rgba(4, 12, 35, 0.5)'
                            ],
                            borderColor: [
                                'rgba(4, 12, 35, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                        {
                            label: 'สถานะสิทธฺ์ STP',
                            data: stp,
                            backgroundColor: [
                                'rgba(4, 12, 135, 0.5)'
                            ],
                            borderColor: [
                                'rgba(4, 12, 135, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                        {
                            label: 'ครูเอกชน PVT',
                            data: pvt,
                            backgroundColor: [
                                'rgba(74, 12, 35, 0.5)'
                            ],
                            borderColor: [
                                'rgba(74, 12, 35, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                        {
                            label: 'คนไทยในต่างประเทศFRG',
                            data: frg,
                            backgroundColor: [
                                'rgba(474, 12, 35, 0.5)'
                            ],
                            borderColor: [
                                'rgba(474, 12, 35, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                        {
                            label: 'ผู้ประกันตนคนพิการDIS',
                            data: dis,
                            backgroundColor: [
                                'rgba(474, 12, 35, 0.5)'
                            ],
                            borderColor: [
                                'rgba(474, 12, 35, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        },
                        {
                            label: 'ชำระเงิน/สงเคราะห์',
                            data: other,
                            backgroundColor: [
                                'rgba(474, 12, 535, 0.5)'
                            ],
                            borderColor: [
                                'rgba(474, 12, 535, 1)'
                            ],
                            borderWidth: 1, 
                            barPercentage: 0.8 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                        }


                    ]
                    };
    
                    // config 
                    const config = {
                        // type: 'line',
                        type: 'bar',
                        data,
                        options: {
                            // indexAxis: 'y',
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    };
    
                    // render init block
                    const myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
    
                }
            }
        </script>
    @endsection
