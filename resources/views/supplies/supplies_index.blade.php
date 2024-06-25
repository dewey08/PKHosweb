@extends('layouts.supplies') 
@section('title','PK-OFFICER || พัสดุ')

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

@section('content')

    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                     
                    {{-- <div class="card-header ">
                        ข้อมูลวัสดุ
                    </div> --}}
                    {{-- <div class="card bg-secondary p-1 mx-0 shadow-lg">  --}}
                        {{-- <div class="panel-header px-3 py-2 text-white">  --}}
                            <div class="card-header ">
                                <div class="d-flex">
                                    <div class="">
                                        <label for="" >ข้อมูลวัสดุ</label> 
                                     </div> 
                                        <div class="ms-auto">
                                            <a href="{{ url('supplies/supplies_index_add') }}" class="btn btn-info btn-sm"  >
                                            {{-- <i class="fa-solid fa-circle-check text-success me-2"></i> --}}
                                            <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                            เพิ่มข้อมูลวัสดุ
                                            </a> 
                                            
                                        </div>
                                </div>          
                        </div>

                        {{-- <div class="panel-body bg-white"> --}}
                            <div class="card-body shadow">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> 
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="10%" class="text-center">รหัสวัสดุ</th>
                                        <th class="text-center">รายการวัสดุ</th>
                                        <th width="10%" class="text-center">ชนิดวัสดุ</th>
                                        <th width="8%" class="text-center">ประเภท</th>
                                        <th width="17%" class="text-center">หมวดวัสดุ</th>
                                        <th width="10%" class="text-center">ราคาสืบ</th>
                                        <th width="6%" class="text-center">claim</th>
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
                                            <td class="text-center" width="10%">{{ $item->product_code }} </td>
                                            <td class="p-2">{{ $item->product_name }}</td>
                                            <td class="p-2" width="10%">{{ $item->product_group_name }}</td>
                                            <td class="text-center" width="8%">{{ $item->sub_type_name }}</td>
                                            <td class="p-2"  width="17%">{{ $item->category_name }}</td>
                                            <td class="text-center" width="10%">{{ $item->product_spypricename }}</td>
                                           
                                            @if ($item->product_claim == 'CLAIM')
                                            <td class="font-weight-medium text-center" width="6%"><div class="badge bg-info">CLAIM ได้</div></td>                                           
                                            @else
                                            <td class="font-weight-medium text-center" width="6%"><div class="badge bg-warning">CLAIM ไม่ได้</div></td> 
                                            @endif
                                            <td class="text-center" width="10%">
                                                <div class="btn-group dropstart">                                               
                                                    <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        ทำรายการ
                                                        <i class="mdi mdi-chevron-down"></i>                                                        
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning" href="{{ url('supplies/supplies_index_edit/' .$item->product_id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for="" style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>
                                                       
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="supplies_destroy({{ $item->product_id }})">
                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                            <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
                                                    </div>
                                                </div>
                            
                                                
                                                {{-- <div class="dropdown">
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
                                                </div> --}}
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
    </div>
 

    @endsection
