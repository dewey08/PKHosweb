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
    .bgc {
            background-color: #264886;
        }

        .bga {
            background-color: #fbff7d;
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
    $sumsaleindex = StaticController::sumsaleindex();
?>
   <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">     
            
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-light btn-sm text-dark me-1">รายการขายสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("market/sale_index")}}" class="col-6 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-1">รายการขายสินค้า<span class="badge bg-danger ms-1">{{$count_market_bill}}</span></a>  
        <div class="text-end">
            <a href="{{url("market/sale")}} " class="btn btn-secondary btn-sm text-white me-2"><i class="fa-brands fa-btc text-white me-2"></i>เปิดบิล </a>
        </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="container-fluid " style="width: 97%">
        <div class="row">
           <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        รายการขายสินค้า
                    </div>
                    <div class="card-body">                                        
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">ลำดับ</th>
                                            <th width="10%" class="text-center">สถานะ</th>
                                            <th width="15%" class="text-center">เลขที่บิล</th>
                                            <th width="15%" class="text-center">วันที่</th>  
                                            <th width="15%" class="text-center">ผู้ขาย</th> 
                                            <th width="15%" class="text-center">ยอดขาย</th> 
                                            <th width="10%" class="text-center">Manage</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; $total = 0; ?>      
                                        @foreach ( $market_basket_bill as $item ) 
                                                    <tr id="sid{{$item->bill_id}}">
                                                        
                                                        <td class="text-center" width="5%"> {{$i++}}</td>

                                                        @if ($item->bill_status == 'narmalsale')
                                                            <td class="font-weight-medium text-center" width="7%"><div class="badge bg-secondary shadow"> ขายปกติ</div></td>
                                                        @elseif ($item->bill_status == 'cancel')
                                                            <td class="font-weight-medium text-center" width="7%"><div class="badge bg-warning shadow">ยกเลิก</div></td>
                                                        @elseif ($item->bill_status == 'finish')
                                                            <td class="font-weight-medium text-center" width="7%"><div class="badge bg-info shadow">เสร็จเรียบร้อย</div></td>                                                    
                                                        @else
                                                            <td class="font-weight-medium text-center" width="7%"><div class="badge bg-dark shadow">ยืนยันการยกเลิก</div></td>
                                                        @endif
                                                        


                                                        <td class="text-center" width="15%">{{$item->bill_no}} </td>
                                                        <td class="text-center" width="15%">{{ DateThai($item->bill_date) }} </td>
                                                        <td class="p-2">{{$item->bill_user_name}} </td>
                                                        <td class="text-center" width="15%">{{number_format($item->bill_total),2}}</td> 
                                                        <td class="text-center" width="10%">
                                                            <div class="dropdown">
                                                                <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                                  ทำรายการ
                                                                </button>                                      
                                                                    <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                                      
                                                                        <li>
                                                                            <a href="{{ url('market/sale_edit/' .$item->bill_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                              <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                              <label for="" style="color: black">แก้ไข</label>
                                                                            </a>  
                                                                          </li>
                                                                          <li>
                                                                            <a class="text-danger" href="javascript:void(0)" onclick="product_destroy({{ $item->bill_id }})">
                                                                              <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                              <label for="" style="color: black">ลบ</label>
                                                                            </a> 
                                                                          </li>
            
                                                                    </ul>
                                                            </div>
                                                            
                                                        </td>
                                            </form>  
                                            
                                        </tr>    
                                        <?php   
                                            $total =   $total + ($item->basket_qty * $item->basket_price);    
                                        ?>
                                        
                                        @endforeach  
                                                                                                 
                                    </tbody>
                                </table>
         
                         
                        </div>

                    </div>                
                </div>
            </div>            
        </div>
        
    </div>

       
   

    @endsection
