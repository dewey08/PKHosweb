@extends('layouts.backend_small')

<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">

@section('content')

<style>
    .center {
        margin: auto;
        width: 100%;
        padding: 10px;
    }

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;

    }

    label {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;

    }

    @media only screen and (min-width: 1200px) {
        label {
            float: right;
        }

    }

    .text-pedding {
        padding-left: 10px;
    }

    .text-font {
        font-size: 14px;
    }
</style>

<script>
    function checklogin() {
        window.location.href = '{{route("index")}}';
    }
</script>
<?php
if(Auth::check()){
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;
    $idsmallhos = Auth::user()->SMALL_ID; 
}else{
    echo "<body onload=\"checklogin()\"></body>";
    exit();
}

$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos);



use App\Http\Controllers\WarehouseController;

$checkagree = WarehouseController::agree($user_id);

?>
<?php
function RemoveDateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }


  function Removeformate($strDate)
{
  $strYear = date("Y",strtotime($strDate));
  $strMonth= date("m",strtotime($strDate));
  $strDay= date("d",strtotime($strDate));


  return $strDay."/".$strMonth."/".$strYear;
  }


?>
<!-- Advanced Tables -->
<div class="bg-body-light">
    <div class="block-header block-header-default">
        <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลสถานะคลังพัสดุ</B></h3>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <div class="row">
                    {{-- <div>
                        <a href="{{ url('smallhos_warehouse/dashboard/'.$idsmallhos) }}"
                            class="btn btn-warning loadscreen">Dashboard</a>
                    </div>
                    <div>&nbsp;</div> --}}

                    <div>
                        <a href="{{ url('smallhos_warehouse/smallwithdrawindex/'.$idsmallhos)}}"
                            class="btn loadscreen"
                            style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">เบิกจากคลังรพ.</a>
                    </div>
                    <div>&nbsp;</div>
                    <div>
                        <a href="{{ url('smallhos_warehouse/smallstockcard/'.$idsmallhos)}}"
                            class="btn loadscreen"
                            style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">คลังรพสต.

                            <span class="badge badge-light"></span>

                        </a>
                    </div>
                    <div>&nbsp;</div>
                    <div>
                        <a href="{{ url('smallhos_warehouse/smallpayindex/'.$idsmallhos)}}"
                            class="btn loadscreen"
                            style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">จ่ายวัสดุ</a>
                    </div>
                    <div>&nbsp;</div>


            </ol>

        </nav>
    </div>
