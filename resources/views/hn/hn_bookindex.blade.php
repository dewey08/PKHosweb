@extends('layouts.userhn')
@section('title','ZOffice || หัวหน้า')
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
  use App\Http\Controllers\UsersuppliesController;
        use App\Http\Controllers\StaticController;
        use App\Models\Products_request_sub;
    
        $refnumber = UsersuppliesController::refnumber();    
        $checkhn = StaticController::checkhn($iduser);
        $checkhnshow = StaticController::checkhnshow($iduser);
        $count_suprephn = StaticController::count_suprephn($iduser);
        $count_bookrep_rong = StaticController::count_bookrep_rong();
  ?>
<div class="container-fluid ">
  <div class="row">
    <div class="col-md-12">  
        <div class="card bg-warning p-1 mx-0 shadow-lg">
          <div class="panel-header px-3 py-2 text-white"> 
            <div class="d-flex">
              <div class="p-2">{{ __('หนังสือราชการ') }} </div> 
              <div class="ms-auto p-2">
                {{-- <a href="" class="btn btn-white btn-sm" data-bs-toggle="modal" data-bs-target="#poModal">
                  <i class="fa-solid fa-circle-check text-warning me-2"></i>
                  อนุมัติทั้งหมด</a>  --}}
                
              </div>
            </div>          
          </div>
            <div class="panel-body bg-white">    
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">
                  <thead>
                    <tr >
                       <th width="5%" class="text-center">ลำดับ</th>
                           <th class="text-center" width="10%">ชั้นความเร็ว</th>
                           <th class="text-center" width="7%">สถานะ</th>
                           <th class="text-center">เรื่อง</th> 
                           <th class="text-center" width="9%">วันที่</th>
                           <th class="text-center" width="9%">เวลา</th>                         
                           <th class="text-center" width="12%">ผู้ส่ง</th>
                           <th width="5%" class="text-center">Manage</th> 
                    </tr>  
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>      
                      @foreach ( $bookrep as $item ) 
                          <tr>
                                <td class="text-center" width="3%">{{$i++}}</td>  

                                  @if ($item->bookrep_speed_class_id == '4')
                                    <td class="font-weight-medium text-center" width="10%"><div class="badge bg-danger shadow">{{$item->bookrep_speed_class_name}}</div></td>
                                  @elseif ($item->bookrep_speed_class_id == '2')
                                    <td class="font-weight-medium text-center" width="10%"><div class="badge bg-success shadow">{{$item->bookrep_speed_class_name}}</div></td>
                                    @elseif ($item->bookrep_speed_class_id == '1')
                                    <td class="font-weight-medium text-center" width="10%"><div class="badge bg-info shadow">{{$item->bookrep_speed_class_name}}</div></td>
                                  @else
                                    <td class="font-weight-medium text-center" width="10%"><div class="badge bg-warning shadow">{{$item->bookrep_speed_class_name}}</div></td>
                                  @endif

                                                              
                                  @if ($item->bookrep_send_code == 'waitsend')
                                  <td class="font-weight-medium text-center" width="7%"><div class="badge bg-secondary shadow"> รอดำเนินการ</div></td>
                                @elseif ($item->bookrep_send_code == 'senddep')
                                  <td class="font-weight-medium text-center" width="7%"><div class="badge bg-warning shadow">ส่งหน่วยงาน</div></td>
                                @elseif ($item->bookrep_send_code == 'waitretire')
                                  <td class="font-weight-medium text-center" width="7%"><div class="badge bg-info shadow">รอเกษียณ</div></td>
                                @elseif ($item->bookrep_send_code == 'retire')
                                  <td class="font-weight-medium text-center" width="7%"><div class="badge bg-success shadow">เกษียณ</div></td>
                                @elseif ($item->bookrep_send_code == 'waitallows')
                                  <td class="font-weight-medium text-center" width="7%"><div class="badge bg-info shadow">รออนุมัติ</div></td>
                                @elseif ($item->bookrep_send_code == 'allows')
                                  <td class="font-weight-medium text-center" width="7%"><div class="badge bg-success shadow">ผอ.อนุมัติ</div></td>
                                @else
                                  <td class="font-weight-medium text-center" width="7%"><div class="badge bg-dark shadow">ลงรับ</div></td>
                                @endif
                                
                                <td class="p-2">{{$item->bookrep_name}}</td>  
                                <td class="p-2" width="9%">{{ dateThai($item->bookrep_save_date)}} </td>   
                                <td class="p-2" width="9%"> {{$item->bookrep_save_time}} น.</td> 
                                <td class="p-2" width="12%">{{$item->bookrep_usersend_name}}</td>  

                                <td class="text-center" width="5%"> 
                                    
                                      <div class="dropdown">
                                        <button class="btn btn-outline-info dropdown-toggle menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                        <ul class="dropdown-menu">
                                          <a class="dropdown-item menu" href="{{url('hn/hn_bookdetail/'.$item->bookrep_id)}}" data-bs-toggle="tooltip" data-bs-placement="left" title="อ่านหนังสือ" target="_blank">
                                            <i class="fa-solid fa-circle-info mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                            <label for="" style="color: black">อ่านหนังสือ</label>  
                                          </a>
                                        </ul>
                                      </div>
                                </td> 
                          </tr>                                                    
                                                        
                      @endforeach
                                      
                  </tbody>
                </table>      
              </div>   
            </div>
        </div>
    </div>
</div>
@endsection
