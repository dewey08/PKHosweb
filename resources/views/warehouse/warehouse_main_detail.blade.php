{{-- @extends('layouts.accpk') --}}
@extends('layouts.warehouse_new')
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
            .dataTables_wrapper .dataTables_filter {
                float: right
            }

            .dataTables_wrapper .dataTables_length {
                float: left
            }

            .dataTables_info {
                float: left;
            }

            .dataTables_paginate {
                float: right
            }

            .custom-tooltip {
                --bs-tooltip-bg: var(--bs-primary);
            }

            .table thead tr th {
                font-size: 14px;
            }

            .table tbody tr td {
                font-size: 13px;
            }

            .menu {
                font-size: 13px;
            }
        }
        .hrow{
            height: 2px;
            margin-bottom: 9px;
        }

    </style>

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <div class="d-flex">
                            <div class="p-2">
                                
                                <label for="">รายการ Stock-Card คลังหลัก => {{$data_invent->warehouse_inven_name}}</label>
                            </div>
                            <div class="ms-auto p-2">
                                
                            </div>
                        </div>
                    </div>

                    <div class="card-body shadow-lg">
                        <div class="table-responsive"> 
                                <table id="example" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-family: sans-serif;font-size: 13px;">
                                        <th width="3%" class="text-center">ลำดับ</th> 
                                        <th width="10%" class="text-center">รหัสวัสดุ</th>
                                        <th class="text-center">รายการวัสดุ</th> 
                                        <th width="10%" class="text-center">รับเข้า</th>
                                        <th width="10%" class="text-center">จ่ายออก</th>
                                        <th width="10%" class="text-center">คงเหลือ</th>
                                        <th width="10%" class="text-center">ราคารวม</th> 
                                        <th width="10%" class="text-center">รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; $date = date('Y'); ?>
                                    @foreach ($warehouse_stock as $item)
                                    <?php
                                        // $paydetail_ = DB::connection('mysql')->select(                                                            '
                                        //     SELECT w.warehouse_pay_id,w.payout_inven_id,wi.warehouse_inven_name,pc.category_name
                                        //         ,ws.product_id,ws.product_code,pd.product_name,pu.unit_name,w.pay_date,ws.product_lot
                                        //         ,SUM(ws.product_qty) as qty_pay,ws.product_price,SUM(ws.product_price_total) as totalprice_pay

                                        //         from warehouse_pay w
                                        //         left outer join warehouse_pay_sub ws on ws.warehouse_pay_id = w.warehouse_pay_id
                                        //         left outer join product_data pd on pd.product_id=ws.product_id
                                        //         left outer join product_category pc on pc.category_id=pd.product_categoryid
                                        //         left outer join warehouse_inven wi on wi.warehouse_inven_id=w.payout_inven_id
                                        //         left outer join product_unit pu on pu.unit_id=ws.product_unit_subid
                                        //         where w.payout_inven_id ="'.$item->warehouse_recieve_inven_id .'"
                                        //         AND ws.product_code ="'.$item->product_code .'"                                                                                                        ',
                                        // );
                                        // foreach ($paydetail_ as $key => $value) {
                                        //    $qty_pay =  $value->qty_pay;
                                        //    $price_pay =  $value->totalprice_pay;
                                        // } 
                                    ?> 
                                        <tr id="sid{{ $item->warehouse_stock_id }}" height="15" style="font-family: sans-serif;font-size: 13px;">
                                            <td class="text-center" width="3%">{{ $i++ }}</td> 
                                            <td class="p-2" width="20%">{{ $item->product_code }}</td> 
                                            <td class="p-2">{{ $item->product_name }}</td> 
                                            <td class="text-center" width="8%">{{ $item->product_qty_recieve }} </td>
                                            <td class="text-center" width="9%">{{ $item->product_qty_pay }} </td>
                                            <td class="text-center" width="8%">{{ $item->product_qty_total   }} </td>
                                            <td class="text-end" width="10%">{{ number_format($item->product_price_total,4) }}</td> 
                                            <td class="text-center" width="10%">
                                                <a class="text-primary" href=""  style="font-size:13px"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detail{{ $item->product_id }}">
                                                    <i class="fa-solid fa-circle-info me-2 text-info"></i> 
                                                </a> 

                                            </td>
                                        </tr>


                                        <!-- Modal -->
                                        <div class="modal fade" id="detail{{ $item->product_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
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
                                                                select ws.product_id,ws.product_code,ws.product_name,ws.product_qty
                                                                ,wr.warehouse_recieve_date,ws.product_price,ws.product_price_total,pu.unit_name,ws.product_lot
                                                                from warehouse_recieve_sub ws
                                                                left outer join warehouse_recieve wr on ws.warehouse_recieve_id = wr.warehouse_recieve_id

                                                                left outer join product_data pd on pd.product_id=ws.product_id
                                                                left outer join product_category pc on pc.category_id=pd.product_categoryid
                                                                left outer join warehouse_inven wi on wi.warehouse_inven_id=wr.warehouse_recieve_inven_id
                                                                left outer join product_unit pu on pu.unit_id=ws.product_unit_subid
                                                                where ws.product_code ="'.$item->product_code .'"                                                                                                                      ',
                                                        );
                                                        $total = 0;
                                                        ?>

                                                      <div class="collapse" id="collapseExample">
                                                        <div class="card card-body">
                                                            <div class="row">
                                                                <div class="col-md-2 text-center" style="font-size:14px">วันที่รับ </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">รหัสวัสดุ </div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">LOT </div>
                                                                <div class="col-md-3 text-center" style="font-size:14px">รายการวัสดุ </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">จำนวน </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">หน่วยนับ </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">ราคา </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">ราคารวม </div>
                                                            </div>
                                                            <hr>
                                                            @foreach ($datadetail as $item3)
                                                                <div class="row hrow">
                                                                    <div class="col-md-2 text-center" style="font-size:14px;"> {{DateThai($item3->warehouse_recieve_date)}}</div>
                                                                    <div class="col-md-1 text-center" style="font-size:14px"> {{ $item3->product_code }}</div>
                                                                    <div class="col-md-2 text-center" style="font-size:14px"> {{ $item3->product_lot }}</div>
                                                                    <div class="col-md-3" style="font-size:14px"> {{ $item3->product_name }}</div>
                                                                    <div class="col-md-1 text-center" style="font-size:14px">
                                                                        {{ $item3->product_qty }} </div>
                                                                        <div class="col-md-1 text-center" style="font-size:14px">
                                                                            {{ $item3->unit_name }} </div>
                                                                    <div class="col-md-1 text-center" style="font-size:14px">
                                                                        {{ number_format($item3->product_price, 4) }}</div>
                                                                    <div class="col-md-1 text-center" style="font-size:14px">
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
                                        </div>

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
