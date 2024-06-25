@extends('layouts.warehouse')
@section('title', 'PK-OFFICER || คลังวัสดุ')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $storeid = Auth::user()->store_id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    ?>
    <style>
        .btn {
            font-size: 15px;
        }

        /* .td {
            font-size: 14px;
            color: #FFFFFF;

        } */

        .bgc {
            background-color: #264886;
        }

        .bga {
            background-color: #fbff7d;
        }
    </style>
    <?php
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\WarehousePayController;
    use App\Http\Controllers\StaticController;
        $refnumber = WarehousePayController::refnumber();
        date_default_timezone_set('Asia/Bangkok');
        $dateyear = date('Y') + 543;
        $datefull = date('Y-m-d H:i:s');
        $time = date("H:i:s");
        $loter = $dateyear.''.$time;
        $date = date('Y-m-d');
    ?>


    <body>
        <div class="container-fluids">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>เลือกรายการวัสดุที่ต้องการจ่าย</h5>
                                </div>
                                <div class="col"></div>
                                <div class="col-md-1 text-end">รายการวัสดุ </div>
                                <div class="col-md-2">
                                   {{-- <input type="text" class="form-control form-control-sm" id="" name=""> --}}
                                   <select name="product_id" id="product_id" class="form-control form-control-sm " style="width: 100%;" required>
                                    <option value="" selected>--รายการวัสดุ--</option>
                                    @foreach ($product_data as $list)
                                        <option value="{{ $list->product_id }}">
                                            {{ $list->product_name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-md-1 text-end">จำนวน </div>
                                <div class="col-md-1">
                                    <input type="text" class="form-control form-control-sm" id="" name="">
                                </div>
                               
                                <div class="col-md-1 text-start">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#insertpaydata"> 
                                        <i class="fa-brands fa-cc-amazon-pay me-2"></i>
                                        จ่าย
                                    </button>
                                </div>
                                <div class="col"></div>
                            </div>
                        </div>
                        <div class="card-body shadow-lg">
                            <div class="table-responsive"> 
                                <table style="width: 100%;" id="example"
                                    class="table table-hover table-striped table-bordered myTable" 
                                    >
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">ลำดับ</th> 
                                            <th width="9%" class="text-center">LOT</th>  
                                            <th width="9%" class="text-center">รหัสวัสดุ</th> 
                                            <th class="text-center">รายการวัสดุ</th> 
                                            <th width="8%" class="text-center">จำนวน</th>
                                            <th width="10%" class="text-center">ราคา</th>
                                            <th width="10%" class="text-center">รวม</th>
                                            <th width="5%" class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; 
                                        ?>
                                        {{-- @foreach ($warehouse_pay as $item)
                                            <tr id="sid{{ $item->warehouse_pay_id }}">
                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                <td class="text-center" width="9%">{{ $item->warehouse_pay_code }} </td>
                                                <td class="text-center" width="4%">{{ $item->warehouse_pay_year }}</td>
                                                <td class="text-center" width="9%">
                                                    {{ DateThai($item->warehouse_pay_date) }}
                                                </td>
                                                <?php  
                                                $pay_frominven = DB::table('warehouse_inven')->where('warehouse_inven_id', '=', $item->warehouse_pay_frominven_id)->first();
                                                $pay_frominven_name = $pay_frominven->warehouse_inven_name;
                                                
                                                $pay_fromuser = DB::table('users')->where('id', '=', $item->warehouse_pay_fromuser_id)->first();
                                                $pay_fromuser_name = $pay_fromuser->fname.' '.$pay_fromuser->lname;
                                                ?>
                                                <td class="p-2">{{ $pay_frominven_name }}</td>     
                                                <td class="p-2" width="14%">{{ $item->warehouse_inven_name }}</td>
                                                <td class="text-center" width="9%">{{ $item->warehouse_pay_status_name }}</td>
                                                <td class="text-center" width="10%">{{ $item->fname }} {{ $item->lname }}</td>
                                                <td class="text-center" width="10%">{{ $pay_fromuser_name}}</td>
                                                
                                                <td class="text-center" width="5%">
                                                     
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            
                                                            <label for="" style="color: rgb(57, 57, 57);font-size:13px">ทำรายการ</label>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-warning" href="{{url('warehouse/warehouse_pay_edit/'.$item->warehouse_pay_id)}}"  
                                                                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                <label for="" style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                            </a>
                                                            
                                                    </div>
    
                                                </td>
                                            </tr>
     
                                        @endforeach --}}
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
                $('select').select2(); 
                       
                $('#product_id').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                // $('#warehouse_pay_year').select2({
                // dropdownParent: $('#insertpaydata')
                // });
                // $('#warehouse_pay_repuser_id').select2({
                // dropdownParent: $('#insertpaydata')
                // });
                 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#Savebtn').click(function() {
                var warehouse_pay_code = $('#warehouse_pay_code').val();
                var warehouse_pay_no_bill = $('#warehouse_pay_no_bill').val();
                var warehouse_pay_year = $('#warehouse_pay_year').val();
                var warehouse_pay_fromuser_id = $('#warehouse_pay_fromuser_id').val();
                var warehouse_pay_repuser_id = $('#warehouse_pay_repuser_id').val();
                var warehouse_pay_date = $('#warehouse_pay_date').val();
                var warehouse_pay_frominven_id = $('#warehouse_pay_frominven_id').val();
                var warehouse_pay_inven_id = $('#warehouse_pay_inven_id').val();
                var store_id = $('#store_id').val();
                $.ajax({
                    url: "{{ route('pay.warehouse_paysave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        warehouse_pay_code,
                        warehouse_pay_no_bill,
                        warehouse_pay_year,
                        warehouse_pay_fromuser_id,
                        warehouse_pay_repuser_id,
                        warehouse_pay_date,
                        warehouse_pay_inven_id,
                        warehouse_pay_frominven_id,
                        store_id
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



            });
   
        </script>


    @endsection
