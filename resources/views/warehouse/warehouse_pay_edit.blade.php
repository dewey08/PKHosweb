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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>แก้ไขใบเบิกจ่ายวัสดุ</h5>
                                </div>
                                <div class="col"></div>
                                <div class="col-md-2 text-end">
                                    {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#insertpaydata">
                                        <i class="fa-solid fa-file-waveform me-2"></i>
                                        สร้างใบเบิก
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body shadow-lg">
                            <div class="row">
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_code">เลขที่บิล :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="warehouse_pay_code" type="text"
                                            class="form-control form-control-sm" name="warehouse_pay_code"
                                            value="{{ $warehouse_pay->warehouse_pay_code }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_no_bill">เลขที่เอกสาร :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="warehouse_pay_no_bill" type="text"
                                            class="form-control form-control-sm" name="warehouse_pay_no_bill" value="{{ $warehouse_pay->warehouse_pay_no_bill }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_year">ปีงบ :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="warehouse_pay_year" name="warehouse_pay_year"
                                            class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                            <option value="">--เลือก--</option>
                                            @foreach ($budget_year as $ye)
                                                @if ($ye->leave_year_id == $dateyear)
                                                    <option value="{{ $ye->leave_year_id }}" selected>
                                                        {{ $ye->leave_year_id }} </option>
                                                @else
                                                    <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                            
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_fromuser_id">ผู้จ่าย :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group"> 
                                            <select id="warehouse_pay_fromuser_id" name="warehouse_pay_fromuser_id"
                                            class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                            <option value="">--เลือก--</option>
                                            @foreach ($users as $ue)
                                                @if ($ue->id == $warehouse_pay->warehouse_pay_fromuser_id)
                                                    <option value="{{ $ue->id }}" selected> {{ $ue->fname }}  {{ $ue->lname }} </option>
                                                @else
                                                    <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_repuser_id">ผู้รับ :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="warehouse_pay_repuser_id" name="warehouse_pay_repuser_id"
                                            class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                            <option value="">--เลือก--</option>
                                            @foreach ($users as $ue)  
                                            @if ( $ue->id == $warehouse_pay->warehouse_pay_repuser_id)
                                            <option value="{{ $ue->id }}" selected> {{ $ue->fname }}  {{ $ue->lname }} </option> 
                                            @else
                                            <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option> 
                                            @endif                                             
                                                                                           
                                            @endforeach
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_date">วันที่จ่าย  :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">                                       
                                            <input class="form-control form-control-sm" type="datetime-local"
                                            id="example-datetime-local-input" name="warehouse_pay_date" value="{{ $warehouse_pay->warehouse_pay_date }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_frominven_id">จ่ายจากคลัง :</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <select id="warehouse_pay_frominven_id" name="warehouse_pay_frominven_id"
                                        class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                        <option value="">--เลือก--</option>
                                        @foreach ($warehouse_inven as $inven)
                                        @if ( $warehouse_pay->warehouse_pay_frominven_id == $inven->warehouse_inven_id)
                                        <option value="{{ $inven->warehouse_inven_id }}" selected> {{ $inven->warehouse_inven_name }} </option>
                                        @else
                                        <option value="{{ $inven->warehouse_inven_id }}"> {{ $inven->warehouse_inven_name }} </option>
                                        @endif
                                            
                                        @endforeach 
                                    </select> 
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <label for="warehouse_pay_inven_id">รับเข้าคลัง :</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="warehouse_pay_inven_id" name="warehouse_pay_inven_id"
                                        class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                        <option value="">--เลือก--</option>
                                        @foreach ($department_sub_sub as $dep)
                                        @if ($warehouse_pay->warehouse_pay_inven_id == $dep->DEPARTMENT_SUB_SUB_ID)
                                        <option value="{{ $dep->DEPARTMENT_SUB_SUB_ID }}" selected> {{ $dep->DEPARTMENT_SUB_SUB_NAME }} </option>
                                        @else
                                        <option value="{{ $dep->DEPARTMENT_SUB_SUB_ID }}"> {{ $dep->DEPARTMENT_SUB_SUB_NAME }} </option>
                                        @endif
                                           
                                        @endforeach
                                    </select>                  
                                    </div>
                                </div> 
                            </div>

                        </div>
                        <input type="hidden" name="store_id" id="store_id" value="{{$storeid}}">
                        <input type="hidden" name="warehouse_pay_id" id="warehouse_pay_id" value="{{$warehouse_pay->warehouse_pay_id}}">
                        <div class="card-footer">
                            <div class="col-md-12 text-end">
                                <div class="form-group">
                                    <button type="button" id="Savebtn" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                        แก้ไขข้อมูล
                                    </button>
                                    <a href="{{ url('warehouse/warehouse_pay') }}" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-xmark me-2"></i>
                                        ยกเลิก
                                    </a>
                                </div>
                            </div>
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
                // $('select').select2();
                

                $('#warehouse_pay_year').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#warehouse_pay_repuser_id').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#warehouse_pay_fromuser_id').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#warehouse_pay_inven_id').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#warehouse_pay_frominven_id').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#Savebtn').click(function() {
                    // alert('ok');
                var warehouse_pay_code = $('#warehouse_pay_code').val();
                var warehouse_pay_no_bill = $('#warehouse_pay_no_bill').val();
                var warehouse_pay_year = $('#warehouse_pay_year').val();
                var warehouse_pay_fromuser_id = $('#warehouse_pay_fromuser_id').val();
                var warehouse_pay_repuser_id = $('#warehouse_pay_repuser_id').val();
                var warehouse_pay_date = $('#example-datetime-local-input').val();
                var warehouse_pay_frominven_id = $('#warehouse_pay_frominven_id').val();
                var warehouse_pay_inven_id = $('#warehouse_pay_inven_id').val();
                var warehouse_pay_id = $('#warehouse_pay_id').val();
                var store_id = $('#store_id').val();
                $.ajax({
                    url: "{{ route('pay.warehouse_payupdate') }}",
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
                        store_id,
                        warehouse_pay_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
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
                                    // window.location.reload();
                                    window.location = "{{ url('warehouse/warehouse_pay') }}";
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
