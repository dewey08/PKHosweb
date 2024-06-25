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
                    <h4 class="mb-sm-0"> รายงานการลงข้อมูล Refer </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active"> รายงานการลงข้อมูล Refer </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row mt-3">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase"> รายงานการลงข้อมูล Refer  
                    
                    
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
                                        <th class="text-center">HN</th>
                                        <th class="text-center">AN</th>
                                        <th class="text-center">เลขบัตรประชาชน</th>
                                        <th class="text-center">วันที่รับบริการ</th>
                                        <th class="text-center">ICD</th>
                                        <th class="text-center">ชื่อ-สกุล</th>
                                        <th class="text-center">สิทธิ์</th>

                                        <th class="text-center">รายการลงค่ารถ</th>
                                        <th class="text-center">จุดส่ง</th>
                                        <th class="text-center">มีพยาบาล</th>
                                        <th class="text-center">ใช้รถ</th> 
                                        <th class="text-center">ส่งไปที่</th> 
                                        <th class="text-center">ชดเชย</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($ipd_day as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>                                           
                                            <td> {{ $item->hn }}</td>  
                                            <td> {{ $item->an }}</td> 
                                            <td> {{ $item->cid }}</td> 
                                            <td>{{ DateThai($item->dchdate) }}</td>
                                            <td> {{ $item->pdx }}</td> 
                                            <td> {{ $item->fullname }}</td> 
                                            <td> {{ $item->pttype }}</td> 

                                            <td> {{ $item->icode }}</td> 
                                            <td> {{ $item->wardname }}</td> 
                                            <td> {{ $item->with_nurse }}</td>  
                                            <td>{{ $item->with_ambulance }}</td>  
                                            <td>{{ $item->hname }}</td> 
                                            <td>{{ $item->mmm }}</td>  
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
