@extends('layouts.supplies')
@section('title', 'PK-OFFICER || ข้อมูลบริการ')
 

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
</style>
<?php
    use Illuminate\Support\Facades\DB; 
    use App\Http\Controllers\SuppliesController;
    use App\Http\Controllers\StaticController;
    $refnumber = SuppliesController::refnumber(); 
    $count_product = StaticController::count_product(); 
    $count_service = StaticController::count_service(); 
?>
    

@section('content')
  
  <script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }

    function serve_destroy(product_id)
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
          url:"{{url('serve/serve_destroy')}}" +'/'+ product_id, 
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
                  window.location = "{{url('serve/serve_index')}}"; //       
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
    <?php
    use App\Http\Controllers\ServeController;
    $refserve = ServeController::refserve();
    ?>
    <div class="container-fluid" >
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">                 
                    
                    <div class="card-header ">
                        <div class="d-flex">
                            <div class=" ">
                                <label for="" >ข้อมูลบริการ</label> 
                             </div> 
                                <div class="ms-auto ">
                                    <a href="{{ url('serve/serve_index_add') }}" class="btn btn-info btn-sm"  >
                                    {{-- <i class="fa-solid fa-circle-check text-success me-2"></i> --}}
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    เพิ่มข้อมูลบริการ
                                    </a> 
                                    
                                </div>
                        </div>          
                </div>
                    <div class="card-body shadow">
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example"> 
                                <thead>
                                    <tr height="10px">
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="12%" class="text-center">รหัสบริการ</th>
                                        <th class="text-center">รายการบริการ</th>
                                        <th width="10%" class="text-center">ชนิดบริการ</th>
                                        <th width="15%" class="text-center">ประเภทพัสดุ</th>
                                        <th width="20%" class="text-center" >หมวดพัสดุ</th> 
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
                                            <td class="text-center" width="10%">{{ $item->product_groupname }}</td>
                                            <td class="text-center" width="15%">{{ $item->product_typename }}</td>
                                            <td class="p-2" width="20%">{{ $item->product_categoryname }}</td> 
                                            <td class="text-center" width="10%">
                                                <div class="btn-group">                                               
                                                    <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        ทำรายการ
                                                        <i class="mdi mdi-chevron-down"></i>                                                        
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning" href="{{ url('serve/serve_index_edit/' .$item->product_id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for="" style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>
                                                       
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="serve_destroy({{ $item->product_id }})">
                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                            <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
                                                    </div>
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
