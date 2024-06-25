@extends('layouts.user')
@section('title', 'PK-OFFICER || คลังย่อย')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function repair_com_cancel(com_repaire_id) {
            // alert(bookrep_id);
            Swal.fire({
                title: 'ต้องการยกเลิกรายการนี้ใช่ไหม?',
                text: "ข้อมูลนี้จะถูกส่งไปยังผู้ดูแลงานคอมพิวเตอร์",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ url('user_com/repair_com_cancel') }}" + '/' + com_repaire_id,
                        success: function(response) {
                            Swal.fire({
                                title: 'แจ้งยกเลิกรายการนี้',
                                text: "Cancel Finish",
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
                        }
                    })
                }
            })
        }
    </script>
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
    use App\Http\Controllers\UsercarController;
    use App\Http\Controllers\StaticController;
    use App\Http\Controllers\UserwarehouseController;
    use App\Models\Products_request_sub;
    
    $refnumber = UserwarehouseController::refnumber();

    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
    date_default_timezone_set('Asia/Bangkok');
    $date = date('Y') + 543;
    $datefull = date('Y-m-d H:i');
    $time = date('H:i:s');
    $loter = $date . '' . $time;
    ?>
    <style>
        @media (min-width: 950px) {
            .modal {
                --bs-modal-width: 950px;
            }
        }

        @media (min-width: 1500px) {
            .modal-xls {
                --bs-modal-width: 1500px;
            }
        }

        @media (min-width: 1500px) {
            .container-fluids {
                width: 1500px;
                margin-left: auto;
                margin-right: auto;
                margin-top: auto;
            }
        }

        .hrow {
            height: 2px;
            margin-bottom: 9px;
        }
    </style>
    
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row invoice-card-row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header ">
                            <div class="d-flex">
                                <div class="p-2">
                                    <label for="">รายการวัสดุ</label>
                                </div>
                                <div class="ms-auto p-2">                                    
                                        {{-- <a href="" class="btn btn-outline-info btn-sm text-info" data-bs-toggle="modal" data-bs-target="#comdetailModal">
                                            <i class="fa-solid fa-folder-plus text-info me-2"></i>
                                            เบิกวัสดุ
                                        </a> --}}
                                    <button class="btn btn-primary btn-sm shadow-lg" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa-solid fa-circle-info text-white me-2"></i>
                                        สร้างใบเบิก
                                    </button>
                                </div>
                                    <!-- Collapsed content -->
                                    <div class="collapse collapse-horizontal" id="collapseExample"> 
                                        <div class="card card-body" style="width: 400px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="" class="btn btn-success text-white btn-sm shadow ms-3">
                                                        <i class="fa-solid fa-folder-plus text-white"></i>
                                                        เบิกวัสดุในแผน
                                                    </a>
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <a href="{{ url('user_ware/warehouse_stock_main') }}" class="btn btn-info text-white btn-sm shadow">
                                                        <i class="fa-solid fa-folder-plus text-white"></i>
                                                        เบิกวัสดุนอกแผน
                                                    </a> --}}
                                                    <a href="" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#comdetailModal">
                                                        <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                                        เบิกวัสดุนอกแผน
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                     

                        <div class="card-body ">
                            <div class="table-responsive"> 
                                <table style="width: 100%;" id="example"
                                    class="table table-hover table-striped table-bordered myTable">
                                    <thead>
                                        <tr height="10px">
                                            <th width="3%" class="text-center">ลำดับ</th> 
                                            <th width="7%" class="text-center">สถานะ</th> 
                                            <th width="10%" class="text-center">รหัสวัสดุ</th>
                                            <th width="10%" class="text-center">ปี</th>
                                            <th width="10%" class="text-center">วันที่</th>
                                            <th class="text-center">คลัง</th>
                                            <th width="12%" class="text-center">ผู้เบิก</th>
                                           
                                            <th width="5%" class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($warehouse_deb_req as $item)
                                        <tr id="sid{{ $item->warehouse_deb_req_id }}">
                                            <td class="text-center" width="3%">{{ $i++ }}</td> 
                                            <td class="text-center" width="7%">{{ $item->warehouse_deb_req_status }} </td>
                                            <td class="text-center" width="10%">{{ $item->warehouse_deb_req_code }}</td> 
                                            <td class="text-center" width="10%">{{ $item->warehouse_deb_req_year }}</td>
                                            <td class="p-2" width="12%">{{ $item->warehouse_deb_req_date }}</td>
                                            <td class="p-2" >{{ $item->warehouse_inven_name }} </td>
                                            <td class="p-2" width="10%">{{ $item->fname }}  {{ $item->lname }} </td>
                                            {{-- <td class="text-center" width="5%">{{ $item->warehouse_stock_sub_status }} </td> --}}
                                            <td class="text-center" width="5%">
                                                <div class="dropdown d-inline-block">
                                                    <button type="button" aria-haspopup="true" aria-expanded="false"
                                                        data-bs-toggle="dropdown"
                                                        class="me-2 dropdown-toggle btn btn-outline-secondary btn-sm">
                                                        ทำรายการ
                                                    </button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                                        class="dropdown-menu-hover-link dropdown-menu">                                                       
                                                       
                                                            <a class="dropdown-item text-primary" href=""  style="font-size:14px"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#detail{{ $item->warehouse_deb_req_id }}">
                                                                <i class="fa-solid fa-circle-info me-2 text-info" style="font-size:14px"></i>
                                                                <span>รายละเอียด</span>
                                                            </a>                                                         
                                                    </div>
                                                </div>

                                            </td>
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

