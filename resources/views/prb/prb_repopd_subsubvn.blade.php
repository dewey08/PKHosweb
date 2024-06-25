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
        <h5 class="mb-sm-0">รายละเอียดผู้ป่วย โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</h5>
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
                                    <th class="text-center">ชื่อ</th>
                                    <th class="text-center">เลขบัตร</th>
                                    <th class="text-center">วันที่รักษา</th>
                                    <th class="text-center">วันที่จำหน่าย</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_repopdsubsubvn as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item->hn}}</td> 
                                        <td>{{$item->an}}</td> 
                                        <td>{{$item->fullname}}</td> 
                                        <td> {{ $item->cid }} </td>
                                        <td>{{ $item->vstdate }} </td>
                                        <td>{{ $item->dchdate }}</td> 
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
        <h5 class="mb-sm-0">รายการ icd10</h5>
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
                                    <th class="text-center">ชื่อไทย</th>
                                    <th class="text-center">diag type</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_icd as $item2)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item2->icd10}}</td> 
                                        <td>{{$item2->name}}</td> 
                                        <td>{{$item2->tname}}</td> 
                                        <td> {{$item2->diagtype }} </td> 
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
    </div>

    <div class="row mt-3">
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
    </div>




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
