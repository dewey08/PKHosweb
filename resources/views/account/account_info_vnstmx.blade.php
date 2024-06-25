@extends('layouts.accountnew')
@section('title', 'PK-OFFICER || Account')
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
            <div class="col-xl-12">
                <label for=""> รายการค่าใช้จ่าย ktb ver เก่า</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">เลขบัตร</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">ราคา</th>
                                        <th class="text-center">Approval_code </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item->personal_id }}</td>
                                            <td class="text-center">{{ $item->transaction_date1 }}</td>                                         
                                            <td class="text-center">{{ $item->amount }}</td>
                                            <td class="text-center">{{ $item->approval_code }}</td>  
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
            <div class="col-xl-12">
                <label for=""> รายการค่าใช้จ่าย ktb ver เก่า 2</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example2"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">VN</th>
                                        <th class="text-center">เลขบัตร</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">วันที่ ktb </th>
                                        <th class="text-center">ราคา </th>
                                        <th class="text-center">Approval_code</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow2 as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item2->vn }}</td>
                                            <td class="text-center">{{ $item2->cid }}</td> 
                                            <td class="text-center">{{ $item2->vstdate }}</td>
                                            <td class="text-center">{{ $item2->transaction_date }}</td>
                                            <td class="text-center">{{ $item2->amount }}</td>
                                            <td class="text-center">{{ $item2->approval_code }}</td> 
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
            <div class="col-xl-12">
                <label for=""> รายการค่าใช้จ่าย ktb ver ใหม่ 1</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example3"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">VN</th>
                                        <th class="text-center">เลขบัตร</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">วันที่ ktb</th>
                                        <th class="text-center">ราคา </th>
                                        <th class="text-center">Approval_code</th>
                                        <th class="text-center">เหตุผล</th>
                                        <th class="text-center">Approval_code เดิม</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow3 as $item3)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item3->vn }}</td>
                                            <td class="text-center">{{ $item3->cid }}</td> 
                                            <td class="text-center">{{ $item3->vstdate }}</td>
                                            <td class="text-center">{{ $item3->transaction_date }}</td>
                                            <td class="text-center">{{ $item3->transaction_amount }}</td>
                                            <td class="text-center">{{ $item3->appr_code }}</td>
                                            <td class="text-center">{{ $item3->reason_keyin }}</td>
                                            <td class="text-center">{{ $item3->appr_code_old_payment }}</td> 
                                           
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
            $('select').select2();             
        });
    </script>

@endsection
