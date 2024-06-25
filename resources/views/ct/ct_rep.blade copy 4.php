@extends('layouts.ctnew')
@section('title', 'PK-OFFICER || CT')
@section('content')
    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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

        .is-hide {
            display: none;
        }

        .modal-dialog {
            max-width: 55%;
        }

        .modal-dialog-slideout {
            min-height: 100%;
            margin:auto 0 0 0 ;   /*  ซ้าย ขวา */
            background: #fff;
        }

        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;

            /* overflow-y: hidden;
            overflow-x: auto; */
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }

        .datepicker {
            z-index: 2051 !important;
        }

    </style>
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $iddep = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\PlanController;
    use App\Models\Plan_control_money;
    $refnumber = PlanController::refnumber();
    ?>
    
    
    <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div> 
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
        <form action="{{ url('ct_rep') }}" method="POST">
            @csrf
        <div class="row"> 
            <div class="col-md-2"> 
                <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail CT</h4>
                <p class="card-title-desc">รายละเอียด</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-6 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control d-shadow" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control d-shadow" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary d-shadow" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button> 
                        <button type="button" class="ladda-button btn-pill btn btn-info d-shadow" id="Pulldata">
                            <span class="ladda-label">  <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ดึงข้อมูล</span>
                            <span class="ladda-spinner"></span>
                        </button>    
                     
                        {{-- <button type="button" class="ladda-button btn-pill btn btn-danger d-shadow Syncdata" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-arrows-rotate text-danger text-white me-2"></i>Sync Data</span>
                            <span class="ladda-spinner"></span>
                        </button>  --}}
                        <button type="button" class="ladda-button btn-pill btn btn-success d-shadow CheckSit" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-user text-danger text-white me-2"></i>Check Sit</span>
                            <span class="ladda-spinner"></span>
                        </button> 
                </div> 
            </div>
        </div>      
        </form>
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardshadow">
                    <div class="card-body">  
                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                                style=" border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center">vn</th>
                                            <th class="text-center" >hn</th>
                                            <th class="text-center" >cid</th>
                                            <th class="text-center">ptname</th>
                                            <th class="text-center">vstdate</th> 
                                            <th class="text-center">สิทธิ์</th>  
                                            <th class="text-center">spsch</th> 
                                            <th class="text-center">total qty</th> 
                                            <th class="text-center">total price Hos</th> 
                                            <th class="text-center">สถานะ</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datashow as $item) 
                                            <tr id="tr_{{$item->vn}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>    
                                                <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                                <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                <td class="p-2" >{{ $item->ptname }}</td> 
                                                <td class="text-center" width="10%">{{ $item->vstdate }}</td>   
                                                <td class="text-center" width="10%">{{ $item->pttype }}</td> 
                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->ptty_spsch }}</td>  
                                                <td class="text-center" width="10%">{{ $item->qty }}</td> 
                                                {{-- <td class="text-center" width="10%">{{ number_format($item->total_price_check, 2) }}</td>  
                                                <td class="text-center" width="10%">{{ number_format($item->opaque_price, 2) }}</td>  
                                                <td class="text-center" width="10%">{{ number_format($item->before_price, 2) }}</td>   --}}
                                                <td class="text-center" width="10%">
                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#MoneyModal_2{{ $item->vn }}" data-bs-toggle="tooltip" data-bs-placement="right" title="รายละเอียด"> 
                                                        <i class="fa fa-lungs-virus" style="font-size:17px;color: rgb(255, 34, 89)"></i> 
                                                        {{ number_format($item->sum_price, 2) }}
                                                    </button> 
                                                </td> 
                                                {{-- <td class="text-center" width="10%">{{ number_format($item->paid, 2) }}</td> 
                                                <td class="text-center" width="10%">{{ number_format($item->remain, 2) }}</td>   --}}
                                                <td class="text-center" style="color:rgb(247, 34, 98)" width="10%">{{ $item->active }}</td> 
                                            </tr>

                                            <?php 
                                                $data_sub = DB::select('
                                                        SELECT a.vn,a.hn,a.cid,a.vstdate,a.ptname,a.pttype,a.ptty_spsch,a.qty,a.sum_price,b.icode,b.ctname,b.qty,b.unitprice,b.sum_price
                                                        FROM a_ct a 
                                                        LEFT OUTER JOIN a_ct_item b ON b.vn = a.vn
                                                        WHERE a.vstdate AND a.vn = "'.$item->vn.'"
                                                ');   
                                                ?>  
                                                <div class="modal fade" id="MoneyModal_2{{ $item->vn }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
                                                    <div class="modal-dialog modal-dialog-slideout">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
 
                                                            <hr>
                                                            <div class="row mt-4" style="font-size:15px;color:red"> 
                                                                <div class="col"></div>
                                                                <div class="col-md-1 text-center" >vstdate</div>
                                                                <div class="col-md-1 text-center" >icode</div>
                                                                <div class="col-md-3 text-center" >รายการ</div>
                                                                <div class="col-md-1 text-center">qty</div>
                                                                <div class="col-md-1 text-center">unitprice </div>
                                                                <div class="col-md-1 text-center">total</div>
                                                                {{-- <div class="col-md-1 text-center">รวมค่าตรวจ</div> --}}
                                                                {{-- <div class="col-md-1 text-center">ค่าสารทึบแสง</div> --}}
                                                                {{-- <div class="col-md-1 text-center">before</div>  --}}
                                                                {{-- <div class="col-md-1 text-center">Total</div> --}}
                                                                {{-- <div class="col-md-1 text-center">ค่าใช้จ่ายรวม</div> --}}
                                                                {{-- <div class="col-md-1 text-center">ชำระแล้ว</div> --}}
                                                                {{-- <div class="col-md-1 text-center">ค้างชำระ</div> --}}
                                                                <div class="col"></div>
                                                            </div>
                                                            <?php $ii = 1; ?>
                                                            @foreach ($data_sub as $v)
                                                            <hr>
                                                                <div class="row" style="font-size:12px;height: 12px;">  
                                                                    <div class="col"></div>
                                                                    <div class="col-md-1 text-start">{{ $v->vstdate}}</div>
                                                                    <div class="col-md-1 text-start">{{ $v->icode}}</div>
                                                                    <div class="col-md-3 text-start">{{ $v->ctname}}</div>
                                                                    <div class="col-md-1 text-start">{{ $v->qty}}</div> 
                                                                    <div class="col-md-1 text-center">{{ number_format($v->unitprice, 2) }}</div>
                                                                    <div class="col-md-1 text-center">{{ number_format($v->sum_price, 2) }}</div>
                                                                    {{-- @if ($v->total_price_check == '')
                                                                    <div class="col-md-1 text-center">0.00</div> 
                                                                    @else
                                                                    <div class="col-md-1 text-center">{{ number_format($v->total_price_check, 2) }}</div> 
                                                                    @endif

                                                                    @if ($v->opaque_price == '')
                                                                        <div class="col-md-1 text-center">0.00</div> 
                                                                    @else
                                                                        <div class="col-md-1 text-center">{{ number_format($v->opaque_price, 2) }}</div> 
                                                                    @endif
                                                                    
                                                                    @if ($v->before_price =='')
                                                                        <div class="col-md-1 text-center">0.00</div>
                                                                    @else
                                                                        <div class="col-md-1 text-center">{{ number_format($v->before_price, 2) }}</div>
                                                                    @endif 

                                                                    @if ($v->total =='')
                                                                        <div class="col-md-1 text-center">0.00</div>
                                                                    @else
                                                                        <div class="col-md-1 text-center">{{ number_format($v->total, 0) }}</div>
                                                                    @endif

                                                                    @if ($v->sumprice =='')
                                                                        <div class="col-md-1 text-center">0.00</div>
                                                                    @else
                                                                        <div class="col-md-1 text-center">{{ number_format($v->sumprice, 2) }}</div>
                                                                    @endif

                                                                    @if ($v->paid =='')
                                                                        <div class="col-md-1 text-center">0.00</div>
                                                                    @else
                                                                        <div class="col-md-1 text-center">{{ number_format($v->paid, 2) }}</div>
                                                                    @endif

                                                                    @if ($v->remain =='')
                                                                        <div class="col-md-1 text-center">0.00</div>
                                                                    @else
                                                                        <div class="col-md-1 text-center">{{ number_format($v->remain, 2) }}</div>
                                                                    @endif  --}}
                                                                    <div class="col"></div>
                                                                </div>
                                                            @endforeach 
                                                            <hr>
                                                            <form class="custom-validation" action="{{ route('ct.ct_rep_confirm') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                        
                                                            {{-- <form action="{{ route('ct.ct_rep_confirm') }}" method="POST" id="Comfirmfinish">
                                                                @csrf --}}
                                                                <input type="hidden" id="vn" name="vn" value="{{ $item->vn }}">
                                                                <div class="row mt-5">
                                                                    <div class="col"></div>
                                                                    <div class="col-md-2">
                                                                        {{-- <button type="button" class="ladda-button btn-pill btn btn-success d-shadow Finish me-3 ms-2" data-style="expand-left" style="width: 150px">
                                                                            <span class="ladda-label me-2"> <i class="fa-solid fa-user text-danger text-white me-2 ms-2"></i>Finish</span>
                                                                            <span class="ladda-spinner"></span>
                                                                        </button> --}}
                                                                        <button type="submit" class="ladda-button btn-pill btn btn-success d-shadow me-3 ms-2" data-style="expand-left" style="width: 150px">
                                                                            <span class="ladda-label me-2"> <i class="fa-solid fa-user text-danger text-white me-2 ms-2"></i>Finish</span>
                                                                            <span class="ladda-spinner"></span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="col"></div>
                                                                </div> 
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    {{-- <div class="modal fade" id="MoneyModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-slideout">
          <div class="modal-content">
            <div class="modal-body">


            </div>
        </div>
    </div>  --}}


    <div class="modal fade" id="MoneyModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-slideout">
          <div class="modal-content">
            <div class="modal-body">
               
                {{-- <hr>
                <div class="row mt-4" style="font-size:15px;color:red"> 
                    <div class="col-md-2 text-center" >รายการ</div>
                    <div class="col-md-2 text-center" >รายการ HOS</div>
                    <div class="col-md-1 text-center">ค่าตรวจ </div>
                    <div class="col-md-1 text-center">รวมค่าตรวจ</div>
                    <div class="col-md-1 text-center">ค่าสารทึบแสง</div>
                    <div class="col-md-1 text-center">before</div> 
                    <div class="col-md-1 text-center">Total</div>
                    <div class="col-md-1 text-center">ค่าใช้จ่ายรวม</div>
                    <div class="col-md-1 text-center">ชำระแล้ว</div>
                    <div class="col-md-1 text-center">ค้างชำระ</div>
                </div>
                <?php $ii = 1; ?>
                @foreach ($data_sub as $v)
                <hr>
                    <div class="row" style="font-size:12px;height: 12px;">  
                        <div class="col-md-2 text-start">{{ $v->ct_check}}</div>
                        <div class="col-md-2 text-start">{{ $v->ct_check_hos}}</div>
                        <div class="col-md-1 text-center">{{ number_format($v->price_check, 2) }}</div>
                        @if ($v->total_price_check == '')
                           <div class="col-md-1 text-center">0.00</div> 
                        @else
                           <div class="col-md-1 text-center">{{ number_format($v->total_price_check, 2) }}</div> 
                        @endif

                        @if ($v->opaque_price == '')
                            <div class="col-md-1 text-center">0.00</div> 
                        @else
                            <div class="col-md-1 text-center">{{ number_format($v->opaque_price, 2) }}</div> 
                        @endif
                        
                        @if ($v->before_price =='')
                            <div class="col-md-1 text-center">0.00</div>
                        @else
                            <div class="col-md-1 text-center">{{ number_format($v->before_price, 2) }}</div>
                        @endif 

                        @if ($v->total =='')
                            <div class="col-md-1 text-center">0.00</div>
                        @else
                            <div class="col-md-1 text-center">{{ number_format($v->total, 0) }}</div>
                        @endif

                        @if ($v->sumprice =='')
                            <div class="col-md-1 text-center">0.00</div>
                        @else
                            <div class="col-md-1 text-center">{{ number_format($v->sumprice, 2) }}</div>
                        @endif

                        @if ($v->paid =='')
                            <div class="col-md-1 text-center">0.00</div>
                        @else
                            <div class="col-md-1 text-center">{{ number_format($v->paid, 2) }}</div>
                        @endif

                        @if ($v->remain =='')
                            <div class="col-md-1 text-center">0.00</div>
                        @else
                            <div class="col-md-1 text-center">{{ number_format($v->remain, 2) }}</div>
                        @endif 
                    </div>
                @endforeach 
                <hr> --}}
              

                <input type="text" name="ct_check_edit" id="ct_check_edit">
                <input type="text" name="price_check_edit" id="price_check_edit">

                <input type="text" name="total_price_check_edit" id="total_price_check_edit">
                <input type="text" name="opaque_price_edit" id="opaque_price_edit">
                <input type="text" name="before_price_edit" id="before_price_edit">
                <input type="text" name="total_edit" id="total_edit">
                <input type="text" name="sumprice_edit" id="sumprice_edit">
                <input type="text" name="paid_edit" id="paid_edit">
                <input type="text" name="remain_edit" id="remain_edit"> 

                <input type="text" name="ct_date_edit" id="ct_date_edit"> 
                <input type="text" name="cid_edit" id="cid_edit"> 

                {{-- <input type="text" name="a_stm_ct_id_edit" id="a_stm_ct_id_edit"> --}}
                <div class="row mt-5">
                    <div class="col"></div>
                    <div class="col-md-2">
                        <button type="button" class="ladda-button btn-pill btn btn-success d-shadow Finish me-3 ms-2" data-style="expand-left" style="width: 150px">
                            <span class="ladda-label me-2"> <i class="fa-solid fa-user text-danger text-white me-2 ms-2"></i>Finish</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                    <div class="col"></div>
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
            $('#example3').DataTable();
           
            $('#startdate').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#enddate').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
           
            $('[data-toggle="datepicker"]').datepicker({ 
                autoHide: true,
                zIndex: 2048,
            });
             
            $('select').select2();
            $('#plan_control_moneyuser_id').select2({
                dropdownParent: $('#MoneyModal')
            });

            $('#edit_plan_type').select2({
                dropdownParent: $('#UpdateModal')
            });
            
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           

            $(document).on('click', '.MoneyModal', function() {
                var a_stm_ct_id = $(this).val();
                // $('#plan_control_moneydate').datepicker();
                // alert(a_stm_ct_id);
                $('#MoneyModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('ct_rep_edit') }}" + '/' + a_stm_ct_id,
                    success: function(data) { 
                        $('#ct_check_edit').val(data.data_show.ct_check)
                        $('#price_check_edit').val(data.data_show.price_check)
                        $('#total_price_check_edit').val(data.data_show.total_price_check)
                        $('#opaque_price_edit').val(data.data_show.opaque_price)
                        $('#before_price_edit').val(data.data_show.before_price)
                        $('#total_edit').val(data.data_show.total)
                        $('#sumprice_edit').val(data.data_show.sumprice)
                        $('#paid_edit').val(data.data_show.paid)
                        $('#remain_edit').val(data.data_show.remain)
                        $('#ct_date_edit').val(data.data_show.ct_date)
                        $('#cid_edit').val(data.data_show.cid)
                        // $('#a_stm_ct_id_edit').val(data.data_show.a_stm_ct_id)
                    },
                });
            });
            
            $('.Syncdata').click(function() {
                var startdate = $('#datepicker').val();
                var enddate = $('#datepicker2').val(); 
                Swal.fire({
                    title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
                    text: "You Sync Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Sync it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#overlay").fadeIn(300);
                        $("#spinner").show();

                        $.ajax({
                            url: "{{ url('ct_rep_sync') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                startdate,
                                enddate
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        title: 'ซิ้งค์ข้อมูลสำเร็จ',
                                        text: "You Sync data success",
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
                                            $('#spinner')
                                        .hide(); //Request is complete so hide spinner
                                            setTimeout(function() {
                                                $("#overlay").fadeOut(
                                                    300);
                                            }, 500);
                                        }
                                    })

                                } else if (data.status == 100) {
                                    Swal.fire({
                                        title: 'ข้อมูลไม่ตรง',
                                        text: "Data Can not.",
                                        icon: 'warning',
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

                    }
                })
            });

            $('.Finish').click(function() {
                // var id = $(this).val();
                var a_stm_ct_id = $('#a_stm_ct_id_tt').val(); 
                alert(a_stm_ct_id);
                Swal.fire({
                    title: 'ยืนยันข้อมูลครบถ้วนใช่ไหม ?',
                    text: "You Confirm Data Success!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Sync it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#overlay").fadeIn(300);
                        $("#spinner").show();

                        // $.ajax({
                        //     url: "{{ route('ct.ct_rep_confirm') }}",
                        //     type: "POST",
                        //     dataType: 'json',
                        //     data: {a_stm_ct_id},
                        //     success: function(data) {
                        //         if (data.status == 200) {
                        //             Swal.fire({
                        //                 title: 'ยืนยันข้อมูลสำเร็จ',
                        //                 text: "You Confirm data success",
                        //                 icon: 'success',
                        //                 showCancelButton: false,
                        //                 confirmButtonColor: '#06D177',
                        //                 confirmButtonText: 'เรียบร้อย'
                        //             }).then((result) => {
                        //                 if (result
                        //                     .isConfirmed) {
                        //                     console.log(
                        //                         data);
                        //                     window.location.reload();
                        //                     $('#spinner')
                        //                 .hide(); //Request is complete so hide spinner
                        //                     setTimeout(function() {
                        //                         $("#overlay").fadeOut(
                        //                             300);
                        //                     }, 500);
                        //                 }
                        //             })

                        //         } else if (data.status == 100) {
                                     

                        //         } else {

                        //         }
                        //     },
                        // });

                    }
                })
            });


            $('.CheckSit').click(function() {
                var datestart = $('#datepicker').val(); 
                var dateend = $('#datepicker2').val(); 
                //    alert(datestart);
                Swal.fire({
                        title: 'ต้องการตรวจสอบสอทธิ์ใช่ไหม ?',
                        text: "You Check Sit Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner-div").show(); //Load button clicked show spinner 
                            $.ajax({
                                url: "{{ route('ct.ct_rep_checksit') }}",
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    datestart,
                                    dateend                        
                                },
                                success: function(data) {
                                    if (data.status == 200) { 
                                        Swal.fire({
                                            title: 'เช็คสิทธิ์สำเร็จ',
                                            text: "You Check sit success",
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
                                                $('#spinner-div').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(300);
                                                    },500);
                                            }
                                        })
                                    } else {
                                        
                                    }

                                },
                            });
                        }
                })
            });

            $('#Pulldata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You Warn Pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('ct.ct_rep_pull') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Pull data success",
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
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

           

           

        });
    </script>

@endsection
