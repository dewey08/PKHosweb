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
        <div class="col-xl-12">
            <label for="">รายงานจำนวนผู้ป่วยนอก OFC </label>
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">VN</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">วันที่</th> 
                                    <th class="text-center">เวลา</th>
                                    <th class="text-center">เลขบัตร</th>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">อายุ</th>
                                    <th class="text-center">สิทธิ</th>
                                    <th class="text-center">ค่ารักษา</th>
                                    <th class="text-center">ชำระเงินเอง</th>
                                    <th class="text-center">ติด C</th>
                                    <th class="text-center">approve_code KTB</th>
                                    <th class="text-center">approve_code HOS</th>
                                    <th class="text-center">appcode eclaim</th>
                                    <th class="text-center">ชดเชย STM</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item2)                                            
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td class="text-center">{{$item2->vn }}</td> 
                                            <td class="text-center">{{ $item2->hn}} </td>    
                                            <td class="text-center">{{$item2->DATEADM }}</td> 
                                            <td class="text-center">{{$item2->timeadm }}</td> 
                                            <td class="text-center">{{$item2->pid }}</td> 
                                            <td class="text-center">{{$item2->fullname }}</td> 
                                            <td class="text-center">{{$item2->age }}</td> 
                                            <td class="text-center">{{$item2->pttype }}</td> 
                                            <td class="text-center"> 
                                                <a href="{{url('account_info_vn_subofc_vndetail/'.$item2->vn )}}" target="_blank">{{ $item2->income}}</a> 
                                            </td> 
                                            <td class="text-center">{{$item2->paid }}</td> 
                                            <td class="text-center">{{$item2->CODE_ID }}</td> 
                                            <td class="text-center">{{$item2->approval_code }}</td> 
                                            <td class="text-center">{{$item2->apphoscode }}</td> 
                                            <td class="text-center">{{$item2->claimcode }}</td>   
                                            <td class="text-center">{{$item2->amountpay }}</td> 
                                            
                                                                            
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
