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
        {{-- <div class="col-xl-2"> </div> --}}
        <div class="col-xl-12">
            <label for="">รายการค่าใช้จ่าย</label>
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">รหัส icode</th>
                                    <th class="text-center">รหัส กรมบัญชีกลาง</th>
                                    <th class="text-center">ชื่อ</th> 
                                    <th class="text-center">จำนวน </th> 
                                    <th class="text-center">ราคา HOSxP</th>
                                    <th class="text-center">ราคา eclaim</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item2)                                            
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td class="text-center">{{$item2->icode }}</td> 
                                            <td class="text-center">{{$item2->nhso_adp_code }}</td>  
                                            <td class="text-center">{{$item2->dname }}</td>  
                                            <td class="text-center">{{$item2->qty }}</td> 
                                            <td class="text-center">{{$item2->sum_price }}</td> 
                                            <td class="text-center">{{$item2->eclaim }}</td>      
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        {{-- <div class="col-xl-2"> </div> --}}
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
