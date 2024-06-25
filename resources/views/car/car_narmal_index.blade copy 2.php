{{-- @extends('layouts.car')
@section('title', 'ZOFFice || ยานพาหนะ')

@section('menu')
    <style>
        .btn {
            font-size: 15px;
        }
         
    </style>
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_article_car = StaticController::count_article_car();
     $count_car_service = StaticController::count_car_service();
 ?>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
           
            <a href="{{ url('car/car_narmal_index') }}" class="btn btn-info btn-sm text-white me-2 mt-2">รถยนต์ทั่วไป <span class="badge bg-danger ms-2">{{$count_car_service}}</span></a>
            <a href="{{ url('car/car_ambulance') }}" class="btn btn-light btn-sm text-dark me-2 mt-2">รถพยาบาล <span class="badge bg-danger ms-2">0</span></a>
            <a href="{{ url('car/car_data_index') }}" class="btn btn-light btn-sm text-dark mt-2">ข้อมูลยานพาหนะ <span class="badge bg-danger ms-2">{{$count_article_car}}</span></a>
            <a href="{{ url('car/car_report') }}"
                class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2 mt-2">รายงาน</a>

            <div class="text-end">
               
               
            </div>
        </div>
    </div>
@endsection

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function car_narmal_updatecancel(car_service_id)
        {
                // alert(bookrep_id);
                Swal.fire({
                title: 'ต้องการยกเลิกรายการนี้ใช่ไหม?',
                text: "ข้อมูลนี้จะถูกยกเลิก !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ',
                cancelButtonText: 'ไม่'
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            });
                            $.ajax({ 
                            type: "POST",
                            url:"{{url('car/car_narmal_updatecancel')}}" +'/'+ car_service_id, 
                            success:function(response)
                            {          
                                Swal.fire({
                                title: 'ยืนยันการยกเลิกสำเร็จ',
                                text: "Cancel Data Success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                if (result.isConfirmed) {   
                                    window.location.reload(); 
                                }
                                }) 
                            }
                            })        
                        }
                    })
        }
    
    
    
    </script>

     --}}
     @extends('layouts.car')
