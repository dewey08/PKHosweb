@extends('layouts.meetting')
@section('title', 'PK-OFFICER || ห้องประชุม')

{{-- @section('menu')
    <style>
        .btn {
            font-size: 15px;
        }
    </style>
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
     $count_meettinservice = StaticController::count_meettinservice();
 ?>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
           
            <a href="{{ url('meetting/meettingroom_dashboard') }}" class="btn btn-light btn-sm text-dark me-2">dashboard  </a>
            <a href="{{ url('meetting/meettingroom_index') }}" class="btn btn-light btn-sm text-dark me-2">รายการห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('meetting/meettingroom_check') }}" class="btn btn-light btn-sm text-dark me-2">ตรวจสอบการจองห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettinservice}}</span></a>
            <a href="" class="btn btn-success btn-sm text-white me-2">จัดสรรห้องประชุม</a>
            <a href="{{ url('meetting/meettingroom_report') }}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รายงาน</a>

            <div class="text-end"> 
               
            </div>
        </div>
    </div>
@endsection --}}

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
    <div class="container-fluid " style="width: 97%">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body shadow-lg"> 
                            <form class="custom-validation" action="{{ route('meetting.meettingroom_check_allow_update') }}" id="insert_updatestatusForm" method="POST" enctype="multipart/form-data">
                                @csrf
        
        
                            <div class="row">
                                <div class="col-md-6">
                                    <div id='calendar'></div>
                                </div> 
                                  <div class="col-md-6">                           
                                    
                                    {{-- <input type="hidden" id="room_id" name="room_id" value="{{$dataedits->room_id}}" >  --}}
                                    <input type="hidden" id="status" name="status" value="REQUEST">
                                    <input type="hidden" id="userid" name="userid" value="{{Auth::user()->id}}">
                                    <input type="hidden" id="meeting_id" name="meeting_id" value="{{$dataedits->meeting_id}}" > 
        
                                    <div class="row"> 
                                        <div class="col-md-3 text-end">
                                            <label for="meetting_title">เรื่องการประชุม </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input id="meetting_title" type="text" class="form-control @error('meetting_title') is-invalid @enderror az" name="meetting_title" value="{{ $dataedits->meetting_title }}" autocomplete="meetting_title">
                                                @error('meetting_title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>                                
                                    </div>  
        
                                    <div class="row mt-3">  
                                        <div class="col-md-3 text-end">
                                            <label for="meetting_target">กลุ่มบุคคลเป้าหมาย </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input id="meetting_target" type="text" class="form-control @error('meetting_target') is-invalid @enderror az" name="meetting_target" value="{{  $dataedits->meetting_target}}" autocomplete="meetting_target" >
                                                 
                                            </div>
                                        </div>                                  
                                    </div>  
        
                                    <div class="row mt-3">  
                                        <div class="col-md-3 text-end">
                                            <label for="meeting_objective_id">วัตถุประสงค์</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input id="meeting_objective_name" type="text" class="form-control" name="meeting_objective_name" value="{{  $dataedits->meeting_objective_name}}">
                                             
                                            </div>
                                        </div>                                
                                      </div> 
        
                                      <div class="row mt-3">  
                                        <div class="col-md-3 text-end">
                                            <label for="meetting_year">ปีงบประมาณ </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="meetting_year" type="text" class="form-control" name="meetting_year" value="{{  $dataedits->meetting_year}}">
                                             
                                            </div>
                                        </div>     
                                        <div class="col-md-2 text-end">
                                            <label for="meetting_person_qty">จำนวน :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="meetting_person_qty" type="text" class="form-control @error('meetting_person_qty') is-invalid @enderror az" name="meetting_person_qty" value="{{ $dataedits->meetting_person_qty}}" autocomplete="meetting_person_qty" >
                                                @error('meetting_person_qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>  
                                        <div class="col-md-1">
                                          <label for="lname">คน</label>
                                      </div>      
                                      </div>
        
                                      <div class="row mt-3">  
                                        <div class="col-md-3 text-end">
                                            <label for="meeting_date_begin">ตั้งแต่วันที่ </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input id="meeting_date_begin" type="date" class="form-control @error('meeting_date_begin') is-invalid @enderror az" name="meeting_date_begin" value="{{ $dataedits->meeting_date_begin }}" autocomplete="meeting_date_begin">
                                                @error('meeting_date_begin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>                                
                                      </div> 
        
                                      <div class="row mt-3">
                                        <div class="col-md-3 text-end">
                                            <label for="meeting_date_end">ถึงวันที่ </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input id="meeting_date_end" type="date" class="form-control @error('meeting_date_end') is-invalid @enderror az" name="meeting_date_end" value="{{ $dataedits->meeting_date_end }}" autocomplete="meeting_date_end">
                                                @error('meeting_date_end')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                      </div> 
        
                                      <div class="row mt-3">  
                                        <div class="col-md-3 text-end">
                                            <label for="meeting_time_begin">ตั้งแต่เวลา </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="meeting_time_begin" type="time" class="form-control @error('meeting_time_begin') is-invalid @enderror az" name="meeting_time_begin" value="{{ $dataedits->meeting_time_begin }}" autocomplete="meeting_time_begin" >
                                                @error('meeting_time_begin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-2 text-end">
                                            <label for="meeting_time_end">ถึงเวลา </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="meeting_time_end" type="time" class="form-control @error('meeting_time_end') is-invalid @enderror az" name="meeting_time_end" value="{{ $dataedits->meeting_time_end }}" autocomplete="meeting_time_end" >
                                                @error('meeting_time_end')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                      </div>
                                        
                                      <div class="row mt-3">  
                                        <div class="col-md-3 text-end">
                                            <label for="meeting_tel">เบอร์โทร </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input id="meeting_tel" type="text" class="form-control az" name="meeting_tel" value="{{ $dataedits->meeting_tel }}">
                                                @error('meeting_tel')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-2 text-end">
                                            
                                        </div>
                                       
                                      </div>
        
                                </div> 
                                 
                            </div>     
                            <div class="row mt-3 mb-5">
                                <div class="col-md-6">
                                    <div class="card-header shadow">
                                        <label for="">อุปกรณ์ที่ต้องการ </label>
                                    </div> 
                                    <div class="card-body shadow">
                                        <div class="table-responsive">
                                            <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                                <thead>
                                                    <tr style="background-color: rgb(173, 247, 250)">
                                                        <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                        <td style="text-align: center;">รายการอุปกรณ์</td>                                                                      
                                                        <td style="text-align: center;" width="12%">จำนวน</td>                                                   
                                                        
                                                    </tr>
                                                </thead> 
                                                <tbody class="tbody1"> 
                                                    @foreach ($meeting_service_list as $key=>$serlist)   
                                                        <tr height="30" >  
                                                            <td style="text-align: center;"> {{$key+1}} </td>                                           
                                                            <td>
                                                                <!-- <select name="MEETTINGLIST_ID[]" id="MEETTING_LIST_ID0" class="form-control form-control-sm " style="width: 100%;" readonly>
                                                                    <option value="" selected ><label class="az">--รายการอุปกรณ์--</label></option> 
                                                                    @foreach ($meeting_list as $list)
                                                                    @if ($serlist->meeting_list_id ==$list ->meeting_list_id)
                                                                    <option value="{{$list ->meeting_list_id }}" selected ><label class="az">{{ $list->meeting_list_name}}</label></option>
                                                                    @else
                                                                    <option value="{{$list ->meeting_list_id }}"><label class="az">{{ $list->meeting_list_name}}</label></option>
                                                                    @endif
                                                                        
                                                                    @endforeach                   
                                                                </select> -->
                                                                <input name="MEETTINGLIST_ID[]" id="MEETTINGLIST_ID0" class="form-control form-control-sm" value="{{ $serlist->meeting_list_name }}" readonly>
                                                            </td>                                                                               
                                                            <td>
                                                                <input name="MEETTINGLIST_QTY[]" id="MEETTINGLIST_QTY0" class="form-control form-control-sm" value="{{ $serlist->meeting_service_list_qty }}" readonly>
                                                            </td>                                               
                                                            
                                                        </tr>    
                                                        @endforeach 
                                                </tbody>   
                                            </table>
                                        </div>
                                    </div>  
                                </div>
        
                                <div class="col-md-6">
                                    <div class="card-header shadow">
                                        <label for="">รายการอาหาร </label>
                                    </div> 
                                    <div class="card-body shadow">
                                        <div class="table-responsive">
                                            <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                                <thead>
                                                    <tr style="background-color: rgb(173, 247, 250)">
                                                        <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                        <td style="text-align: center;">รายการอาหาร</td>                                                                      
                                                        <td style="text-align: center;" width="10%">จำนวน</td>                                                    
                                                       
                                                    </tr>
                                                </thead> 
                                                <tbody class="tbody2"> 
                                                    @foreach ($meeting_service_food as $key=>$foodlist)   
                                                        <tr height="30" >  
                                                            <td style="text-align: center;"> {{$key+1}} </td>                                                
                                                            <td> 
                                                                <!-- <select name="FOOD_LIST" id="FOOD_LIST" class="form-control form-control-sm " style="width: 100%;">
                                                                    <option value="" selected class="myFontselect">--รายการอาหาร--</option> 
                                                                    @foreach ($food_list as $food)
                                                                    @if ($foodlist->food_list_id ==  $food->food_list_id)
                                                                    <option value="{{ $food->food_list_id }}" selected class="myFontselect">{{$food->food_list_name}}</option>
                                                                    @else
                                                                    <option value="{{ $food->food_list_id }}">{{$food->food_list_name}}</option>
                                                                    @endif
                                                                        
                                                                    @endforeach  
                                                                </select> -->
                                                                <input name="FOOD_LIST[]" id="FOOD_LIST" class="form-control form-control-sm" value="{{ $foodlist->food_list_name }}" readonly>
                                                            </td>                                                                               
                                                            <td>
                                                            <input name="FOOD_LIST_QTY[]" id="FOOD_LIST_QTY0" class="form-control form-control-sm"  value="{{ $foodlist->meeting_service_food_qty }}" readonly>
                                                            </td> 
                                                            
                                                        </tr>  
                                                    @endforeach                                                               
                                                </tbody>   
                                            </table>
                                        </div> 
                                    </div>  
                                </div>
                            </div>
                                
                            <div class="card-footer">
                                <div class="col-md-12 text-end"> 
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm"> 
                                            {{-- บันทึกข้อมูล --}}
                                            จัดสรรห้องประชุม
                                        </button> 
                                        <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-danger btn-sm">
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
    </div>
    </div>
   


@endsection
