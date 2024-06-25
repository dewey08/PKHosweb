@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || KPI-งานประกัน')
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

<div class="container-fluid">
 
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Sales</p>
                            <h4 class="mb-2">1452</h4>
                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ri-shopping-cart-2-line font-size-24"></i>  
                            </span>
                        </div>
                    </div>                                            
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">New Orders</p>
                            <h4 class="mb-2">938</h4>
                            <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="mdi mdi-currency-usd font-size-24"></i>  
                            </span>
                        </div>
                    </div>                                              
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">New Users</p>
                            <h4 class="mb-2">8246</h4>
                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ri-user-3-line font-size-24"></i>  
                            </span>
                        </div>
                    </div>                                              
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Unique Visitors</p>
                            <h4 class="mb-2">29670</h4>
                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="mdi mdi-currency-btc font-size-24"></i>  
                            </span>
                        </div>
                    </div>                                              
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown">
                            <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">This Years<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">วันนี้</a>
                                <a class="dropdown-item" href="#">ย้อนหลัง 1 สัปดาห์</a>
                                <a class="dropdown-item" href="#">ย้อนหลัง 1 เดือน</a>
                                <a class="dropdown-item" href="#">ย้อนหลัง 1 ปี</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Revenue</h4>

                    {{-- <div class="text-center pt-3">
                        <div class="row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div>
                                    <h5>17,493</h5>
                                    <p class="text-muted text-truncate mb-0">Marketplace</p>
                                </div>
                            </div> 
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div>
                                    <h5>$44,960</h5>
                                    <p class="text-muted text-truncate mb-0">Last Week</p>
                                </div>
                            </div> 
                            <div class="col-sm-4">
                                <div>
                                    <h5>$29,142</h5>
                                    <p class="text-muted text-truncate mb-0">Last Month</p>
                                </div>
                            </div> 
                        </div> 
                    </div>
                </div> --}}
                <div class="card-body py-0 px-2">
                    {{-- <div id="column_line_chart" class="apex-charts" dir="ltr"></div> --}}
                    <div class="chart-container-fluid">
                      <canvas id="myChart" width="800" height="1200"></canvas>
                  </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->



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
     var url = "{{ route('claim.bk_getbar') }}";
     xmlhttp.open("GET", url, true);
     xmlhttp.send();
     xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
             var datas = JSON.parse(this.responseText);
             // console.log(datas);
             label = datas.chartData_dataset.map(function(e) {
                 return e.label;
             });
             // console.log(label);
             count = datas.chartData_dataset.map(function(e) {
                 return e.count;
             });
             // console.log(count);
             label_week = datas.chartData_dataset_week.map(function(e) {
                 return e.label_week;
             });
             console.log(label_week);
             count_week = datas.chartData_dataset_week.map(function(e) {
                 return e.count_week;
             });
             console.log(count_week);
             // setup 
             const data = {
                 labels: label ,
                 datasets: [                        
                 {
                     label: ['จำนวนคนที่มาย้อนหลัง 1 สัปดาห์'],
                     data: count_week,
                     backgroundColor: [
                         'rgba(255, 26, 104, 0.2)'
                         // 'rgba(54, 162, 235, 0.2)',
                         // 'rgba(255, 206, 86, 0.2)',
                         // 'rgba(75, 192, 192, 0.2)',
                         // 'rgba(153, 102, 255, 0.2)',
                         // 'rgba(255, 159, 64, 0.2)',
                         // 'rgba(155, 26, 104, 0.2)'
                     ],
                     borderColor: [
                         'rgba(255, 26, 104, 1)'
                        //  'rgba(54, 162, 235, 1)',
                        //  'rgba(255, 206, 86, 1)',
                        //  'rgba(75, 192, 192, 1)',
                        //  'rgba(153, 102, 255, 1)',
                        //  'rgba(255, 159, 64, 1)',
                        //  'rgba(155, 26, 104, 1)'
                     ],
                     borderWidth: 1,
                     barPercentage: 0.9 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น 
                 },
                 {
                     label: ['จำนวนคนที่มาย้อนหลัง 1 เดือน'],
                     data: count,
                     backgroundColor: [
                         // 'rgba(255, 26, 104, 0.5)',
                         'rgba(54, 162, 235, 0.5)'
                         // 'rgba(255, 206, 86, 0.5)',
                         // 'rgba(75, 192, 192, 0.5)',
                         // 'rgba(153, 102, 255, 0.5)',
                         // 'rgba(255, 159, 64, 0.5)',
                         // 'rgba(155, 26, 104, 0.2)'
                     ],
                     borderColor: [
                         // 'rgba(255, 26, 104, 1)',
                         'rgba(54, 162, 235, 1)'
                    //      // 'rgba(255, 206, 86, 1)',
                    //      // 'rgba(75, 192, 192, 1)',
                    //      // 'rgba(153, 102, 255, 1)',
                    //      // 'rgba(255, 159, 64, 1)',
                    //      // 'rgba(155, 26, 104, 1)'
                     ],
                     borderWidth: 1,
                     barPercentage: 0.9 // ตัวนี้จะเป็นขนาดความกว้างของ bar =.ถ้าปิดตัวนี้ bar จะใหญ่ขึ้น
                 }
             ]
             };

             // config 
             const config = {
                 type: 'bar',
                 data,
                 options: {
                     indexAxis: 'y',
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
