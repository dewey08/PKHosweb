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

        <div class="row">
            <div class="col-xl-12">
                
                    <div class="row">
                        <div class="col">
                            <h5 class="mb-sm-0">รายงานข้อมูลสิทธิ พรบ.ผู้ป่วยใน </h5>
                        </div>
                        <div class="col-md-1 text-end"> </div>
                        <div class="col-md-2 text-center">
                            
                        </div>
                        <div class="col-md-1 text-center"> </div>
                        <div class="col-md-2 text-center">
                             
                        </div>
                        <div class="col-md-2">
                     
                        </div>
                        <div class="col"></div>
                
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-12">
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
                                    <th class="text-center">เลขบัตรประชาชน</th>
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">ICD</th> 
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">สิทธิ</th>
                                    <th class="text-center">เลขที่ใบเสร็จ</th>
                                    <th class="text-center">ค่ารักษาทั้งหมด</th>
                                    <th class="text-center">ชำระเงินเอง</th>
                                    <th class="text-center">ค้างชำระ</th>
                                    <th class="text-center">เลขหนังสือ</th>
                                    <th class="text-center">เรียกเก็บเงิน</th>
                                    <th class="text-center">วงเงินสูงสุด</th>
                                    <th class="text-center">บริษัท</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_repipdsubreq as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item->hn}}</td> 
                                        <td>{{$item->an}}</td> 
                                        <td>{{$item->cid}}</td> 
                                        <td>{{$item->dchdate}}</td> 
                                        <td> {{ $item->pdx }} </td> 
                                        <td>{{ $item->fullname }}</td>
                                        <td>{{ $item->pttype }}</td>

                                        <td>{{ $item->rcpno }}</td>
                                        <td>{{ $item->income }}</td>
                                        <td>{{ $item->paid_money }}</td>
                                        <td>{{ $item->remain_money }} </td>
                                        <td>{{ $item->nhso_docno }} </td>

                                        <td>{{ $item->nhso_ownright_pid }} </td>
                                        <td>{{ $item->max_debt_amount }} </td>
                                        <td>{{ $item->nhso_govname }} </td>
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
        //      $(document).on('click','.edit_claim',function(){
        //         var ECLAIM_NO = $(this).val();
        //         var ECLAIM_STATUS = $(this).val();
        //         alert(ECLAIM_STATUS);
        //                 $('#linetokenModal').modal('show');
        //                 $.ajax({
        //                 type: "GET",
        //                 url:"{{ url('eclaim_check_edit') }}" +'/'+ ECLAIM_NO,  
        //                 success: function(data) {
        //                     // console.log(data.code.ECLAIM_NO);
        //                     $('#ECLAIM_NO').val(data.code.ECLAIM_NO)  
        //                     $('#ECLAIM_STATUS').val(data.code.ECLAIM_STATUS)                
        //                 },      
        //         });
        // });
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#heck_updateForm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })

                        } else {
                            // Swal.fire(
                            //     'ไม่มีข้อมูลต้องการจัดการ !',
                            //     'You clicked the button !',
                            //     'warning'
                            //     )
                        }
                    }
                });
            });
        });
    </script>


@endsection
