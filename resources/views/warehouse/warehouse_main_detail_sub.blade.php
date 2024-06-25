{{-- @extends('layouts.accpk') --}}
@extends('layouts.warehouse')
@section('title', 'PK-OFFICER || คลังวัสดุ')
@section('content')

    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function warehouse_destroy(warehouse_rep_id) {
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
                        url: "{{ url('warehouse/warehouse_destroy') }}" + '/' + warehouse_rep_id,
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
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + warehouse_rep_id).remove();
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
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SuppliesController;
    use App\Http\Controllers\StaticController;
    $refnumber = SuppliesController::refnumber();
    $count_product = StaticController::count_product();
    $count_service = StaticController::count_service();
    ?>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <div class="d-flex">
                            <div class="p-2">
                                <label for="">รายการ Stock-Card คลังหลัก</label>
                            </div>
                            <div class="ms-auto p-2">
                                {{-- <a href="{{ url('warehouse/warehouse_add') }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    ตรวจรับทั่วไป
                                </a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example"> --}}
                            <table style="width: 100%;" id="example"
                                class="table table-hover table-striped table-bordered myTable">
                                <thead>
                                    <tr>
                                        <th width="3%" class="text-center">ลำดับ</th> 
                                        <th width="9%" class="text-center">คลัง</th>
                                        <th width="10%" class="text-center">รหัสวัสดุ</th>
                                        <th class="text-center">รายการวัสดุ</th>
                                        <th class="text-center">หมวดวัสดุ</th>
                                        <th width="8%" class="text-center">จำนวน</th>
                                        <th width="8%" class="text-center">ราคารวม</th>
                                        <th width="5%" class="text-center">สถานะ</th> 
                                        <th width="5%" class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $date = date('Y');
                                    ?>
                                    @foreach ($warehouse_stock as $item)
                                        <tr id="sid{{ $item->warehouse_stock_id }}">
                                            <td class="text-center" width="3%">{{ $i++ }}</td> 
                                            <td class="text-center" width="12%">{{ $item->warehouse_inven_name }} </td>
                                            <td class="text-center" width="10%">{{ $item->product_code }}</td>
                                            {{-- <td class="text-center" width="9%">
                                                {{ DateThai($item->warehouse_rep_date) }}
                                            </td> --}}
                                            <td class="p-2">{{ $item->product_name }}</td>
                                            <td class="p-2" width="12%">{{ $item->product_categoryname }}</td>
                                            <td class="text-center" width="7%">{{ $item->product_qty }} </td>
                                            <td class="text-center" width="10%">{{ $item->product_price_total }} </td>
                                            <td class="text-center" width="5%">{{ $item->warehouse_stock_status }} </td>
                                            <td class="text-center" width="5%">
                                                <div class="dropdown d-inline-block">
                                                    <button type="button" aria-haspopup="true" aria-expanded="false"
                                                        data-bs-toggle="dropdown"
                                                        class="mb-2 me-2 dropdown-toggle btn btn-outline-secondary btn-sm">
                                                        ทำรายการ
                                                    </button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                                        class="dropdown-menu-hover-link dropdown-menu">
                                                        
                                                       
                                                            <a class="dropdown-item text-primary" href=""  style="font-size:14px"
                                                                data-bs-toggle="modal"
                                                                data-bs-target=".detail{{ $item->warehouse_stock_id }}">
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


@endsection
