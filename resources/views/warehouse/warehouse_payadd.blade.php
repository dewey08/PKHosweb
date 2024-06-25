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
        } else {
            echo "<body onload=\"TypeAdmin()\"></body>";
            exit();
        }
        $url = Request::url();
        $pos = strrpos($url, '/') + 1;

?>

<?php
        use Illuminate\Support\Facades\DB;
        use App\Http\Controllers\WarehouseController;
        use App\Http\Controllers\StaticController;
        use App\Models\Warehouse_pay_sub;
        $refnumber = WarehouseController::refnumber();
        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y') + 543;
        $datefull = date('Y-m-d H:i:s');
        $time = date("H:i:s");
        $loter = $date.''.$time
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

<body onload="run01();">
    <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>

        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="p-2">
                                <label for="">เพิ่มรายการวัสดุ ===>> {{$data_inven->warehouse_inven_name}}</label>
                            </div>

                        </div>
                    </div>
                    {{-- <div class="card-body shadow-lg"> --}}


                        <div class="card-body shadow-lg">
                                <form class="custom-validation" action="{{ route('pay.warehouse_payadd_save') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="warehouse_pay_id" id="warehouse_pay_id" value="{{$warehouse_pay->warehouse_pay_id }}">
                                    <div class="row mb-3">
                                        {{-- <div class="col"></div> --}}
                                        <div class="col-md-1">
                                            รายการวัสดุ
                                        </div>
                                        <div class="col-md-8">
                                            <select name="product_id" id="product_id" class="form-control form-control-sm " style="width: 100%;" required>
                                                <option value="" selected>--รายการวัสดุ--</option>
                                                @foreach ($product as $list)
                                                <?php $countcheck =  Warehouse_pay_sub::where('warehouse_recieve_sub_id','=',$list->warehouse_recieve_sub_id)->count();?>
                                                    @if($countcheck == 0  )
                                                        <option value="{{ $list->warehouse_recieve_sub_id }}">{{ $list->product_code }} {{ $list->product_name }}=>ราคา {{ $list->price }}=>LOT {{ $list->product_lot }}=>คงเหลือ {{ $list->total }} {{ $list->unit_name }}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-1 text-center">
                                            จำนวน
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="product_qty" id="product_qty" class="form-control form-control-sm ">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" class=" me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary btn-sm">
                                                <i class="fas fa-plus me-2"></i>
                                                ADD
                                            </button>
                                        </div>
                                        {{-- <div class="col"></div> --}}
                                    </div>
                                </form>
                                {{-- <form class="custom-validation" action="{{ route('pay.warehouse_payadd_save') }}" method="POST"
                                id="warehouse_paysave" enctype="multipart/form-data">
                                @csrf --}}
                                <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">

                                <input type="hidden" name="warehouse_inven_id" id="warehouse_inven_id" value="{{$data_inven->warehouse_inven_id }}">

                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">ลำดับ</th>
                                            <th width="9%" class="text-center">รหัสวัสดุ</th>
                                            <th class="text-center">รายการวัสดุ</th>
                                            <th class="text-center">หน่วย</th>
                                            <th width="8%" class="text-center">จำนวน</th>
                                            <th width="10%" class="text-center">ราคา/หน่วย</th>
                                            <th width="10%" class="text-center">ราคารวม</th>
                                            <th width="10%" class="text-center">Lot</th>
                                            <th width="5%" class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $date = date('Y');
                                        ?>
                                        @foreach ($warehouse_pay_sub as $item)
                                            <tr id="sid{{ $item->warehouse_pay_sub_id }}">
                                                <td class="text-center" width="3%">{{ $i++ }}</td>
                                                <td class="text-center" width="9%">{{ $item->product_code }} </td>
                                                <td class="p-2">{{ $item->product_name }}</td>
                                                <td class="p-2" width="14%">{{ $item->unit_name }}</td>
                                                <td class="text-center" width="9%">{{ $item->product_qty }}</td>
                                                <td class="text-center" width="10%">{{ $item->product_price }}</td>
                                                <td class="text-center" width="10%">{{ $item->product_price_total }}</td>
                                                <td class="text-center" width="10%">{{ $item->product_lot}}</td>

                                                <td class="text-center" width="5%">

                                                    <div class="dropdown d-inline-block">
                                                        <button type="button" aria-haspopup="true" aria-expanded="false"
                                                            data-bs-toggle="dropdown"
                                                            class="me-2 dropdown-toggle btn btn-outline-secondary btn-sm">
                                                            ทำรายการ
                                                        </button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu">

                                                                <button class="dropdown-item text-warning" style="font-size:13px" data-bs-toggle="modal" data-bs-target=".editModal{{ $item->warehouse_pay_sub_id }}">
                                                                    <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                                    <span>แก้ไข</span>
                                                                </button>

                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>



                        </div>
                        <div class="card-footer mt-3">
                            <div class="col-md-12 text-end">
                                <div class="form-group">
                                    
                                    {{-- <button type="button" class=" me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success btn-sm">
                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                        บันทึกข้อมูล
                                    </button>
                                    <a href="{{ url('warehouse/warehouse_pay') }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm">
                                        <i class="fa-solid fa-xmark me-2"></i>
                                        ยกเลิก
                                    </a> --}}
                                    <a href="{{ url('warehouse/warehouse_pay') }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm">
                                        <i class="fa-solid fa-xmark me-2"></i>
                                        ยกเลิก
                                    </a>
                                </div>
                            </div>
                        </div>

                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    function run01(){
                    var count = $('.tbody1').children('tr').length;
                    var number;
                        for (number = 1; number < count+1; number++) {
                            checksummoney(number);

                        }

                }
    function checkunitref_pay(number){
    var product_id = document.getElementById("product_id"+number).value;
        var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('warehouse/checkunitref_pay')}}",
                    method: "GET",
                    data: {
                        product_id: product_id,
                        _token: _token
                    },
                    success: function (result) {
                        $('.showunit'+number).html(result);
                        $('.showprice'+number).html(result);
                    }
                })
        }
        $(document).ready(function() {

            $('select').select2();

            $('#product_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
                var dateTime = 'L'+date+''+time;
                var tr ='<tr style="font-size:13px">'+
                        '<td style="text-align: center;">'+
                        number+
                        '</td>'+
                        '<td>'+
                        '<select name="product_id[]" id="product_id'+number+'" class="form-control form-control-sm js-example-basic-single" style="width: 100%;" onchange="checkunitref_pay('+number+')">'+
                        '<option value="" selected>--รายการวัสดุ--</option>'+
                        '@foreach ($product_data as $list)'+
                        '<option value="{{ $list->product_id }}">{{ $list->product_code }} {{ $list->product_name }} ==>ราคา {{ $list->price }} ==>LOT {{ $list->product_lot }} ==>ยอดคงเหลือ {{ $list->total }}</option>'+
                        '@endforeach'+
                        '</select> '+
                        '</td>'+
                        '<td><div class="showunit'+number+'">'+
                        '<select name="product_unit_subid[]" id="product_unit_subid'+number+'" class="form-control form-control-sm js-example-basic-single" style="width: 100%;">'+
                        '<option value="" selected>--หน่วย--</option>'+
                        '@foreach ($product_unit as $uni)'+
                        '<option value="{{ $uni->unit_id }}">{{$uni->unit_name}}</option>'+
                        '@endforeach'+
                        '</select> '+
                        '</td>'+
                        '<td>'+
                        '<input name="product_qty[]" id="product_qty'+number+'" type="number" class="form-control form-control-sm" onkeyup="checksummoney('+number+');">'+
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

    //-----------------------------------------------------
    function checksummoney(count){

        var SUP_TOTAL=document.getElementById("product_qty"+count).value;
        var PRICE_PER_UNIT=document.getElementById("product_price"+count).value;
       // alert(SUP_TOTAL);
        var _token=$('input[name="_token"]').val();
             $.ajax({
                     url:"{{route('ware.checksummoney')}}",
                     method:"GET",
                     data:{SUP_TOTAL:SUP_TOTAL,PRICE_PER_UNIT:PRICE_PER_UNIT,_token:_token},
                     success:function(result){
                        $('.summoney'+count).html(result);
                        findTotal();
                     }
             })
    }
    function checksummoney_pay(count){

          var SUP_TOTAL=document.getElementById("product_qty"+count).value;
        //   var PRICE_PER_UNIT=document.getElementById("product_price"+count).value;
         // alert(SUP_TOTAL);
          var _token=$('input[name="_token"]').val();
               $.ajax({
                       url:"{{route('ware.checksummoney_pay')}}",
                       method:"GET",
                       data:{SUP_TOTAL:SUP_TOTAL,_token:_token},
                       success:function(result){
                          $('.summoney'+count).html(result);
                          findTotal();
                       }
               })
      }

      function numberWithCommas(nStr) {
        nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }

      function findTotal(){
        var arr = document.getElementsByName('sum');
        var tot=0;

        count = $('.tbody1').children('tr').length;
        for(var i=0;i<count;i++){
                tot += parseFloat(arr[i].value);
        }
        count = tot.toFixed(5);
        document.getElementById('total').value = numberWithCommas(count);

    }


</script>
<script>
    $(document).ready(function() {
        $('#warehouse_paysave').on('submit',function(e){
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
        $('#Paysave').on('submit',function(e){
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
                        if (data.status == 200 ) {
                                Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                    // window.location="{{url('warehouse/warehouse_index')}}";
                                }
                                })
                            }
                        } else {

                        }
                });
        });
    });
</script>

@endsection
{{-- url:"{{route('msupplies.checkunitref')}}", --}}
