@extends('layouts.pkclaim_refer')

@section('content')
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
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="row">
                            <div class="col-6 col-md-4 col-xl-2 mt-3">
                                <div class="card">
                                    <div class="card-body bg-light shadow-lg">
                                        <a href="{{ url('report_refer_2561') }}" class="nav-link text-dark text-center">
                                            <i class="fa-solid fa-2x fa-truck-medical text-info"></i>
                                            <br>
                                            <label for="" class="mt-2">2561</label>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl-2 mt-3">
                                <div class="card">
                                    <div class="card-body bg-light shadow-lg">
                                        <a href="{{ url('report_refer_2562') }}" class="nav-link text-dark text-center">
                                            <i class="fa-solid fa-2x fa-truck-medical text-primary"></i>
                                            <br>
                                            <label for="" class="mt-2">2562</label>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl-2 mt-3">
                                <div class="card">
                                    <div class="card-body bg-light shadow-lg">
                                        <a href="{{ url('report_refer_2563') }}" class="nav-link text-dark text-center">
                                            <i class="fa-solid fa-2x fa-truck-medical text-warning"></i>
                                            <br>
                                            <label for="" class="mt-2">2563</label>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl-2 mt-3">
                                <div class="card">
                                    <div class="card-body bg-light shadow-lg">
                                        <a href="{{ url('report_refer_2564') }}" class="nav-link text-dark text-center">
                                            <i class="fa-solid fa-2x fa-truck-medical text-success"></i>
                                            <br>
                                            <label for="" class="mt-2">2564</label>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl-2 mt-3">
                                <div class="card">
                                    <div class="card-body bg-light shadow-lg">
                                        <a href="{{ url('report_refer_2565') }}" class="nav-link text-dark text-center">
                                            <i class="fa-solid fa-2x fa-truck-medical text-danger"></i>
                                            <br>
                                            <label for="" class="mt-2">2565</label>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl-2 mt-3">
                                {{-- <div class="card">
                                        <div class="card-body bg-light shadow-lg">
                                            <a href="{{ url('admin/home') }}" class="nav-link text-dark text-center">
                                                <i class="fa-solid fa-3x fa-chart-line text-warning"></i>
                                                <br>
                                                <label for="" class="mt-2">2566</label>
                                            </a>
                                        </div>
                                    </div> --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <h6 class="mb-0 text-uppercase"> รายงานการลงข้อมูล Refer OPD</h6>
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
                                        <th class="text-center">จำนวนผู้ป่วย (ครั้ง)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow_opd as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>

                                            @if ($item->months == '1')
                                                <td>มกราคม</td>
                                            @elseif ($item->months == '2')
                                                <td>กุมภาพันธ์</td>
                                            @elseif ($item->months == '3')
                                                <td>มีนาคม</td>
                                            @elseif ($item->months == '4')
                                                <td>เมษายน</td>
                                            @elseif ($item->months == '5')
                                                <td>พฤษภาคม</td>
                                            @elseif ($item->months == '6')
                                                <td>มิถุนายน</td>
                                            @elseif ($item->months == '7')
                                                <td>กรกฎาคม</td>
                                            @elseif ($item->months == '8')
                                                <td>สิงหาคม</td>
                                            @elseif ($item->months == '9')
                                                <td>กันยายน</td>
                                            @elseif ($item->months == '10')
                                                <td>ตุลาคม</td>
                                            @elseif ($item->months == '11')
                                                <td>พฤษจิกายน</td>
                                            @else
                                                <td>ธันวาคม</td>
                                            @endif
                                            <td>{{ $item->hn }}</td>
                                            <td>{{ $item->vn }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-6">
                <h6 class="mb-0 text-uppercase"> รายงานการลงข้อมูล Refer IPD</h6>
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
                                        <th class="text-center">จำนวนผู้ป่วย (ครั้ง)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow_ipd as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            @if ($item2->months == '1')
                                                <td>มกราคม</td>
                                            @elseif ($item2->months == '2')
                                                <td>กุมภาพันธ์</td>
                                            @elseif ($item2->months == '3')
                                                <td>มีนาคม</td>
                                            @elseif ($item2->months == '4')
                                                <td>เมษายน</td>
                                            @elseif ($item2->months == '5')
                                                <td>พฤษภาคม</td>
                                            @elseif ($item2->months == '6')
                                                <td>มิถุนายน</td>
                                            @elseif ($item2->months == '7')
                                                <td>กรกฎาคม</td>
                                            @elseif ($item2->months == '8')
                                                <td>สิงหาคม</td>
                                            @elseif ($item2->months == '9')
                                                <td>กันยายน</td>
                                            @elseif ($item2->months == '10')
                                                <td>ตุลาคม</td>
                                            @elseif ($item2->months == '11')
                                                <td>พฤษจิกายน</td>
                                            @else
                                                <td>ธันวาคม</td>
                                            @endif
                                            <td>{{ $item2->HN }}</td>
                                            <td>{{ $item2->AN }}</td>

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
@endsection