@section('title','ZOffice || ยานพาหนะ')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function car_narmal_updatecancel(car_service_id)
        {
                // alert(bookrep_id);
                Swal.fire({
                title: 'ต้องการยกเลิกรายการนี้ใช่ไหม?',
                text: "ข้อมูลนี้จะถูกยกเลิก !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ',
                cancelButtonText: 'ไม่'
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            });
                            $.ajax({ 
                            type: "POST",
                            url:"{{url('car/car_narmal_updatecancel')}}" +'/'+ car_service_id, 
                            success:function(response)
                            {          
                                Swal.fire({
                                title: 'ยืนยันการยกเลิกสำเร็จ',
                                text: "Cancel Data Success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                if (result.isConfirmed) {   
                                    window.location.reload(); 
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
    use App\Http\Controllers\UsercarController;
        use App\Http\Controllers\StaticController;
        use App\Models\Products_request_sub; 
        use Illuminate\Support\Facades\DB;   
        $count_article_car = StaticController::count_article_car();
        $count_car_service = StaticController::count_car_service();
        $refnumber = UsercarController::refnumber();    
        $checkhn = StaticController::checkhn($iduser);
        $checkhnshow = StaticController::checkhnshow($iduser);
        $count_suprephn = StaticController::count_suprephn($iduser);
        $count_bookrep_po = StaticController::count_bookrep_po();
    ?>
    <div class="container-fluid " style="width: 97%">
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example">
                                <thead>
                                    <tr height="10px">
                                        <th width="7%">ลำดับ</th>
                                        <th width="10%">สถานะ</th>
                                        <th width="10%">วันที่ไป</th>
                                        <th>เหตุผล</th> 
                                        <th width="25%">สถานที่ไป</th> 
                                        <th width="15%">ผู้ร้องขอ</th>
                                        <th width="10%">จัดการ</th>
                                    </tr>  
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                        @foreach ($car_service as $item)
                                            <tr id="sid{{ $item->car_service_id }}" height="30">
                                                <td class="text-center" width="3%">{{ $i++ }}</td>    
                                               
                                                @if ($item->car_service_status == 'request')
                                                <td class="text-center" width="7%"><div class="badge bg-warning">ร้องขอ</div></td>
                                                @elseif ($item->car_service_status == 'allocate')
                                                  <td class="text-center" width="7%"><div class="badge bg-secondary">จัดสรร</div></td>   
                                                @elseif ($item->car_service_status == 'allocateall')
                                                  <td class="text-center" width="7%"><div class="badge bg-secondary">จัดสรรร่วม</div></td>    
                                                @elseif ($item->car_service_status == 'cancel')
                                                  <td class="text-center" width="7%"><div class="badge bg-danger">แจ้งยกเลิก</div></td>  
                                                @elseif ($item->car_service_status == 'confirmcancel')
                                                  <td class="text-center" width="7%"><div class="badge " style="background: rgb(141, 140, 138)">ยกเลิก</div></td>                                     
                                                @else
                                                  <td class="text-center" width="75%"><div class="badge bg-success">อนุมัติ</div></td>
                                                @endif

                                                <td class="p-2">{{ dateThai($item->car_service_date)}} </td> 
                                                <td class="p-2">{{ $item->car_service_reason }}</td> 
                                                <td class="p-2" width="25%">{{ $item->car_location_name }}</td>
                                                <td class="p-2" width="15%">{{ $item->car_service_user_name }}</td>
                                                <td class="text-center" width="10%">                                                    
                                                    <div class="dropdown">
                                                      <button class="btn btn-outline-info dropdown-toggle menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                                      <ul class="dropdown-menu">
                                                            <li>
                                                              <a class="dropdown-item menu" data-bs-toggle="modal" data-bs-target="#cardetailModal{{$item->car_service_id}}" data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด">
                                                                <i class="fa-solid fa-file-pen mt-2 ms-2 mb-2 me-2 text-info"></i>
                                                                <label for="" style="color: rgb(33, 187, 248)">จัดการ</label> 
                                                              </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item menu" data-bs-toggle="modal" data-bs-target="#carModal" data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด">
                                                                  <i class="fa-solid fa-file-pen mt-2 ms-2 mb-2 me-2 text-info"></i>
                                                                  <label for="" style="color: rgb(33, 187, 248)">จัดการvvv</label> 
                                                                </a>
                                                              </li>
                                                            <li>
                                                                <a class="dropdown-item menu edit_car" value="{{$item->car_service_id }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                                    title="จัดสรร" > 
                                                                    <i class="fa-solid fa-file-pen mt-2 ms-2 me-2 text-info"></i>
                                                                    <label for="" style="color: rgb(33, 187, 248)">จัดสรร</label>  
                                                            </a>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="btn btn-warning btn-sm edit_car" value="{{ $item->car_service_id }}" 
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                                    title="แก้ไข" >
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </button>
                                                            </li>
                                                            <li>
                                                              <a class="dropdown-item menu" href="{{ url('user_car/car_narmal_print/'. $item->car_service_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด">
                                                                <i class="fa-solid fa-print mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                                                <label for="" style="color: rgb(24, 115, 252)">Print</label> 
                                                              </a>
                                                            </li>
                                                            <li>
                                                              <a class="dropdown-item menu" href="javascript:void(0)" onclick="car_narmal_updatecancel({{$item->car_service_id}})" data-bs-toggle="tooltip" data-bs-placement="left" title="แจ้งยกเลิก">
                                                    
                                                                <i class="fa-solid fa-xmark me-2 mt-2 ms-2 mb-2 text-danger"></i>
                                                                <label for="" style="color: rgb(255, 22, 22)">ยืนยันการยกเลิก</label> 
                                                              </a>
                                                            </li>                                                               
                                                      </ul>
                                                    </div>
                                                </td>
                                        </tr> 

                                        <div class="modal fade" id="cardetailModal{{$item->car_service_id}}" tabindex="-1" aria-labelledby="cardetailModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                  <div class="modal-content">                                                        
                                                      <div class="modal-header">
                                                          <h5 class="modal-title" id="cardetailModalLabel">จัดสรรการใช้รถยนต์ทั่วไป ทะเบียน {{$item->car_service_register}}</h5>                                                        
                                                      </div>
                                                      <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-9 "> 
                                                                    <div class="row">
                                                                        <div class="col-md-3 mt-2">
                                                                            <label for=""><b>ตามหนังสือเลขที่ :</b></label>
                                                                        </div>
                                                                        <div class="col-md-9 mt-2 text-left">                                                               
                                                                              <label for="">{{$item->car_service_book}}</label>                                                               
                                                                        </div>                                                                        
                                                                    </div>                                                              
                                                                    <div class="row">                                                                    
                                                                        <div class="col-md-3 mt-2">
                                                                            <label for=""><b>ปีงบประมาณ :</b></label>
                                                                        </div>
                                                                        <div class="col-md-9 mt-2 text-left">                                                                      
                                                                            <label for="">{{$item->car_service_year}}</label>                                                              
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">                                                                    
                                                                        <div class="col-md-3 mt-2">
                                                                            <label for=""><b>สถานที่ไป :</b></label>
                                                                        </div>
                                                                        <div class="col-md-9 mt-2 text-left">                                                                      
                                                                            <label for="">{{$item->car_location_name}}</label>                                                              
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">                                                                    
                                                                        <div class="col-md-3 mt-2">
                                                                            <label for=""><b>เหตุผล :</b></label>
                                                                        </div>
                                                                        <div class="col-md-9 mt-2 text-left">                                                                      
                                                                            <label for="">{{$item->car_service_reason}}</label>                                                              
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">                                                                    
                                                                        <div class="col-md-3 mt-2">
                                                                            <label for=""><b>วันที่ไป :</b></label>
                                                                        </div>
                                                                        <div class="col-md-9 mt-2 text-left">                                                                      
                                                                            <label for="">{{ dateThai($item->car_service_date)}}</label>                                                              
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">                                                                    
                                                                        <div class="col-md-3 mt-2">
                                                                            <label for=""><b>ตั้งแต่เวลา :</b></label>
                                                                        </div>
                                                                        <div class="col-md-2 mt-2 text-left">                                                                      
                                                                            <label for="">{{formatetime($item->car_service_length_gotime)}} น.</label>                                                              
                                                                        </div>
                                                                        <div class="col-md-2 mt-2">
                                                                            <label for=""><b>ถึงเวลา :</b></label>
                                                                        </div>
                                                                        <div class="col-md-2 mt-2 text-left">                                                                      
                                                                            <label for="">{{formatetime($item->car_service_length_backtime)}} น.</label>                                                              
                                                                        </div>                                                                       
                                                                    </div>
                                                                    <div class="row">  
                                                                        <div class="col-md-3 mt-2">
                                                                            <label for=""><b>ผู้ร้องขอ :</b></label>
                                                                        </div>
                                                                        <div class="col-md-9 mt-2">
                                                                            <label for="">{{$item->car_service_user_name}}</label> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 "> 
                                                                    @if ( $item->article_img == Null )
                                                                    <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="400px" width="450px" alt="Image" class="img-thumbnail">
                                                                    @else
                                                                    <img src="{{asset('storage/article/'.$item->article_img)}}" id="edit_upload_preview" height="400px" width="450px" alt="Image" class="img-thumbnail">                                 
                                                                    @endif

                                                                </div>
                                                            </div>                                                         
                                                    <hr>

                                                    <div class="row ">
                                                        <div class="col-md-2 mt-2">
                                                            <label for="">สถานะการจัดสรร :</label>
                                                        </div>
                                                        <div class="col-md-2 mt-2"> 
                                                            <div class="form-group">
                                                                <select name="car_service_status" id="car_service_status" class="form-control " style="width: 100%;">
                                                                @foreach ($car_status as $itemst)
                                                                    <option value="{{ $itemst->car_status_id}}">{{ $itemst->car_status_name}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-md-2 mt-2">
                                                            <label for="">เลขไมล์ก่อนเดินทาง :</label>
                                                        </div>
                                                        <div class="col-md-2 mt-2"> 
                                                            <div class="form-group">
                                                                <div class="form-outline bga">
                                                                    <input type="text" id="car_service_mikenumber_befor" name="car_service_mikenumber_befor" class="form-control form-control-sm " placeholder=""/>                                                 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <label for="" > เลขไมล์หลังเดินทาง :</label>
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                           
                                                            <div class="form-group">
                                                                <div class="form-outline bga">
                                                                    <input type="text" id="car_service_mikenumber_after" name="car_service_mikenumber_after" class="form-control form-control-sm " placeholder=""/>                                                 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row ">                                                                                                                 
                                                        <div class="col-md-2 mt-2">
                                                            <label for="car_drive_user_id">จัดสรรพนักงานขับ : </label>
                                                        </div>
                                                        <div class="col-md-4 mt-2"> 
                                                            <div class="form-group">
                                                                <select name="car_drive_user_id" id="car_drive_user_id" class="form-control show_drive" style="width: 100%;">
                                                                    @foreach ($car_drive as $itemdrive)
                                                                        <option value="{{ $itemdrive->car_drive_user_id}}">{{ $itemdrive->car_drive_user_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <label for="" style="color: rgb(255, 145, 0)">* กรณีไม่มี </label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <div class="form-group">                                                                                                              --}}
                                                                <select name="DRIVE_INSERT" id="DRIVE_INSERT" class="form-control" style="width: 100%;">
                                                                    <option value="">เพิ่มพนักงานขับ</option>
                                                                        @foreach ($users as $itemdrive)
                                                                            <option value="{{ $itemdrive->id}}">{{ $itemdrive->fname}} {{ $itemdrive->lname}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div> 
                                                        </div>
                                                        <div class="col-md-1 mt-2"> 
                        
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary btn-sm" onclick="adddrive();">
                                                                    เพิ่ม
                                                                </button> 
                                                            </div>
                                                        </div> 
                                                        
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-md-2 mt-2">
                                                            <label for="">เวลา :</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2"> 
                                                            <div class="form-group"> 
                                                                    <input type="text" id="car_service_length_gotime" name="car_service_length_gotime" class="form-control" placeholder=""/>                                                 
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <label for="" > ถึงเวลา :</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                           
                                                            <div class="form-group"> 
                                                                    <input type="text" id="car_service_length_backtime" name="car_service_length_backtime" class="form-control" placeholder=""/>                                                 
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 mt-2"> 
                                                        </div> 
                                                    </div>

                                                    <div class="row ">                             
                                                        <div class="col-md-12 ">
                                                        <h3 class="mt-2 text-center">Digital Signature</h3>
                                                            <div id="signature-pad" >
                                                                <div style="border:solid 1px teal; width:320px;height:120px;padding:3px;position:relative;">
                                                                    <div id="note" onmouseover="my_function();" class="text-center">The signature should be inside box</div>
                                                                    <canvas id="the_canvas" width="320px" height="100px" ></canvas>
                                                                </div> 
                                                                    <input type="hidden" id="signature" name="signature">
                                                                    <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                                                    <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                                                    {{-- <input type="hidden" id="car_service_no" name="car_service_no" value="{{$refnumber}}">  --}}
                            
                                                                    <button type="button" id="clear_btn" class="btn btn-danger btn-sm mt-3 text-center" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                                                                    <button type="button" id="save_btn" class="btn btn-info btn-sm mt-3 text-center" data-action="save-png" onclick="create()"><span class="glyphicon glyphicon-ok"></span> Create</button>  
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    </div>
                                                      <div class="modal-footer">
                                                        <button type="submit" id="saveBtn" class="btn btn-primary btn-sm" >
                                                            <i class="fa-solid fa-floppy-disk me-2"></i>
                                                            จัดสรร
                                                        </button>
                                                          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">
                                                            <i class="fa-solid fa-xmark me-2"></i>
                                                                ปิด
                                                          </button>
                                                      </div>

                                                  </div>
                                            </div>
                                        </div>

                                          
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="carModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">                                                        
            <div class="modal-header">
                <h5 class="modal-title" id="cardetailModalLabel">จัดสรรการใช้รถยนต์ทั่วไป ทะเบียน 
                    {{-- {{$item->car_service_register}} --}}
                </h5>                                                        
            </div>
            <div class="modal-body">
                  <div class="row">
                      <div class="col-md-9 "> 
                          <div class="row">
                              <div class="col-md-3 mt-2">
                                  <label for=""><b>ตามหนังสือเลขที่ :</b></label>
                              </div>
                              <div class="col-md-9 mt-2 text-left">                                                               
                                    {{-- <label for="">{{$item->car_service_book}}</label>                                                                --}}
                              </div>                                                                        
                          </div>                                                              
                          <div class="row">                                                                    
                              <div class="col-md-3 mt-2">
                                  <label for=""><b>ปีงบประมาณ :</b></label>
                              </div>
                              <div class="col-md-9 mt-2 text-left">                                                                      
                                  {{-- <label for="">{{$item->car_service_year}}</label>                                                               --}}
                              </div>
                          </div>

                          <div class="row">                                                                    
                              <div class="col-md-3 mt-2">
                                  <label for=""><b>สถานที่ไป :</b></label>
                              </div>
                              <div class="col-md-9 mt-2 text-left">                                                                      
                                  {{-- <label for="">{{$item->car_location_name}}</label>                                                               --}}
                              </div>
                          </div>

                          <div class="row">                                                                    
                              <div class="col-md-3 mt-2">
                                  <label for=""><b>เหตุผล :</b></label>
                              </div>
                              <div class="col-md-9 mt-2 text-left">                                                                      
                                  {{-- <label for="">{{$item->car_service_reason}}</label>                                                               --}}
                              </div>
                          </div>

                          <div class="row">                                                                    
                              <div class="col-md-3 mt-2">
                                  <label for=""><b>วันที่ไป :</b></label>
                              </div>
                              <div class="col-md-9 mt-2 text-left">                                                                      
                                  {{-- <label for="">{{ dateThai($item->car_service_date)}}</label>                                                               --}}
                              </div>
                          </div>

                          <div class="row">                                                                    
                              <div class="col-md-3 mt-2">
                                  <label for=""><b>ตั้งแต่เวลา :</b></label>
                              </div>
                              <div class="col-md-2 mt-2 text-left">                                                                      
                                  {{-- <label for="">{{formatetime($item->car_service_length_gotime)}} น.</label>                                                               --}}
                              </div>
                              <div class="col-md-2 mt-2">
                                  <label for=""><b>ถึงเวลา :</b></label>
                              </div>
                              <div class="col-md-2 mt-2 text-left">                                                                      
                                  {{-- <label for="">{{formatetime($item->car_service_length_backtime)}} น.</label>                                                               --}}
                              </div>                                                                       
                          </div>
                          <div class="row">  
                              <div class="col-md-3 mt-2">
                                  <label for=""><b>ผู้ร้องขอ :</b></label>
                              </div>
                              <div class="col-md-9 mt-2">
                                  {{-- <label for="">{{$item->car_service_user_name}}</label>  --}}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3 "> 
                          {{-- @if ( $item->article_img == Null )
                          <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="400px" width="450px" alt="Image" class="img-thumbnail">
                          @else
                          <img src="{{asset('storage/article/'.$item->article_img)}}" id="edit_upload_preview" height="400px" width="450px" alt="Image" class="img-thumbnail">                                 
                          @endif --}}

                      </div>
                  </div>                                                         
          <hr>

          <div class="row ">
              <div class="col-md-2 mt-2">
                  <label for="">สถานะการจัดสรร :</label>
              </div>
              <div class="col-md-2 mt-2"> 
                  <div class="form-group">
                      <select name="car_service_status" id="car_service_status" class="form-control " style="width: 100%;">
                            {{-- @foreach ($car_status as $itemst)
                                <option value="{{ $itemst->car_status_id}}">{{ $itemst->car_status_name}}</option>
                            @endforeach --}}
                      </select>
                  </div>
              </div>
             
              <div class="col-md-2 mt-2">
                  <label for="">เลขไมล์ก่อนเดินทาง :</label>
              </div>
              <div class="col-md-2 mt-2"> 
                  <div class="form-group">
                      <div class="form-outline bga">
                          <input type="text" id="car_service_mikenumber_befor" name="car_service_mikenumber_befor" class="form-control form-control-sm " placeholder=""/>                                                 
                      </div> 
                  </div>
              </div>
              <div class="col-md-2 mt-2">
                  <label for="" > เลขไมล์หลังเดินทาง :</label>
              </div>
              <div class="col-md-2 mt-2">
                 
                  <div class="form-group">
                      <div class="form-outline bga">
                          <input type="text" id="car_service_mikenumber_after" name="car_service_mikenumber_after" class="form-control form-control-sm " placeholder=""/>                                                 
                      </div> 
                  </div>
              </div>
          </div>

          <div class="row ">                                                                                                                 
              <div class="col-md-2 mt-2">
                  <label for="car_drive_user_id">จัดสรรพนักงานขับ : </label>
              </div>
              <div class="col-md-4 mt-2"> 
                  <div class="form-group">
                      <select name="car_drive_user_id" id="car_drive_user_id" class="form-control show_drive" style="width: 100%;">
                          {{-- @foreach ($car_drive as $itemdrive)
                              <option value="{{ $itemdrive->car_drive_user_id}}">{{ $itemdrive->car_drive_user_name}}</option>
                          @endforeach --}}
                      </select>
                  </div>
              </div>
              <div class="col-md-2 mt-2">
                  <label for="" style="color: rgb(255, 145, 0)">* กรณีไม่มี </label>
              </div>
              <div class="col-md-3 mt-2">
                  <div class="form-group">                                                                                                            
                      {{-- <select name="DRIVE_INSERT" id="DRIVE_INSERT" class="form-control" style="width: 100%;">
                          <option value="">เพิ่มพนักงานขับ</option>
                              @foreach ($users as $itemdrive)
                                  <option value="{{ $itemdrive->id}}">{{ $itemdrive->fname}} {{ $itemdrive->lname}}</option>
                              @endforeach
                      </select> --}}
                  </div> 
              </div>
              <div class="col-md-1 mt-2"> 

                  <div class="form-group">
                      <button type="button" class="btn btn-primary btn-sm" onclick="adddrive();">
                          เพิ่ม
                      </button> 
                  </div>
              </div> 
              
          </div>

          <div class="row ">
              <div class="col-md-2 mt-2">
                  <label for="">เวลา :</label>
              </div>
              <div class="col-md-4 mt-2"> 
                  <div class="form-group"> 
                          <input type="text" id="car_service_length_gotime" name="car_service_length_gotime" class="form-control" placeholder=""/>                                                 
                      
                  </div>
              </div>
              <div class="col-md-2 mt-2">
                  <label for="" > ถึงเวลา :</label>
              </div>
              <div class="col-md-3 mt-2">
                 
                  <div class="form-group"> 
                          <input type="text" id="car_service_length_backtime" name="car_service_length_backtime" class="form-control" placeholder=""/>                                                 
                     
                  </div>
              </div>
              <div class="col-md-1 mt-2"> 
              </div> 
          </div>

          <div class="row ">                             
              <div class="col-md-12 ">
              <h3 class="mt-2 text-center">Digital Signature</h3>
                  <div id="signature-pad" >
                      <div style="border:solid 1px teal; width:320px;height:120px;padding:3px;position:relative;">
                          <div id="note" onmouseover="my_function();" class="text-center">The signature should be inside box</div>
                          <canvas id="the_canvas" width="320px" height="100px" ></canvas>
                      </div> 
                          <input type="hidden" id="signature" name="signature">
                          <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                          <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> 

                          <button type="button" id="clear_btn" class="btn btn-danger btn-sm mt-3 text-center" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                          <button type="button" id="save_btn" class="btn btn-info btn-sm mt-3 text-center" data-action="save-png" onclick="create()"><span class="glyphicon glyphicon-ok"></span> Create</button>  
                  </div>
              </div>
              
          </div>

          </div>
            <div class="modal-footer">
              <button type="submit" id="saveBtn" class="btn btn-primary btn-sm" >
                  <i class="fa-solid fa-floppy-disk me-2"></i>
                  จัดสรร
              </button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">
                  <i class="fa-solid fa-xmark me-2"></i>
                      ปิด
                </button>
            </div>

        </div>
    </div>
  </div>

@endsection
@section('footer') 

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 


<script> 
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("canvas");
    var el_note = document.getElementById("note");
    var signaturePad;
    signaturePad = new SignaturePad(canvas);
    clearButton.addEventListener("click", function (event) {
    document.getElementById("note").innerHTML="The signature should be inside box";
    signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function (event){
            if (signaturePad.isEmpty()){
                alert("Please provide signature first.");
                event.preventDefault();
            }else{
                var canvas  = document.getElementById("the_canvas");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature").value = dataUrl;

                // ข้อความแจ้ง
                    Swal.fire({
                        title: 'สร้างสำเร็จ',
                        text: "You create success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',               
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {}
                    })  
            }
    });
    function my_function(){
        document.getElementById("note").innerHTML="";
    } 

</script>
<script>
    function adddrive() {
       var drivenew = document.getElementById("DRIVE_INSERT").value; 
       var _token = $('input[name="_token"]').val();
       alert(drivenew);
       $.ajax({
           url: "{{route('car.adddrive')}}",
           method: "POST",
           data: {
            drivenew: drivenew,
               _token: _token
           },
           success: function (result) {
               $('.show_drive').html(result);
           }
       })
     }
</script>
<script>
    $(document).on('click','.edit_car',function(){
                  var id = $(this).val();
                  alert(id);
                          $('#carModal').modal('show');
                          $.ajax({
                          type: "GET",
                          url:"{{url('car/car_narmal_allocate')}}" +'/'+ id,  
                          success: function(data) {
                            //   console.log(data.carservice.car_service_id);
                              // $('#line_token_name').val(data.carservice.line_token_name)  
                              // $('#line_token_code').val(data.carservice.line_token_code) 
                              // $('#line_token_id').val(data.carservice.car_service_id)                
                          },      
                  });
          });
  </script>
@endsection