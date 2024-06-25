@extends('layouts.market')
@section('title', 'ZOFFice || รายชื่อสมาชิก')

<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function customer_destroy(customer_id)
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
          url:"{{url('customer/customer_destroy')}}" +'/'+ customer_id, 
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
                  $("#sid"+customer_id).remove();     
                  // window.location.reload(); 
                  window.location = "{{url('customer/customer')}}"; //     
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
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-secondary btn-sm text-white me-2">รายชื่อลูกค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("customer/customer")}}" class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">สมาชิก<span class="badge bg-danger ms-2">{{$count_market_repproducts}}</span></a>  
        <div class="text-end">
            <a href="{{ url('customer/customer_add') }}" class="btn btn-light btn-sm text-dark me-2">เพิ่มสมาชิก</a>
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
                        รายชื่อสมาชิก
                    </div>

                    <div class="card-body shadow">
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example">
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="12%" class="text-center">รหัสสมาชิก</th>
                                        <th width="10%" class="text-center">รูปสมาชิก</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>  
                                        <th width="12%" class="text-center">เบอร์โทร</th>
                                        <th width="20%" class="text-center">ที่อยู่</th> 
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($market_customer as $item)
                                        <tr id="sid{{ $item->customer_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-center" width="12%">{{ $item->pcustomer_code }} </td>
                                            <td class="text-center" width="12%"> <img src="{{asset('storage/customer/'.$item->img)}}" height="70px" width="70px" alt="Image" class="img-thumbnail"> </td>
                                            <td class="p-2">{{ $item->prefix_name }} {{ $item->pcustomer_fname }} {{ $item->pcustomer_lname }}</td>  
                                            <td class="text-center" width="12%"> {{ $item->pcustomer_tel }} </td>
                                            <td class="text-center" width="20%">{{ $item->pcustomer_address }} </td> 
  
                                            <td class="text-center" width="10%">
                                                
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                            <li>
                                                                <a href="{{ url('customer/customer_edit/' .$item->customer_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)" onclick="customer_destroy({{ $item->customer_id }})">
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
