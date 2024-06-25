@extends('layouts.user')
@section('title', 'PK-OFFICER || แจ้งซ่อมคอมพิวเตอร์')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function car_ambulance_cancel(car_service_id)
        {
        // alert(bookrep_id);
        Swal.fire({
        title: 'ต้องการยกเลิกรายการนี้ใช่ไหม?',
        text: "ข้อมูลนี้จะถูกส่งไปยังผู้ดูแลงานยานพาหนะ",
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
                    url:"{{url('user_car/car_ambulance_cancel')}}" +'/'+ car_service_id, 
                    success:function(response)
                    {          
                        Swal.fire({
                        title: 'รอการยืนยันจากผู้ดูแลงาน',
                        text: "Wait for confirmation from the supervisor",
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
      
          $refnumber = UsercarController::refnumber();    
          $checkhn = StaticController::checkhn($iduser);
          $checkhnshow = StaticController::checkhnshow($iduser);
          $count_suprephn = StaticController::count_suprephn($iduser);
          $count_bookrep_po = StaticController::count_bookrep_po();
    ?>
 
<div class="container-fluid ">

<div class="row justify-content-center">
        <div class="row invoice-card-row">  
        <div class="col-md-12 mt-2">
               
              <div class="card bg-info p-1 mx-0 shadow-lg">
                <div class="panel-header px-3 py-2 text-white">
                  ข้อมูลการขอใช้รถพยาบาล
                </div>
                <div class="panel-body bg-white">
                    <div class="row"> 
                      <div class="col-md-12">
                          <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm myTable " style="width: 100%;" id="example_user"> 
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
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #592DF7">จัดสรร</div></td>   
                                                    @elseif ($item->car_service_status == 'allocateall')
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #07D79E">จัดสรรร่วม</div></td>  
                                                      @elseif ($item->car_service_status == 'noallow')
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #E80DEF">ไม่อนุมัติ</div></td>    
                                                    @elseif ($item->car_service_status == 'cancel')
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #ff0606">แจ้งยกเลิก</div></td>  
                                                    @elseif ($item->car_service_status == 'confirmcancel')
                                                    <td class="text-center" width="7%"><div class="badge " style="background: #ab9e9e">ยกเลิก</div></td>                                                                                       
                                                    @else
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #3CDF44">อนุมัติ</div></td>
                                                    @endif

                                                    <td class="p-2" width="10%">{{ dateThai($item->car_service_date)}} </td> 
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
                                                                    <label for="" style="color: rgb(33, 187, 248)">รายละเอียด</label> 
                                                                  </a>
                                                                </li>
                                                                <li>
                                                                  <a class="dropdown-item menu" href="{{ url('user_car/car_narmal_print/'. $item->car_service_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Print" target="_blank">
                                                                    <i class="fa-solid fa-print mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                                                    <label for="" style="color: rgb(24, 115, 252)">Print</label> 
                                                                  </a>
                                                                </li>
                                                                <li>
                                                                  <a class="dropdown-item menu" href="javascript:void(0)" onclick="car_ambulance_cancel({{$item->car_service_id}})" data-bs-toggle="tooltip" data-bs-placement="left" title="แจ้งยกเลิก">
                                                        
                                                                    <i class="fa-solid fa-xmark me-2 mt-2 ms-2 mb-2 text-danger"></i>
                                                                    <label for="" style="color: rgb(255, 22, 22)">แจ้งยกเลิก</label> 
                                                                  </a>
                                                                </li>                                                               
                                                          </ul>
                                                        </div> 
                                                    </td>
                                              </tr> 

                                              <div class="modal fade" id="cardetailModal{{$item->car_service_id}}" tabindex="-1" aria-labelledby="cardetailModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                      <div class="modal-content">                                                        
                                                          <div class="modal-header">
                                                              <h5 class="modal-title" id="cardetailModalLabel">รายละเอียดจองรถยนต์ทะเบียน {{$item->car_service_register}}</h5>
                                                            
                                                          </div>
                                                          <div class="modal-body">
                                                            
                                                              <div class="row">
                                                                  <div class="col-md-2 ">
                                                                      <label for=""><b>ตามหนังสือเลขที่ :</b></label>
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                   
                                                                        <label for="car_service_reason">{{$item->car_service_book}}</label>
                                                                   
                                                                  </div>
                                                                  <div class="col-md-2 ">
                                                                      <label for=""><b>ปีงบประมาณ :</b></label>
                                                                  </div>
                                                                  <div class="col-md-3">
                                                                    
                                                                        <label for="car_service_reason">{{$item->car_service_year}}</label>
                                                                  
                                                                  </div>
                                                              </div>

                                                              <div class="row mt-3">
                                                                  <div class="col-md-2">
                                                                      <label for=""><b>สถานที่ไป :</b></label>
                                                                  </div>
                                                                  <div class="col-md-4"> 
                                                                      <div class="form-group">
                                                                        <label for="car_service_reason">{{$item->car_location_name}}</label>
                                                                    </div>
                                                                  </div>
                                                                  <div class="col-md-2 ">
                                                                    <label for="" ><b>เหตุผล :</b></label>
                                                                  </div>
                                                                  <div class="col-md-3">
                                                                    <div class="form-group">
                                                                      <label for="car_service_reason">{{$item->car_service_reason}}</label>
                                                                    </div> 
                                                                  </div>
                                                                 
                                                              </div>

                                                            

                                                              <div class="row mt-3">
                                                                  <div class="col-md-2">
                                                                      <label for=""><b>วันที่ไป :</b></label>
                                                                  </div> 
                                                                  <div class="col-md-4">
                                                                      <div class="form-group">
                                                                        <label for="car_service_year">{{ dateThai($item->car_service_date)}}</label>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col-md-2">
                                                                    <label for=""><b>ตั้งแต่เวลา :</b></label>
                                                                </div> 
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                      <label for="car_service_year">{{formatetime($item->car_service_length_gotime)}}</label>
                                                                    </div>
                                                                </div>
                                                                  <div class="col-md-1">
                                                                      <label for=""><b>ถึงเวลา :</b></label>
                                                                  </div>
                                                                  
                                                                  <div class="col-md-2">
                                                                      <div class="form-group">
                                                                        <label for="car_service_year">{{formatetime($item->car_service_length_backtime)}}</label>
                                                                      </div>
                                                                  </div>
                                                              </div>

                                                          </div>
                                                          
                                                          <div class="modal-footer">
                                                            
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
@endsection
@section('footer') 
 


@endsection
