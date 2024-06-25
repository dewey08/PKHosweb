@extends('layouts.article')

@section('title', 'ZOFFice || ครุภัณฑ์')
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
        <a href="{{ url('article/article_dashboard') }}" class="btn btn-light btn-sm text-dark me-2">dashboard </a>
            <a href="{{url("land/land_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลที่ดิน<span class="badge bg-danger ms-2">{{$count_land}}</span></a>
            <a href="{{url("building/building_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลอาคาร<span class="badge bg-danger ms-2">{{$count_building}}</span></a>   
            <a href="{{url("article/article_index")}}" class="btn btn-secondary btn-sm text-white me-2">ข้อมูลครุภัณฑ์<span class="badge bg-danger ms-2">{{$count_article}}</span></a>           
            <a href=" " class="btn btn-light btn-sm text-dark me-2">ข้อมูลค่าเสื่อม</a>
            <a href=" " class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ขายทอดตลาด</a>  
        <div class="text-end">
            <a href="{{ url('article/article_index_add') }}" class="btn btn-light btn-sm text-dark me-2">เพิ่มข้อมูลครุภัณฑ์ </a>
        </div>
        </div>
    </div>
@endsection
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function article_destroy(article_id)
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
        url:"{{url('article/article_destroy')}}" +'/'+ article_id, 
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
                $("#sid"+article_id).remove();     
                // window.location.reload(); 
                window.location = "{{url('article/article_index')}}";  
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
    use App\Http\Controllers\ArticleController;
    $refnumber = ArticleController::refnumber();
    ?>
    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">

                    {{-- <div class="px-3 py-2 border-bottom">
                        <div class="container-fluid d-flex flex-wrap justify-content-center">
                            <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">
                                {{ __('ข้อมูลครุภัณฑ์') }}</a>

                            <div class="text-end">
                                <a href="{{ url('supplies/supplies_index_add') }}" class="btn btn-primary"><i
                                        class="fa-solid fa-folder-plus me-2"> เพิ่มข้อมูล</i></a>
                            </div>
                        </div>
                    </div> --}}

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
                                        <th width="13%" class="text-center">รหัสครุภัณฑ์</th>
                                        <th class="text-center">รายการครุภัณฑ์</th>
                                        <th width="15%" class="text-center">ประเภทค่าเสื่อม</th>
                                        <th width="15%" class="text-center">หมวดครุภัณฑ์</th>
                                        <th width="20%" class="text-center">ประจำหน่วยงาน</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($article_data as $item)
                                        <tr id="sid{{ $item->article_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="p-2" width="20%">{{ $item->article_num }} </td>
                                            <td class="p-2">{{ $item->article_name }}</td>
                                            <td class="p-2" width="15%">{{ $item->article_decline_name }}</td>
                                            <td class="p-2" width="15%">{{ $item->article_categoryname }}</td>
                                            <td class="p-2" width="17%">{{ $item->article_deb_subsub_name }}</td>
                                            <td class="text-center" width="10%">
                                                <a href="{{ url('article/article_index_edit/' . $item->article_id) }}"
                                                    class="text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข" >
                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="article_destroy({{ $item->article_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can me-2"></i>
                                                </a>
                                              <!-- <a class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="เพิ่มรายละเอียด" data-bs-toggle="modal" data-bs-target="#saexampleModal">
                                                    <i class="fa-solid fa-file-circle-plus"></i>
                                                </a> -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{ $article_data->links() }}
                                </ul>
                            </nav> --}}

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                {{-- <div class="card">
                    <div class="px-3 py-2 border-bottom">
                      <div class="container d-flex flex-wrap justify-content-center">                                        
                          <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">   {{ __('เพิ่มข้อมูลครุภัณฑ์') }}</a>  
          
                          <div class="text-end">                    
                         
                        </div>
                      </div>
                    </div>
      
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('art.article_index_save') }}" method="POST"
                            id="insert_articleForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="article_typeid" id="PRODUCT_TYPEID" value="2">
                            <input type="hidden" name="article_groupid" id="PRODUCT_GROUPID" value="3">

                        <div class="row"> --}}
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <img src="{{ asset('assets/images/default-image.JPG') }}" id="add_upload_preview"
                                    alt="Image" class="img-thumbnail" width="150px" height="150px">
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="article_img">Upload</label>
                                        <input type="file" class="form-control" id="article_img" name="article_img"
                                            onchange="addarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>   --}}
                            {{-- <div class="col-md-6"> --}}
                                {{-- <div class="form-group">
                                    <select id="leave_year_id" name="leave_year_id" class="form-select form-select-lg" style="width: 100%" >
                                        <option value="">ปีงบประมาณ</option>
                                        @foreach ($budget_year as $year)
                                            <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }} </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                               
                                {{-- <div class="form-group mt-2">
                                    <label for="">วันที่รับเข้า</label>
                                    <input id="article_recieve_date" type="date" class="form-control" name="article_recieve_date" autocomplete="article_fsn" autofocus placeholder="วันที่รับเข้า" >
                                </div> --}}
               
                                {{-- <div class="form-group mt-2">
                                    <input id="article_price" type="text" class="form-control" name="article_price" autocomplete="article_price" autofocus placeholder="ราคา" >
                                </div> --}}
                            {{-- </div>
                            
                          </div>   
                          <br>                      
                      
                        <div class="row"> --}}
                            {{-- <div class="col-md-8 detali_fsn">
                                <div class="form-group">
                                    <input id="article_fsn" type="text" class="form-control" name="article_fsn" autocomplete="article_fsn" autofocus placeholder="เลือกรหัสหมวดครุภัณฑ์" >
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#saexampleModal">
                                        <i class="fa-solid fa-file-circle-plus me-3"></i> 
                                    </button> 
                                </div>
                            </div>                         
                          </div>                           --}}
                          {{-- <div class="row mt-3">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <input id="article_num" type="text" class="form-control" name="article_num" required autocomplete="article_num" autofocus placeholder="เลขครุภัณฑ์">
                                </div>
                            </div>                      
                            </div>
                      <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="article_name" type="text" class="form-control" name="article_name" required autocomplete="article_name" autofocus placeholder="ชื่อครุภัณฑ์">
                            </div>
                        </div>                      
                        </div>
      
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="article_attribute" type="text" class="form-control" name="article_attribute" autocomplete="article_attribute" autofocus placeholder="คุณลักษณะ">
                                </div>
                            </div> --}}
                        {{-- </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select id="article_decline_id" name="article_decline_id"
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($product_decline as $prodecli)
                                        <option value="{{ $prodecli->decline_id }}">
                                            {{ $prodecli->decline_name }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                            </div>                  
                        </div>
                        --}}
                        {{-- <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">                         
                                  <select id="article_categoryid" name="article_categoryid"
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
                                <select id="article_deb_subsub_id" name="article_deb_subsub_id" class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($department_sub_sub as $deb_subsub)
                                            <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}"> {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
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
        </div> --}}


            <!-- Modal -->
            <div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="articleModalLabel">เลขหมวดครุภัณฑ์</h5>
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
                                            {{-- <td >{{$prop->NUM}}</td>
                                            <td >{{$prop->PROPOTIES_NAME}}</td>                                                                
                                            <td >
                                                 <button type="button" class="btn btn-info"  onclick="selectfsn({{$prop->PROPOTIES_ID}})">เลือก</button>   
                                            </td> --}}
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



             
    @endsection
