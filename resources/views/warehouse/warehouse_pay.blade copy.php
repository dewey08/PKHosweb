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
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StaticController;
$refnumber = WarehouseController::refnumber();
date_default_timezone_set('Asia/Bangkok');
$date = date('Y') + 543;
$datefull = date('Y-m-d H:i:s');
$time = date("H:i:s");
$loter = $date.''.$time
?>


<body onload="run01();">
    <div class="container-fluid">
        <div class="row">
            <form class="custom-validation" action="{{ route('ware.warehouse_update') }}" method="POST"
                            id="warehouse_update" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="warehouse_rep_id" id="warehouse_rep_id" value="{{$warehouse_rep->warehouse_rep_id}}">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> 
                        <div class="d-flex">
                            <div class="p-2">
                                <label for="">ตรวจรับทั่วไป </label>
                            </div>
                            <div class="ms-auto">
                                <div class="row">                                   
                                   
                                        @if ($warehouse_rep->warehouse_rep_send == 'FINISH')
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="warehouse_rep_send" id="warehouse_rep_send" value="FINISH" checked>
                                                    <label class="form-check-label" for="warehouse_rep_send">
                                                    ครบ
                                                    </label>
                                                </div> 
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="warehouse_rep_send" id="warehouse_rep_send" value="STALE">
                                                    <label class="form-check-label" for="warehouse_rep_send">
                                                      ไม่ครบ
                                                    </label>
                                                  </div>
                                            </div>                                          
                                        @else
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="warehouse_rep_send" id="warehouse_rep_send" value="FINISH" >
                                                <label class="form-check-label" for="warehouse_rep_send">
                                                ครบ
                                                </label>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="warehouse_rep_send" id="warehouse_rep_send" value="STALE" checked>
                                                <label class="form-check-label" for="warehouse_rep_send">
                                                  ไม่ครบ
                                                </label>
                                              </div>
                                        </div>
                                            
                                        @endif
                                       
                                  
                                    
                                    <div class="col me-5"></div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        
                        <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label for="warehouse_rep_code">เลขที่รับ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_code" type="text"
                                                class="form-control form-control-sm" name="warehouse_rep_code"
                                                value="{{ $warehouse_rep->warehouse_rep_code }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="warehouse_rep_no_bill">เลขที่บิล :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_no_bill" type="text"
                                                class="form-control form-control-sm" name="warehouse_rep_no_bill" value="{{$warehouse_rep->warehouse_rep_no_bill }}">
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <label for="warehouse_rep_po">เลขที่ PO :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_po" type="text" class="form-control form-control-sm"
                                                name="warehouse_rep_po" value="{{ $warehouse_rep->warehouse_rep_po }}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="warehouse_rep_year">ปีงบ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select id="warehouse_rep_year" name="warehouse_rep_year"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($budget_year as $ye)
                                                    @if ($warehouse_rep->warehouse_rep_year == $ye->leave_year_id)
                                                        <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }} </option>
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
                                        <label for="warehouse_rep_user_id">ผู้รับ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select id="warehouse_rep_user_id" name="warehouse_rep_user_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($users as $itemu)
                                                @if ($warehouse_rep->warehouse_rep_user_id == $itemu->id)
                                                <option value="{{ $itemu->id }}" selected> {{ $itemu->fname }} {{ $itemu->lname }} </option>
                                                @else
                                                <option value="{{ $itemu->id }}"> {{ $itemu->fname }} {{ $itemu->lname }} </option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="warehouse_rep_inven_id">รับเข้าคลัง :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select id="warehouse_rep_inven_id" name="warehouse_rep_inven_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($warehouse_inven as $inven)
                                                @if ($warehouse_rep->warehouse_rep_inven_id == $inven->warehouse_inven_id)
                                                <option value="{{ $inven->warehouse_inven_id }}" selected> {{ $inven->warehouse_inven_name }}</option>
                                                @else
                                                <option value="{{ $inven->warehouse_inven_id }}"> {{ $inven->warehouse_inven_name }}</option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="warehouse_rep_vendor_id">รับจาก :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select id="warehouse_rep_vendor_id" name="warehouse_rep_vendor_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($products_vendor as $ven)
                                                @if ($warehouse_rep->warehouse_rep_vendor_id == $ven->vendor_id)
                                                <option value="{{ $ven->vendor_id }}" selected> {{ $ven->vendor_name }}</option>
                                                @else
                                                <option value="{{ $ven->vendor_id }}"> {{ $ven->vendor_name }}</option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="warehouse_rep_date">วันที่รับ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input class="form-control form-control-sm" type="datetime-local"
                                                id="example-datetime-local-input" name="warehouse_rep_date" value="{{$warehouse_rep->warehouse_rep_date}}">

                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>

                        <hr>
                        {{-- <div class="row">
                            <div class="col-md-9">  
                                         
                                </div>
                                <div class="col-md-1">  
                                    <label for="">รวมมูลค่า</label>
                                  
                        </div>
                                <div class="col-md-2">   
                                    <input class="form-control input-sm " style="text-align: right;background-color:#E0FFFF ;font-size: 16px;" type="text" name="total" id="total" readonly>                                            
                              
                        </div>
                            </div>
                            <br> --}}
                        {{-- <div class="row">
                            <div class="col-md-12"> --}}
                                {{-- <div class="card-header shadow">
                                    <label for="">วัสดุที่รับเข้า </label> --}}
                                                                   
                            {{-- </div> --}}

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
                                                    <td style="text-align: center;" width="8%">ราคาต่อหน่วย</td>
                                                    <td style="text-align: center;" width="12%">มูลค่า</td>
                                                    <td style="text-align: center;" width="12%">Lot</td>
                                                    <td style="text-align: center;" width="6%">วันผลิต</td>
                                                    <td style="text-align: center;" width="6%">วันหมดอายุ</td>
                                                    <td style="text-align: center;" width="4%">
                                                        <a class="btn btn-sm btn-success addRow" style="color:#FFFFFF;"><i
                                                                class="fas fa-plus"></i></a>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody1">
                                                @if ($count == 0)
                                                    <tr height="30" style="font-size:13px">
                                                        <td style="text-align: center;"> 1 </td>
                                                        <td>
                                                            <select name="product_id[]" id="product_id0" class="form-control form-control-sm " style="width: 100%;" onchange="checkunitref(0);">
                                                                <option value="" selected>--รายการวัสดุ--</option>
                                                                @foreach ($product_data as $list)
                                                                    <option value="{{ $list->product_id }}">
                                                                        {{ $list->product_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="product_type_id[]" id="product_type_id0" class="form-control form-control-sm" style="width: 100%;" >
                                                            
                                                                @foreach ($products_typefree as $free)
                                                                            <option value="{{ $free -> products_typefree_id }}">{{ $free->products_typefree_name}}</option>
                                                                        @endforeach                   
                                                            </select>
                                                        </td>
                                                        <td><div class="showunit0">
                                                            <select name="product_unit_subid[]" id="product_unit_subid[]"  class="form-control form-control-sm" style="width: 100%;">
                                                                <option value="" selected>--หน่วย--</option>
                                                                @foreach ($product_unit as $uni)
                                                                            <option value="{{ $uni -> unit_id }}">{{ $uni->unit_name}}</option>
                                                                        @endforeach                   
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input name="product_qty[]" id="product_qty0" type="number" class="form-control form-control-sm" onkeyup="checksummoney(0)">
                                                        </td>

                                                        <td>
                                                            <input name="product_price[]" id="product_price0" type="number" class="form-control form-control-sm" onkeyup="checksummoney(0)">
                                            
                                                        <td> 
                                                                <div class="summoney0"></div>  
                                                        </td>
                                                        <td>
                                                            <?php  $detallot = 'L'.substr(date("Ymd"),2).'-'.date("His"); ?>
                                                            <input name="product_lot[]" id="product_lot[]"
                                                                class="form-control form-control-sm" value="{{$detallot}}">
                                                        </td>
                                                        <td>
                                                            <input name="warehouse_rep_sub_exedate[]"
                                                                id="warehouse_rep_sub_exedate[]"
                                                                class="form-control form-control-sm" type="date">
                                                        </td>
                                                        <td>
                                                            <input name="warehouse_rep_sub_expdate[]"
                                                                id="warehouse_rep_sub_expdate[]"
                                                                class="form-control form-control-sm" type="date">
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-sm btn-danger fa fa-trash-alt remove1"
                                                                style="color:#FFFFFF;">
                                                            </a>
                                                        </td>
                                                        <input type="hidden" name="SUP_UNIT_ID_H[]" id="SUP_UNIT_ID_H0" value="0">
                                                    </tr>
                                                    
                                                @else
                                                        <?php $count = 1; ?>
                                                        @foreach ($warehouse_repsub as $item)  
                                                                <tr height="30" style="font-size:13px">
                                                                    <td style="text-align: center;">  {{$count}}</td>
                                                                    <td>
                                                                        <select name="product_id[]" id="product_id{{$count}}" class="form-control form-control-sm " style="width: 100%;" onchange="checkunitref(0);">
                                                                            <option value="" selected>--รายการวัสดุ--</option>
                                                                            @foreach ($product_data as $list)
                                                                            @if ($item->product_id == $list->product_id)
                                                                            <option value="{{ $list->product_id }}" selected> {{ $list->product_name }}</option>
                                                                            @else
                                                                            <option value="{{ $list->product_id }}"> {{ $list->product_name }}</option>
                                                                            @endif
                                                                                
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
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
                                                                            @if ($item->product_unit_subid == $uni -> unit_id)
                                                                            <option value="{{ $uni -> unit_id }}" selected>{{ $uni->unit_name}}</option>
                                                                            @else
                                                                            <option value="{{ $uni -> unit_id }}">{{ $uni->unit_name}}</option>
                                                                            @endif
                                                                                        
                                                                            @endforeach                   
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="product_qty[]" id="product_qty{{$count}}" type="number" class="form-control form-control-sm" value="{{$item->product_qty}}" onkeyup="checksummoney(<?php echo $count;?>)">
                                                                    </td>

                                                                    <td>
                                                                        <input name="product_price[]" id="product_price{{$count}}" type="number" class="form-control form-control-sm" value="{{$item->product_price}}" onkeyup="checksummoney(<?php echo $count;?>)">
                                                        
                                                                <td>
                                                                    
                                                                    <div class="summoney{{$count}}"></div>
                                                                    </td>
                                                                    <td>
                                                                        <?php  $detallot = 'L'.substr(date("Ymd"),2).'-'.date("His"); ?>
                                                                        <?php if($item->product_lot <> '' && $item->product_lot <> null){$detallot = $item->product_lot; }else{ $detallot = 'L'.substr(date("Ymd"),2).'-'.date("His"); } ?>
                                                                        <input name="product_lot[]" id="product_lot[]"
                                                                            class="form-control form-control-sm" value="{{$detallot}}">
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
                                                                    <td style="text-align: center;">
                                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove1"
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                    </td>
                                                                    <input type="hidden" name="SUP_UNIT_ID_H[]" id="SUP_UNIT_ID_H0" value="0">
                                                                </tr>

                                                        <?php  $count++;?>
                                                        @endforeach
                                                    
                                                @endif
                                               
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

                                    {{-- </div>
                                </div> --}}
                            {{-- </div> --}}
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
                var dateTime = 'L'+date+'-'+time;
                var tr ='<tr style="font-size:13px">'+
                        '<td style="text-align: center;">'+
                        number+
                        '</td>'+
                        '<td>'+
                        '<select name="product_id[]" id="product_id'+number+'" class="form-control form-control-sm js-example-basic-single" style="width: 100%;" onchange="checkunitref('+number+')">'+            
                        '<option value="" selected>--รายการวัสดุ--</option>'+ 
                        '@foreach ($product_data as $list)'+
                        '<option value="{{ $list->product_id }}">{{$list->product_name}}</option>'+
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
                        '<input name="product_qty[]" id="product_qty'+number+'" type="number" class="form-control form-control-sm" onkeyup="checksummoney('+number+');">'+
                        '</td>'+ 
                        '<td>'+
                        '<input name="product_price[]" id="product_price'+number+'" type="number" class="form-control form-control-sm" onkeyup="checksummoney('+number+');">'+
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
                        '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;"></a></td>'+
                        '<input type="hidden" name="SUP_UNIT_ID_H[]" id="SUP_UNIT_ID_H'+number+'" value="0">'+
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

    function checksummoney(number){          
       
          var SUP_TOTAL=document.getElementById("product_qty"+number).value;
          var PRICE_PER_UNIT=document.getElementById("product_price"+number).value;          
         // alert(SUP_TOTAL);          
          var _token=$('input[name="_token"]').val();
               $.ajax({
                       url:"{{route('ware.checksummoney')}}",
                       method:"GET",
                       data:{SUP_TOTAL:SUP_TOTAL,PRICE_PER_UNIT:PRICE_PER_UNIT,_token:_token},
                       success:function(result){
                          $('.summoney'+number).html(result);
                          findTotal();
                       }
               })               
      }           
    
//       function numberWithCommas(nStr) {
//         nStr += '';
//             x = nStr.split('.');
//             x1 = x[0];
//             x2 = x.length > 1 ? '.' + x[1] : '';
//             var rgx = /(\d+)(\d{3})/;
//             while (rgx.test(x1)) {
//                 x1 = x1.replace(rgx, '$1' + ',' + '$2');
//             }
//             return x1 + x2;
//     }
    
//     function findTotal(){
//     var arr = document.getElementsByName('sum');
//     var tot=0;

//     count = $('.tbody1').children('tr').length;
//     for(var i=0;i<count;i++){
//             tot += parseFloat(arr[i].value);
//     }
//     document.getElementById('total').value =tot.toFixed(5);
// }

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
        $('#warehouse_update').on('submit',function(e){
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
                                title: 'แก้ไขข้อมูลสำเร็จ',
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