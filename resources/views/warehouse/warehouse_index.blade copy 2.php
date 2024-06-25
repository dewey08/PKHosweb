@extends('layouts.accpk')
@section('title', 'PK-OFFICER || คลังวัสดุ')

<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }

    function supplies_destroy(product_id) {
        Swal.fire({
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('supplies/supplies_destroy') }}" + '/' + product_id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'ลบข้อมูล!',
                            text: "You Delet data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            // cancelButtonColor: '#d33',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#sid" + product_id).remove();
                                // window.location.reload(); 
                                window.location =
                                    "{{ url('supplies/supplies_index') }}"; //     
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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
?>

@section('content')

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <div class="d-flex">
                            <div class="p-2">
                                <label for="">รายการตรวจรับ</label>
                            </div>
                            <div class="ms-auto p-2">
                                <a href="{{ url('warehouse/warehouse_add') }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    ตรวจรับทั่วไป
                                </a>

                            </div>
                        </div>
                    </div>


                    <div class="card-body shadow-lg">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example">
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        {{-- <th width="7%" class="text-center">สถานะ</th> --}}
                                        <th width="8%" class="text-center">เลขที่รับ</th>
                                        <th width="5%" class="text-center">ปีงบ</th>
                                        <th width="7%" class="text-center">วันที่</th>
                                        <th width="10%" class="text-center">รับเข้าคลัง</th>
                                        <th width="10%" class="text-center">สถานะส่ง</th>
                                        <th width="6%" class="text-center">ประเภท</th>
                                        <th class="text-center">ตัวแทนจำหน่าย</th>
                                        <th width="12%" class="text-center">ผู้รับ</th>
                                        <th width="7%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $date = date('Y');
                                    ?>
                                    @foreach ($warehouse_rep as $item)
                                        <tr id="sid{{ $item->warehouse_rep_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            {{-- <td class="text-center" width="7%">{{ $item->warehouse_rep_status }} </td> --}}
                                            <td class="text-center" width="8%">{{ $item->warehouse_rep_code }} </td>
                                            <td class="text-center" width="5%">{{ $item->warehouse_rep_year }}</td>
                                            <td class="text-center" width="7%">{{ DateThai($item->warehouse_rep_date) }}
                                            </td>
                                            <td class="p-2">{{ $item->warehouse_rep_inven_name }}</td>

                                            @if ($item->warehouse_rep_send == 'FINISH')
                                                <td class="font-weight-medium text-center" width="10%">
                                                    <div class="badge bg-primary">ครบ</div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="10%">
                                                    <div class="badge bg-danger">ค้าง</div>
                                                </td>
                                            @endif

                                            @if ($item->warehouse_rep_type == 'ASSET')
                                                <td class="font-weight-medium text-center" width="6%">
                                                    <div class="badge bg-warning">ผ่านพัสดุ</div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="6%">
                                                    <div class="badge bg-info">โดยตรง</div>
                                                </td>
                                            @endif

                                            <td class="p-2" width="17%">{{ $item->warehouse_rep_vendor_name }}</td>
                                            <td class="text-center" width="12%">{{ $item->warehouse_rep_user_name }}
                                            </td>
                                            <td class="text-center" width="7%">
                                                <div class="btn-group ">
                                                    {{-- <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        ทำรายการ
                                                        <i class="mdi mdi-chevron-down"></i>
                                                    </button> --}}
                                                    <button type="button"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-chevron-left"></i> ทำรายการ
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning"
                                                            href="{{ url('warehouse/warehouse_plus/'.$item->warehouse_rep_id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for=""
                                                                style="color: rgb(5, 173, 134);font-size:13px">รับรายการที่ส่งไม่ครบ</label>
                                                        </a>

                                                        <a class="dropdown-item text-warning"
                                                            href="{{ url('warehouse/warehouse_edit/' . $item->warehouse_rep_id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for=""
                                                                style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>
                                                     

                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item"
                                                            href="{{ url('warehouse_editplus/'.$item->warehouse_rep_id) }}">
                                                            <i class="fa-solid fa-square-check me-2"></i>
                                                            <label for=""
                                                                style="color:rgb(5, 92, 173);font-size:13px">ยืนยันการรับ</label>
                                                        </a>
                                                        <a href="{{ url('warehouse/warehouse_editplus/' . $item->warehouse_rep_id) }}"
                                                            class="dropdown-item">
                                                            <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                                            ตรวจรับทั่วไป
                                                        </a>

                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="supplies_destroy({{ $item->warehouse_rep_id }})">
                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                            <label for=""
                                                                style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
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


@endsection
