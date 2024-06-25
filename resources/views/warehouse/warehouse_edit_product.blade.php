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
            {{-- <form class="custom-validation" action="{{ route('ware.warehouse_addsave') }}" method="POST"
                            id="warehouse_save" enctype="multipart/form-data"> --}}
                            <form class="custom-validation" action="{{ route('ware.warehouse_update_product') }}" method="POST"
                            id="warehouse_updateaddsub" enctype="multipart/form-data">
                            @csrf
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="p-2">
                                <label for="">แก้ไขรายการวัสดุ ===>> {{$inven->warehouse_inven_name}}</label>
                            </div>

                        </div>
                    </div>

                        <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">
                        <input type="hidden" name="warehouse_rep_id" id="warehouse_rep_id" value="{{$warehouse_rep->warehouse_rep_id }}">
                        <input type="hidden" name="warehouse_inven_id" id="warehouse_inven_id" value="{{$inven->warehouse_inven_id }}">

                        <div class="card-body shadow-lg">
                            <div class="table-responsive">
                                <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                    <thead>
                                        <tr
                                            style="background-color: rgb(68, 101, 101);color:#FFFFFF;font-size:14px">
                                            <td style="text-align: center;"width="3%">ลำดับ</td>
                                            <td style="text-align: center;">รายการวัสดุ</td>
                                            <td style="text-align: center;" width="8%">ประเภท</td>
                                            <td style="text-align: center;" width="6%">หน่วย</td>
                                            <td style="text-align: center;" width="6%">จำนวน</td>
                                            <td style="text-align: center;" width="8%">ราคา</td>
                                            <td style="text-align: center;" width="12%">รวม</td>
                                            <td style="text-align: center;" width="12%">Lot</td>
                                            <td style="text-align: center;" width="6%">วันผลิต</td>
                                            <td style="text-align: center;" width="6%">วันหมดอายุ</td>
                                            <td style="text-align: center;" width="6%">status</td>
                                            <td style="text-align: center;" width="4%">
                                                <a class="btn btn-sm btn-success addRow" style="color:#FFFFFF;"><i
                                                        class="fas fa-plus"></i></a>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody1">
                                        @if ( $count == 0)
                                            @foreach ($data_sub as $item)
                                                <tr height="30" style="font-size:13px">
                                                        <td style="text-align: center;"> 1 </td>
                                                        <td>
                                                            <select name="product_id[]" id="product_id0" class="form-control form-control-sm " style="width: 100%;" onchange="checkunitref(0);" required>
                                                                <option value="" selected>--รายการวัสดุ--</option>
                                                                @foreach ($product_data as $list)
                                                                @if ($item->product_id == $list->product_id)
                                                                <option value="{{ $list->product_id }}" selected> {{ $list->product_name }}</option>
                                                                @else
                                                                <option value="{{ $list->product_id }}">{{ $list->product_code }} {{ $list->product_name }}</option>
                                                                @endif

                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="product_type_id[]" id="product_type_id0" class="form-control form-control-sm" style="width: 100%;" >

                                                                        @foreach ($products_typefree as $free)
                                                                        @if ($item->product_type_id == $free->products_typefree_id)
                                                                        <option value="{{ $free -> products_typefree_id }}" selected>{{ $free->products_typefree_name}}</option>
                                                                        @else
                                                                        <option value="{{ $free -> products_typefree_id }}">{{ $free->products_typefree_name}}</option>
                                                                        @endif

                                                                        @endforeach
                                                            </select>
                                                        </td>
                                                        <td><div class="showunit0">
                                                            <select name="product_unit_subid[]" id="product_unit_subid[]"  class="form-control form-control-sm" style="width: 100%;">
                                                                <option value="" selected>--หน่วย--</option>

                                                                        @foreach ($product_unit as $uni)
                                                                        @if ($item->product_unit_subid == $uni->unit_id)
                                                                        <option value="{{ $uni -> unit_id }}" selected>{{ $uni->unit_name}}</option>
                                                                        @else
                                                                        <option value="{{ $uni -> unit_id }}">{{ $uni->unit_name}}</option>
                                                                        @endif

                                                                        @endforeach
                                                            </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input name="product_qty[]" id="product_qty0" type="text" class="form-control form-control-sm" onkeyup="checksummoney(0)" >
                                                        </td>

                                                        <td>
                                                            @if ($item->product_price == '')
                                                            <input name="product_price[]" id="product_price0" type="text" class="form-control form-control-sm" onkeyup="checksummoney(0)">
                                                            @else
                                                            <input name="product_price[]" id="product_price0" type="text" class="form-control form-control-sm" onkeyup="checksummoney(0)" >
                                                            @endif


                                                        <td>
                                                                <div class="summoney0"></div>
                                                        </td>
                                                        <td>
                                                            <?php  $detallot = 'L'.substr(date("Ymd"),2).''.date("His"); ?>
                                                            <?php if($item->product_lot <> '' && $item->product_lot <> null){$detallot = $item->product_lot; }else{ $detallot = 'L'.substr(date("Ymd"),2).'-'.date("His"); } ?>

                                                            <input name="product_lot[]" id="product_lot[]"
                                                                class="form-control form-control-sm" value="{{$detallot}}" >
                                                        </td>
                                                        <td>
                                                            <input name="warehouse_rep_sub_exedate[]"
                                                                id="warehouse_rep_sub_exedate[]"
                                                                class="form-control form-control-sm" type="date" value="{{$item->warehouse_rep_sub_exedate}}">
                                                        </td>
                                                        <td>
                                                            <input name="warehouse_rep_sub_expdate[]"
                                                                id="warehouse_rep_sub_expdate[]"
                                                                class="form-control form-control-sm" type="date" value="{{$item->warehouse_rep_sub_expdate}}">
                                                        </td>
                                                        <td>
                                                            <select name="warehouse_rep_sub_status[]" id="warehouse_rep_sub_status{{$count}}" class="form-control form-control-sm" style="width: 100%;" >
                                                                @if ($item->warehouse_rep_sub_status == '1')
                                                                <option value="1" selected>ครบ</option>
                                                                <option value="2">ไม่ครบ</option>
                                                                @else
                                                                <option value="1">ครบ</option>
                                                                <option value="2" selected>ไม่ครบ</option>
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-sm btn-danger fa fa-trash-alt remove1"
                                                                style="color:#FFFFFF;">
                                                            </a>
                                                        </td>

                                                </tr>

                                            @endforeach
                                        @else

                                            <?php $count = 1; ?>
                                                    @if ($counproduct > 0)
                                                        @foreach ($data_sub as $item)
                                                            <tr height="30" style="font-size:13px">
                                                                <td style="text-align: center;">  {{$count}}</td>

                                                                <input name="warehouse_rep_sub_id[]" id="warehouse_rep_sub_id{{$count}}" type="hidden" class="form-control form-control-sm" value="{{$item->warehouse_rep_sub_id}}" onkeyup="checksummoney(<?php echo $count;?>)">
                                                                {{-- <input name="warehouse_rep_code[]" id="warehouse_rep_code{{$count}}" type="text" class="form-control form-control-sm" value="{{$item->warehouse_rep_code}}" onkeyup="checksummoney(<?php echo $count;?>)"> --}}
                                                                <td width="20%">
                                                                    <select name="product_id[]" id="product_id{{$count}}" class="form-control form-control-sm " style="width: 100%;" onchange="checkunitref(0);">
                                                                        <option value="" selected>--รายการวัสดุ--</option>
                                                                        @foreach ($product_data as $list)
                                                                        @if ($item->product_id == $list->product_id)
                                                                        <option value="{{ $list->product_id }}" selected> {{ $list->product_code }}{{ $list->product_name }}</option>
                                                                        @else
                                                                        <option value="{{ $list->product_id }}"> {{ $list->product_code }}{{ $list->product_name }}</option>
                                                                        @endif

                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="product_type_id[]" id="product_type_id{{$count}}" class="form-control form-control-sm" style="width: 100%;" >

                                                                        @foreach ($products_typefree as $free)
                                                                        @if ($item->product_type_id == $free->products_typefree_id)
                                                                        <option value="{{ $free->products_typefree_id }}" selected>{{ $free->products_typefree_name}}</option>
                                                                        @else
                                                                        <option value="{{ $free->products_typefree_id }}">{{ $free->products_typefree_name}}</option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><div class="showunit0">
                                                                    <select name="product_unit_subid[]" id="product_unit_subid{{$count}}"  class="form-control form-control-sm" style="width: 100%;">
                                                                        <option value="" selected>--หน่วย--</option>
                                                                        @foreach ($product_unit as $uni)
                                                                        @if ($item->product_unit_subid == $uni-> unit_id)
                                                                        <option value="{{ $uni -> unit_id }}" selected>{{ $uni->unit_name}}</option>
                                                                        @else
                                                                        <option value="{{ $uni -> unit_id }}">{{ $uni->unit_name}}</option>
                                                                        @endif

                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td >
                                                                    <input name="product_qty[]" id="product_qty{{$count}}" type="text" class="form-control form-control-sm text-center" value="{{$item->product_qty}}" onkeyup="checksummoney(<?php echo $count;?>)">
                                                                </td>
                                                                <td style="text-align: right">
                                                                    <input name="product_price[]" id="product_price{{$count}}" type="text" class="form-control form-control-sm text-end" value="{{$item->product_price}}" onkeyup="checksummoney(<?php echo $count;?>)">
                                                                <td>
                                                                <div class="summoney{{$count}}"></div>
                                                                </td>
                                                                <td >
                                                                    <?php  $detallot = 'L'.substr(date("Ymd"),2).''.date("His"); ?>
                                                                    <?php if($item->product_lot <> '' && $item->product_lot <> null){$detallot = $item->product_lot; }else{ $detallot = 'L'.substr(date("Ymd"),2).'-'.date("His"); } ?>
                                                                    <input name="product_lot[]" id="product_lot[]"
                                                                        class="form-control form-control-sm text-center" value="{{$detallot}}">
                                                                </td>
                                                                <td width="5%">
                                                                    <input name="warehouse_rep_sub_exedate[]"
                                                                        id="warehouse_rep_sub_exedate[]"
                                                                        class="form-control form-control-sm text-center" type="date" value="{{$item->warehouse_rep_sub_exedate}}">
                                                                </td>
                                                                <td width="5%" >
                                                                    <input name="warehouse_rep_sub_expdate[]"
                                                                        id="warehouse_rep_sub_expdate[]"
                                                                        class="form-control form-control-sm text-center" type="date" value="{{$item->warehouse_rep_sub_expdate}}">
                                                                </td>
                                                                <td>
                                                                    <select name="warehouse_rep_sub_status[]" id="warehouse_rep_sub_status{{$count}}" class="form-control form-control-sm" style="width: 100%;" >
                                                                        @if ($item->warehouse_rep_sub_status == '1')
                                                                        <option value="1" selected>ครบ</option>
                                                                        <option value="2">ไม่ครบ</option>
                                                                        @else
                                                                        <option value="1">ครบ</option>
                                                                        <option value="2" selected>ไม่ครบ</option>
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    <a class="btn btn-sm btn-danger fa fa-trash-alt remove1"
                                                                        style="color:#FFFFFF;">
                                                                    </a>
                                                                </td>

                                                            </tr>

                                                            <?php  $count++;?>
                                                        @endforeach
                                                    @else
                                                    @endif
                                        @endif
                                    </tbody>
                                </table>

                                <hr>
                                <div class="row">
                                    <div class="col-md-7"> </div>
                                        <div class="col-md-2 text-end">
                                            <label for="" style="color: red">ราคาทั้งหมด</label>
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

                        <div class="card-footer">
                            <div class="col-md-12 text-end">
                                <div class="form-group">
                                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                        บันทึกข้อมูล
                                    </button>
                                    <a href="{{ url('warehouse/warehouse_index') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm">
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
    function checkunitref(number){
    var unitnew = document.getElementById("product_id"+number).value;
        var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('warehouse/checkunitref')}}",
                    method: "GET",
                    data: {
                    unitnew: unitnew,
                        _token: _token
                    },
                    success: function (result) {
                        $('.showunit'+number).html(result);
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
                        '<td width="20%">'+
                        '<select name="product_id[]" id="product_id'+number+'" class="form-control form-control-sm js-example-basic-single" style="width: 100%;" onchange="checkunitref('+number+')">'+
                        '<option value="" selected>--รายการวัสดุ--</option>'+
                        '@foreach ($product_data as $list)'+
                        '<option value="{{ $list->product_id }}">{{ $list->product_code }}{{$list->product_name}}</option>'+
                        '@endforeach'+
                        '</select> '+
                        '</td>'+
                        '<td>'+
                        '<select name="product_type_id[]" id="product_type_id'+number+'" class="form-control form-control-sm js-example-basic-single" style="width: 100%;">'+
                        '@foreach ($products_typefree as $free)'+
                        '<option value="{{ $free->products_typefree_id }}">{{$free->products_typefree_name}}</option>'+
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
                        '<input name="product_qty[]" id="product_qty'+number+'" type="text" class="form-control form-control-sm" onkeyup="checksummoney('+number+');">'+
                        '</td>'+
                        '<td>'+
                        '<input name="product_price[]" id="product_price'+number+'" type="text" class="form-control form-control-sm" onkeyup="checksummoney('+number+');">'+
                        '</td>'+
                        '<td>'+
                        '<div class="summoney'+number+'"></div>'+
                        '</td>'+
                        '<td>'+
                        '<input name="product_lot[]" id="product_lot'+number+'" class="form-control form-control-sm" value="'+dateTime+'">'+
                        '</td>'+
                        '<td>'+
                        '<input name="warehouse_rep_sub_exedate[]" id="warehouse_rep_sub_exedate'+number+'" class="form-control form-control-sm" type="date">'+
                        '</td>'+
                        '<td>'+
                        '<input name="warehouse_rep_sub_expdate[]" id="warehouse_rep_sub_expdate'+number+'" class="form-control form-control-sm" type="date">'+
                        '</td>'+
                        '<td>'+
                        '<select name="warehouse_rep_sub_status[]" id="warehouse_rep_sub_status'+number+'" class="form-control form-control-sm" style="width: 100%;">'+
                        '<option value="1">ครบ</option>'+
                        '<option value="2">ไม่ครบ</option>'+
                        '</select>'+
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

              $('#warehouse_updateaddsub').on('submit',function(e){
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
                            if (data.status == 0 ) {

                            } else {
                              Swal.fire({
                                title: 'แก้ไขรายการสำเร็จ',
                                text: "You Edit data success",
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
{{-- url:"{{route('msupplies.checkunitref')}}", --}}
