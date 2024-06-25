@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || ประกันสังคม')
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
    <div class="container-fluid">
     
    <div class="row mt-3">
        <h5 class="mb-sm-0"> รายงานจำนวนผู้ป่วยนอก ปกส.นอกเขต  </h5>
        <div class="col-xl-12 mt-2">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                            id="example"> --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">VN</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">PDX</th>
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">icode</th>
                                    <th class="text-center">อุปกรณ์</th>
                                    <th class="text-center">รหัส</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="text-center">ค่าใช้จ่าย HOSxP</th> 
                                    <th class="text-center">claim_code</th>
                                    <th class="text-center">nhso_docno</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item)                                            
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td>  {{ $item->vn }} </td> 
                                            <td>  {{ $item->hn }} </td> 
                                            <td>{{ $item->pdx }} </td>     
                                            <td class="text-center">{{ $item->vstdate }}</td>                                                       
                                            <td>{{ $item->fullname }}</td>  
                                            <td>{{ $item->icode }} </td> 
                                            <td>{{ $item->name }} </td> 
                                            <td>{{ $item->billcode }} </td> 
                                            <td>{{ $item->qty }} </td> 
                                            <td class="text-center">{{ $item->total }}</td>  
                                            <td class="p-2">{{ $item->claim_code }}</td> 
                                            <td class="p-2">{{ $item->nhso_docno }}</td>   
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
