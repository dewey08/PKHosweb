{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.user')
@section('title', 'PKClaim || ผู้ใช้งานทั่วไป')
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
                    <h4 class="mb-sm-0">รายงานการลงข้อมูล Refer </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">รายงานการลงข้อมูล Refer </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('report.report_refer_main_rep') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-md-1 text-end">ปีงบประมาณ</div>
                        <div class="col-md-2 text-center">
                            <select id="year_id" name="year_id" class="form-control" style="width: 100%">
                                <option value=""></option>
                                @foreach ($year as $ye)
                                    <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                        </div>
                        <div class="col"></div>
                </form>
            </div>


        </div>
    </div>


    {{-- <div class="row mt-3">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase"> รายงานการลงข้อมูลรับกลับ Refer IPD ปี {{$year_ids}}</h6>
                <hr />
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">เดือน</th>
                                        <th class="text-center">จำนวนผู้ป่วย (คน)</th>
                                        <th class="text-center">จำนวนผู้ป่วย OPD (ครั้ง)</th>
                                        <th class="text-center">จำนวนผู้ป่วย IPD (ครั้ง)</th>
                                        <th class="text-center">IMC STROKE</th>
                                        <th class="text-center">IMC TRAUMATIC BRAIN</th>
                                        <th class="text-center">IMC SPINAL CORD INJURY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow_oipd as $item3)
                                        <tr>
                                            <td>{{ $i++ }}</td>

                                            @if ($item3->months == '1')
                                                <td width="15%">มกราคม</td>
                                            @elseif ($item3->months == '2')
                                                <td width="15%">กุมภาพันธ์</td>
                                            @elseif ($item3->months == '3')
                                                <td width="15%">มีนาคม</td>
                                            @elseif ($item3->months == '4')
                                                <td width="15%">เมษายน</td>
                                            @elseif ($item3->months == '5')
                                                <td width="15%">พฤษภาคม</td>
                                            @elseif ($item3->months == '6')
                                                <td width="15%">มิถุนายน</td>
                                            @elseif ($item3->months == '7')
                                                <td width="15%">กรกฎาคม</td>
                                            @elseif ($item3->months == '8')
                                                <td width="15%">สิงหาคม</td>
                                            @elseif ($item3->months == '9')
                                                <td width="15%">กันยายน</td>
                                            @elseif ($item3->months == '10')
                                                <td width="15%">ตุลาคม</td>
                                            @elseif ($item3->months == '11')
                                                <td width="15%">พฤษจิกายน</td>
                                            @else
                                                <td width="15%">ธันวาคม</td>
                                            @endif
                                            <td>{{ $item3->HN }}</td>
                                            <td>
                                                <a href="{{url('report_refer_mainsub_checkopd/'.$item3->months.'/'.$year_ids)}}" target="_blank">{{ $item3->VN }}</a>   
                                            </td>
                                            <td>
                                                <a href="{{url('report_refer_mainsub_checkipd/'.$item3->months.'/'.$year_ids)}}" target="_blank">{{ $item3->AN }}</a> 
                                               
                                                </td>
                                            <td>
                                                <a href="{{url('report_refer_mainsub_checkimcstork/'.$item3->months.'/'.$year_ids)}}" target="_blank">{{ $item3->IMC }}</a> 
                                                
                                            </td>
                                            <td>
                                                <a href="{{url('report_refer_mainsub_checkimcbrain/'.$item3->months.'/'.$year_ids)}}" target="_blank">{{ $item3->IMC_BRAIN }}</a> 
                                               
                                            </td>
                                            <td>
                                                <a href="{{url('report_refer_mainsub_checkinjury/'.$item3->months.'/'.$year_ids.'/'.$item3->I2AN)}}" target="_blank">{{ $item3->IMC_INJURY }}</a> 
                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div> --}}

    <div class="row mt-3">
        <div class="col-xl-12">
            <h6 class="mb-0 text-uppercase"> รายงานการลงข้อมูลรับ Refer IPD </h6>
            <hr />
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">จำนวนผู้ป่วย (คน)</th>
                                    <th class="text-center">จำนวนผู้ป่วย OPD (ครั้ง)</th>
                                    <th class="text-center">จำนวนผู้ป่วย IPD (ครั้ง)</th>
                                    <th class="text-center">IMC STROKE</th>
                                    <th class="text-center">IMC TRAUMATIC BRAIN</th>
                                    <th class="text-center">IMC SPINAL CORD INJURY</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow_repoipd as $item4)
                                    <tr>
                                        <td>{{ $i++ }}</td>

                                        @if ($item4->months == '1')
                                            <td width="15%">มกราคม</td>
                                        @elseif ($item4->months == '2')
                                            <td width="15%">กุมภาพันธ์</td>
                                        @elseif ($item4->months == '3')
                                            <td width="15%">มีนาคม</td>
                                        @elseif ($item4->months == '4')
                                            <td width="15%">เมษายน</td>
                                        @elseif ($item4->months == '5')
                                            <td width="15%">พฤษภาคม</td>
                                        @elseif ($item4->months == '6')
                                            <td width="15%">มิถุนายน</td>
                                        @elseif ($item4->months == '7')
                                            <td width="15%">กรกฎาคม</td>
                                        @elseif ($item4->months == '8')
                                            <td width="15%">สิงหาคม</td>
                                        @elseif ($item4->months == '9')
                                            <td width="15%">กันยายน</td>
                                        @elseif ($item4->months == '10')
                                            <td width="15%">ตุลาคม</td>
                                        @elseif ($item4->months == '11')
                                            <td width="15%">พฤษจิกายน</td>
                                        @else
                                            <td width="15%">ธันวาคม</td>
                                        @endif
                                        <td>{{ $item4->HN }}</td>
                                        <td>
                                            <a href="{{ url('report_refer_mainsub_rep_opd/'.$item4->months.'/'.$year_ids) }}"
                                                target="_blank">{{ $item4->VN }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('report_refer_mainsub_rep_ipd/'.$item4->months.'/'.$year_ids) }}"
                                                target="_blank">{{ $item4->AN }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('report_refer_mainsub_rep_imcstork/'.$item4->months.'/'.$year_ids) }}"
                                                target="_blank"> {{ $item4->IMC }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('report_refer_mainsub_rep_imcbrain/'.$item4->months.'/'.$year_ids) }}"
                                                target="_blank">{{ $item4->IMC_BRAIN }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('report_refer_mainsub_rep_imcinjury/' . $item4->months . '/' . $year_ids) }}"
                                                target="_blank">{{ $item4->IMC_INJURY }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


    </div>
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('#year_id').select2({
                placeholder: "== เลือกปีที่ต้องการ ==",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
@endsection
