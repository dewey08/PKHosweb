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
            <div class="col-xl-6">

                <div class="row mt-3">
                    @foreach ($data_outlocate_incomesum as $items)
                    <h5 class="mb-sm-0">รายการค่าใช้จ่าย  นอน  {{$items->sadmdate}} วัน</h5>
                    @endforeach
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
                                            @foreach ($data_outlocate_income as $item)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item->income}}</td>  
                                                        <td>{{ $item->iname }} </td>                                            
                                                        <td class="text-center" >{{ $item->qty }}</td>  
                                                        <td class="text-center" >{{ $item->paidst }}</td>  
                                                        <td class="text-center" >{{ $item->nopaidst }}</td>   
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
                    <h5 class="mb-sm-0">รายการค่าใช้จ่ายค่าห้อง</h5> 
                    <div class="col-xl-12 mt-2">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive"> 
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">รหัส</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">จำนวน</th> 
                                                <th class="text-center">เบิกได้</th> 
                                                <th class="text-center">เบิกไม่ได้</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_outlocate_room as $item3)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item3->billcode}}</td>  
                                                        <td>{{ $item3->name }} </td>                                            
                                                        <td class="text-center" >{{ $item3->qty }}</td>  
                                                        <td class="text-center" >{{ $item3->paidst }}</td>  
                                                        <td class="text-center" >{{ $item3->nopaidst }}</td>   
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
                    <h5 class="mb-sm-0">รายการ COVID</h5> 
                    <div class="col-xl-12 mt-2">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive"> 
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">รหัส</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">จำนวน</th> 
                                                <th class="text-center">เบิกได้</th> 
                                                <th class="text-center">เบิกไม่ได้</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_outlocate_covid as $item4)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item4->billcode}}</td>  
                                                        <td>{{ $item4->name }} </td>                                            
                                                        <td class="text-center" >{{ $item4->qty }}</td>  
                                                        <td class="text-center" >{{ $item4->paidst }}</td>  
                                                        <td class="text-center" >{{ $item4->nopaidst }}</td>   
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
                <div class="row mt-3">
                    <h5 class="mb-sm-0">รายการค่าใช้จ่าย Eclaim</h5>
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
                                                <th class="text-center">เบิกได้</th>
                                                <th class="text-center">เบิกไม่ได้</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_outlocate_eclaim as $item2)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item2->SERVICE_ITEM}}</td>                                       
                                                        <td class="text-center" >{{ $item2->SEVer }}</td>  
                                                        <td class="text-center">{{ $item2->repsev }}</td>   
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
                    <h5 class="mb-sm-0">รายการ COVID CI</h5> 
                    <div class="col-xl-12 mt-2">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive"> 
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">รหัส</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">จำนวน</th> 
                                                <th class="text-center">เบิกได้</th> 
                                                <th class="text-center">เบิกไม่ได้</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_outlocate_covidci as $item6)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item6->billcode}}</td>  
                                                        <td>{{ $item6->name }} </td>                                            
                                                        <td class="text-center" >{{ $item6->qty }}</td>  
                                                        <td class="text-center" >{{ $item6->paidst }}</td>  
                                                        <td class="text-center" >{{ $item6->nopaidst }}</td>   
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
                    <h5 class="mb-sm-0">รายการค่าอุปกรณ์</h5> 
                    <div class="col-xl-12 mt-2">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive"> 
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">รหัส</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">จำนวน</th> 
                                                <th class="text-center">เบิกได้</th> 
                                                <th class="text-center">เบิกไม่ได้</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_outlocate_list as $item7)                                            
                                                    <tr>
                                                        <td>{{$i++ }}</td>
                                                        <td>{{$item7->billcode}}</td>  
                                                        <td>{{ $item7->name }} </td>                                            
                                                        <td class="text-center" >{{ $item7->qty }}</td>  
                                                        <td class="text-center" >{{ $item7->paidst }}</td>  
                                                        <td class="text-center" >{{ $item7->nopaidst }}</td>   
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
