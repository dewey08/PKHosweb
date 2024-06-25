@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Report')
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

    <div class="row mt-3">
        <h5 class="mb-sm-0">Patient EMR 48-55</h5>
        <div class="col-xl-12 mt-2">
           
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive"> 
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">สิทธิ</th>
                                    <th class="text-center">ICD10</th>
                                    <th class="text-center">ค่าใช้จ่าย</th>
                                    <th class="text-center">อุปกรณ์</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_repipdsubsuban as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item->dchdate}}</td> 
                                        <td>{{$item->pttype}}</td> 
                                        <td>{{$item->pdx}}</td> 
                                        <td> {{ $item->income }} </td>
                                        <td>{{ $item->billcode }} </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-3">
        <h5 class="mb-sm-0">Patient EMR 56</h5>
        <div class="col-xl-12 mt-2">
           
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive"> 
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">สิทธิ</th>
                                    <th class="text-center">ICD10</th>
                                    <th class="text-center">ค่าใช้จ่าย</th>
                                    <th class="text-center">อุปกรณ์</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($Patient_emr56 as $item2)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item2->dchdate}}</td> 
                                        <td>{{$item2->pttype}}</td> 
                                        <td>{{$item2->pdx}}</td> 
                                        <td> {{$item2->income }} </td>
                                        <td>{{$item2->billcode }} </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- <div class="row mt-3">
        <h5 class="mb-sm-0">รายการค่าใช้จ่าย HOSxP</h5>
        <div class="col-xl-12 mt-2">
            
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive"> 
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">รหัสหมวด</th> 
                                    <th class="text-center">ชื่อ</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="text-center">เบิกได้</th> 
                                    <th class="text-center">เบิกไม่ได้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_payhos as $item3)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item3->income}}</td> 
                                        <td>{{$item3->name}}</td> 
                                        <td>{{$item3->qty}}</td> 
                                        <td> {{$item3->pay }} </td> 
                                        <td> {{$item3->nopay }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}

    {{-- <div class="row mt-3">
        <h5 class="mb-sm-0">รายการค่าใช้จ่าย HOSxP</h5>
        <div class="col-xl-12 mt-2">
            
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive"> 
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">รหัส icode ยา</th> 
                                    <th class="text-center">รหัส กรมบัญชีกลาง</th>
                                    <th class="text-center">ชื่อ</th>
                                    <th class="text-center">จำนวน</th> 
                                    <th class="text-center">ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_payhoslist as $item4)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item4->icode}}</td> 
                                        <td>{{$item4->nhso_adp_code}}</td> 
                                        <td>{{$item4->name}}</td> 
                                        <td>{{$item4->qty }} </td> 
                                        <td>{{$item4->price }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}




    </div>





@endsection
@section('footer')
    <script>
       
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
           
        });
    </script>


@endsection
