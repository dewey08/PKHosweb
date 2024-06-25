{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.user')
@section('title','PK-OFFICER || ผู้ใช้งานทั่วไป')
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
                    <h4 class="mb-sm-0">รายการยาเบิก</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">รายการยาเบิก</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
       
 
     
        <div class="row">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase">รายการยาเบิก</h6>
                <hr />
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th> 
                                        <th class="text-center">วันที่</th> 
                                        <th class="text-center">ชื่อ</th> 
                                        <th class="text-center">จำนวน</th> 
                                        <th class="text-center">ราคา/หน่วย</th>  
                                        <th class="text-center">ราคา</th>  
                                         
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td> 
                                            <td>{{ DateThai($item->vstdate) }}</td> 
                                            <td>{{ $item->name }}</td> 
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->price2 }}</td>   
                                            <td> {{$item->pricetotal}}</td>  
                                             
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
            
        });
    </script>
@endsection
