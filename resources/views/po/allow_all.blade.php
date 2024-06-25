@extends('layouts.userpo')
@section('title','ZOffice || ยานพาหนะ')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function car_narmal_cancel(car_service_id)
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
                    url:"{{url('user_car/car_narmal_cancel')}}" +'/'+ car_service_id, 
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
 
<div class="row">
        <div class="col-md-12 mt-2">               
              <div class="card bg-success p-1 mx-0 shadow-lg">
                {{-- <div class="panel-header px-3 py-2 text-white">
                  <label for="" class="me-5 mb-2">ข้อมูลการขอใช้รถยนต์ทั้งหมด</label>
                  
                  <a href="" data-bs-toggle="modal" class="btn btn-white btn-sm ms-5" data-bs-target="#carservicessModal">  
                    <i class="fa-solid fa-circle-check text-white text-success"></i>
                    อนุมัติทั้งหมด
                </a> 
                </div> --}}
                <div class="panel-header px-3 py-2 text-white"> 
                    <div class="d-flex">
                      <div class="p-2">{{ __('ข้อมูลการขอใช้รถยนต์ทั้งหมด') }} </div> 
                      <div class="ms-auto p-2">
                        <a href="" class="btn btn-white btn-sm" data-bs-toggle="modal" data-bs-target="#carservicessModal">
                          <i class="fa-solid fa-circle-check text-success me-2"></i>
                          อนุมัติทั้งหมด</a> 
                        
                      </div>
                    </div>          
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



                                                    {{-- <p class="m-0 fa fa-circle me-2" style="color:#3CDF44;"></p> อนุมัติ<label
                                                    class="me-3"></label>
                                                <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> จัดสรร<label
                                                    class="me-3"></label>
                                                    <p class="m-0 fa fa-circle me-2" style="color:#07D79E;"></p> จัดสรรร่วม<label
                                                    class="me-3"></label>
                                                <p class="m-0 fa fa-circle me-2" style="color:#E80DEF;"></p> ไม่อนุมัติ<label
                                                    class="me-3"></label>
                                                <p class="m-0 fa fa-circle me-2" style="color:#FA2A0F;"></p> แจ้งยกเลิก<label
                                                    class="me-3"></label>
                                                <p class="m-0 fa fa-circle me-2" style="color:#ab9e9e;"></p> ยกเลิก<label
                                                    class="me-3"></label>
                                                <p class="m-0 fa fa-circle me-2" style="color:#fa861a;"></p>ร้องขอ <label
                                                    class="me-5"></label> --}}


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
                                                                    <label for="" style="color: rgb(33, 187, 248)">รายละเอียด</label> 
                                                                  </a>
                                                                </li>

                                                                <li>
                                                                  <a class="dropdown-item menu" href="{{ url('po/allow_all_add/'. $item->car_service_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="จัดการ" >
                                                                    <i class="fa-solid fa-file-pen mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                                                    <label for="" style="color: rgb(8, 111, 228)">จัดการ</label> 
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


