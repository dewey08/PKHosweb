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
        $time = date("H:i:s");
        $loter = $date.''.$time
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
    <div class="container-fluids">
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
                                <form class="custom-validation" action="{{ route('user_ware.warehouse_stock_subsave') }}" method="POST" 
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
                                                    class="form-control form-control-sm" name="warehouse_deb_req_code"
                                                    value="{{ $refnumber }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="warehouse_deb_req_date">วันที่่ต้องการ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input class="form-control form-control-sm" type="datetime-local"
                                                id="example-datetime-local-input" name="warehouse_deb_req_date" value="{{$datefull}}"> 
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="warehouse_deb_req_savedate">วันที่่บันทึก :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input class="form-control form-control-sm" type="datetime-local"
                                                id="example-datetime-local-input" name="warehouse_deb_req_savedate" value="{{$datefull}}" readonly> 
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
                                                            <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}
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
                                                <select id="warehouse_deb_req_userid" name="warehouse_deb_req_userid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($users as $itemu)
                                                    @if ($iduser == $itemu->id)
                                                    <option value="{{ $itemu->id }}" selected> {{ $itemu->fname }} {{ $itemu->lname }} </option>
                                                    @else
                                                    <option value="{{ $itemu->id }}"> {{ $itemu->fname }} {{ $itemu->lname }} </option>
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
                                                    <option value="{{ $item2->id }}" selected>{{ $item2->fname }} {{ $item2->lname }} </option>
                                                    @else
                                                    <option value="{{ $item2->id }}">{{ $item2->fname }} {{ $item2->lname }} </option>
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
                                                <input id="warehouse_deb_req_because" type="text" class="form-control form-control-sm" name="warehouse_deb_req_because" >
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
                                            <tr
                                                style="background-color: rgb(68, 101, 101);color:#FFFFFF;font-size:14px">
                                                <td style="text-align: center;"width="3%">ลำดับ</td>
                                                <td style="text-align: center;">รายการวัสดุ</td> 
                                                <td style="text-align: center;" width="6%">หน่วย</td>
                                                <td style="text-align: center;" width="6%">จำนวน</td> 
                                                <td style="text-align: center;" width="4%">
                                                    <a class="btn btn-sm btn-success addRow" style="color:#FFFFFF;"><i
                                                            class="fas fa-plus"></i></a>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody1">
                                            <tr height="30" style="font-size:13px">
                                                <td style="text-align: center;"> 1 </td>
                                                <td>
                                                    <select name="product_id[]" id="product_id0" class="form-control form-control-sm " style="width: 100%;" onchange="checkunituser(0);" required>
                                                        <option value="" selected>--รายการวัสดุ--</option>
                                                        @foreach ($product_data as $list)
                                                            <option value="{{ $list->product_id }}">
                                                                {{ $list->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td> 
                                                <td>
                                                    <div class="showunits0">
                                                    <select name="PRODUCT_UNIT_SUBID[]" id="PRODUCT_UNIT_SUBID[]" class="form-control form-control-sm js-example-basic-single" style="width: 100%;">
                                                        <option value="" selected>--หน่วย--</option>
                                                        @foreach ($product_unit as $uni)
                                                                    <option value="{{$uni->unit_id }}">{{ $uni->unit_name}}</option>
                                                                @endforeach                   
                                                    </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="product_qty[]" id="product_qty0" type="number" class="form-control form-control-sm" >
                                                </td>
   
                                                <td style="text-align: center;">
                                                    <a class="btn btn-sm btn-danger fa fa-trash-alt remove1"
                                                        style="color:#FFFFFF;">
                                                    </a>
                                                </td>
                                               
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr>
                                    <div class="row">
                                        <div class="col-md-7"> </div>
                                            <div class="col-md-2 text-end">  
                                                <label for="" style="color: red">รวมมูลค่า</label>
                                            </div>
                                            <div class="col-md-2">   
                                                <input class="form-control form-control-sm" style="text-align: right;background-color:#fffec5 ;font-size: 16px;color:red" type="text" name="total" id="total" readonly>                                            
                                            </div>
                                            <div class="col-md-1">  
                                                <label for="" style="color: red">บาท</label>
                                            </div>
                                        </div>
                                    </div> 
                            </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-md-12 text-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-floppy-disk me-2"></i>
                                            บันทึกข้อมูล
                                        </button>
                                        <a href="{{ url('warehouse/warehouse_index') }}" class="btn btn-danger btn-sm">
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
    @endsection
    @section('footer')
    <script>
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        function checkunituser(number){    
    var productid = document.getElementById("product_id"+number).value;        
        var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('user_ware/checkunituser')}}",
                    method: "GET",
                    data: {
                        productid: productid,
                        _token: _token
                    },
                    success: function (result) {
                        $('.showunits'+number).html(result);
                    }
                })   
        }
            $(document).ready(function() {

$('select').select2(); 
           
$('#product_id').select2({
    placeholder: "--เลือก--",
    allowClear: true
});




$('.addRow').on('click',function(){
    addRow();
    var count = $('.tbody1').children('tr').length;
        var number =  (count+ 1).valueOf();
        // datepicker(number);
        $('.js-example-basic-single').select2();
});
function addRow(){
    var count = $('.tbody1').children('tr').length;
    var number =  (count + 1).valueOf();

    var today = new Date();
    var date = String(today.getFullYear()).substring(2)+''+String(today.getMonth()+1).padStart(2, '0')+''+String(today.getDate()).padStart(2, '0');
    var time = String(today.getHours()).padStart(2, '0') + "" + String(today.getMinutes()).padStart(2, '0') + "" + String(today.getSeconds()).padStart(2, '0');;
    var dateTime = 'L'+date+'-'+time;
    var tr ='<tr style="font-size:13px">'+
            '<td style="text-align: center;">'+
            number+
            '</td>'+
            '<td>'+
            '<select name="product_id[]" id="product_id'+number+'" class="form-control form-control-sm js-example-basic-single" style="width: 100%;" onchange="checkunituser('+number+')">'+            
            '<option value="" selected>--รายการวัสดุ--</option>'+ 
            '@foreach ($product_data as $list)'+
            '<option value="{{ $list->product_id }}">{{$list->product_name}}</option>'+
            '@endforeach'+
            '</select> '+
            '</td>'+    
            '<td>'+
            '<div class="showunits'+number+'">'+
            '<select name="PRODUCT_UNIT_SUBID[]" id="PRODUCT_UNIT_SUBID'+number+'" class="form-control form-control-sm js-example-basic-single" style="width: 100%;">'+            
            '<option value="" selected>--หน่วย--</option>'+ 
            '@foreach ($product_unit as $uni)'+
            '<option value="{{ $uni->unit_id }}">{{$uni->unit_name}}</option>'+
            '@endforeach'+
            '</select> '+
            '</div>'+
            '</td>'+             
            '<td>'+
            '<input name="product_qty[]" id="product_qty'+number+'" type="number" class="form-control form-control-sm">'+
            '</td>'+              
            '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;"></a></td>'+                        
            '</tr>';
    $('.tbody1').append(tr);
    };
    $('.tbody1').on('click','.remove1', function(){
$(this).parent().parent().remove(); 
 
});

});
</script>
<script> 
        $('body').on('keydown', 'input, select, textarea', function(e) {
        var self = $(this)
          , form = self.parents('form:eq(0)')
          , focusable
          , next
          ;
        if (e.keyCode == 13) {
            focusable = form.find('input,a,select,button,textarea').filter(':visible');
            next = focusable.eq(focusable.index(this)+1);
            if (next.length) {
                next.focus();
            } else {
                form.submit();
            }
            return false;
        }
    });
            

    
</script>
<script>
     $(document).ready(function() {
        $('#warehouse_save').on('submit',function(e){
                    e.preventDefault();            
                    var form = this; 
                    $.ajax({
                          url:$(form).attr('action'),
                          method:$(form).attr('method'),
                          data:new FormData(form),
                          processData:false,
                          dataType:'json',
                          contentType:false,
                          beforeSend:function(){
                            $(form).find('span.error-text').text('');
                          },
                          success:function(data){
                            if (data.status == 100 ) {
                                Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับเข้าคลัง...!!',
                                text: 'กรุณาเลือกรับเข้าคลังอะไร!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    }
                                })
                            }else if (data.status == 150 ) {
                                Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับจาก...!!',
                                text: 'กรุณาเลือกรับจากตัวแทนจำหน่ายอะไร!',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                    }
                                })
                            }else if (data.status == 500 ) {
                                Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรายการวัสดุ...!!',
                                text: 'กรุณาเลือกรายการวัสดุ!',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                    }
                                })
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('warehouse/warehouse_index')}}";
                                }
                              })      
                            }
                          }
                    });
              });
    });
</script>
    
@endsection
