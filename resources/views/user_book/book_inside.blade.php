@extends('layouts.user')
@section('title','PK-OFFICER || หนังสือเข้า')
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
        $count_bookrep_po = StaticController::count_bookrep_po();
  ?>
 
<style>
      body{
          font-size:14px;
      }
      .btn{
        font-size:13px;
      }
     
</style>
<style>
  #button{
         display:block;
         margin:20px auto;
         padding:30px 30px;
         background-color:#eee;
         border:solid #ccc 1px;
         cursor: pointer;
         }
         #overlay{	
         position: fixed;
         top: 0;
         z-index: 100;
         width: 100%;
         height:100%;
         display: none;
         background: rgba(0,0,0,0.6);
         }
         .cv-spinner {
         height: 100%;
         display: flex;
         justify-content: center;
         align-items: center;  
         }
         .spinner {
         width: 250px;
         height: 250px;
         border: 10px #ddd solid;
         border-top: 10px #353636 solid;
         border-radius: 50%;
         animation: sp-anime 0.8s infinite linear;
         }
         @keyframes sp-anime {
         100% { 
             transform: rotate(390deg); 
         }
         }
         .is-hide{
         display:none;
         }
</style>

<div class="container-fluid " style="width: 100%">

  <div id="preloader">
    <div id="status">
        <div class="spinner">
            
        </div>
    </div>
</div>

  <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('หนังสือเข้า') }}</div>

                <div class="card-body">
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
                                    <td class="p-2" width="9%" style="font-size: 14px;">{{ dateThai($item->bookrep_save_date)}} </td>   
                                    <td class="p-2" width="9%" style="font-size: 14px;"> {{$item->bookrep_save_time}} น.</td> 
                                    <td class="p-2" width="12%">{{$item->bookrep_usersend_name}}</td>  
    
                                    <td class="text-center" width="10%"> 
                                         
                                          <div class="dropdown">
                                            <button class="btn btn-outline-info dropdown-toggle menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                            <ul class="dropdown-menu">
                                                  <li> 
                                                    <a class="dropdown-item menu btn-sm" href="{{url('user_book/user_bookdetail/'.$item->bookrep_id)}}" data-bs-toggle="tooltip" data-bs-placement="left" title="อ่านหนังสือ" target="_blank">
                                                      <i class="fa-solid fa-circle-info mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                                      <label for="" style="color: black">อ่านหนังสือ</label>  
                                                    </a>
                                                  </li>
                                                
                                                  {{-- <li>
                                                    <a class="dropdown-item menu" href="javascript:void(0)" onclick="car_ambulance_cancel({{$item->car_service_id}})" data-bs-toggle="tooltip" data-bs-placement="left" title="แจ้งยกเลิก">
                                          
                                                      <i class="fa-solid fa-xmark me-2 mt-2 ms-2 mb-2 text-danger"></i>
                                                      <label for="" style="color: rgb(255, 22, 22)">แจ้งยกเลิก</label> 
                                                    </a>
                                                  </li>   --}}
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
</div>
@endsection
