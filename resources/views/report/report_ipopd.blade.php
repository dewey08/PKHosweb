{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.user')
@section('title','PKClaim || ผู้ใช้งานทั่วไป')
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
                    <h4 class="mb-sm-0">Refer in จากสถานพยาบาลอื่น แยกตาม OPD,IPD </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">Refer in จากสถานพยาบาลอื่น แยกตาม OPD,IPD</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
 
                <form action="{{ route('report.report_ipopd')}}" method="post">
                    @csrf
              

                <div class="row">                   
                        <div class="col"></div>
                        <div class="col-md-1 text-end">ปีงบประมาณ</div>
                        <div class="col-md-2 text-center">
                            <select id="year_id" name="q" type="text" class="form-control"  > 
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

 
        <div class="row">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase"> Refer in จากสถานพยาบาลอื่น แยกตาม OPD,IPD ปี {{$year_ids}}</h6>
                <hr />
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">hospcode</th>
                                        <th class="text-center">name</th>
                                        <th class="text-center">ipd</th>
                                        <th class="text-center">opd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashowipopd as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->hospcode }}</td>
                                            <td> {{ $item->name }}</td>
                                            <td>{{ $item->ipd }} </td>
                                            <td>{{ $item->opd }} </td>
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
