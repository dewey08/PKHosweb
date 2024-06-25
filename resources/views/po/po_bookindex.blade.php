@extends('layouts.userpo')
@section('title','ZOffice || ผู้อำนวยการ')
@section('content')
<script>
  function TypeAdmin() {
      window.location.href = '{{ route('index') }}';
  }
  function bookmake_allowpo(iduser)
        {
        // alert(bookrep_id);
        Swal.fire({
        title: 'ต้องการอนุมัติทั้งหมดใช่ไหม?',
        text: "ข้อมูลจะถูกอนุมติทั้งหมด",
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
                    url:"{{url('po/bookmake_allowpo')}}" +'/'+ iduser, 
                    success:function(response)
                    {          
                        Swal.fire({
                        title: 'อนุมติสำเร็จ!',
                        text: "You Send data success",
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
      use App\Http\Controllers\UsersuppliesController;
            use App\Http\Controllers\StaticController;
            use App\Models\Products_request_sub;
        
            $refnumber = UsersuppliesController::refnumber();    
            $checkhn = StaticController::checkhn($iduser);
            $checkhnshow = StaticController::checkhnshow($iduser);
            $count_suprephn = StaticController::count_suprephn($iduser);
            $count_bookrep_rong = StaticController::count_bookrep_rong();
            $count_bookrep_po = StaticController::count_bookrep_po();
  ?>


<div class="container-fluid ">
  <div class="row">
    <div class="col-md-12">  
        <div class="card bg-success p-1 mx-0 shadow-lg">
          <div class="panel-header px-3 py-2 text-white"> 
            <div class="d-flex">
              <div class="p-2">{{ __('หนังสือราชการ') }} </div> 
              <div class="ms-auto p-2">
                <a href="" class="btn btn-white btn-sm" data-bs-toggle="modal" data-bs-target="#poModal">
                  <i class="fa-solid fa-circle-check text-success me-2"></i>
                  อนุมัติทั้งหมด</a> 
                {{-- <a href="javascript:void(0)" onclick="bookmake_allowpo({{$iduser}})" class="btn btn-success btn-sm text-white"> 
                  <i class="fa-solid fa-circle-check me-2"></i>
                  อนุมัติทั้งหมด
                </a> --}}
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
                           <!-- <th>id</th> -->
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
                                      {{-- <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                              ทำรายการ
                                            </button>                                      
                                            <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                  <li>
                                                        <a href="{{url('po/po_bookindex_detail/'.$item->bookrep_id.'/'.Auth::user()->id )}}" class="text-primary me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="รายละเอียด" >
                                                          <i class="fa-solid fa-circle-info me-2 mt-3 ms-4 mb-3"></i>
                                                          <label for="" style="color: black">รายละเอียด</label>  
                                                        </a>
                                                  </li>                                  
                                            </ul>
                                      </div>  --}}
                                      <div class="dropdown">
                                        <button class="btn btn-outline-info dropdown-toggle menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                        <ul class="dropdown-menu">
                                              {{-- <li>
                                                <a class="dropdown-item menu" data-bs-toggle="modal" data-bs-target="#cardetailModal{{$item->car_service_id}}" data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด">
                                                  <i class="fa-solid fa-file-pen mt-2 ms-2 mb-2 me-2 text-info"></i>
                                                  <label for="" style="color: rgb(33, 187, 248)">รายละเอียด</label> 
                                                </a>
                                              </li> --}}
                                              {{-- <li>
                                                <a class="dropdown-item menu" href="{{ url('user_car/car_narmal_print/'. $item->car_service_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Print" >
                                                  <i class="fa-solid fa-print mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                                  <label for="" style="color: rgb(24, 115, 252)">Print</label> 
                                                </a>
                                              </li> --}}
                                              {{-- <li>
                                                <a class="dropdown-item menu" href="javascript:void(0)" onclick="car_narmal_cancel({{$item->car_service_id}})" data-bs-toggle="tooltip" data-bs-placement="left" title="แจ้งยกเลิก">
                                      
                                                  <i class="fa-solid fa-xmark me-2 mt-2 ms-2 mb-2 text-danger"></i>
                                                  <label for="" style="color: rgb(255, 22, 22)">แจ้งยกเลิก</label> 
                                                </a>
                                              </li>                                                                --}}
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

<!-- Modal -->
<div class="modal fade" id="poModal" tabindex="-1" aria-labelledby="poModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="poModalLabel">ทำรายการอนุมัติทั้งหมด</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form class="custom-validation" action="{{ route('po.bookmake_allowpo') }}" method="POST" id="allowall_updateForm" enctype="multipart/form-data">
              @csrf
 
          <div class="row">
              
       
              <h3 class="text-center mt-3">ความคิดเห็น</h3>
              
              <div class="row">
                <div class="col-md-2">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="bookrep_comment3" id="bookrep_comment_a" value="อนุมัติ"/>
                    <label class="form-check-label" for="bookrep_comment_a"> อนุมัติ</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="bookrep_comment3" id="bookrep_comment_b"  value="ไม่อนุมัติ"/>
                    <label class="form-check-label" for="bookrep_comment_b">ไม่อนุมัติ </label>
                  </div>  
                  
                </div>
                <div class="col-md-2">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="bookrep_comment3" id="bookrep_comment_c"  value="ทราบ"/>
                    <label class="form-check-label" for="bookrep_comment_c"> ทราบ </label>
                  </div>  
                </div>
                <div class="col-md-2">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="bookrep_comment3" id="bookrep_comment_d"  value="เห็นชอบ"/>
                    <label class="form-check-label" for="bookrep_comment_d"> เห็นชอบ </label>
                  </div>  
                </div>
                <div class="col-md-2">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="bookrep_comment3" id="bookrep_comment_e"  value="อนุญาต"/>
                    <label class="form-check-label" for="bookrep_comment_e"> อนุญาต </label>
                  </div>  
                </div>
                <div class="col-md-2">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="bookrep_comment3" id="bookrep_comment_f"  value="แจ้ง"/>
                    <label class="form-check-label" for="bookrep_comment_f"> แจ้ง </label>
                  </div>  
                </div>
              </div>
               
              <h3 class="mt-3 text-center">Digital Signature</h3>
              <div id="signature-pad" class="mt-2 text-center">
                <div style="border:solid 1px teal;height:120px;"> 
                      <div id="note" onmouseover="my_function();" class="text-center">The signature should be inside box</div>
                      <canvas id="the_canvas" width="320px" height="100px" ></canvas>
                  </div> 
                      <input type="hidden" id="signature" name="signature">
                      <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                      <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> 

                      <button type="button" id="clear_btn" class="btn btn-secondary btn-sm mt-3 me-2" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                      <button type="button" id="save_btn" class="btn btn-info btn-sm mt-3 me-2" data-action="save-png" onclick="create()"><span class="glyphicon glyphicon-ok"></span> Create</button>
                      
                      <button type="submit" class="btn btn-success btn-sm mt-3 me-2">
                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                        อนุมติทั้งหมด</button>  
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
      // alert("Please provide signature first.");
      Swal.fire(
                'กรุณาลงลายเซนต์ก่อน !',
                'You clicked the button !',
                'warning'
                )
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

              $('select').select2();
              $('#meetting_year').select2({
                  dropdownParent: $('#carservicessModal')
              });
              $('#car_service_status').select2({
                  dropdownParent: $('#carservicessModal')
              });
                         
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });       

              $('#allowall_updateForm').on('submit', function(e) {
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
                            Swal.fire(
                              'กรุณาลงลายเซนต์ก่อน !',
                              'You clicked the button !',
                              'warning'
                              )
                          }
                      }
                  });
              });



  });
</script>


@endsection
