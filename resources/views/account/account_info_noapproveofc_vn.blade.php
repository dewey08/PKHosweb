@extends('layouts.account')
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
                <label for=""> รายการค่าใช้จ่าย</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสหมวด</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้ </th>
                                        <th class="text-center">เบิกไม่ได้ </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item->income }}</td>
                                            <td class="p-2">{{ $item->iname }}</td>                                         
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-center">{{ $item->paidst }}</td> 
                                            <td class="text-center">{{ $item->nopaidst }}</td>  
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
                <label for=""> รายการยาเบิก</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example2"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">billcode</th>
                                        <th class="text-center">ชื่อรายการ</th>
                                        <th class="text-center">หมวดค่ารักษา</th>
                                        <th class="text-center">จำนวน </th>
                                        <th class="text-center">ราคาต่อหน่วย</th> 
                                        <th class="text-center">ราคา</th> 
                                        <th class="text-center">วันที่สั่ง</th> 
                                        <th class="text-center">เวลา</th> 
                                        <th class="text-center">last modified</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; 
                                    $total = 0;?>
                                    @foreach ($datashow2 as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item2->icode }}</td> 
                                            <td class="text-center">{{ $item2->billcode }}</td>
                                            <td class="p-2">{{ $item2->nnname }}</td>
                                            <td class="p-2">{{ $item2->iname }}</td>
                                            <td class="text-center">{{ $item2->qty }}</td> 
                                            <td class="text-center">{{ $item2->price }}</td> 
                                            <td class="text-center">{{ $item2->sumprice }}</td> 
                                            <td class="text-center">{{ $item2->rxdate }}</td> 
                                            <td class="text-center">{{ $item2->rxtime }}</td> 
                                            <td class="text-center">{{ $item2->last_modified }}</td> 
                                        </tr>
                                        <?php
                                            $total = $total + $item2->sumprice;
                                        ?>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"></td>
                                        <td class="text-center">รวม</td>
                                        <td class="text-end">{{$total}}</td>
                                    </tr>
                                    {{-- $total = $total + $item2->qty * $item2->sumprice; --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <label for=""> ประวัติการส่งต่อ รักษา</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example3"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">เจ้าหน้าที่</th>
                                        <th class="text-center">รับเวลา</th>
                                        <th class="p-2">แผนกรับส่ง</th>
                                        <th class="text-center">เวลา </th>
                                        <th class="text-center">ส่งไปแผนก</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow3 as $item3)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item3->outdate }}</td>
                                            <td class="p-2">{{ $item3->staff_name }}</td> 
                                            <td class="text-center">{{ $item3->intime }}</td>
                                            <td class="p-2">{{ $item3->from_department }}</td>
                                            <td class="text-center">{{ $item3->outtime }}</td>
                                            <td class="p-2">{{ $item3->to_department }}</td> 
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
