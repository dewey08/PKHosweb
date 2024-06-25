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
                <form action="{{ route('prb.prb_repipd') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <h5 class="mb-sm-0">รายงานการลงข้อมูลผู้ป่วยใน พรบ. ที่จำหน่าย</h5>
                        </div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <input id="startdate" name="startdate" class="form-control form-control-sm" type="date"
                                value="{{ $startdate }}">
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <input id="enddate" name="enddate" class="form-control form-control-sm" type="date"
                                value="{{ $enddate }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                        </div>
                        <div class="col"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                            id="example"> --}}
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">จำนวนผู้ป่วยคน</th>
                                    <th class="text-center">จำนวนผู้ป่วยครั้ง</th>
                                    <th class="text-center">จำนวนที่เบิก</th>
                                    <th class="text-center">จำนวนที่ไม่ได้เบิก</th>
                                    <th class="text-center">ค่ารักษาทั้งหมด</th>
                                    <th class="text-center">จำนวนเงินที่เรียกเก็บ</th>
                                    <th class="text-center">จำนวนที่ได้รับชดเชย</th>
                                    <th class="text-center">ร้อยละ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_repipd as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        {{-- <td>{{$item->vstdate}}</td>  --}}
                                        @if ($item->months == '1')
                                            <td width="15%" class="text-center">มกราคม</td>
                                        @elseif ($item->months == '2')
                                            <td width="15%" class="text-center">กุมภาพันธ์</td>
                                        @elseif ($item->months == '3')
                                            <td width="15%" class="text-center">มีนาคม</td>
                                        @elseif ($item->months == '4')
                                            <td width="15%" class="text-center">เมษายน</td>
                                        @elseif ($item->months == '5')
                                            <td width="15%" class="text-center">พฤษภาคม</td>
                                        @elseif ($item->months == '6')
                                            <td width="15%" class="text-center">มิถุนายน</td>
                                        @elseif ($item->months == '7')
                                            <td width="15%" class="text-center">กรกฎาคม</td>
                                        @elseif ($item->months == '8')
                                            <td width="15%" class="text-center">สิงหาคม</td>
                                        @elseif ($item->months == '9')
                                            <td width="15%" class="text-center">กันยายน</td>
                                        @elseif ($item->months == '10')
                                            <td width="15%" class="text-center">ตุลาคม</td>
                                        @elseif ($item->months == '11')
                                            <td width="15%" class="text-center">พฤษจิกายน</td>
                                        @else
                                            <td width="15%" class="text-center">ธันวาคม</td>
                                        @endif
                                        <td>
                                            <a href="{{url('prb_repipd_subhn/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->hn }}</a>   
                                        </td>
                                        <td>
                                            <a href="{{url('prb_repipd_subvn/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->an }}</a>    
                                        </td>
                                        <td>
                                            <a href="{{url('prb_repipd_subreq/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->nhso_ownright_pid }}</a>  
                                         </td>
                                        <td>
                                            <a href="{{url('prb_repipd_subnoreq/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->claim_code }}</a>  
                                        </td>
                                        <td>{{ $item->income }}</td>
                                        <td>{{ $item->nhso_ownright_pidtotal }} </td>
                                        <td>{{ $item->nhso_ownright_name }} </td>
                                        <td>{{ $item->afterclaim_code }} </td>
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
