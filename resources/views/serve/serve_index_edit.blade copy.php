@extends('layouts.supplies')
@section('title', 'ZOFFice || ข้อมูลบริการ')
@section('menu')
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
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลวัสดุ<span class="badge bg-danger ms-2">{{$count_product}}</span></a>   
            <a href="{{url("serve/serve_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-success btn-sm text-white me-2">ข้อมูลบริการ<span class="badge bg-danger ms-2">{{$count_service}}</span></a>  
        <div class="text-end">
           <!-- <a href="{{ url('supplies/supplies_index_add') }}" class="btn btn-light btn-sm text-dark shadow me-2">เพิ่มข้อมูลวัสดุ </a>-->
        </div>
        </div>
    </div>
@endsection

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
    use App\Http\Controllers\ServeController;
    $refserve = ServeController::refserve();
    ?>
    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">                 
                    <div class="card-header shadow-lg">
                        ข้อมูลบริการ
                    </div>

                    <div class="card-body shadow">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="table_id">
                                {{-- <table class="table table-hover table-bordered border-primary" style="wproduct_idth: 100%;" product_id="table_id"> เส้นสีฟ้า --}}
                                <thead>
                                    <tr height="10px">
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="15%" class="text-center">รหัสบริการ</th>
                                        <th class="text-center">รายการบริการ</th>
                                        <th width="10%" class="text-center">ชนิดบริการ</th>
                                        <th width="10%" class="text-center">ประเภทพัสดุ</th>
                                        <th width="20%" class="text-center">หมวดพัสดุ</th>
                                        {{-- <th width="10%" class="text-center">ราคาสืบ</th> --}}
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($product_data as $item)
                                        <tr id="sid{{ $item->product_id }}">
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $item->product_code }} </td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->product_groupname }}</td>
                                            <td>{{ $item->product_typename }}</td>
                                            <td>{{ $item->product_categoryname }}</td>
                                            {{-- <td>{{ $item->product_spypricename }}</td> --}}
                                            <td>
                                                <a href="{{ url('serve/serve_index_edit/'.$item->product_id) }}"
                                                    class="text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข">
                                                    <i class="fa-solid fa-pen-to-square me-3"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="serve_destroy({{ $item->product_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{ $product_data->links() }}
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="card">
                    <div class="card-header shadow-lg text-center">
                        แก้ไขข้อมูลบริการ
                    </div>
      
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('serve.serve_index_update') }}" method="POST"
                            id="update_serveForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input id="product_id" type="hidden" class="form-control" name="product_id" value="{{ $dataedits->product_id}}" >
                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">                               
                                @if ( $dataedits->img == Null )
                                <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">
                                @else
                                <img src="{{asset('storage/serve/'.$dataedits->img)}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">                                 
                                @endif
                            <br>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="img"></label>
                                <input type="file" class="form-control" id="img" name="img"
                                    onchange="editserve(this)">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="product_code" type="text" class="form-control"
                                        name="product_code" value="{{ $dataedits->product_code}}" readonly>
                                </div>
                            </div>                         
                          </div>                          
      
                      <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="product_name" type="text" class="form-control" value="{{ $dataedits->product_name}}"
                                    name="product_name" required >
                            </div>
                        </div>                      
                        </div>
      
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="product_attribute" type="text" class="form-control" value="{{ $dataedits->product_attribute}}"
                                        name="product_attribute" >
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="product_groupids" type="hidden" class="form-control" name="product_groupid" value="4">  
                                    <input id="w" type="text" class="form-control" name="w" autocomplete="w" autofocus placeholder="บริการ" readonly>                                    
                                </div>
                            </div>                  
                        </div>
                        <div class="row mt-3">
                          <div class="col-md-12">
                              <div class="form-group">     
                                <input id="product_typeids" type="hidden" class="form-control" name="product_typeid" value="3">  
                                <input id="s" type="text" class="form-control" name="s" autocomplete="s" autofocus placeholder="จ้างเหมา" readonly>  
                              </div>
                          </div>                  
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">  
                                    <input id="product_categoryids" type="hidden" class="form-control" name="product_categoryid" value="23">  
                                    <input id="ss" type="text" class="form-control" name="ss" autocomplete="ss" autofocus placeholder="จ้างเหมาอื่นๆ" readonly>  
                                </div>
                            </div>                  
                          </div>
                       
                                                                         
                      <div class="form-group mt-3">             
                          <button type="submit" class="btn btn-primary " >
                              <i class="fa-solid fa-floppy-disk me-3"></i>แก้ไขข้อมูล
                          </button>                    
                      </div>
      
                        </form>
                      </div>
                  </div>
            </div> --}}
        </div>




        

    @endsection
