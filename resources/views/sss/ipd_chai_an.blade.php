@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || ประกันสังคม')
@section('content')
{{-- <script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }    
</script> --}}
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
     
    <div class="row mt-3">
        <h5 class="mb-sm-0">รายงานข้อมููลสิทธิ ปกส.ชัยภูมิ IPD</h5>
        <div class="col-xl-12 mt-2">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">AN</th>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">เลขบัตรประชาชน</th>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">วันเกิด</th>
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">เวลารับบริการ</th>
                                    <th class="text-center">แผนก</th> 
                                    <th class="text-center">วันที่จำหน่าย</th> 
                                    <th class="text-center">เวลาจำหน่าย</th> 
                                    <th class="text-center">แผนกที่จำหน่าย</th> 
                                    <th class="text-center">สถานภาพการจำหน่าย</th> 
                                    <th class="text-center">ประเภทการจำหน่าย</th> 
                                    <th class="text-center">ICD</th> 
                                    <th class="text-center">ค่าใช้จ่าย</th> 
                                    <th class="text-center">สิทธิ</th> 
                                    <th class="text-center">แพทย์</th> 
                                    <th class="text-center">licenseno</th> 
                                    <th class="text-center">Claimno</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item)                                            
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td>  {{ $item->hn }} </td> 
                                            <td>  {{ $item->an }} </td> 
                                            <td>{{ $item->fullname }} </td>     
                                            <td class="text-center">{{ $item->cid }}</td>                                                       
                                            <td>{{ $item->birth }}</td>  
                                            <td>{{ $item->regdate }} </td> 
                                            <td>{{ $item->regtime }} </td> 
                                            <td>{{ $item->wardname }} </td> 
                                            <td class="text-center">{{ $item->dchdate }}</td> 
                                            
                                            <td>{{ $item->dchtime }} </td> 
                                            <td>{{ $item->payward }} </td> 
                                            <td>{{ $item->status }} </td> 
                                            <td>{{ $item->typename }} </td> 
                                            <td>{{ $item->pdx }} </td> 
                                            <td>{{ $item->income }} </td> 
                                            <td>{{ $item->pttype }} </td> 
                                            <td>{{ $item->doctor }} </td> 
                                            <td>{{ $item->licenseno }} </td> 
                                            <td>{{ $item->claim_code }} </td> 
                                            <td>{{ $item->Claimno }} </td>   
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

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>

@endsection
