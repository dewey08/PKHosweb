@extends('layouts.supplies')
@section('title', 'ZOFFice || พัสดุ')
@section('menu')
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
@endsection

@section('content')

    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                    <!--<div class="px-3 py-2 border-bottom">
                        <div class="container-fluid d-flex flex-wrap"> 
                            ข้อมูลวัสดุ
                            <div class="text-end"> </div>
                        </div>
                    </div>-->
                    <div class="card-header shadow-lg">
                        ข้อมูลวัสดุ
                    </div>

                    <div class="card-body shadow">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="table_id"> 
                                <thead>
                                    <tr height="10px">
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
                                                <a href="{{ url('supplies/supplies_index_edit/' . $item->product_id) }}"
                                                    class="text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข">
                                                    <i class="fa-solid fa-pen-to-square me-3"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="supplies_destroy({{ $item->product_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-md-3">
                <div class="card shadow"> 
                    <div class="card-header shadow-lg text-center">
                        เพิ่มข้อมูลวัสดุ
                    </div>      
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('sup.supplies_index_save') }}" method="POST"
                            id="insert_productForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
      
                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                <img src="{{ asset('assets/images/default-image.JPG') }}" id="add_upload_preview"
                                alt="Image" class="img-thumbnail" width="150px" height="150px">
                            <br>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="img"></label>
                                <input type="file" class="form-control" id="img" name="img"
                                    onchange="addproducts(this)">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="product_code" type="text" class="form-control"
                                        name="product_code" value="{{ $refnumber }}"
                                        autocomplete="product_code" autofocus placeholder="รหัสวัสดุ" readonly>
                                </div>
                            </div>                         
                          </div>                          
      
                      <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="product_name" type="text" class="form-control"
                                    name="product_name" required autocomplete="product_name" autofocus
                                    placeholder="รายการวัสดุ">
                            </div>
                        </div>                      
                        </div>
      
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="product_attribute" type="text" class="form-control"
                                        name="product_attribute" autocomplete="product_attribute" autofocus
                                        placeholder="คุณลักษณะ">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select id="product_groupid" name="product_groupid"
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($product_group as $progroup)
                                        <option value="{{ $progroup->product_group_id }}">
                                            {{ $progroup->product_group_name }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                            </div>                  
                        </div>
                        <div class="row mt-3">
                          <div class="col-md-12">
                              <div class="form-group">                         
                                <select id="product_typeid" name="product_typeid"
                                class="form-select form-select-lg" style="width: 100%" >
                                <option value="1">วัสดุ</option>
                               
                            </select>                        
                              </div>
                          </div>                  
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">                         
                                  <select id="product_categoryid" name="product_categoryid"
                                  class="form-select form-select-lg" style="width: 100%">
                                  <option value=""></option>
                                  @foreach ($product_category as $procat)
                                      <option value="{{ $procat->category_id }}">
                                          {{ $procat->category_name }}
                                      </option>
                                  @endforeach
                              </select>                        
                                </div>
                            </div>                  
                          </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select id="product_spypriceid" name="product_spypriceid"
                                        class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($product_spyprice as $prospy)
                                            <option value="{{ $prospy->spyprice_id }}">
                                                {{ $prospy->spyprice_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                  
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id="product_unit_bigid" name="product_unit_bigid"
                                        class="form-select form-select-lg show_unit" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($product_unit as $prounit)
                                            <option value="{{ $prounit->unit_id }}">
                                                {{ $prounit->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>  
                            <div class="col-md-4"> 
                                <div class="form-outline bga">
                                    <input type="text" id="UNIT_INSERT" name="UNIT_INSERT" class="form-control shadow"/>
                                    <label class="form-label" for="UNIT_INSERT" style="color: rgb(255, 72, 0)">เพิ่มหน่วย</label>
                                </div> 
                            </div>
                            <div class="col-md-1"> 
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addunit();">
                                        เพิ่ม
                                    </button> 
                                </div>
                            </div> 
                            <div class="col-md-1">   </div>          
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select id="product_unit_subid" name="product_unit_subid"
                                        class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($product_unit as $prounit)
                                            <option value="{{ $prounit->unit_id }}">
                                                {{ $prounit->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                  
                        </div>
                                                                         
                      <div class="form-group mt-3">             
                          <button type="submit" class="btn btn-primary " >
                              <i class="fa-solid fa-floppy-disk me-3"></i>บันทึกข้อมูล
                          </button>                    
                      </div>
      
                        </form>
                      </div>
                  </div>
            </div>
            -->
        </div>



        <script src="{{ asset('js/products.js') }}"></script>

    @endsection
