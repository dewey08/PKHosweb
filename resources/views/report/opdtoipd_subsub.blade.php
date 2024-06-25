{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.pkclaim')
@section('title','PK-OFFICER || OPIP')
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
   <div class="tabs-animation">
  
        <div class="row mt-4">
            
            <div class="col-xl-12">
            
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-4 ms-2 me-2 mb-2">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">  รายการค่าใช้จ่าย</h4>
                                 
                            </div>
                            <div class="col"></div>
                            
                        </div>
                        <div class="table-responsive mt-2">
                            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสกรมบัญชีกลาง</th> 
                                        <th class="text-center">ชื่อ</th> 
                                        <th class="text-center">จำนวน</th> 
                                        <th class="text-center">ราคา</th> 
                                        <th class="text-center">เจ้าหน้าที่</th>  
                                        <th class="text-center">เวลา</th>  
                                        <th class="text-center">เวลา Admit</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item2->icode }}</td> 
                                            <td class="p-2">{{ $item2->dname }}</td> 
                                            <td class="text-center">{{ $item2->qty }}</td> 
                                            <td class="text-center">{{ $item2->price }}</td>  
                                            <td class="p-2"> {{ $item2->staff }} </td>  
                                            <td class="text-center">{{ $item2->rxtime }}</td> 
                                            <td class="text-center">{{ $item2->rxtimeadmit }}</td> 
                                             
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
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#ex_1').DataTable();
            $('#ex_2').DataTable();
            $('#ex_3').DataTable();
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('#pttype').select2({
                placeholder: "== เลือกสิทธิ์ต้องการ ==",
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
