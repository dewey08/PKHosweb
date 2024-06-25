@extends('layouts.supplies')

@section('title', 'ZOFFice || อาคาร')
@section('menu')
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center"> 
        <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ขอซื้อขอจ้าง</a>
        <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">จัดซื้อจัดจ้าง</a> 
        <a href="{{url("land/land_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลที่ดิน</a>
        <a href="{{url("building/building_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-primary text-white me-2">ข้อมูลอาคาร</a>   
        <a href="{{url("serve/serve_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลบริการ</a>            
        <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลวัสดุ</a>
        <a href="{{url("article/article_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลครุภัณฑ์</a>           
        <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลค่าเสื่อม</a>
        <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-warning text-white me-2">ขายทอดตลาด</a>  
        
        <div class="text-end">
            {{-- <a type="button" class="btn btn-light text-dark me-2">Login</a> --}}
            <a type="button" class="btn btn-danger">ตั้งค่าข้อมูล</a>
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
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-9">
                <div class="card">

                    <div class="px-3 py-2 border-bottom">
                        <div class="container-fluid d-flex flex-wrap justify-content-center">
                            <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">
                                {{ __('ข้อมูลอาคาร') }}</a>

                            <div class="text-end">
                                {{-- <a href="{{ url('supplies/supplies_index_add') }}" class="btn btn-primary"><i
                                        class="fa-solid fa-folder-plus me-2"> เพิ่มข้อมูล</i></a> --}}
                            </div>
                        </div>
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
                                        <th class="text-center">ชื่ออาคาร</th>
                                        <th width="12%" class="text-center">งบประมาณที่สร้าง</th>
                                        <th width="10%" class="text-center">วันที่เริ่มสร้าง</th>
                                        <th width="10%" class="text-center">วันที่แล้วเสร็จ</th>
                                        <th width="8%" class="text-center">อายุใช้งาน</th>
                                        <th width="10%" class="text-center">งบประมาณ</th>
                                        <th width="13%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($building_data as $item)
                                    <tr id="sid{{ $item->building_id }}">
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="p-2">{{ $item->building_name }} </td>
                                        <td class="text-center">{{ number_format($item->building_budget_price ),2}}</td>
                                        <td class="text-center">{{ DateThai($item->building_creation_date )}}</td>
                                        <td class="text-center">{{ DateThai($item->building_completion_date) }}</td>
                                        <td class="text-center">{{ $item->building_long }}</td>
                                        <td class="p-2">{{ $item->building_budget_name }}</td>
                                        <td>
                                            <a href="{{ url('building/building_index_edit/'.$item->building_id) }}"
                                                class="btn rounded-pill text-warning" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                title="แก้ไข">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn rounded-pill text-danger" href="javascript:void(0)"
                                                onclick="building_destroy({{ $item->building_id }})"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                data-bs-custom-class="custom-tooltip" title="ลบ">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                            <a class="btn rounded-pill text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="เพิ่มรายละเอียด" data-bs-toggle="modal" data-bs-target="#saexampleModal">
                                                <i class="fa-solid fa-file-circle-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{ $building_data->links() }}
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="px-3 py-2 border-bottom">
                      <div class="container d-flex flex-wrap justify-content-center">                                        
                          <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">   {{ __('แก้ไขข้อมูลอาคาร') }}</a>  
          
                          <div class="text-end">                    
                         
                        </div>
                      </div>
                    </div>
      
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('bu.building_index_update') }}" method="POST"
                            id="update_buildingForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="building_id" id="building_id" value="{{$dataedits->building_id}}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                   
                                    @if ( $dataedits->building_img == Null )
                                    <img src="{{asset('assets/images/default-image.JPG')}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">
                                    @else
                                    <img src="{{asset('storage/building/'.$dataedits->building_img)}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">                                 
                                    @endif
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="building_img">Upload</label>
                                        <input type="file" class="form-control" id="building_img" name="building_img"
                                            onchange="editbuilding(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6">
                               
                            </div>                            
                          </div>                         
                      
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">หมายเลขระวาง</label>
                                    <select id="building_tonnage_number" name="building_tonnage_number" class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                            @foreach ($land_data as $land)
                                            @if ($dataedits->building_tonnage_number == $land->land_tonnage_number)
                                            <option value="{{ $land->land_id }}" selected>{{$land->land_tonnage_number }}  </option>
                                            @else
                                            <option value="{{ $land->land_id }}">{{$land->land_tonnage_number }}  </option>
                                            @endif     
                                                
                                            @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">งบประมาณ</label>
                                    <select id="building_budget_id" name="building_budget_id" class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                            @foreach ($product_budget as $budget)
                                            @if ($dataedits->building_budget_id == $budget->budget_id)
                                            <option value="{{$budget->budget_id}}" selected>{{$budget->budget_name }}  </option>
                                            @else
                                            <option value="{{$budget->budget_id}}">{{$budget->budget_name }}  </option>
                                            @endif     
                                               
                                            @endforeach
                                    </select>
                                </div>
                            </div>                
                          </div>    
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">วิธีได้มา</label>
                                    <select id="building_method_id" name="building_method_id" class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                            @foreach ($product_method as $method)
                                            @if ($dataedits->building_method_id == $method->method_id)
                                            <option value="{{$method->method_id}}" selected>{{$method->method_name }}  </option>
                                            @else
                                            <option value="{{$method->method_id}}">{{$method->method_name }}  </option>
                                            @endif     
                                                
                                            @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">วิธีการซื้อ</label>
                                    <select id="building_buy_id" name="building_buy_id" class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                            @foreach ($product_buy as $buy)
                                            @if ($dataedits->building_buy_id == $buy->buy_id)
                                            <option value="{{$buy->buy_id}}" selected>{{$buy->buy_name }}  </option>
                                            @else
                                            <option value="{{$buy->buy_id}}">{{$buy->buy_name }}  </option>
                                            @endif     
                                                
                                            @endforeach
                                    </select>
                                </div>
                            </div>                       
                        </div>
                      
                          <div class="row mt-3">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label for="">ชื่อสิ่งปลูกสร้าง</label>
                                    <input id="building_name" type="text" class="form-control" name="building_name" value="{{$dataedits->building_name}}">
                                </div>
                            </div>                      
                            </div>
                      <div class="row mt-3">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="">ใช้งบประมาณ</label>
                                    <input id="building_budget_price" type="text" class="form-control" name="building_budget_price" value="{{$dataedits->building_budget_price}}">
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <div class="form-group">
                                   <label for="">บาท</label>
                                </div>
                            </div>                       
                        </div>
               
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">วันที่สร้าง</label>
                                    <input id="building_creation_date" type="date" class="form-control" name="building_creation_date" value="{{$dataedits->building_creation_date}}">
                                   
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">วันที่แล้วเสร็จ</label>
                                    <input id="building_completion_date" type="date" class="form-control" name="building_completion_date" value="{{$dataedits->building_completion_date}}">
                                  
                                </div>
                            </div>                
                          </div>    
                          <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">วันที่ส่งมอบ</label>
                                    <input id="building_delivery_date" type="date" class="form-control" name="building_delivery_date" value="{{$dataedits->building_delivery_date}}">
                                   
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">อายุการใช้งาน</label>
                                    <input id="building_long" type="text" class="form-control" name="building_long" value="{{$dataedits->building_long}}">
                                  
                                </div>
                            </div>                
                          </div>    
                       
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">                         
                                    <select id="building_decline_id" name="building_decline_id" class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($product_decline as $decli)
                                        @if ($dataedits->building_decline_id == $decli->decline_id)
                                        <option value="{{ $decli->decline_id }}" selected> {{ $decli->decline_name }} </option>
                                        @else
                                        <option value="{{ $decli->decline_id }}"> {{ $decli->decline_name }} </option>
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


           
            <script src="{{ asset('js/building.js') }}"></script>       
    @endsection
