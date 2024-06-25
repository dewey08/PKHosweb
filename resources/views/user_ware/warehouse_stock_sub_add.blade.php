@extends('layouts.user')
@section('title', 'PK-OFFICER || คลังย่อย')
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
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    use App\Http\Controllers\UserwarehouseController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    
    $refnumber = UserwarehouseController::refnumber();
    $checkhn = UserwarehouseController::checkhn($iduser);
    
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
    {{-- <body onload="run01();"> --}}

    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="row invoice-card-row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-header ">
                                <div class="d-flex">
                                    <div class="p-2">
                                        <label for="">เบิกวัสดุ</label>
                                    </div>
                                    <div class="ms-auto p-2">
                                        {{-- <a href="{{ url('user_ware/warehouse_stock_sub_add') }}" class="btn btn-info btn-sm text-white">
                                            <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                            เบิกวัสดุ
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- id="stock_subsave_save"  --}}
                            <div class="card-body ">
                                <div class="row">
                                    <form class="custom-validation"
                                        action="{{ route('user_ware.warehouse_stock_subsave') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <label for="warehouse_deb_req_code">เลขที่เบิก :</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input id="warehouse_deb_req_code" type="text"
                                                            class="form-control form-control-sm"
                                                            name="warehouse_deb_req_code" value="{{ $refnumber }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="warehouse_deb_req_date">วันที่ต้องการ :</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input class="form-control form-control-sm" type="datetime-local"
                                                            id="example-datetime-local-input" name="warehouse_deb_req_date"
                                                            value="{{ $datefull }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="warehouse_deb_req_savedate">วันที่บันทึก :</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input class="form-control form-control-sm" type="datetime-local"
                                                            id="example-datetime-local-input"
                                                            name="warehouse_deb_req_savedate" value="{{ $datefull }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="warehouse_deb_req_year">ปีงบ :</label>
                                                </div>
                                                <div class="col-md-2">
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
                                                <div class="col-md-1">
                                                    <label for="warehouse_deb_req_userid">ผู้ขอเบิก :</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select id="warehouse_deb_req_userid"
                                                            name="warehouse_deb_req_userid"
                                                            class="form-select form-select-lg" style="width: 100%">
                                                            <option value="">--เลือก--</option>
                                                            @foreach ($users as $itemu)
                                                                @if ($iduser == $itemu->id)
                                                                    <option value="{{ $itemu->id }}" selected>
                                                                        {{ $itemu->fname }} {{ $itemu->lname }} </option>
                                                                @else
                                                                    <option value="{{ $itemu->id }}">
                                                                        {{ $itemu->fname }} {{ $itemu->lname }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="warehouse_deb_req_hnid">ผู้เห็นชอบ :</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select id="warehouse_deb_req_hnid" name="warehouse_deb_req_hnid"
                                                            class="form-select form-select-lg" style="width: 100%" required>
                                                            <option value="">--เลือก--</option>
                                                            @foreach ($users as $item2)
                                                                @if ($item2->id == $checkhn)
                                                                    <option value="{{ $item2->id }}" selected>
                                                                        {{ $item2->fname }} {{ $item2->lname }} </option>
                                                                @else
                                                                    <option value="{{ $item2->id }}">
                                                                        {{ $item2->fname }} {{ $item2->lname }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="warehouse_deb_req_because">เหตุผล :</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input id="warehouse_deb_req_because" type="text"
                                                            class="form-control form-control-sm"
                                                            name="warehouse_deb_req_because">
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                </div>

                                <hr>

                                <div class="card-body shadow-lg">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                            <thead>
                                                <tr style="background-color: rgb(43, 86, 136);color:#FFFFFF;font-size:14px">
                                                    <td style="text-align: center;"width="3%">ลำดับ</td>
                                                    <td style="text-align: center;">รายการวัสดุ</td>
                                                    <td style="text-align: center;" width="6%">เลือก</td>
                                                    <td style="text-align: center;" width="10%">หน่วย</td>
                                                    <td style="text-align: center;" width="10%">จำนวน</td>
                                                    <td style="text-align: center;" width="4%">
                                                        <a class="btn btn-outline-success btn-sm addRow"
                                                            style="color:#FFFFFF;"><i class="fas fa-plus"></i></a>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody1">
                                                <tr style="text-align: center; font-size: 13px;">
                                                    <td style="text-align: center; font-size: 13px;">
                                                        1
                                                    </td>
                                                    <td style="text-align: left;" class="p-2 infoselectsupreq0"> </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#addsup"
                                                            onclick="getdetailselect(0);">เลือก</button>
                                                    </td>
                                                    <td style="text-align: left;" class="p-2 infounitname0"
                                                    width="10%">

                                                </td>
                                                    <td class="text-pedding" width="10%">
                                                        <input name="WAREHOUSE_REQUEST_SUB_AMOUNT[]" id="WAREHOUSE_REQUEST_SUB_AMOUNT"
                                                            class="form-control form-control-sm" style=" font-family: 'Kanit', sans-serif;">
                                                    </td>
                                                   

                                                    <td style="text-align: center;"><a
                                                            class="btn btn-outline-danger btn-sm remove"
                                                            style="color:#e2a704;"><i class="fa fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>


                                <input type="hidden" name="warehouse_inven_id" id="warehouse_inven_id"
                                    value="{{ $data_warehouse_stock->warehouse_inven_id }}">



                                <div class="card-footer">
                                    <div class="col-md-12 text-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                                บันทึกข้อมูล
                                            </button>
                                            <a href="{{ url('warehouse/warehouse_index') }}"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-xmark me-2"></i>
                                                ยกเลิก
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
        </div>
        <!--    เมนูเลือก   -->

        <div class="modal fade" id="addsup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" >
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title"
                            style="font-family: 'Kanit', sans-serif; font-size:14px;font-size: 1.5rem;font-weight:normal;">
                            เลือกวัสดุที่ต้องการเบิก</h2>
                    </div>
                    <div class="modal-body">

                        <body>
                            <div class="container mt-3">
                                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                <br>
                                <div style='overflow:scroll; height:300px;'>

                                    <div id="getdetailselect"></div>

                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <div align="right">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"> <i
                                    class="fa-solid fa-xmark me-2"></i>ปิดหน้าต่าง</button>

                        </div>
                    </div>
    </body>
    </div>
    </div>
    </div>
@endsection
@section('footer')
    <script>
        $('select').select2();
        $('#product_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });

        // $('.addRow').on('click', function() {
        //     addRow();
        //     var count = $('.tbody1').children('tr').length;
        //     var number = (count).valueOf();
        //     $('.js-example-basic-single').select2();
        // });

        $('.addRow').on('click', function() {
            addRow();
            var count = $('.tbody1').children('tr').length;
            var number = (count).valueOf();
            // checkcountdetail()
        });

        function addRow() {
            var count = $('.tbody1').children('tr').length;
            var number = (count + 1).valueOf();

            var tr = '<tr style="text-align: center; font-size: 13px;">' +
                '<td style="text-align: center;">' +
                +number +
                '</td>' +
                '<td style="text-align: left;" class="p-2 infoselectsupreq' + count + '">' +
                '</td>' +
                '<td class="text-center">' +
                '<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addsup"  onclick="getdetailselect(' +
                count + ');">เลือก</button>' +
                '</td>' +
                '<td style="text-align: left;" class="p-2 infounitname' + count + '" >' +
                '</td>' +
                '<td class="text-pedding">' +
                '<input name="WAREHOUSE_REQUEST_SUB_AMOUNT[]" id="WAREHOUSE_REQUEST_SUB_AMOUNT" class="form-control form-control-sm" style=" font-family: \'Kanit\', sans-serif;"  >' +
                '</td>' +
               
                '<td style="text-align: center;"><a class="btn btn-outline-danger btn-sm remove" style="color:#e2a704;"><i class="fa fa-trash-alt"></i></a></td>' +
                '</tr>';

            $('.tbody1').append(tr);
        };

        $('.tbody1').on('click', '.remove', function() {
            $(this).parent().parent().remove();
            // checkcountdetail()
        });

        function getdetailselect(count) {
            var id_inven = document.getElementById("warehouse_inven_id").value;
            $.ajax({
                url: "{{ route('user_ware.getdetailselect') }}",
                method: "GET",
                data: {
                    id_inven: id_inven,
                    count: count
                },
                success: function(result) {
                    $('#getdetailselect').html(result);
                }
            })
        }

        function selectsupreq(id_inven, count) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('user_ware.selectsupreq') }}",
                method: "GET",
                data: {
                    id_inven: id_inven,
                    _token: _token
                },
                success: function(result) {
                    $('.infoselectsupreq' + count).html(result);
                    $('.infounitname' + count).html(result);
                }
            })
            $.ajax({
                url: "{{ route('user_ware.selectsupunitname') }}",
                method: "GET",
                data: {
                    id_inven: id_inven,
                    _token: _token
                },
                success: function(result) {
                    $('.infounitname' + count).html(result);
                }
            })
            $('#addsup').modal('hide');
        }


        // ***************************

        function checkunituser(number) {
            var productid = document.getElementById("product_id" + number).value;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('user_ware/checkunituser') }}",
                method: "GET",
                data: {
                    productid: productid,
                    _token: _token
                },
                success: function(result) {
                    $('.showunits' + number).html(result);
                }
            })
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection


{{-- function selectsupreq(id_inven, count) {
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: "{{ route('warehouse.selectsupreq') }}",
        method: "GET",
        data: {
            id_inven: id_inven,
            _token: _token
        },
        success: function(result) {
            $('.infoselectsupreq' + count).html(result);
        }
    })
    $.ajax({
        url: "{{ route('warehouse.selectsupunitname') }}",
        method: "GET",
        data: {
            id_inven: id_inven,
            _token: _token
        },
        success: function(result) {
            $('.infounitname' + count).html(result);
        }
    })
    $('#modeladdsup').modal('hide');
} --}}
