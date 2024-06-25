@extends('layouts.pkreport')

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
                    <h4 class="mb-sm-0">Report</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">รายงานเรียกเก็บสิทธิรัฐวิสาหกิจ</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pb-0"> 
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-md-2">
                                <input type="date" name="startdate" id="startdate" class="form-control"> 
                            </div>
                            <div class="col-md-1 text-center"> 
                                <label for=""> ถึง </label> 
                            </div>
                            <div class="col-md-2"> 
                                <input type="date" name="enddate" id="enddate" class="form-control"> 
                            </div>
                            <div class="col-md-2"> 
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                                    ค้นหา
                                </button>
                            </div>
                            <div class="col"></div>
                        </div>

                        <div class="card-body py-0 px-2"> 
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                        id="example">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">เดือน</th>
                                                <th class="text-center">จำนวนผู้ป่วยคน</th>
                                                <th class="text-center">จำนวนผู้ป่วยครั้ง</th>
                                                <th class="text-center">จำนวนผู้ป่วยสิทธิ Covid</th>
                                                <th class="text-center">จำนวนที่เบิก</th>
                                                <th class="text-center">จำนวนที่รบชดเชยจาก STM</th>
                                                <th class="text-center">จำนวนที่ไม่ได้เบิก</th>
                                                <th class="text-center">U071</th>
                                                <th class="text-center">ค่าใช้จ่าย HOSxP</th>
                                                <th class="text-center">ชำระเอง</th>
                                                <th class="text-center">ลูกหนี้</th>
                                                <th class="text-center">เบิกชดเชย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($datashow as $item)
                                                <tr id="sid ">
                                                    <td class="text-center"> {{ $i++ }}</td>
                                                    @if ($item->monthshow == '1')
                                                        <td class="p-2">มกราคม </td>
                                                    @elseif ($item->monthshow == '2')
                                                        <td class="p-2">กุมภาพันธ์ </td>
                                                    @elseif ($item->monthshow == '3')
                                                        <td class="p-2">มีนาคม </td>
                                                    @elseif ($item->monthshow == '4')
                                                        <td class="p-2">เมษายน </td>
                                                    @elseif ($item->monthshow == '5')
                                                        <td class="p-2">พฤษภาคม </td>
                                                    @elseif ($item->monthshow == '6')
                                                        <td class="p-2">มิถุนายน </td>
                                                    @elseif ($item->monthshow == '7')
                                                        <td class="p-2">กรกฎาคม </td>
                                                    @elseif ($item->monthshow == '8')
                                                        <td class="p-2">สิงหาคม </td>
                                                    @elseif ($item->monthshow == '9')
                                                        <td class="p-2">กันยายน </td>
                                                    @elseif ($item->monthshow == '10')
                                                        <td class="p-2">ตุลาคม </td>
                                                    @elseif ($item->monthshow == '11')
                                                        <td class="p-2">พฤษจิกายน </td>
                                                    @else
                                                        <td class="p-2">ธันวาคม </td>
                                                    @endif

                                                    <td class="p-2">{{ $item->vhn }}</td>
                                                    <td class="p-2">{{ $item->vvn }}</td>
                                                    <td class="p-2">{{ $item->pt }}</td>
                                                    <td class="text-center">{{ $item->vnn }} </td>
                                                    <td class="text-center">{{ $item->mmvn }}</td>
                                                    <td class="text-center">{{ $item->aftercount }}</td>
                                                    <td class="text-center">{{ $item->ii }}</td>
                                                    <td class="text-center">{{ $item->inco }}</td>
                                                    <td class="text-center">{{ $item->paid }}</td>
                                                    <td class="text-center">{{ $item->uc }}</td>
                                                    <td class="text-center">{{ $item->amon }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
