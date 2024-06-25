@extends('layouts.account')
@section('title', 'PK-OFFICE || Account')
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
            <div class="col-xl-6">
                <div class="row mt-3">
                    <div class="col-xl-12">
                        <label for=""> Claimcode</label>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($datashow4 as $item4)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item4->claimcode }}</td>
                                                    
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
                        <label for=""> รายการค่าใช้จ่าย HOSxP</label>
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
                                    <table id="example"
                                        class="table table-striped table-bordered dt-responsive nowrap myTable"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">รหัส icode ยา</th>
                                                <th class="text-center">รหัส กรมบัญชีกลาง</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">จำนวน </th> 
                                                <th class="text-center">ราคา </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($datashow2 as $item2)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item2->icode }}</td>
                                                    <td class="p-2">{{ $item2->nhso_adp_code }}</td>                                         
                                                    <td class="p-2">{{ $item2->dname }}</td> 
                                                    <td class="text-center">{{ $item2->qty }}</td> 
                                                    <td class="text-center">{{ $item2->sum_price }}</td>  
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
            <div class="col-xl-6">
                <label for="">รายการค่าใช้จ่าย Eclaim</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example3"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th> 
                                        <th class="text-center">รหัสหมวด</th> 
                                        <th class="text-center">เบิกได้</th>
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow3 as $item3)
                                        <tr>
                                            <td>{{ $i++ }}</td> 
                                            <td class="p-2">{{ $item3->SERVICE_ITEM }}</td> 
                                            <td class="text-center">{{ $item3->sev }}</td>
                                            <td class="text-center">{{ $item3->REsev }}</td> 
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
            {{-- <div class="col-xl-6">
                <label for=""> รายการยาเบิก</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส icode ยา</th>
                                        <th class="text-center">รหัส กรมบัญชีกลาง</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน </th> 
                                        <th class="text-center">ราคา </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow2 as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item2->icode }}</td>
                                            <td class="p-2">{{ $item2->nhso_adp_code }}</td>                                         
                                            <td class="p-2">{{ $item2->dname }}</td> 
                                            <td class="text-center">{{ $item2->qty }}</td> 
                                            <td class="text-center">{{ $item2->sum_price }}</td>  
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-xl-6">
                <label for="">รายการค่าใช้จ่าย Eclaim</label>
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example3"
                                class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th> 
                                        <th class="text-center">รหัสหมวด</th> 
                                        <th class="text-center">เบิกได้</th>
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow3 as $item3)
                                        <tr>
                                            <td>{{ $i++ }}</td> 
                                            <td class="p-2">{{ $item3->SERVICE_ITEM }}</td> 
                                            <td class="text-center">{{ $item3->sev }}</td>
                                            <td class="text-center">{{ $item3->REsev }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
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
