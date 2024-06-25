@extends('layouts.supplies') 
@section('title','PKClaim || พัสดุ')

<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function supplies_destroy(product_id)
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
          url:"{{url('supplies/supplies_destroy')}}" +'/'+ product_id, 
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
                  window.location = "{{url('supplies/supplies_index')}}"; //     
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
    ?>
    {{-- @section('menu') --}}
<style>
    .btn {
        font-size: 15px;
    }
</style>
{{--  
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">   
            <a href="{{ url('supplies/supplies_dashboard') }}" class="btn btn-light btn-sm text-dark me-2">dashboard </a>
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-light btn-sm text-dark me-2">ขอซื้อขอจ้าง<span class="badge bg-danger ms-2">12</span></a>
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-light btn-sm text-dark me-2">จัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">14</span></a>   
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-success btn-sm text-white me-2">ข้อมูลวัสดุ<span class="badge bg-danger ms-2">{{$count_product}}</span></a>   
            <a href="{{url("serve/serve_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ข้อมูลบริการ<span class="badge bg-danger ms-2">{{$count_service}}</span></a>  
        <div class="text-end">
            <a href="{{ url('supplies/supplies_index_add') }}" class="btn btn-light btn-sm text-dark me-2">เพิ่มข้อมูลวัสดุ </a>
        </div>
        </div>
    </div>
@endsection --}}

@section('content')

    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                     
                    <div class="card-header ">
                        ข้อมูลวัสดุ
                    </div>

                    <div class="card-body shadow">
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example">
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="12%" class="text-center">รหัสวัสดุ</th>
                                        <th class="text-center">รายการวัสดุ</th>
                                        <th width="10%" class="text-center">ชนิดวัสดุ</th>
                                        <th width="10%" class="text-center">ประเภทวัสดุ</th>
                                        <th width="17%" class="text-center">หมวดวัสดุ</th>
                                        <th width="12%" class="text-center">ราคาสืบ</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($product_data as $item)
                                        <tr id="sid{{ $item->product_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-center" width="12%">{{ $item->product_code }} </td>
                                            <td class="p-2">{{ $item->product_name }}</td>
                                            <td class="p-2" width="12%">{{ $item->product_groupname }}</td>
                                            <td class="text-center" width="12%">{{ $item->product_typename }}</td>
                                            <td class="p-2"  width="17%">{{ $item->product_categoryname }}</td>
                                            <td class="text-center" width="12%">{{ $item->product_spypricename }}</td>
                                            <td class="text-center" width="10%">
                                                
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                            <li>
                                                                <a href="{{ url('supplies/supplies_index_edit/' .$item->product_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)" onclick="supplies_destroy({{ $item->product_id }})">
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