</div>
<div class="block shadow" style="width:95%;margin:10px auto 10px;">
    <div class="block-content">
        <form action="{{ route('warehouse.dashboardsearch',[ 'iduser'=>1 ]) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-2 d-flex justify-content-center align-items-center fs-16">
                    &nbsp;ประจำปีงบประมาณ : &nbsp;
                </div>
                <div class="col-md-2">
                    <select name="STATUS_CODE" id="STATUS_CODE" class="form-control input-lg fs-16"
                        style=" font-family: 'Kanit', sans-serif;">
                        @foreach ($budgets as $budget)
                        @if($budget->LEAVE_YEAR_ID== $year_id)
                        <option value="{{ $budget->LEAVE_YEAR_ID  }}" selected>{{ $budget->LEAVE_YEAR_ID}}
                        </option>
                        @else
                        <option value="{{ $budget->LEAVE_YEAR_ID  }}">{{ $budget->LEAVE_YEAR_ID}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <span>
                        <button type="submit" class="btn btn-info fs-16">แสดง</button>
                    </span>
                </div>
            </div>
        </form>
        <div class="block-content mt-3 mb-4 shadow">
            <div class="row">
                <div class="col-md-4 col-xl-6">
                    <div class="block block-rounded bg-sl2-b3">
                        <div class="block-content block-content-full d-flex justify-content-between">
                            <div class="ml-2 left">
                                <p class="text-white mb-0 fs-16">
                                    ขอเบิกวัสดุ
                                </p>
                                <p class="text-white mb-0" style="font-size: 2.2rem;">
                                    <span class="fs-13">เรื่อง</span>
                                </p>
                            </div>
                            <div class="text-white text-center">
                                <i class="m-0 fa fa-2x fa fa-hand-holding text-white pt-2 pb-2 mr-3"></i> <br>
                                <!-- <p class="mb-0 fs-20">0.00%</p> -->
                            </div>
                        </div>
                    </div>
                </div>
         
                <div class="col-md-4 col-xl-6">
                    <div class="block block-rounded bg-sl2-g4">
                        <div class="block-content block-content-full d-flex justify-content-between">
                            <div class="ml-2 left">
                                <p class="text-white mb-0 fs-16">
                                อนุมัติจ่าย
                                </p>
                                <p class="text-white mb-0" style="font-size: 2.2rem;">
                                    <span class="fs-13">เรื่อง</span>
                                </p>
                            </div>
                            <div class="text-white text-center">
                                <i class="m-0 fa fa-2x fa fa-hand-point-up text-white pt-2 pb-2 mr-3"></i> <br>
                                <!-- <p class="mb-0 fs-20">0.00%</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="block-content mt-3 mb-4 shadow">
            <h3 class="block-title fs-18 fw-b">ข้อมูลแผนภูมิคลังวัสดุ</h3>
            <hr>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <!-- รูปแบบแสดง chart -->
                    <div class="panel p-1 bg-sl2-sb3">
                        <div class="pane-heading py-2 px-3 text-white fs-16" style="text-align:left">จำนวนมูลค่าการเบิกวัสดุของรพสต. ปีปัจจุบัน
                        </div>
                        <div class="pane-body bg-white d-flex justify-content-center" style="overflow-y:hidden">
                            <div id="columnchart_01" class="f-kanit" style="width: 100%;height:500px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <!-- รูปแบบแสดง chart -->
                    <div class="panel p-1 bg-sl2-sb3">
                        <div class="pane-heading py-2 px-3 text-white fs-16" style="text-align:left">จำนวนมูลค่าการจ่ายวัสดุของรพสต. ปีปัจจุบัน
                        </div>
                        <div class="pane-body bg-white d-flex justify-content-center" style="overflow-y:hidden">
                            <div id="columnchart_02" class="f-kanit" style="width: 100%;height:500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>

<script src="{{ asset('google/Charts.js') }}"></script>

<script type="text/javascript">

    google.load("visualization", "1", {
        packages: ["corechart"]
    });
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['เดือน', 'มูลค่า'],
            ['ต.ค', <?php echo $m10_1; ?> ],
            ['พ.ย', <?php echo $m11_1; ?> ],
            ['ธ.ค', <?php echo $m12_1; ?> ],
            ['ม.ค', <?php echo $m1_1; ?> ],
            ['ก.พ', <?php echo $m2_1; ?> ],
            ['มี.ค', <?php echo $m3_1; ?> ],
            ['เม.ย', <?php echo $m4_1; ?> ],
            ['พ.ค', <?php echo $m5_1; ?> ],
            ['มิ.ย', <?php echo $m6_1; ?> ],
            ['ก.ค', <?php echo $m7_1; ?> ],
            ['ส.ค', <?php echo $m8_1; ?> ],
            ['ก.ย', <?php echo $m9_1; ?> ],
        ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            }
        ]);
        var options = {
            fontName: 'Kanit',
            fontSize: 16,
            // colors: ['#82b54b'],
            legend: {
                position: 'center'
            },
            bar: {
                groupWidth: "80%"
            },
            vAxis: {
                title: 'บาท',
                titleTextStyle: {
                    italic: false
                }
            },
            hAxis: {
                title: 'เดือน',
                fontName: 'Kanit',
                titleTextStyle: {
                    italic: false
                }
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_01'));
        chart.draw(view, options);
    }

    google.setOnLoadCallback(drawChart2);
    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['เดือน', 'มูลค่า'],
            ['ต.ค', <?php echo $m10_1; ?> ],
            ['พ.ย', <?php echo $m11_1; ?> ],
            ['ธ.ค', <?php echo $m12_1; ?> ],
            ['ม.ค', <?php echo $m1_1; ?> ],
            ['ก.พ', <?php echo $m2_1; ?> ],
            ['มี.ค', <?php echo $m3_1; ?> ],
            ['เม.ย', <?php echo $m4_1; ?> ],
            ['พ.ค', <?php echo $m5_1; ?> ],
            ['มิ.ย', <?php echo $m6_1; ?> ],
            ['ก.ค', <?php echo $m7_1; ?> ],
            ['ส.ค', <?php echo $m8_1; ?> ],
            ['ก.ย', <?php echo $m9_1; ?> ],
        ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            }
        ]);
        var options = {
            fontName: 'Kanit',
            fontSize: 16,
            colors: ['#DC3912'],
            legend: {
                position: 'center'
            },
            bar: {
                groupWidth: "80%"
            },
            vAxis: {
                title: 'บาท',
                titleTextStyle: {
                    italic: false
                }
            },
            hAxis: {
                title: 'เดือน',
                fontName: 'Kanit',
                titleTextStyle: {
                    italic: false
                }
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_02'));
        chart.draw(view, options);
    }
</script>

@endsection