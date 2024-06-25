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
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example"> --}}
                            <table style="width: 100%;" id="example"
                                class="table table-hover table-striped table-bordered myTable">
                                <thead>
                                    <tr>
                                        <th width="3%" class="text-center">ลำดับ</th> 
                                        <th width="9%" class="text-center">คลัง</th>
                                        <th width="7%" class="text-center">รหัสวัสดุ</th>
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
                                            <td class="text-center" width="7%">{{ $item->product_code }}</td>
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
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-warning"
                                                                href="{{ url('warehouse/warehouse_edit/' . $item->warehouse_stock_id) }}"
                                                                style="font-size:14px">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-warning"
                                                                    style="font-size:13px"></i>
                                                                <span>แก้ไข</span>
                                                            </a>
                                                         

                                                    </div>
                                                </div>


                                            </td>
                                        </tr>


                                        <!--  Modal content for the above example -->
                                        {{-- <div class="modal fade detail{{ $item->warehouse_stock_id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myExtraLargeModalLabel">
                                                            รายละเอียดการตรวจรับ</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_code">เลขที่รับ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input id="warehouse_rep_code" type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="warehouse_rep_code"
                                                                        value="{{ $item->warehouse_rep_code }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_no_bill">เลขที่บิล </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input id="warehouse_rep_no_bill" type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="warehouse_rep_no_bill"
                                                                        value="{{ $item->warehouse_rep_no_bill }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 ">
                                                                <label for="warehouse_rep_po">เลขที่ PO </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input id="warehouse_rep_po" type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="warehouse_rep_po"
                                                                        value="{{ $item->warehouse_rep_po }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_year">ปีงบ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input id="" type="text"
                                                                        class="form-control form-control-sm"
                                                                        name=""
                                                                        value="{{ $item->warehouse_rep_year }}" readonly>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mt-3">
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_user_id">ผู้รับ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input id="" type="text"
                                                                        class="form-control form-control-sm"
                                                                        name=""
                                                                        value="{{ $item->warehouse_rep_user_name }}"
                                                                        readonly>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_inven_id">รับเข้าคลัง </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input id="" type="text"
                                                                        class="form-control form-control-sm"
                                                                        name=""
                                                                        value="{{ $item->warehouse_rep_inven_name }}"
                                                                        readonly>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_vendor_id">รับจาก </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input id="" type="text"
                                                                        class="form-control form-control-sm"
                                                                        name=""
                                                                        value="{{ $item->warehouse_rep_vendor_name }}"
                                                                        readonly>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="">วันที่รับ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input class="form-control form-control-sm"
                                                                        type="datetime-local"
                                                                        id="example-datetime-local-input" name=""
                                                                        value="{{ $item->warehouse_rep_date }}">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <div class="row bg-info">
                                                            <div class="col-md-2 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">รหัสวัสดุ</label>
                                                            </div>
                                                            <div class="col-md-3 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">รายการวัสดุ</label>
                                                            </div>
                                                            <div class="col-md-1 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">หน่วยนับ</label>
                                                            </div>
                                                            <div class="col-md-1 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">ประเภท</label></div>
                                                            <div class="col-md-1 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">จำนวน</label></div>
                                                            <div class="col-md-2 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">ราคา</label></div>
                                                            <div class="col-md-2 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">ราคารวม</label>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <?php $ii = 1;
                                                        $datadetail = DB::connection('mysql')->select(
                                                            '   
                                                                                                                        select product_code,product_name,product_type_name,product_qty,product_price,product_price_total,product_unit_subname
                                                                                                                        from warehouse_rep_sub 
                                                                                                                        where warehouse_rep_id ="' .
                                                                $item->warehouse_rep_id .
                                                                '"  
                                                                                                                        ',
                                                        );
                                                        $total = 0;
                                                        ?>
                                                        @foreach ($datadetail as $item3)
                                                            <div class="row">
                                                                <div class="col-md-2 text-center" style="font-size:14px">
                                                                    {{ $item3->product_code }}</div>
                                                                <div class="col-md-3" style="font-size:14px">
                                                                    {{ $item3->product_name }}</div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">
                                                                    {{ $item3->product_unit_subname }} </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">
                                                                    {{ $item3->product_type_name }}</div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">
                                                                    {{ $item3->product_qty }} </div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">
                                                                    {{ number_format($item3->product_price, 2) }}</div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">
                                                                    {{ number_format($item3->product_price_total, 2) }}
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <?php
                                                            $total = $total + $item3->product_qty * $item3->product_price;
                                                            ?>
                                                        @endforeach
                                                        <div class="text-end me-5">
                                                           
                                                            <label for=""
                                                                class="me-4">ราคารวมทั้งหมด</label><label
                                                                for=""> <b style="color: red;font-size:17px">
                                                                    {{ number_format($total, 2) }} </b> </label><label
                                                                for="" class="ms-4"> บาท</label>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-dismiss="modal">
                                                            <i class="fa-solid fa-xmark me-2"></i>
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).on('click', '.detail', function() {
            var an = $(this).val();
            // alert(line_token_id);
            $('#labdetail').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ url('k.karn_main_sss_detail') }}" + '/' + an,
                success: function(data) {
                    console.log(data.datadetail.billcode);
                    $('#billcode').val(data.datadetail.billcode)
                    $('#namelab').val(data.datadetail.namelab)
                    $('#qt').val(data.datadetail.qt)
                    $('#pricet').val(data.datadetail.pricet)
                },
            });
        });
    </script>

@endsection
