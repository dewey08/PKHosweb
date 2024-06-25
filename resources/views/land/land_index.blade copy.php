@extends('layouts.article')

@section('title', 'ZOFFice || ข้อมูลที่ดิน')

@section('menu')
<style>
    .btn {
        font-size: 15px;
    }
</style>
 <?php
 use App\Http\Controllers\StaticController;
 use Illuminate\Support\Facades\DB;   
 $count_land = StaticController::count_land();
 $count_building = StaticController::count_building();
 $count_article = StaticController::count_article();
?>
<div class="px-3 py-2 border-bottom">
    <div class="container d-flex flex-wrap justify-content-center">
            <a href="{{ url('article/article_dashboard') }}" class="btn btn-light btn-sm dark-white me-2">dashboard </a>
            <a href="{{url("land/land_index")}}" class="btn btn-secondary btn-sm text-white me-2">ข้อมูลที่ดิน<span class="badge bg-danger ms-2">{{$count_land}}</span></a>
            <a href="{{url("building/building_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลอาคาร<span class="badge bg-danger ms-2">{{$count_building}}</span></a>   
            <a href="{{url("article/article_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลครุภัณฑ์<span class="badge bg-danger ms-2">{{$count_article}}</span></a>           
            <a href=" " class="btn btn-light btn-sm text-dark me-2">ข้อมูลค่าเสื่อม</a>
            <a href=" " class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ขายทอดตลาด</a>  
        
        <div class="text-end">
            <a href="{{ url('land/land_index_add') }}" class="btn btn-light btn-sm text-dark me-2">เพิ่มข้อมูลที่ดิน </a>
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
    use App\Http\Controllers\LandController;
    $refnumber = LandController::refnumber();
    ?>
    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">

                    <div class="px-3 py-2 border-bottom">
                        <div class="container-fluid d-flex flex-wrap justify-content-center">
                            {{-- <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">
                                {{ __('ข้อมูลที่ดิน') }}</a> --}}

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
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> 
                                <thead>
                                    <tr height="10px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th width="15%" class="text-center">หมายเลขระวาง</th>
                                        <th width="15%" class="text-center">เลขที่</th>
                                        <th width="15%" class="text-center">เลขโฉนดที่ดิน</th>
                                        <th width="15%" class="text-center">หน้าสำรวจ</th>
                                        <th width="15%" class="text-center">วันที่ถือครอง</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($land_data as $item)
                                        <tr id="sid{{ $item->land_id }}">
                                            <td class="text-center" width="5%">{{ $i++ }}</td>
                                            <td class="p-2">{{ $item->land_tonnage_number }} </td>
                                            <td class="p-2">{{ $item->land_no }}</td>
                                            <td class="p-2">{{ $item->land_tonnage_no }}</td>
                                            <td class="p-2">{{ $item->land_explore_page }}</td>
                                            <td class="text-center" width="15%">{{ DateThai($item->land_date) }}</td>
                                            <td class="text-center" width="10%">
                                                {{-- <a class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="เพิ่มรายละเอียด" data-bs-toggle="modal" data-bs-target="#saexampleModal">
                                                    <i class="fa-solid fa-file-circle-plus"></i>
                                                </a> --}}
                                                <a href="{{ url('land/land_index_edit/' . $item->land_id) }}"
                                                    class="text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข" >
                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="land_destroy({{ $item->land_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can me-2"></i>
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{ $land_data->links() }}
                                </ul>
                            </nav> --}}

                        </div>
                    </div>
                </div>
            </div>
          <!-- <div class="col-md-3">
                <div class="card">
                    <div class="px-3 py-2 border-bottom">
                      <div class="container d-flex flex-wrap justify-content-center">                                        
                          <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">   {{ __('เพิ่มข้อมูลที่ดิน') }}</a>  
          
                          <div class="text-end">                    
                         
                        </div>
                      </div>
                    </div>
      
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('land.land_index_save') }}" method="POST"
                            id="insert_landForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <img src="{{ asset('assets/images/default-image.JPG') }}" id="add_upload_preview"
                                    alt="Image" class="img-thumbnail" width="150px" height="150px">
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="land_img"></label>
                                        <input type="file" class="form-control" id="land_img" name="land_img"
                                            onchange="addland(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>  
                           
                            
                          </div>                         
                      
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="land_tonnage_number" type="text" class="form-control" name="land_tonnage_number" autocomplete="land_tonnage_number" autofocus placeholder="หมายเลขระวาง" >
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="land_no" type="text" class="form-control" name="land_no" required autocomplete="land_no" autofocus placeholder="เลขที่">
                                </div>
                            </div>                
                          </div>    
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="land_tonnage_no" type="text" class="form-control" name="land_tonnage_no" required autocomplete="land_tonnage_no" autofocus placeholder="เลขโฉนดที่ดิน">
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="land_explore_page" type="text" class="form-control" name="land_explore_page" autocomplete="land_explore_page" autofocus placeholder="หน้าสำรวจ">
                                </div>
                            </div>                       
                        </div>
      
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="land_farm_area" type="text" class="form-control" name="land_farm_area" autocomplete="land_farm_area" autofocus placeholder="เนื้อที่ไร่">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="land_work_area" type="text" class="form-control" name="land_work_area" autocomplete="land_work_area" autofocus placeholder="เนื้อที่งาน">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">เนื้อที่ตารางวา</label>
                                    <input id="land_square_wah_area" type="text" class="form-control" name="land_square_wah_area" autocomplete="land_square_wah_area" autofocus placeholder="เนื้อที่ตารางวา">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="">วันที่ถือครอง</label>
                                <input id="land_date" type="date" class="form-control" name="land_date" autocomplete="land_date" autofocus placeholder="วันถือครอง" >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">ผู้ถือครอง</label>
                                    <input id="land_holder_name" type="text" class="form-control" name="land_holder_name"  >
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">ที่ตั้งบ้านเลขที่</label>
                                    <input id="land_house_number" type="text" class="form-control" name="land_house_number" >
                                </div>
                            </div>                             
                        </div>
                        
               
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select id="land_province_location" name="land_province_location"
                                    class="form-select form-select-lg provice" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($data_province as $province)
                                        <option value="{{ $province->ID }}"> {{ $province->PROVINCE_NAME }} </option>
                                    @endforeach
                                </select>
                                </div>
                            </div>                  
                        </div>
                       
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">                         
                                  <select id="land_district_location" name="land_district_location" class="form-select form-select-lg amphures" style="width: 100%">
                                    <option value=""></option>
                                 
                                    </select>                        
                                </div>
                            </div>                  
                          </div>
                        <div class="row mt-3">
                          <div class="col-md-12">
                              <div class="form-group">
                                <select id="land_tumbon_location" name="land_tumbon_location" class="form-select form-select-lg tumbon" style="width: 100%">
                                        <option value=""></option>
                                       
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
            </div> -->
        </div>


            <!-- Modal -->
            <div class="modal fade" id="saexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เลขหมวดครุภัณฑ์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" id="myInput" type="text" placeholder="ค้นหา..">
                        <br>
                        <div style='overflow:scroll; height:300px;'>
                            <table class="table">
                                <thead>                      
                                    <tr>
                                        <td style="text-align: center;" width="20%">เลข FSN</td>
                                        <td style="text-align: center;">ชื่อพัสดุ</th>                                    
                                        <td style="text-align: center;" width="5%">เลือก</td>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @foreach ($product_prop as $prop)
                                        <tr>                                           
                                            <td >{{$prop->fsn}}</td>
                                            <td >{{$prop->prop_name}}</td>                                                                
                                            <td >
                                                 <button type="button" class="btn btn-info"  onclick="selectfsn({{$prop->prop_id}})">เลือก</button>   
                                            </td>
                                        </tr>
                                    @endforeach                            
                                </tbody>
                            </table>                               
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>



            <script src="{{ asset('js/land.js') }}"></script>       
    @endsection
