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
    use App\Models\Products_request_sub;
    
    $refnumber = UsercarController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
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
    
    <div class="container-fluids">
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
                                        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fa-solid fa-circle-info text-white"></i>
                                            เบิกวัสดุ
                                        </button>
                                        <!-- Collapsed content -->
                                        <div class="collapse collapse-horizontal" id="collapseExample"> 
                                            <div class="card card-body" style="width: 300px;">
                                                <div class="row">
                                                    <div class="col-md-6 mt-3">
                                                        <label for="ot_one_detail">เหตุผล </label>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <div class="form-outline">
                                                            <input id="ot_one_detail" type="text" class="form-control input-rounded"
                                                                name="ot_one_detail">
                                                        </div>
                                                    </div>
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
                                        <?php $i = 1; ?>
                                        @foreach ($warehouse_stock_sub as $item)
                                        <tr id="sid{{ $item->warehouse_stock_sub_id }}">
                                            <td class="text-center" width="3%">{{ $i++ }}</td> 
                                            <td class="text-center" width="12%">{{ $item->DEPARTMENT_SUB_SUB_NAME }} </td>
                                            <td class="text-center" width="10%">{{ $item->product_code }}</td> 
                                            <td class="p-2">{{ $item->product_name }}</td>
                                            <td class="p-2" width="12%">{{ $item->product_categoryname }}</td>
                                            <td class="text-center" width="7%">{{ $item->product_qty }} </td>
                                            <td class="text-center" width="10%">{{ $item->product_price_total }} </td>
                                            <td class="text-center" width="5%">{{ $item->warehouse_stock_sub_status }} </td>
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
                                                                data-bs-target="#detail{{ $item->warehouse_stock_sub_id }}">
                                                                <i class="fa-solid fa-circle-info me-2 text-info" style="font-size:14px"></i>
                                                                <span>รายละเอียด</span>
                                                            </a>                                                         
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        {{-- <div class="modal fade" id="detail{{ $item->warehouse_stock_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xls">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">รายละเอียด {{ $item->product_name }}</h1> 
                                                <p>
                                                    <a class="btn btn-outline-info" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="--bs-btn-border-radius: .7rem;">
                                                      รายการรับเข้า
                                                    </a>
                                                    <button class="btn btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample" style="--bs-btn-border-radius: .7rem;">
                                                      รายการจ่ายออก
                                                    </button>
                                                  </p>
                                                </div>
                                                <div class="modal-body">
                                                    <?php $ii = 1;
                                                        $datadetail = DB::connection('mysql')->select(                                                            '   
                                                                select ws.product_id,ws.product_code,ws.product_name,ws.product_type_name,ws.product_qty
                                                                ,wr.warehouse_rep_date,ws.product_price,ws.product_price_total,ws.product_unit_subname,ws.product_lot
                                                                from warehouse_rep wr
                                                                left outer join warehouse_rep_sub ws on ws.warehouse_rep_id = wr.warehouse_rep_id 
                                                                where wr.warehouse_rep_inven_id ="'.$item->warehouse_inven_id .'"  
                                                                and ws.product_code ="'.$item->product_code .'"                                                                                                                      ',
                                                        );
                                                        $total = 0;
                                                        ?>

                                                      <div class="collapse" id="collapseExample">
                                                        <div class="card card-body">
                                                            <div class="row">
                                                                <div class="col-md-2 text-center" style="font-size:14px">วันที่รับ </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">รหัสวัสดุ </div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">LOT </div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">รายการวัสดุ </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">จำนวน </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">หน่วยนับ </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">ราคา </div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">ราคารวม </div>
                                                            </div> 
                                                            <hr>  
                                                            @foreach ($datadetail as $item3)
                                                                <div class="row hrow"> 
                                                                    <div class="col-md-2 text-center" style="font-size:14px;"> {{$item3->warehouse_rep_date}}</div>
                                                                    <div class="col-md-1 text-center" style="font-size:14px"> {{ $item3->product_code }}</div>
                                                                    <div class="col-md-2 text-center" style="font-size:14px"> {{ $item3->product_lot }}</div>
                                                                    <div class="col-md-2" style="font-size:14px"> {{ $item3->product_name }}</div>  
                                                                    <div class="col-md-1 text-center" style="font-size:14px">
                                                                        {{ $item3->product_qty }} </div>
                                                                        <div class="col-md-1 text-center" style="font-size:14px">
                                                                            {{ $item3->product_unit_subname }} </div>
                                                                    <div class="col-md-1 text-center" style="font-size:14px">
                                                                        {{ number_format($item3->product_price, 4) }}</div>
                                                                    <div class="col-md-2 text-center" style="font-size:14px">
                                                                        {{ number_format($item3->product_price_total, 4) }}
                                                                    </div>
                                                                </div>
                                                                <hr> 
                                                            <?php
                                                            $total = $total + $item3->product_qty * $item3->product_price;
                                                            ?>
                                                            @endforeach
                                                            <div class="text-end me-5"> 
                                                                <label for=""
                                                                    class="me-5">ราคารวมทั้งหมด</label><label
                                                                    for=""> <b style="color: red;font-size:17px">
                                                                        {{ number_format($total, 4) }} </b> </label><label
                                                                    for="" class="ms-2"> บาท</label>
                                                            </div>
                                                        </div>
                                                      </div>
                                                      <hr>
                                                      <div class="collapse" id="collapseExample2">
                                                        <div class="card card-body">
                                                          Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.2222
                                                        </div>
                                                      </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" style="--bs-btn-border-radius: .7rem;"><i
                                                    class="fa-solid fa-xmark me-2"></i>Close</button> 
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
    </div>
</div>

<div class="modal fade" id="comdetailModal" tabindex="-1" aria-labelledby="comdetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comdetailModalLabel">เบิกวัสดุ </h5>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6 col-md-6 col-xl-6 mt-3">  
                        <div class="card">
                            <div class="card-body shadow-lg text-center">  
                                <a href="" class="btn btn-success text-white">
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    เบิกวัสดุในแผน
                                </a>
                            </div>
                        </div>
                    </div> 
                    <div class="col-6 col-md-6 col-xl-6 mt-3">  
                        <div class="card">
                            <div class="card-body shadow-lg text-center">  
                                <a href="{{ url('user_ware/warehouse_stock_main') }}" class="btn btn-info text-white">
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    เบิกวัสดุนอกแผน
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>

            <div class="modal-footer">               
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

@endsection
