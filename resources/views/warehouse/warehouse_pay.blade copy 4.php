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
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
           }
           .cv-spinner {
           height: 100%;
           display: flex;
           justify-content: center;
           align-items: center;
           }
           .spinner {
           width: 250px;
           height: 250px;
           border: 10px #ddd solid;
           border-top: 10px #1fdab1 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% {
               transform: rotate(390deg);
           }
           }
           .is-hide{
           display:none;
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


<div class="tabs-animation">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
            </div>
        </div>
    </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-1 text-end">
                                    <p for="pay_code">เลขที่บิล :</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="pay_code" type="text"
                                            class="form-control form-control-sm" name="pay_code"
                                            value="{{ $refnumber }}" style="font-family: sans-serif;font-size: 13px;"
                                             readonly>
                                    </div>
                                </div>


                                <div class="col-md-1 text-end">
                                    <p for="pay_year">ปีงบ :</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="pay_year" name="pay_year"
                                            class="form-select form-select-lg" style="width: 100%" style="font-family: sans-serif;font-size: 13px;">
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

                                <div class="col-md-1 text-end">
                                    <p for="pay_date">วันที่จ่าย  :</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="pay_date" type="date"
                                            class="form-control form-control-sm" name="pay_date" value="{{ $date }}" style="font-family: sans-serif;font-size: 13px;">
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <p for="pay_user_id">ผู้รับ :</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="pay_user_id" name="pay_user_id"
                                            class="form-select form-select-lg" style="width: 100%" style="font-family: sans-serif;font-size: 13px;">
                                            <option value="">--เลือก--</option>
                                            @foreach ($users as $ue)
                                                <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <div class="row mt-3">
                                <div class="col-md-1 text-end">
                                    <p for="pay_payuser_id">ผู้จ่าย :</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                            <select id="pay_payuser_id" name="pay_payuser_id"
                                            class="form-select form-select-lg" style="width: 100%" style="font-family: sans-serif;font-size: 13px;">
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

                                <div class="col-md-1 text-end">
                                    <p for="payout_inven_id">จ่ายจากคลัง :</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select id="payout_inven_id" name="payout_inven_id"
                                        class="form-select form-select-lg" style="width: 100%" style="font-family: sans-serif;font-size: 13px;">
                                        <option value="">--เลือก--</option>
                                        @foreach ($warehouse_inven as $inven)
                                            {{-- <option value="{{ $inven->warehouse_inven_id }}">
                                                {{ $inven->warehouse_inven_name }}
                                            </option> --}}
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <p for="payin_inven_id">รับเข้าคลัง :</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select id="payin_inven_id" name="payin_inven_id"
                                        class="form-select form-select-lg" style="width: 100%" style="font-family: sans-serif;font-size: 13px;">
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

                            <input type="hidden" name="store_id" id="store_id" value="{{$storeid}}">
                            <input type="hidden" name="warehouse_pay_id" id="editwarehouse_pay_id" >

                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <div class="form-group">
                                        <button type="button" id="Savebtn" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-floppy-disk me-2"></i>
                                            สร้างใบจ่าย
                                        </button> 
                                    </div>
                                </div>
                            </div>


                        </div>
                           
                            {{-- <div class="card-footer">
                                <div class="col-md-12 text-end">
                                    <div class="form-group">
                                        <button type="button" id="Savebtn" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary btn-sm">
                                            <i class="fa-solid fa-floppy-disk me-2"></i>
                                            สร้างใบเบิก
                                        </button> 
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            รายการจ่ายวัสดุ
                            <div class="btn-actions-pane-right">
                                <div role="group" class="btn-group-sm btn-group">

                                    {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                                        data-bs-toggle="modal" data-bs-target="#insertpaydata">
                                        <i class="pe-7s-shuffle btn-icon-wrapper"></i>สร้างใบเบิก
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body shadow-lg">
                                {{-- <table style="width: 100%;" id="example"
                                    class="table table-hover table-striped table-bordered myTable"
                                    > --}}
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-family: sans-serif;font-size: 13px;">
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
                                                <tr id="sid{{ $item->warehouse_pay_id }}" style="font-family: sans-serif;font-size: 13px;">
                                                    <td class="text-center" width="3%">{{ $i++ }}</td>
                                                    <td class="text-center" width="9%">{{ $item->pay_code }} </td>
                                                    <td class="text-center" width="4%">{{ $item->pay_year }}</td>
                                                    <td class="text-center" width="9%"> {{ DateThai($item->pay_date) }} </td>
                                                    <?php
                                                    //จ่ายจากคลัง
                                                    $pay_frominven = DB::table('warehouse_inven')->where('warehouse_inven_id', '=', $item->payout_inven_id)->first();
                                                    // $pay_frominven_name = $pay_frominven->warehouse_inven_name;

                                                    //ผู้จ่าย
                                                    $pay_fromuser = DB::table('users')->where('id', '=', $item->pay_payuser_id)->first();
                                                    $pay_fromuser_name = $pay_fromuser->fname.' '.$pay_fromuser->lname;
                                                    ?>
                                                    <td class="p-2">
                                                        {{-- {{ $pay_frominven_name }} --}}
                                                    </td>
                                                    <td class="p-2" width="14%">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
                                                    <td class="text-center" width="9%">{{ $item->pay_status }}</td>
                                                    <td class="text-center" width="10%">{{ $item->fname }} {{ $item->lname }}</td>
                                                    <td class="text-center" width="10%">{{ $pay_fromuser_name}}</td>

                                                    <td class="text-center" width="5%">

                                                        {{-- <div class="btn-group">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <p for="" style="color: rgb(57, 57, 57);font-size:13px">ทำรายการ</p>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item text-warning" href="{{url('warehouse/warehouse_pay_edit/'.$item->warehouse_pay_id)}}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                    <p for="" style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</p>
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item text-warning" href="{{url('warehouse/warehouse_pay_sub/'.$item->warehouse_pay_id)}}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการจ่าย">
                                                                    <i class="fa-solid fa-folder-plus me-2" style="color: rgb(112, 34, 238)"></i>
                                                                    <p for="" style="color: rgb(112, 34, 238);font-size:13px">เพิ่มรายการจ่าย</p>
                                                                </a>
                                                        </div> --}}
                                                        <div class="dropdown d-inline-block">
                                                            <button type="button" aria-haspopup="true" aria-expanded="false"
                                                                data-bs-toggle="dropdown"
                                                                class="me-2 dropdown-toggle btn btn-outline-secondary btn-sm">
                                                                ทำรายการ
                                                            </button>
                                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu">
                                                                <a class="dropdown-item text-warning"
                                                                        href="{{url('warehouse_payedit/'.$item->warehouse_pay_id)}}" style="font-size:13px" target="blank">
                                                                        <i class="fa-solid fa-clipboard-check me-2 text-warning"
                                                                            style="font-size:13px"></i>
                                                                        <span>แก้ไข</span>
                                                                    </a>
                                                                    {{-- <button class="dropdown-item text-warning" style="font-size:13px" data-bs-toggle="modal" data-bs-target=".editModal{{ $item->warehouse_pay_id }}">
                                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                                        <span>แก้ไข</span>
                                                                    </button> --}}
                                                                <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-primary"
                                                                    href="{{ url('warehouse_payadd/' . $item->warehouse_pay_id) }}"
                                                                    style="font-size:13px" target="blank">
                                                                    <i class="fa-solid fa-clipboard-check me-2 text-primary"
                                                                        style="font-size:13px"></i>
                                                                    <span>เพิ่มรายการวัสดุ</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>


                                                  <!-- Modal Edit-->
                                        <div class="modal fade editModal{{ $item->warehouse_pay_id }}" id="editModal" tabindex="-1" role="dialog" aria-pledby="editModalp" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myExtraLargeModalp">แก้ไขใบเบิก</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-p="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-2 text-end">
                                                                    <p for="pay_code">เลขที่บิล :</p>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <input id="editpay_code" type="text"
                                                                            class="form-control form-control-sm" name="pay_code"
                                                                            value="{{ $item->pay_code }}"
                                                                             readonly>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-2 text-end">
                                                                    <p for="pay_year">ปีงบ :</p>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <select id="editpay_year" name="pay_year"
                                                                            class="form-select form-select-lg" style="width: 100%">
                                                                            <option value="">--เลือก--</option>
                                                                            @foreach ($budget_year as $ye)
                                                                                @if ($ye->leave_year_id ==  $item->pay_year)
                                                                                    <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }} </option>
                                                                                @else
                                                                                    <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }} </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 text-end">
                                                                    <p for="pay_date">วันที่จ่าย  :</p>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <input id="editpay_date" type="date" class="form-control form-control-sm" name="pay_date" value="{{ $item->pay_date }}">
                                                                    </div>
                                                                </div>


                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-md-2 text-end">
                                                                    <p for="editpay_payuser_id">ผู้จ่าย :</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                            <select id="editpay_payuser_id" name="pay_payuser_id"
                                                                            class="form-select form-select-lg" style="width: 100%">
                                                                            <option value="">--เลือก--</option>
                                                                            @foreach ($users as $ue)
                                                                                @if ($ue->id == $item->pay_payuser_id)
                                                                                    <option value="{{ $ue->id }}" selected> {{ $ue->fname }}  {{ $ue->lname }} </option>
                                                                                @else
                                                                                    <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 text-end">
                                                                    <p for="pay_user_id">ผู้รับ :</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <select id="editpay_user_id" name="pay_user_id"
                                                                            class="form-select form-select-lg" style="width: 100%">
                                                                            <option value="">--เลือก--</option>
                                                                            @foreach ($users as $uee)
                                                                                @if ($uee->id == $item->pay_user_id)
                                                                                    <option value="{{ $uee->id }}" selected> {{ $uee->fname }}  {{ $uee->lname }} </option>
                                                                                @else
                                                                                    <option value="{{ $uee->id }}"> {{ $uee->fname }}  {{ $uee->lname }} </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-md-2 text-end">
                                                                    <p for="payout_inven_id">จ่ายจากคลัง :</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <select id="editpayout_inven_id" name="payout_inven_id"
                                                                        class="form-select form-select-lg" style="width: 100%">
                                                                        <option value="">--เลือก--</option>
                                                                        {{-- @foreach ($warehouse_inven as $inven)
                                                                        @if ($item->payout_inven_id ==$inven->warehouse_inven_id )
                                                                        <option value="{{ $inven->warehouse_inven_id }}" selected>{{ $inven->warehouse_inven_name }}</option>
                                                                        @else
                                                                        <option value="{{ $inven->warehouse_inven_id }}">{{ $inven->warehouse_inven_name }}</option>
                                                                        @endif

                                                                        @endforeach --}}
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 text-end">
                                                                    <p for="payin_inven_id">รับเข้าคลัง :</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <select id="editpayin_inven_id" name="payin_inven_id"
                                                                        class="form-select form-select-lg" style="width: 100%">
                                                                        <option value="">--เลือก--</option>
                                                                        @foreach ($department_sub_sub as $dep)
                                                                        @if ($item->payin_inven_id == $dep->DEPARTMENT_SUB_SUB_ID)
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
                                                        <input type="hidden" name="store_id" id="editstore_id" value="{{$storeid}}">
                                                        <input type="hidden" name="warehouse_pay_id" id="editwarehouse_pay_id" value="{{$item->warehouse_pay_id}}">
                                                        <div class="modal-footer">
                                                            <div class="col-md-12 text-end">
                                                                <div class="form-group">
                                                                    <button type="button" id="Updatebtn" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary btn-sm">
                                                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                        บันทึกข้อมูล
                                                                    </button>
                                                                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
                                                                            class="fa-solid fa-xmark me-2"></i>Close</button>

                                                                </div>
                                                            </div>
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

        <!--  Modal content for the insertborrowdata example -->
        <div class="modal fade" id="insertpaydata" tabindex="-1" role="dialog" aria-pledby="myExtraLargeModalp"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalp">สร้างใบเบิก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-p="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2 text-end">
                                <p for="pay_code">เลขที่บิล :</p>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="pay_code" type="text"
                                        class="form-control form-control-sm" name="pay_code"
                                        value="{{ $refnumber }}"
                                         readonly>
                                </div>
                            </div>


                            <div class="col-md-2 text-end">
                                <p for="pay_year">ปีงบ :</p>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="pay_year" name="pay_year"
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

                            <div class="col-md-2 text-end">
                                <p for="pay_date">วันที่จ่าย  :</p>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="pay_date" type="date"
                                        class="form-control form-control-sm" name="pay_date" value="{{ $date }}">
                                </div>
                            </div>


                        </div>

                        <div class="row mt-3">
                            <div class="col-md-2 text-end">
                                <p for="pay_payuser_id">ผู้จ่าย :</p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                        <select id="pay_payuser_id" name="pay_payuser_id"
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
                                <p for="pay_user_id">ผู้รับ :</p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="pay_user_id" name="pay_user_id"
                                        class="form-select form-select-lg" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($users as $ue)
                                            <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-2 text-end">
                                <p for="payout_inven_id">จ่ายจากคลัง :</p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="payout_inven_id" name="payout_inven_id"
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value="">--เลือก--</option>
                                    @foreach ($warehouse_inven as $inven)
                                        {{-- <option value="{{ $inven->warehouse_inven_id }}">
                                            {{ $inven->warehouse_inven_name }}
                                        </option> --}}
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <p for="payin_inven_id">รับเข้าคลัง :</p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="payin_inven_id" name="payin_inven_id"
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
                                <button type="button" id="Savebtn" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
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
                $('#pay_year').select2({
                // dropdownParent: $('#insertpaydata')
                placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#pay_user_id').select2({
                // dropdownParent: $('#insertpaydata')
                placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#pay_payuser_id').select2({
                // dropdownParent: $('#insertpaydata')
                placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#payin_inven_id').select2({
                // dropdownParent: $('#insertpaydata')
                placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#payout_inven_id').select2({
                // dropdownParent: $('#insertpaydata')
                placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#warehouse_pay_year2').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });

                $('#editpay_year').select2({
                    dropdownParent: $('#editModal')
                });
                $('#editpay_payuser_id').select2({
                    dropdownParent: $('#editModal')
                });
                $('#editpay_user_id').select2({
                    dropdownParent: $('#editModal')
                });

                $('#editpayout_inven_id').select2({
                    dropdownParent: $('#editModal')
                });
                $('#editpayin_inven_id').select2({
                    dropdownParent: $('#editModal')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#Savebtn').click(function() {
                    var pay_code = $('#pay_code').val();
                    // var warehouse_pay_no_bill = $('#warehouse_pay_no_bill').val();
                    var pay_year = $('#pay_year').val();
                    var pay_payuser_id = $('#pay_payuser_id').val();
                    var pay_user_id = $('#pay_user_id').val();
                    var pay_date = $('#pay_date').val();
                    var payin_inven_id = $('#payin_inven_id').val();
                    var payout_inven_id = $('#payout_inven_id').val();
                    var store_id = $('#store_id').val();
                    $.ajax({
                        url: "{{ route('pay.warehouse_paysave') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            pay_code,
                            // warehouse_pay_no_bill,
                            pay_year,
                            pay_payuser_id,
                            pay_user_id,
                            pay_date,
                            payout_inven_id,
                            payin_inven_id,
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


                $('#Updatebtn').click(function() {
                    var editpay_code = $('#editpay_code').val();
                    var editwarehouse_pay_id = $('#editwarehouse_pay_id').val();
                    var editpay_year = $('#editpay_year').val();
                    var editpay_payuser_id = $('#editpay_payuser_id').val();
                    var editpay_user_id = $('#editpay_user_id').val();
                    var editpay_date = $('#editpay_date').val();
                    var editpayin_inven_id = $('#editpayin_inven_id').val();
                    var editpayout_inven_id = $('#editpayout_inven_id').val();
                    var editstore_id = $('#editstore_id').val();
                    $.ajax({
                        url: "{{ route('pay.warehouse_payupdate') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            editpay_code,
                            editwarehouse_pay_id,
                            editpay_year,
                            editpay_payuser_id,
                            editpay_user_id,
                            editpay_date,
                            editpayout_inven_id,
                            editpayin_inven_id,
                            editstore_id
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You Update data success",
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
