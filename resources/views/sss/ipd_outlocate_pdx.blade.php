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
            <div class="col-xl-5">
                <div class="row mt-3">
                    <h5 class="mb-sm-0">รายการ icd10 ผู้ป่วยใน</h5>
                    <div class="col-xl-12 mt-2">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive"> 
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">ICD10&ICD9</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">diag type</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_outlocate_pdx_icd10 as $item)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item->icd10}}</td>  
                                                        <td>{{ $item->name }} </td>                                            
                                                        <td class="text-center" >{{ $item->diagtype }}</td>   
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
            <div class="col-xl-7">
                <div class="row mt-3">
                    <h5 class="mb-sm-0">รายการ icd9 ผู้ป่วยใน</h5>
                    <div class="col-xl-12 mt-2">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive"> 
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">ICD10&ICD9</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">diag type</th>
                                                <th class="text-center">วันที่เข้า</th>
                                                <th class="text-center">เวลาเข้า</th>
                                                <th class="text-center">วันที่ออก</th>
                                                <th class="text-center">เวลาออก</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_outlocate_pdx_icd9 as $item2)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item2->icd9}}</td>   
                                                        <td> {{ $item2->iname }} </td> 
                                                        <td>{{ $item2->priority }} </td>                                            
                                                        <td class="text-center" >{{ $item2->opdate }}</td>  
                                                        <td class="text-center">{{ $item2->optime }}</td>                                                       
                                                        <td>{{ $item2->enddate }} </td>  
                                                        <td>{{ $item2->endtime }} </td>   
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

        </div>
    </div>





@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
  
        });
    </script>

@endsection