<div class="modal fade" id="carservicessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                  อนุมัติการใช้รถยนต์ทั้งหมด
              </h5>
              {{-- <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  <i class="fa-solid fa-circle-info text-white"></i>
                  รายละเอียด
                </button>  --}}
          </div>
          <div class="modal-body">
               <!-- Collapsed content -->
                  {{-- <div class="collapse mt-1 mb-2" id="collapseExample">             
                     
                              <div class="row">
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_book">ตามหนังสือเลขที่ </label>
                                  </div>
                                  <div class="col-md-4 mt-2">
                                      <div class="form-group">
                                       <input id="car_service_book" type="text" class="form-control form-control-sm input-rounded" name="car_service_book" readonly> 
                                      </div>
                                  </div>
  
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_year">ปีงบประมาณ </label>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <input id="car_service_year" type="text" class="form-control form-control-sm input-rounded" name="car_service_year" readonly>  
                                      </div>
                                  </div>    
                              </div>
  
                              <div class="row ">
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_location">สถานที่ไป </label>
                                  </div>
                                  <div class="col-md-4 mt-2">
                                      <div class="form-group">
                                          <input id="car_service_location" type="text" class="form-control form-control-sm input-rounded" name="car_service_location" readonly>  
                                          
                                      </div>
                                  </div>
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_register">ทะเบียนรถยนต์ </label>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <input id="car_service_register" type="text" class="form-control form-control-sm input-rounded" name="car_service_register" readonly>  
                                      </div>
                                  </div>
                                   
                              </div>
  
                              <div class="row">
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_reason">เหตุผล </label>
                                  </div>
                                  <div class="col-md-10 mt-2">
                                      <div class="form-outline">
                                          <input id="car_service_reason" type="text"
                                              class="form-control form-control-sm input-rounded" name="car_service_reason" readonly>
  
                                      </div>
                                  </div>    
                              </div>
  
                              <div class="row">
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_date">ตั้งแต่วันที่ </label>
                                  </div>
                                  <div class="col-md-4 mt-2">
                                      <div class="form-group">
                                          <input id="car_service_date" type="text"
                                              class="form-control form-control-sm input-rounded"
                                              name="car_service_date" readonly>
                                      </div>
                                  </div>
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_date2">ถึงวันที่ </label>
                                  </div>
  
                                  <div class="col-md-4 mt-2">
                                      <div class="form-group">
                                          <input id="car_service_date2" type="text"
                                              class="form-control form-control-sm input-rounded"
                                              name="car_service_date2" readonly>
                                      </div>
                                  </div>    
                              </div>
  
                              <div class="row"> 
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_length_gotime">ตั้งแต่เวลา </label>
                                  </div>
                                  <div class="col-md-4 mt-2">
                                      <div class="form-group">
                                          <input id="car_service_length_gotime" type="text"
                                              class="form-control form-control-sm input-rounded"
                                              name="car_service_length_gotime" readonly>
                                      </div>
                                  </div>
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_length_backtime">ถึงเวลา </label>
                                  </div>
                                  <div class="col-md-4 mt-2">
                                      <div class="form-group">
                                          <input id="car_service_length_backtime" type="text"
                                              class="form-control form-control-sm input-rounded"
                                              name="car_service_length_backtime" readonly>
                                      </div>
                                  </div>
                              </div>

                              <div class="row"> 
                                  <div class="col-md-2 mt-2">
                                      <label for="car_service_length_gotime">พนักงานขับ </label>
                                  </div>
                                  <div class="col-md-4 mt-2">
                                      <div class="form-group">
                                          <input id="car_service_userdrive_name" type="text"
                                              class="form-control form-control-sm input-rounded"
                                              name="car_service_userdrive_name" readonly>
                                      </div>
                                  </div>
                                   
                              </div>

                         
                  </div>
            --}}
                  <div class="row"> 
                      {{-- <form action="{{ route('po.po_carcalenda_update_allallowpo') }}" method="POST" enctype="multipart/form-data">  --}}
                        <form action="{{ route('po.po_carcalenda_update_allallowpo') }}" method="POST" id="update_allowallowpoForm" enctype="multipart/form-data"> 
                          @csrf
                                  <h3 class="text-center mt-3 mb-3">ความคิดเห็น</h3>
                                  <div class="row">
                                      <div class="col-md-2 mt-3">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="car_service_status" id="bookrep_comment_a" value="allow"/>
                                          <label class="form-check-label" for="bookrep_comment_a"> อนุมัติ</label>
                                        </div>
                                      </div>
                                      <div class="col-md-2 mt-3">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="car_service_status" id="bookrep_comment_b"  value="noallow"/>
                                          <label class="form-check-label" for="bookrep_comment_b">ไม่อนุมัติ </label>
                                        </div> 
                                      </div>
                                      <div class="col-md-2 mt-3">
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="car_service_status" id="bookrep_comment_b"  value="confirmcancel"/>
                                            <label class="form-check-label" for="bookrep_comment_b">ยกเลิก </label>
                                          </div> 
                                        </div>
                                      
                                    </div>
                                  <h3 class="mt-3 text-center">Digital Signature</h3>
                                  <div id="signature-pad" class="mt-2 text-center"> 
                                          <div style="border:solid 1px teal;height:120px;"> 
                                          <div id="note" onmouseover="my_function();" class="text-center">The
                                              signature should be inside box</div>
                                          <canvas id="the_canvas" width="320px" height="100px"></canvas>
                                      </div>
                              
                                      <input type="hidden" id="signature" name="signature">
                                      <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                      <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                      <input type="hidden" id="car_service_no" name="car_service_no" value="{{ $refnumber }}">   
                                      <input type="hidden" id="car_service_id" name="car_service_id">

                                      <button type="button" id="clear_btn"
                                      class="btn btn-secondary btn-sm mt-3 ms-3 me-2" data-action="clear"><span
                                          class="glyphicon glyphicon-remove"></span> Clear</button>
                                  
                                      <button type="button" id="save_btn"
                                      class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png"
                                      onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                      Create</button>
                                  
                                      <button type="submit" class="btn btn-success btn-sm mt-3 me-2">
                                          <i class="fa-solid fa-circle-check text-white me-2"></i>
                                          อนุมัติทั้งหมด
                                      </button>
                              
                                      <button type="button" class="btn btn-danger btn-sm mt-3 me-2" data-bs-dismiss="modal" id="closebtn">
                                          <i class="fa-solid fa-xmark me-2"></i>
                                          ปิด
                                      </button>
                              
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
  $(document).ready(function() {
            $('#update_allowallowpoForm').on('submit', function(e) {
                e.preventDefault();
                var form = this; 
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
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
                        } else {

                        }
                    }
                });
            });

            
        });
</script>

@endsection
