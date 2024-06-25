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
            <label for="">รายงานจำนวนผู้ป่วยนอก OFC </label>
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">PDX</th> 
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">ลูกหนี้</th>
                                    <th class="text-center">ชำระเงินเอง</th>
                                    <th class="text-center">ใบเสร็จ</th>
                                    <th class="text-center">ค่าใช้จ่าย HOSxP</th>
                                    <th class="text-center">ค่าใช้จ่าย ปิดลูกหนี้</th>
                                    <th class="text-center">ค่าใช้จ่าย EDC</th>
                                    <th class="text-center">cc</th>
                                    <th class="text-center">approve_code HOSxP</th>
                                    <th class="text-center">approve_code KTB</th>
                                    <th class="text-center">อายุ</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item)                                            
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td class="text-center">{{$item->hn }}</td> 
                                            <td class="text-center">
                                                {{ $item->cid}}
                                                {{-- <a href="{{url('account_info_vnstmx/'.$item->cid.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->cid}}</a>   --}}
                                            </td>    
                                            @if ($item->scheck == 'check')
                                            <td class="text-center"><button type="button" class="btn btn-success">CHECK</button></td> 
                                        @else
                                            <td class="text-center"><button type="button" class="btn btn-warning">ออก stm</button></td> 
                                        @endif
                                            <td class="text-center">{{$item->pdx }}</td> 
                                            <td class="text-center">{{$item->vstdate }}</td> 
                                            <td class="text-center">{{$item->fullname }}</td> 
                                            <td class="text-center"> 
                                                <a href="{{url('account_info_noapproveofc_vn/'.$item->vn.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->uc_money}}</a> 
                                            </td> 
                                            <td class="text-center">{{$item->paid_money }}</td> 
                                            <td class="text-center">{{$item->rcpno }}</td> 
                                            <td class="text-center">{{$item->hincome }}</td> 
                                            <td class="text-center">{{$item->rramont }}</td> 
                                            <td class="text-center">{{$item->edc }}</td> 
                                            <td class="text-center">{{$item->cc }}</td> 
                                            <td class="text-center">{{$item->apphoscode }}</td> 
                                            <td class="text-center">{{$item->appktb }}</td>   
                                            <td class="text-center">{{$item->age_y }}</td> 
                                           
                                           
                                                                            
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