<div class="modal fade" id="comdetailModal" tabindex="-1" aria-labelledby="comdetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comdetailModalLabel">สร้างใบเบิกวัสดุ </h5> 
            </div>
            <div class="modal-body">  
                <div class="row">
                    <div class="col-md-2">
                        <label for="warehouse_deb_req_code">เลขที่เบิก :</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input id="warehouse_deb_req_code" type="text"
                                class="form-control form-control-sm"
                                name="warehouse_deb_req_code" value="{{ $refnumber }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="warehouse_deb_req_year">ปีงบ :</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="warehouse_deb_req_year" name="warehouse_deb_req_year"
                                class="form-select form-select-lg" style="width: 100%">
                                <option value="">--เลือก--</option>
                                @foreach ($budget_year as $ye)
                                    @if ($ye->leave_year_id == $date)
                                        <option value="{{ $ye->leave_year_id }}" selected>
                                            {{ $ye->leave_year_id }} </option>
                                    @else
                                        <option value="{{ $ye->leave_year_id }}">
                                            {{ $ye->leave_year_id }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <label for="warehouse_deb_req_savedate">วันที่บันทึก :</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="form-control form-control-sm" type="datetime-local"
                                id="warehouse_deb_req_savedate"
                                name="warehouse_deb_req_savedate" value="{{ $datefull }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="warehouse_deb_req_date">วันที่ต้องการ :</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="form-control form-control-sm" type="datetime-local"
                                id="warehouse_deb_req_date" name="warehouse_deb_req_date"
                                value="{{ $datefull }}">
                        </div>
                    </div>
                   
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <label for="warehouse_deb_req_inven_id">คลังที่ต้องการ</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select id="warehouse_deb_req_inven_id" name="warehouse_deb_req_inven_id"
                                class="form-select form-select-lg" style="width: 100%">
                                <option value="">--เลือก--</option>
                                @foreach ($warehouse_inven as $sto)
                                 
                                        <option value="{{ $sto->warehouse_inven_id }}">
                                            {{ $sto->warehouse_inven_name }}
                                        </option>
                                   
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">   
                <button type="button" id="SaveBtn" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    สร้างใบเบิก
                </button>            
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">
                    <i class="fa-solid fa-xmark me-2"></i>
                    ปิด
                </button>
            </div>

        </div>
    </div>
</div>
 

  @endsection
@section('footer')
<script>
     $('select').select2(); 
        $('#warehouse_deb_req_inven_id').select2({
                dropdownParent: $('#comdetailModal')
        });
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $('#SaveBtn').click(function() {
                var warehouse_deb_req_code = $('#warehouse_deb_req_code').val();
                var warehouse_deb_req_year = $('#warehouse_deb_req_year').val();
                var warehouse_deb_req_savedate = $('#warehouse_deb_req_savedate').val();
                var warehouse_deb_req_date = $('#warehouse_deb_req_date').val();
                var warehouse_deb_req_inven_id = $('#warehouse_deb_req_inven_id').val();
                $.ajax({
                    url: "{{ route('user_ware.warehouse_stock_subbillsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        warehouse_deb_req_code,
                        warehouse_deb_req_year,
                        warehouse_deb_req_savedate,
                        warehouse_deb_req_date,
                        warehouse_deb_req_inven_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });
</script>
@endsection
