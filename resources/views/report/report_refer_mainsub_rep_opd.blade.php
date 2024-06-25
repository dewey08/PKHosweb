{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.user')
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
                    <h4 class="mb-sm-0"> รายงานจำนวนผู้ป่วย OPD Refer </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active"> รายงานจำนวนผู้ป่วย OPD Refer </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row mt-3">
            <div class="col-xl-6">
                <h6 class="mb-0 text-uppercase"> รายงานการลงข้อมูล Refer OPD เดือน 
                    @if ($month == '1')
                    มกราคม
                    @elseif ($month == '2')
                    กุมภาพันธ์
                    @elseif ($month == '3')
                    มีนาคม
                    @elseif ($month == '4')
                    เมษายน
                    @elseif ($month == '5')
                    พฤษภาคม
                    @elseif ($month == '6')
                    มิถุนายน
                    @elseif ($month == '7')
                    กรกฎาคม
                    @elseif ($month == '8')
                    สิงหาคม
                    @elseif ($month == '9')
                    กันยายน
                    @elseif ($month == '10')
                    ตุลาคม
                    @elseif ($month == '11')
                    พฤษจิกายน
                    @else
                    ธันวาคม
                    @endif
                    
                </h6>
                <hr />
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center" width="50%">วันที่</th>
                                        <th class="text-center">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center" width="50%">{{ DateThai($item->vstdate) }}</td>
                                            <td class="text-center">{{ $item->VN }}</td>
                                            
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
            // $('#saveBtn').click(function() {
            //     // alert('OK');
            //     var year_id = $('#year_id').val();
            //     // alert(year_id);
            //     $.ajax({
            //                     url: "{{ route('report.report_refer_main') }}",
            //                     type: "POST",
            //                     dataType: 'json',
            //                     data: {                                 
            //                         year_id                               
            //                     },
            //                     success: function(data) {
            //                         if (data.status == 0) {                                      

            //                         } else {                                                                                       
            //                                     window.location
            //                                         .reload();                                          
            //                         }
            //                     },
            //                 });
            // });
        });
    </script>
@endsection
