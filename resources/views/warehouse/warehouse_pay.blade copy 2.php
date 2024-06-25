@extends('layouts.warehouse_new')
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
                                <div class="col-md-4">
                                    <h5>เบิกจ่ายวัสดุ</h5>
                                </div>
                                <div class="col"></div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#insertpaydata">
                                        <i class="fa-solid fa-file-waveform me-2"></i>
                                        สร้างใบเบิก
                                    </button>
                                </div>
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
                                            <th width="9%" class="text-center">เลขที่บิล</th>
                                            <th width="4%" class="text-center">ปีงบ</th>
                                            <th width="9%" class="text-center">วันที่จ่าย</th>
                                            <th class="text-center">จากคลัง</th>
                                            <th class="text-center">รับเข้าคลัง</th> 
                                            <th width="8%" class="text-center">สถานะคลัง</th>
                                            <th width="10%" class="text-center">ผู้รับ</th>
                                            <th width="10%" class="text-center">ผู้จ่าย</th>
                                            <th width="5%" class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $date = date('Y');
                                        ?>
                                        @foreach ($warehouse_pay as $item)
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
                                                {{-- <td class="text-center" width="5%">
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">ทำรายการ</button>
                                                        <ul class="dropdown-menu"> 
                                                           
                                                           
                                                            <a class="dropdown-item menu" 
                                                                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="รายละเอียด" >
                                                                <i class="fa-solid fa-pen-to-square ms-2 me-2 text-primary"></i>
                                                                <label for=""
                                                                    style="font-size:13px;color: rgb(15, 107, 228)">รายละเอียด</label>
                                                            </a> 
                                                           
                                                        </ul>
                                                    </div>
    
                                                </td> --}}
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
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-warning" href="{{url('warehouse/warehouse_pay_sub/'.$item->warehouse_pay_id)}}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการจ่าย">
                                                                <i class="fa-solid fa-folder-plus me-2" style="color: rgb(112, 34, 238)"></i>
                                                                <label for="" style="color: rgb(112, 34, 238);font-size:13px">เพิ่มรายการจ่าย</label>
                                                            </a>
                                                          
                                                            {{-- <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="person_destroy({{ $mem->id }})" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                            </a>
                                                        </div> --}}
                                                    </div>
    
                                                </td>
                                            </tr>
    
                                                <!--  Modal content for the editpaydata example -->
                                                {{-- <div class="modal fade" id="editpaydata{{ $item->warehouse_pay_id }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myExtraLargeModalLabel">แก้ไขใบเบิก</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-2 text-end">
                                                                        <label for="warehouse_pay_code">เลขที่บิล :</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <input id="warehouse_pay_code" type="text"
                                                                                class="form-control form-control-sm" name="warehouse_pay_code"
                                                                                value="{{ $item->warehouse_pay_code }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-end">
                                                                        <label for="warehouse_pay_no_bill">เลขที่เอกสาร :</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <input id="warehouse_pay_no_bill" type="text"
                                                                                class="form-control form-control-sm" name="warehouse_pay_no_bill">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2 text-end">
                                                                        <label for="warehouse_pay_year">ปีงบ :</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <select id="editwarehouse_pay_year" name="warehouse_pay_year"
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
                                                                                <select id="editwarehouse_pay_fromuser_id" name="warehouse_pay_fromuser_id"
                                                                                class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                                                                <option value="">--เลือก--</option>
                                                                                @foreach ($users as $ue)
                                                                                    @if ($ue->id == $item->warehouse_pay_fromuser_id)
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
                                                                            <select id="editwarehouse_pay_repuser_id" name="warehouse_pay_repuser_id"
                                                                                class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                                                                <option value="">--เลือก--</option>
                                                                                @foreach ($users as $ue)                                               
                                                                                    <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>                                             
                                                                                @endforeach
                                                                            </select>                                    
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-end">
                                                                        <label for="warehouse_pay_date">วันที่จ่าย  :</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <input id="warehouse_pay_date" type="date"
                                                                                class="form-control form-control-sm" name="warehouse_pay_date" value="{{ $date }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-2 text-end">
                                                                        <label for="warehouse_pay_frominven_id">จ่ายจากคลัง :</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group"> 
                                                                            <select id="editwarehouse_pay_frominven_id" name="warehouse_pay_frominven_id"
                                                                            class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                                                            <option value="">--เลือก--</option>
                                                                            @foreach ($warehouse_inven as $inven)
                                                                                <option value="{{ $inven->warehouse_inven_id }}">
                                                                                    {{ $inven->warehouse_inven_name }}
                                                                                </option>
                                                                            @endforeach 
                                                                        </select> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-end">
                                                                        <label for="warehouse_pay_inven_id">รับเข้าคลัง :</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <select id="editwarehouse_pay_inven_id" name="warehouse_pay_inven_id"
                                                                            class="form-select form-select-lg" style="width: 100%;font-size:14px">
                                                                            <option value="">--เลือก--</option>
                                                                            @foreach ($department_sub_sub as $dep)
                                                                                <option value="{{ $dep->DEPARTMENT_SUB_SUB_ID }}">
                                                                                    {{ $dep->DEPARTMENT_SUB_SUB_NAME }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>                  
                                                                        </div>
                                                                    </div> 
                                                                </div>

                                                            </div>
                                                            <input type="hidden" name="store_id" id="store_id" value="{{$storeid}}">

                                                            <div class="modal-footer">
                                                                <div class="col-md-12 text-end">
                                                                    <div class="form-group">
                                                                        <button type="button" id="Savebtn" class="btn btn-primary btn-sm">
                                                                            <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                            บันทึกข้อมูล
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                                                                class="fa-solid fa-xmark me-2"></i>Close</button>

                                                                    </div>
                                                                </div>
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

        <!--  Modal content for the insertborrowdata example -->
        <div class="modal fade" id="insertpaydata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">สร้างใบเบิก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2 text-end">
                                <label for="warehouse_pay_code">เลขที่บิล :</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="warehouse_pay_code" type="text"
                                        class="form-control form-control-sm" name="warehouse_pay_code"
                                        value="{{ $refnumber }}"
                                         readonly>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <label for="warehouse_pay_no_bill">เลขที่เอกสาร :</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="warehouse_pay_no_bill" type="text"
                                        class="form-control form-control-sm" name="warehouse_pay_no_bill">
                                </div>
                            </div>
                            
                            <div class="col-md-2 text-end">
                                <label for="warehouse_pay_year">ปีงบ :</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="warehouse_pay_year" name="warehouse_pay_year"
                                        class="form-select form-select-lg" style="width: 100%">
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
                                        class="form-select form-select-lg" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($users as $ue)
                                            @if ($ue->id == $iduser)
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
                                        class="form-select form-select-lg" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($users as $ue)                                               
                                            <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>                                             
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <label for="warehouse_pay_date">วันที่จ่าย  :</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="warehouse_pay_date" type="date"
                                        class="form-control form-control-sm" name="warehouse_pay_date" value="{{ $date }}">
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
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value="">--เลือก--</option>
                                    @foreach ($warehouse_inven as $inven)
                                        <option value="{{ $inven->warehouse_inven_id }}">
                                            {{ $inven->warehouse_inven_name }}
                                        </option>
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
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value="">--เลือก--</option>
                                    @foreach ($department_sub_sub as $dep)
                                        <option value="{{ $dep->DEPARTMENT_SUB_SUB_ID }}">
                                            {{ $dep->DEPARTMENT_SUB_SUB_NAME }}
                                        </option>
                                    @endforeach
                                </select>                  
                                </div>
                            </div> 
                        </div>

                    </div>
                    <input type="hidden" name="store_id" id="store_id" value="{{$storeid}}">

                    <div class="modal-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="button" id="Savebtn" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark me-2"></i>Close</button>

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
                dropdownParent: $('#insertpaydata')
                });
                $('#warehouse_pay_repuser_id').select2({
                dropdownParent: $('#insertpaydata')
                });
                $('#warehouse_pay_fromuser_id').select2({
                dropdownParent: $('#insertpaydata')
                });
                $('#warehouse_pay_inven_id').select2({
                dropdownParent: $('#insertpaydata')
                });
                $('#warehouse_pay_frominven_id').select2({
                dropdownParent: $('#insertpaydata')
                });

                // $('#editwarehouse_pay_year').select2({
                // dropdownParent: $('#insertpaydata')
                // });
                // $('#editwarehouse_pay_repuser_id').select2({
                // dropdownParent: $('#insertpaydata')
                // });
                // $('#editwarehouse_pay_fromuser_id').select2({
                // dropdownParent: $('#insertpaydata')
                // });
                // $('#editwarehouse_pay_inven_id').select2({
                // dropdownParent: $('#insertpaydata')
                // });
                // $('#editwarehouse_pay_frominven_id').select2({
                // dropdownParent: $('#insertpaydata')
                // });

                $('#warehouse_pay_year2').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });

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
