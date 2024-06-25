@extends('layouts.supplies')

@section('title', 'ZOFFice || ครุภัณฑ์')
@section('menu')
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center"> 
            <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ขอซื้อขอจ้าง</a>
            <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">จัดซื้อจัดจ้าง</a> 
            <a href="{{url("land/land_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลที่ดิน</a>
            <a href="{{url("building/building_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลอาคาร</a>   
            <a href="{{url("serve/serve_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลบริการ</a>            
            <a href="{{url("supplies/supplies_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-warning text-white me-2">ข้อมูลวัสดุ</a>
            <a href="{{url("article/article_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 btn btn-primary text-white me-2">ข้อมูลครุภัณฑ์</a>           
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
    <?php
    use App\Http\Controllers\ArticleController;
    $refnumber = ArticleController::refnumber();
    ?>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-9">
                <div class="card">

                    <div class="px-3 py-2 border-bottom">
                        <div class="container-fluid d-flex flex-wrap justify-content-center">
                            <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">
                                {{ __('ข้อมูลครุภัณฑ์') }}</a>

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
                                        <th width="15%" class="text-center">รหัสครุภัณฑ์</th>
                                        <th class="text-center">รายการครุภัณฑ์</th>
                                        <th width="15%" class="text-center">ประเภทค่าเสื่อม</th>
                                        <th width="15%" class="text-center">หมวดครุภัณฑ์</th>
                                        <th width="20%" class="text-center">ประจำหน่วยงาน</th>
                                        {{-- <th width="10%" class="text-center">ราคาสืบ</th> --}}
                                        <th width="13%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($article_data as $item)
                                        <tr id="sid{{ $item->article_id }}">
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td class="p-2">{{ $item->article_num }} </td>
                                            <td class="p-2">{{ $item->article_name }}</td>
                                            <td class="p-2">{{ $item->article_decline_name }}</td>
                                            <td class="p-2">{{ $item->article_categoryname }}</td>
                                            <td class="p-2">{{ $item->article_deb_subsub_name }}</td>
                                            {{-- <td>{{ $item->article_spypricename }}</td> --}}
                                            <td class="text-center" width="13%">
                                                <a href="{{ url('article/article_index_edit/' . $item->article_id) }}"
                                                    class="btn rounded-pill text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข" value="{{ $item->article_id }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a class="btn rounded-pill text-danger" href="javascript:void(0)"
                                                    onclick="article_destroy({{ $item->article_id }})"
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
                                    {{ $article_data->links() }}
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
                          <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-danger me-2">   {{ __('แก้ไขข้อมูลครุภัณฑ์') }}</a>  
          
                          <div class="text-end">                    
                         
                        </div>
                      </div>
                    </div>
      
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('art.article_index_update') }}" method="POST"
                            id="update_articleForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="article_typeid" id="PRODUCT_TYPEID" value="2">
                            <input type="hidden" name="article_groupid" id="PRODUCT_GROUPID" value="3">
                            <input type="hidden" name="article_id" id="article_id" value="{{$dataedits->article_id}}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    @if ( $dataedits->article_img == Null )
                                    <img src="{{asset('assets/images/default-image.JPG')}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">
                                    @else
                                    <img src="{{asset('storage/article/'.$dataedits->article_img)}}" id="edit_upload_preview" height="150px" width="150px" alt="Image" class="img-thumbnail">                                 
                                    @endif
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="article_img">Upload</label>
                                        <input type="file" class="form-control" id="article_img" name="article_img"
                                            onchange="editarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">ปีงบประมาณ</label>
                                    <select id="leave_year_id" name="leave_year_id" class="form-select form-select-lg" style="width: 100%" >
                                        <option value="">ปีงบประมาณ</option>
                                        @foreach ($budget_year as $year)
                                        @if ($dataedits->article_year == $year->leave_year_id)
                                        <option value="{{ $year->leave_year_id }}" selected> {{ $year->leave_year_id }} </option>
                                        @else
                                        <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }} </option>
                                        @endif
                                            
                                        @endforeach
                                    </select>
                                </div>
                               
                                <div class="form-group mt-2">
                                    <label for="">วันที่รับเข้า</label>
                                    <input id="article_recieve_date" type="date" class="form-control" name="article_recieve_date" value="{{$dataedits->article_recieve_date}}" >
                                </div>
               
                                <div class="form-group mt-2">
                                    <label for="">ราคา</label>
                                    <input id="article_price" type="text" class="form-control" name="article_price" value="{{$dataedits->article_price}}" >
                                </div>
                            </div>
                            
                          </div>                         
                      
                        <div class="row">
                            <div class="col-md-8 detali_fsn">
                                <div class="form-group">
                                    <label for="">รหัสหมวดครุภัณฑ์</label>
                                    <input id="article_fsn" type="text" class="form-control" name="article_fsn" value="{{$dataedits->article_fsn}}" >
                                </div>
                            </div>  
                            <div class="col-md-4 mt-4">
                                <div class="form-group">
                                    <label for=""></label>
                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#saexampleModal">
                                        <i class="fa-solid fa-file-circle-plus me-3"></i>เลือก
                                    </button> 
                                </div>
                            </div>                         
                          </div>                          
                          <div class="row mt-3">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label for="">เลขครุภัณฑ์</label>
                                    <input id="article_num" type="text" class="form-control" name="article_num" value="{{$dataedits->article_num}}">
                                </div>
                            </div>                      
                            </div>
                      <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ชื่อครุภัณฑ์</label>
                                <input id="article_name" type="text" class="form-control" name="article_name" value="{{$dataedits->article_name}}">
                            </div>
                        </div>                      
                        </div>
      
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">คุณลักษณะ</label>
                                    <input id="article_attribute" type="text" class="form-control" name="article_attribute" value="{{$dataedits->article_attribute}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ประเภทค่าเสื่อม</label>
                                    <select id="article_decline_id" name="article_decline_id"
                                    class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($product_decline as $prodecli)
                                    @if ($dataedits->article_decline_id ==$prodecli->decline_id)
                                    <option value="{{ $prodecli->decline_id }}" selected> {{ $prodecli->decline_name }} </option>
                                    @else
                                    <option value="{{ $prodecli->decline_id }}"> {{ $prodecli->decline_name }} </option>
                                    @endif
                                        
                                    @endforeach
                                </select>
                                </div>
                            </div>                  
                        </div>
                       
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">  
                                    <label for="">หมวดครุภัณฑ์</label>                       
                                  <select id="article_categoryid" name="article_categoryid"
                                  class="form-select form-select-lg" style="width: 100%">
                                  <option value=""></option>
                                  @foreach ($product_category as $procat)
                                  @if ($dataedits->article_categoryid == $procat->category_id)
                                  <option value="{{ $procat->category_id }}" selected>{{ $procat->category_name }}</option>
                                  @else
                                  <option value="{{ $procat->category_id }}">{{ $procat->category_name }}</option>
                                  @endif
                                      
                                  @endforeach
                              </select>                        
                                </div>
                            </div>                  
                          </div>
                        <div class="row mt-3">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label for="">ประจำหน่วยงาน</label>
                                <select id="article_deb_subsub_id" name="article_deb_subsub_id" class="form-select form-select-lg" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($department_sub_sub as $deb_subsub)
                                        @if ($dataedits->article_deb_subsub_id ==$deb_subsub->DEPARTMENT_SUB_SUB_ID )
                                        <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}" selected> {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                        @else
                                        <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}"> {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
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
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                </div>
                </div>
            </div>



            <script src="{{ asset('js/article.js') }}"></script>       
    @endsection
