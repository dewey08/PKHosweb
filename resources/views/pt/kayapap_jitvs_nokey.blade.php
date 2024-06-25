@extends('layouts.report_font')
@section('title', 'PK-OFFICER || งานจิตเวชและยาเสพติด')
@section('content')
     
    <div class="container-fluid">
  
    <div class="row mt-3">
        <div class="col-xl-12">
            <h5>รายงานจำนวนผู้ป่วยยังไม่เบิก</h5>
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">เลขบัตร</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>  
                                    <th class="text-center">สิทธฺิ</th> 
                                    <th class="text-center">รายการ</th> 
                                    <th class="text-center">จำนวน</th> 
                                    <th class="text-center">ผู้เบิก</th> 
                                    <th class="text-center">สถานะการเบิก</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($kayapap_jitvs_nokey as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{ $item->hn}}</td>                                     
                                        <td width="15%" class="text-center">{{ $item->vstdate}}</td>
                                        <td class="text-center"> {{$item->cid}}</td>
                                        <td class="p-2">{{ $item->fullname}}</td> 
                                        <td class="text-center">{{ $item->pttype}}</td>
                                        <td class="text-center">{{ $item->nname}}</td>
                                        <td class="text-center">{{ $item->qty}}</td>
                                        <td class="text-center"> </td> 
                                        <td class="text-center"> </td> 
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
