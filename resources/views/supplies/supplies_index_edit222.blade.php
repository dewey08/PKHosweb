@extends('layouts.supplies')
@section('title', 'ZOFFice || พัสดุ')
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
    $refnumber = SuppliesController::refnumber(); 
?>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">   
            <a href="{{ url('supplies/supplies_dashboard') }}" class="btn btn-outline-success btn-sm text-dark shadow me-2">dashboard </a>
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-outline-success btn-sm text-dark shadow me-2">ขอซื้อขอจ้าง<span class="badge bg-danger ms-2">12</span></a>
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-outline-success btn-sm text-dark shadow me-2">จัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">14</span></a>   
            <a href="{{url("supplies/supplies_index")}}" class="btn btn-success btn-sm text-white shadow me-2">ข้อมูลวัสดุ<span class="badge bg-danger ms-2">10</span></a>   
            <a href=" " class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-outline-success btn-sm text-dark shadow me-2">ข้อมูลบริการ</a>  
        <div class="text-end">
            <a href="{{ url('article/article_index_add') }}" class="btn btn-outline-danger btn-sm text-dark shadow me-2">ตั้งค่า </a>
        </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-9">
                <div class="card shadow">
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
                                {{-- <table class="table table-hover table-bordered border-primary" style="wproduct_idth: 100%;" product_id="table_id"> เส้นสีฟ้า --}}
                                <thead>
                                    <tr height="10px">
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="12%" class="text-center">รหัสวัสดุ</th>
                                        <th class="text-center">รายการวัสดุ</th>
                                        <th width="10%" class="text-center">ชนิดวัสดุ</th>
                                        <th width="10%" class="text-center">ประเภทวัสดุ</th>
                                        <th width="20%" class="text-center">หมวดวัสดุ</th>
                                        <th width="10%" class="text-center">ราคาสืบ</th>
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
                                        <td class="p-2">{{ $item->product_categoryname }}</td>
                                        <td class="text-center" width="12%">{{ $item->product_spypricename }}</td>
                                        <td class="text-center" width="10%">
                                            <a href="{{ url('supplies/supplies_index_edit/' . $item->product_id) }}"
                                                class="text-warning" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                title="แก้ไข" value="{{ $item->product_id }}">
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
            <div class="col-md-3">
                <div class="card shadow"> 
                    <div class="card-header shadow-lg text-center">
                        แก้ไขข้อมูลวัสดุ
                    </div>  
      
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('sup.supplies_index_update') }}" method="POST"
                            id="update_productForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input id="product_id" type="hidden" class="form-control" name="product_id" value="{{ $dataedits->product_id}}" >
                            {{-- <input id="img_name" type="hidden" class="form-control" name="img_name" value="{{ $dataedits->img_name}}" > --}}
                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                @if ( $dataedits->img == Null )
                                <img src="{{asset('assets/images/default-image.JPG')}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">
                                @else
                                <img src="{{asset('storage/products/'.$dataedits->img)}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">
                               <!--   <td> <img src="data:image/jpg;base64,{{chunk_split(base64_encode($dataedits->img)) }}" height="60px" width="60px"></td> -->
                                @endif  
                            <br>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="img"></label>
                                <input type="file" class="form-control" id="img" name="img"
                                    onchange="editproducts(this)">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="product_code" type="text" class="form-control"
                                        name="product_code" value="{{ $dataedits->product_code }}"
                                        autocomplete="product_code" autofocus placeholder="รหัสวัสดุ" readonly>
                                </div>
                            </div>                         
                          </div>                          
      
                      <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="product_name" type="text" class="form-control" value="{{ $dataedits->product_name }}"
                                    name="product_name" required autocomplete="product_name" autofocus
                                    placeholder="รายการวัสดุ">
                            </div>
                        </div>                      
                        </div>
      
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">คุณลักษณะ</label>
                                    <input id="product_attribute" type="text" class="form-control" value="{{ $dataedits->product_attribute }}"
                                        name="product_attribute" >
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">วัสดุ</label> 
                                    <select id="product_groupid" name="product_groupid"
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($product_group as $progroup)
                                    @if ($dataedits->product_groupid == $progroup->product_group_id)
                                    <option value="{{ $progroup->product_group_id }}" selected>{{ $progroup->product_group_name }} </option>
                                    @else
                                    <option value="{{ $progroup->product_group_id }}">{{ $progroup->product_group_name }} </option>
                                    @endif                                        
                                    @endforeach
                                </select>
                                </div>
                            </div>                  
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">  
                                    <label for="">ประเภทวัสดุ</label>                         
                                  <select id="product_typeid" name="product_typeid"
                                  class="form-select form-select-lg" style="width: 100%" >
                                  <option value="1">วัสดุ</option>
                                  {{-- @foreach ($product_type as $protype)
                                      <option value="{{ $protype->sub_type_id }}"> {{ $protype->sub_type_name }} </option>
                                  @endforeach --}}
                              </select>                        
                                </div>
                            </div>                  
                          </div>
                          <div class="row mt-3">
                              <div class="col-md-12">
                                  <div class="form-group">   
                                    <label for="">หมวดครุภัณฑ์</label>                        
                                    <select id="product_categoryid" name="product_categoryid"
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($product_category as $procat)
                                    @if ($dataedits->product_categoryid == $procat->category_id)
                                    <option value="{{ $procat->category_id }}" selected> {{ $procat->category_name }} </option>
                                    @else
                                    <option value="{{ $procat->category_id }}"> {{ $procat->category_name }} </option>
                                    @endif                                        
                                    @endforeach
                                </select>                        
                                  </div>
                              </div>                  
                            </div>
                        <div class="row mt-3">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label for="">ราคาสืบ</label> 
                                <select id="product_spypriceid" name="product_spypriceid" class="form-select form-select-lg" style="width: 100%">
                                <option value=""></option>
                                @foreach ($product_spyprice as $prospy)
                                @if ($dataedits->product_spypriceid == $prospy->spyprice_id)
                                <option value="{{ $prospy->spyprice_id }}" selected> {{ $prospy->spyprice_name }} </option>
                                @else
                                <option value="{{ $prospy->spyprice_id }}"> {{ $prospy->spyprice_name }} </option>
                                @endif                                    
                                @endforeach
                            </select>
                              </div>
                          </div>                  
                        </div>
                        <div class="row mt-3">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label for="">หน่วยนับ</label> 
                                <select id="product_unit_subid" name="product_unit_subid"
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($product_unit as $prounit)
                                    @if ($dataedits->product_unit_subid == $prounit->unit_id)
                                    <option value="{{ $prounit->unit_id }}" selected> {{ $prounit->unit_name }} </option>
                                    @else
                                    <option value="{{ $prounit->unit_id }}"> {{ $prounit->unit_name }} </option>
                                    @endif                                        
                                    @endforeach
                                </select>
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
            </div>
        </div>


        <script src="{{ asset('js/products.js') }}"></script>


    @endsection
