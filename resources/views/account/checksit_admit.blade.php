@extends('layouts.pkclaim')
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

        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('acc.checksit_admit') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-1 text-end">ผังบัญชี </div>
                        <div class="col-md-3 text-center">
                            <select id="pang_id" name="pang_id" class="form-control" style="width: 100%" required>
                                <option value="">--เลือกผังบัญชี--</option>
                                @foreach ($pang as $p)
                                    @if ($pang_id == $p->pang_id)
                                        <option value="{{ $p->pang_id }}" selected>{{ $p->pang_fullname }}</option>
                                    @else
                                        <option value="{{ $p->pang_id }}">{{ $p->pang_fullname }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                    id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $startdate }}">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                    id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $enddate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                            <button type="button" id="checkBtn" class="btn btn-success">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ตรวจสอบสิทธิ์
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
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">Stamp</th>
                                    <th class="text-center">AN</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">AdmitDischarge</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">สิทธิ/รพ</th>
                                    <th class="text-center">สิทธิ สปสช</th>
                                    <th class="text-center">pang_stamp_id</th>
                                    <th class="text-center">pdx</th>
                                    <th class="text-center">income</th>
                                    <th class="text-center">uc_money</th>
                                    <th class="text-center">paid_money</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->Stamp }}</td>
                                        <td>{{ $item->AN }}</td>
                                        <td>{{ $item->HN }}</td>

                                        <td class="text-center">{{ $item->AdmitDischarge }}</td>

                                        <td class="text-center">{{ $item->cid }}</td>
                                        <td>{{ $item->pttype }} </td>
                                        <td>{{ $item->spsc }} </td>
                                        <td>{{ $item->pang_stamp_nhso }} </td>
                                        <td>{{ $item->pang_stamp_id }} </td>
                                        <td>{{ $item->pdx }} </td>
                                        <td>{{ $item->income }} </td>
                                        <td> {{ $item->uc_money }} </td>
                                        <td>{{ $item->paid_money }} </td>
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
