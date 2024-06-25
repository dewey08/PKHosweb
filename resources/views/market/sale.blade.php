@extends('layouts.market')
@section('title', 'ZOFFice || ขายสินค้า')
@section('menu')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function sale_destroy(basket_id)
    {
      Swal.fire({
      title: 'ต้องการลบใช่ไหม?',
      text: "ข้อมูลนี้จะถูกลบไปเลย !!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
      cancelButtonText: 'ไม่, ยกเลิก'
      }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({ 
          url:"{{url('market/sale_destroy')}}" +'/'+ basket_id, 
          type:'DELETE',
          data:{
              _token : $("input[name=_token]").val()
          },
          success:function(response)
          {          
              Swal.fire({
                title: 'ลบข้อมูล!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  $("#sid"+basket_id).remove();     
                  window.location.reload(); 
                //   window.location = "{{url('market/product_index')}}"; //     
                }
              }) 
          }
          })        
        }
        })
}

function bill_destroy(bill_id)
    {
      Swal.fire({
      title: 'ต้องการลบใช่ไหม?',
      text: "ข้อมูลนี้จะถูกลบไปเลย !!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
      cancelButtonText: 'ไม่, ยกเลิก'
      }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({ 
          url:"{{url('market/bill_destroy')}}" +'/'+ bill_id, 
          type:'DELETE',
          data:{
              _token : $("input[name=_token]").val()
          },
          success:function(response)
          {          
              Swal.fire({
                title: 'ลบข้อมูล!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {      
                //   window.location.reload(); 
                  window.location = "{{url('market/sale_index')}}"; //     
                }
              }) 
          }
          })        
        }
        })
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
    * {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

/*the container must be positioned relative:*/
/* .autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
} */
    .btn {
        font-size: 15px;
    }
    .bgc {
            background-color: #264886;
        }

        .bga {
            background-color: #fbff7d;
        }
        .table tr td{
            padding:0px;
            }


            .table.class_selector td{
            padding:0px;
            }
</style>
<?php
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\MarketController;
use App\Http\Controllers\StaticController;
    $refnumber = MarketController::refnumber(); 
    $refmaxid = MarketController::refmaxid(); 
    $count_market_bill = StaticController::count_market_bill(); 
    $count_service = StaticController::count_service(); 
    $count_marketproducts = StaticController::count_marketproducts(); 
    $count_market_repproducts = StaticController::count_market_repproducts();
?>
   <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">     
            
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-light btn-sm text-dark me-1">รายการขายสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("market/sale_index")}}" class="col-6 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-1">รายการขายสินค้า<span class="badge bg-danger ms-1">{{$count_market_bill}}</span></a>  
        <div class="text-end">
            {{-- <a href=" " class="btn btn-secondary btn-sm text-white me-2">เพิ่มรายการสินค้า </a> --}}
        </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="container-fluid " style="width: 97%">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        รายการสินค้า
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php $number = 0; ?>
                            @foreach ( $market_product as $items )
                            <?php $number++; ?>
                                    
                           
                                        <div class="col-md-4 text-center mt-2" >
                                            <form class="custom-validation" action="{{ route('mar.sale_save') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                
                                                {{-- <input type="text" class="form-control mt-1" id="bill_id" name="bill_id" value="{{$databills->bill_id}}">  --}}

                                            <div class="bg-image hover-overlay ripple">                                                
                                                <a href="">                                                   
                                                    <img src="{{asset('storage/products/'.$items->img)}}" height="320px" width="320px" alt="Image" class="img-thumbnail mt-3">
                                                    <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>                                            
                                                </a>    
                                                <input type="hidden" class="form-control mt-1" id="product_id" name="product_id" value="{{$items->product_id}}"> 
                                                <input type="hidden" class="form-control mt-1" id="product_price" name="product_price" value="{{$items->product_price}}">                            
                                                <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger mt-3">{{$items->product_price}} </span>
                                            </div> 
                                            
                                            <div class="row">
                                                <div class="col-md-4"></div> 
                                                <div class="col-md-4">
                                                    <input type="number" class="form-control mt-1" id="product_qty" name="product_qty" > 
                                                </div> 
                                                <div class="col-md-4"></div> 
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm mt-2"> 
                                                เพิ่มใส่ตะกร้า
                                            </button>
                                            {{-- <button type="submit" class="btn btn-primary btn-sm mt-1"> 
                                                <i class="fa-solid fa-cart-arrow-down"></i>  
                                            </button> --}}
                                            {{-- <button type="button" id="saveBtn" class="btn btn-primary btn-sm mt-1">                                       
                                                เพิ่มใส่ตะกร้า
                                            </button> --}}
                                            {{-- <i class="fa-solid fa-floppy-disk me-2"></i>--}}
                                            {{-- <button type="button" onclick="saveBtn({{$items->product_id}})" class="btn btn-primary btn-sm mt-1">เพิ่มใส่ตะกร้า     </button>   --}}
                                     
                                        </div>
                                  
                                    </form>
                            
                                @endforeach                     
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-3">                              
                                {{$market_product->links()}}                            
                            </ul>
                        </nav>  
                        
                    </div> 
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        
                        <div class="row">  
                            <div class="col-md-3 "> </div>                          
                            <div class="col-md-6">
                                <div id="reader" width="300px"></div>  
                                <?php
                                    // echo '<img src="data:image/png,' . Milon\Barcode\DNS1D::getBarcodePNG(5, "C39", 3, 33) . '" alt=""   />';
                                    // echo '<img src="data:image/png;base64,' . Milon\Barcode\DNS1D::getBarcodePNG(5, "C39", 3, 33) . '" alt="" />';
                                ?>
                                {{-- <input type="text" id="scanner" />                              --}}
                                {{-- <form autocomplete="off" action="/action_page.php">  
                                        <input id="myInput" type="text" name="myCountry" placeholder="barcode">  
                                    <button type="submit" class="btn btn-primary btn-sm text-white">  
                                        ADD
                                    </button>
                                </form> --}}                                 
                            </div> 
                            <div class="col-md-3 "> </div>  
                        </div>
                        <div class="row">                            
                            <div class="col-md-3 mt-2">barcode
                            </div>
                            <div class="col-md-6 mt-2">
                                <input id="myInput" type="text" name="myCountry" placeholder="barcode" class="form-control">

                            </div>
                            <div class="col-md-3 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm text-white">  
                                    ADD
                                </button>
                            </div>  
                        </div>
                    </div>
                    <div class="card-body">                                        
                            <div class="table-responsive ">
                                {{-- <table class="table table-hover table-sm" style="width: 100%;" > --}}
                                    <table class="table table-hover table-responsive" style="wproduct_idth: 100%;">
                                    <thead>
                                        <tr height="10px"> 
                                            <th width="42%" class="text-center">รายการ</th>
                                            <th width="12%" class="text-center"> จำนวน</th>
                                            <th width="18%" class="text-center"> ราคา</th>
                                            <th width="28%" class="text-center"> จัดการ</th> 
                                        </tr>  
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; $total = 0; ?>      
                                        @foreach ( $market_basket as $item ) 
                                                    <tr id="sid{{$item->basket_id}}">
                                                        
                                                        <td class="p-2" width="42%">
                                                            {{$item->basket_product_name}}
                                                        </td>
                                                        <form class="custom-validation" action="{{route('mar.sale_update')}}" method="POST">
                                                            @csrf
                                                            <input id="basket_id" type="hidden" class="form-control" name="basket_id" value="{{$item->basket_id}}">
                                                            
                                                            <input id="basket_product_id" type="hidden" class="form-control" name="basket_product_id" value="{{$item->basket_product_id}}">
                                                        <td class="text-center" width="12%">
                                                            <input id="basket_qty" type="text" class="form-control text-center" name="basket_qty" value="{{$item->basket_qty}}">
                                                        </td>
                                                        <td class="text-center" width="18%">
                                                            <input id="basket_price" type="text" class="form-control text-end" name="basket_price" value="{{$item->basket_price}}">
                                                        </td>
                                                        <td class="text-center" width="28%">
                                                            {{-- <button type="submit" class="btn btn-light btn-sm text-warning"> 
                                                                <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                            </button> --}}
                                                            <a href="javascript:void(0)" class="btn btn-light btn-sm text-danger" onclick="sale_destroy({{ $item->basket_id}})">  
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
 
                                                            
                                                        </td>
                                            </form>  
                                            
                                        </tr>    
                                        <?php   
                                            $total =   $total + ($item->basket_qty * $item->basket_price);    
                                        ?>
                                        
                                        @endforeach  
                                        <tr>
                                            <td colspan="2" align="right" class="p-2">ราคารวมทั้งหมด</td> 
                                            <td align="right" class="text-danger p-2"><b>{{number_format(($total),2)}} </b></td> 
                                            
                                            <td class="p-2">บาท</td>
                                           
                                        </tr>                                                             
                                    </tbody>
                                </table>
        
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">                              
                                        {{-- {{$market_basket->links()}}  --}}
                                    </ul>
                                </nav>  
                            </div>
                    </div> 
                    <div class="card-footer">
                        
                        <div class="container d-flex flex-wrap justify-content-center">     
                            <form class="custom-validation" action="{{route('mar.sale_savebill')}}" method="POST">
                                @csrf
                                <input id="bill_total" type="hidden" class="form-control form-control-sm text-end" name="bill_total" value="{{$total}}">
                            
                                <button type="submit" class="col-12 col-lg-auto mb-lg-0 me-lg-auto btn btn-primary btn-sm text-white me-3">  
                                        <i class="fa-solid fa-floppy-disk me-2 text-white"></i>
                                        บันทึก
                                </button>        
                            </form>
                           
                        <div class="text-end"> 
                            <a href="{{url('market/sale_index')}}" class="btn btn-danger btn-sm text-white ms-3" >
                                <i class="fa-solid fa-right-from-bracket me-2"></i>
                                ปิด</a>
                        </div>
                        </div>
                    </div>     
                </div>
            </div>            
        </div>
       
    </div>

    {{-- <div class="col-md-4 mt-2">
        <div id="reader" width="250px"></div>
        <input id="basket_id" type="text" class="form-control" name="basket_id">
        <form autocomplete="off" action="/action_page.php">
            
            <div class="autocomplete" style="width:300px;">
               
                <input id="myInput" type="text" name="myCountry" placeholder="barcode">
                
            </div>
            <button type="submit" class="btn btn-primary btn-sm text-white">  
                ADD
            </button>
        </form> --}}
         

    @endsection
