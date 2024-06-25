@extends('layouts.user')
@section('title', 'PK-OFFICER || งานจิตเวชและยาเสพติด')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    {{-- <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style> --}}
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
            <h5>รายงานจำนวนผู้ป่วย</h5>
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
                                    <th class="text-center">ชดเชย</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($kayapap_vs_spsch as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{ $item->hn}}</td>                                     
                                        <td width="15%" class="text-center">{{ $item->vstdate}}</td>
                                        <td class="text-center"> {{$item->cid}}</td>
                                        <td class="text-center">{{ $item->fullname}}</td>
                                        <td class="text-center">{{ $item->pttype}}</td>
                                        <td class="text-center">{{ $item->equipment_name}}</td> 
                                        <td class="text-center">{{ $item->qty}}</td>
                                        <td class="text-center">{{ $item->personel}}</td> 
                                        <td class="text-center">{{ $item->pay_price}}</td> 
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
            $('#checkBtn').click(function() {

                var pang_id = $('#pang_id').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();
                // alert(enddate);
                $.ajax({
                    url: "{{ route('acc.checksit_admit_spsch') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        pang_id,
                        startdate,
                        enddate
                    },
                    success: function(data) {
                        // if (data.status == 200) { 
                        //     Swal.fire({
                        //         title: 'บันทึกข้อมูลสำเร็จ',
                        //         text: "You Insert data success",
                        //         icon: 'success',
                        //         showCancelButton: false,
                        //         confirmButtonColor: '#06D177',
                        //         confirmButtonText: 'เรียบร้อย'
                        //     }).then((result) => {
                        //         if (result
                        //             .isConfirmed) {
                        //             console.log(
                        //                 data);

                        //             window.location
                        //                 .reload();
                        //         }
                        //     })
                        // } else {

                        // }

                    },
                });
            });

        });
    </script>

@endsection
