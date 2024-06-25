@extends('layouts.market')
@section('title', 'ZOFFice || รายการสินค้า')

<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function product_destroy(product_id)
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
          url:"{{url('market/product_destroy')}}" +'/'+ product_id, 
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
                  $("#sid"+product_id).remove();     
                  // window.location.reload(); 
                  window.location = "{{url('market/product_index')}}"; //     
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
    use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
    $refnumber = SuppliesController::refnumber(); 
    $count_product = StaticController::count_product(); 
    $count_service = StaticController::count_service(); 
    $count_marketproducts = StaticController::count_marketproducts(); 
    $count_market_repproducts = StaticController::count_market_repproducts();
    ?>
    @section('menu')
<style>
    .btn {
        font-size: 15px;
    }
</style>
 
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">     
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-secondary btn-sm text-white me-2">รายการสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("market/product_index")}}" class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-secondary btn-sm text-white me-2">รายการสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>  
        <div class="text-end">
            <a href="{{ url('market/product_add') }}" class="btn btn-light btn-sm text-dark me-2">เพิ่มสินค้า </a>
        </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                     
                    <div class="card-header ">
                        รายการสินค้า
                    </div>

                    <div class="card-body shadow">
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example">
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="10%" class="text-center">รหัสสินค้า</th>
                                        <th width="10%" class="text-center">barcode</th>
                                        <th width="7%" class="text-center">รูปสินค้า</th>
                                        <th class="text-center">รายการสินค้า</th> 
                                        <th width="7%" class="text-center">จำนวน</th> 
                                        <th width="7%" class="text-center">ราคา</th> 
                                        <th width="10%" class="text-center">รับเข้า</th>
                                        <th width="10%" class="text-center">จ่ายออก</th>
                                        <th width="10%" class="text-center">คงเหลือ</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($market_product as $item)
                                        <tr id="sid{{ $item->product_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-center" width="10%">{{ $item->product_code }} </td>
                                            <td class="text-center" width="10%">
                                                <?php
                                                $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
                                                $Pi = '<img src="data:image/jpeg;base64,' . base64_encode($generator->getBarcode($item->product_code, $generator::TYPE_CODE_128,2,30)) . '" height="30px" width="95%" > ';
                                                echo $Pi;
                                            ?>
                                            {{ $item->product_code}}
                                            <br>                                
                                            {!! QrCode::size(30)->generate($item->product_code); !!} 
                                            </td>
                                            <td class="text-center" width="7%"> <img src="{{asset('storage/products/'.$item->img)}}" height="70px" width="70px" alt="Image" class="img-thumbnail"> </td>
                                            <td class="p-2">{{ $item->product_name }}</td> 
                                            <td class="text-center" width="7%">{{ $item->product_qty }}</td> 
                                            <td class="text-end" width="7%">{{ $item->product_price }}</td> 
                                            <td class="text-center" width="10%">{{number_format(StaticController::sumrecieve($item->product_code))}} </td>
                                            <td class="text-center" width="10%">{{ $item->product_code }} </td>
                                            {{-- <td class="text-center" width="10%">{{ $item->product_code }} </td> --}}

                                            @if(number_format(StaticController::sumtotalqty($item->product_code)) == '0'  )
                                                <td style="text-align: center;color:#f1120a;background-color: #f8f597;font-size:15px;">{{number_format(StaticController::sumtotalqty($item->product_code)) }}</td>
                                            @elseif( number_format(StaticController::sumtotalqty($item->product_code))  >= '100')
                                                <td style="text-align: center;color:#8a18f5;background-color: #ffffff;font-size:15px;">{{number_format(StaticController::sumtotalqty($item->product_code)) }}</td>
                                            @elseif( number_format(StaticController::sumtotalqty($item->product_code))  <= '90' )
                                                <td style="text-align: center;color:#95E605;background-color: #ffffff;font-size:15px;">{{number_format(StaticController::sumtotalqty($item->product_code)) }}</td>
                                            @else
                                                <td style="text-align: center;">{{number_format(StaticController::sumtotalqty($item->product_code)) }}</td>
                                            @endif

                                            <td class="text-center" width="10%">
                                                
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                            <li>
                                                                <a href="{{ url('market/product_edit/' .$item->product_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)" onclick="product_destroy({{ $item->product_id }})">
                                                                  <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                  <label for="" style="color: black">ลบ</label>
                                                                </a> 
                                                              </li>

                                                        </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
           
        </div>

 

    @endsection
