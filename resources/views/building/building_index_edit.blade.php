@extends('layouts.article')
@section('title', 'PK-OFFICER || ข้อมูลอาคาร')
 
    <style>
        .btn {
            font-size: 15px;
        }
        .bgc{
    background-color: #264886;
   }
   .bga{
    background-color: #fbff7d;
   }
    </style>
    <?php
        use App\Http\Controllers\StaticController;
        use Illuminate\Support\Facades\DB;   
        $count_land = StaticController::count_land();
        $count_building = StaticController::count_building();
        $count_article = StaticController::count_article();
    ?>
 

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
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        แก้ไขข้อมูลอาคาร
                    </div>
                    <div class="card-body shadow-lg">
                        <form class="custom-validation" action="{{ route('bu.building_index_update') }}" method="POST"
                            id="update_buildingForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="building_id" id="building_id" value="{{$dataedits->building_id}}">

                        <div class="row">                          

                            <div class="col-md-4">
                                <div class="form-group"> 
                                    @if ( $dataedits->building_img == Null )
                                    <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="450px" width="350px" alt="Image" class="img-thumbnail">
                                    @else
                                    <img src="{{asset('storage/building/'.$dataedits->building_img)}}" id="edit_upload_preview" height="450px" width="350px" alt="Image" class="img-thumbnail">                                 
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
                            <div class="col-md-8"> 
           
                                <div class="row">
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_tonnage_number">ปลูกบนที่ดิน :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
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
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_budget_id">งบประมาณ :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
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
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_method_id">วิธีได้มา :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
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
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_buy_id">วิธีการซื้อ :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
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
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_name">ชื่อสิ่งปลูกสร้าง :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="building_name" type="text" class="form-control form-control-sm" name="building_name" value="{{$dataedits->building_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_budget_price">ใช้งบประมาณ :</label>
                                    </div>
                                    <div class="col-md-3"> 
                                        <div class="form-group">
                                            <input id="building_budget_price" type="text" class="form-control form-control-sm" name="building_budget_price" value="{{$dataedits->building_budget_price}}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                           <label for="">บาท</label>
                                        </div>
                                    </div> 
                                </div>

                               
                                <div class="row mt-3">
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_creation_date">วันที่สร้าง :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="building_creation_date" type="date" class="form-control form-control-sm" name="building_creation_date" value="{{$dataedits->building_creation_date}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_completion_date">วันที่แล้วเสร็จ :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="building_completion_date" type="date" class="form-control form-control-sm" name="building_completion_date" value="{{$dataedits->building_completion_date}}">
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_delivery_date">วันที่ส่งมอบ :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="building_delivery_date" type="date" class="form-control form-control-sm" name="building_delivery_date" value="{{$dataedits->building_delivery_date}}">
                                        </div>
                                    </div>
                                     <!--
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_long">อายุการใช้งาน :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="building_long" type="text" class="form-control" name="building_long" value="{{$dataedits->building_long}}">
                                        </div>
                                    </div>   
                                -->
                                </div>

                                <div class="row mt-3">                                      
                                    
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_userid">ผู้รับผิดชอบ :</label>
                                    </div>
                                    <div class="col-md-4 "> 
                                        <div class="form-group"> 
                                            <select id="building_userid" name="building_userid" style="width: 100%">                      
                                                <option value=""></option>
                                                @foreach ($users as $item )
                                                @if ($dataedits->building_userid == $item->id)
                                                <option value="{{ $item->id}}" selected>{{ $item->fname}} {{ $item->lname}}</option>
                                                @else
                                                <option value="{{ $item->id}}">{{ $item->fname}} {{ $item->lname}}</option>
                                                @endif
                                                   
                                                @endforeach                             
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_engineer">วิศวกร :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="building_engineer" type="text" class="form-control form-control-sm" name="building_engineer" value="{{$dataedits->building_engineer}}">
                                        </div>
                                    </div> 
                                </div> 

                               
                                {{-- <div class="row mt-3">
                                    <div class="col-md-2 text-end"> 
                                        <label for="land_holder_name">ผู้ถือครอง :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="land_holder_name" type="text" class="form-control" name="land_holder_name" value="{{$dataedits->land_holder_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end"> 
                                        <label for="land_house_number">ที่ตั้งบ้านเลขที่ :</label>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <input id="land_house_number" type="text" class="form-control" name="land_house_number" value="{{$dataedits->land_house_number}}">
                                        </div>
                                    </div>                                    
                                </div>  --}}
                                                              
                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end"> 
                                            <label for="land_house_number">อัตราเสื่อม :</label>
                                        </div>
                                    <div class="col-md-4">
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
                                    
                                    <div class="col-md-2 text-end"> 
                                        <label for="building_type_id">ประเภทอาคาร :</label>
                                    </div>
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="building_type_id" name="building_type_id" class="form-select form-select-lg" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($building_type as $btype)
                                            @if ($dataedits->building_type_id ==$btype->building_type_id )
                                            <option value="{{ $btype->building_type_id }}" selected> {{ $btype->building_type_name }} </option>
                                            @else
                                            <option value="{{ $btype->building_type_id }}"> {{ $btype->building_type_name }} </option>
                                            @endif
                                               
                                            @endforeach
                                        </select>     
                                    </div>
                                    </div>  
                                    

                                </div>


                            </div>                                               
                        </div> 
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end"> 
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button> 
                                <a href="{{url('building/building_index')}}" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>
                            </div>
                   
                        </div>   
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
   

    @endsection
    @section('footer')
        <script>
            function editbuilding(input) {
                var fileInput = document.getElementById('building_img');
                var url = input.value;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#edit_upload_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                    fileInput.value = '';
                    return false;
                }
            }
    
            
           
        </script>
    @endsection
