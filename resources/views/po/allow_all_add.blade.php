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
 
<div class="row justify-content-center">
        <div class="row invoice-card-row">  
        <div class="col-md-12 mt-2">
               
              <div class="card bg-success p-1 mx-0 shadow-lg">
               
                <div class="panel-header px-3 py-2 text-white"> 
                    <div class="d-flex">
                      <div class="p-2">{{ __('รายละเอียดการขอใช้รถยนต์') }} </div> 
                      {{-- <div class="ms-auto p-2">
                        <a href="" class="btn btn-white btn-sm" data-bs-toggle="modal" data-bs-target="#carservicessModal">
                          <i class="fa-solid fa-circle-check text-success me-2"></i>
                          อนุมัติทั้งหมด
                        </a> 
                        
                      </div> --}}
                    </div>          
                  </div>

                <div class="panel-body bg-white">
                    <div class="row"> 
                        <div class="col-md-6 mt-3">
                            <div class="row">
                                <div class="col-md-3 mt-3 ms-3">
                                    <label for=""><b>ตามหนังสือเลขที่ :</b></label>
                                </div>
                                <div class="col mt-3 ms-3">                                 
                                      <label for="car_service_reason">{{$dataedits->car_service_book}}</label>                                 
                                </div>                               
                            </div>
                            <div class="row">                               
                                <div class="col-md-3 mt-3 ms-3">
                                    <label for=""><b>ปีงบประมาณ :</b></label>
                                </div>
                                <div class="col mt-3 ms-3">                                  
                                      <label for="car_service_reason">{{$dataedits->car_service_year}}</label>                                
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mt-3 ms-3">
                                    <label for=""><b>สถานที่ไป :</b></label>
                                </div>
                                <div class="col mt-3 ms-3"> 
                                    <div class="form-group">
                                      <label for="car_service_reason">{{$dataedits->car_location_name}}</label>
                                  </div>
                                </div>                                                           
                            </div>
                            <div class="row">                              
                                <div class="col-md-3 mt-3 ms-3">
                                  <label for="" ><b>เหตุผล :</b></label>
                                </div>
                                <div class="col mt-3 ms-3">
                                  <div class="form-group">
                                    <label for="car_service_reason">{{$dataedits->car_service_reason}}</label>
                                  </div> 
                                </div>                               
                            </div>

                            <div class="row">
                                <div class="col-md-3 mt-3 ms-3">
                                    <label for=""><b>วันที่ไป :</b></label>
                                </div> 
                                <div class="col mt-3 ms-3">
                                    <div class="form-group">
                                      <label for="car_service_year">{{ dateThai($dataedits->car_service_date)}}</label>
                                    </div>
                                </div>                                
                            </div>
                          
                            <div class="row">                              
                                <div class="col-md-3 mt-3 ms-3">
                                  <label for=""><b>ตั้งแต่เวลา :</b></label>
                              </div> 
                              <div class="col mt-3 ms-3">
                                  <div class="form-group">
                                    <label for="car_service_year">{{formatetime($dataedits->car_service_length_gotime)}} น.</label>
                                  </div>
                              </div>                               
                            </div>

                            <div class="row">  
                                <div class="col-md-3 mt-3 ms-3">
                                    <label for=""><b>ถึงเวลา :</b></label>
                                </div>
                                
                                <div class="col mt-3 ms-3">
                                    <div class="form-group">
                                      <label for="car_service_year">{{formatetime($dataedits->car_service_length_backtime)}} น.</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="row"> 
                                    {{-- <form action="{{ route('po.po_carcalenda_update_allallowpo') }}" method="POST" enctype="multipart/form-data">  --}}
                                    <form action="{{ route('po.po_carcalenda_update_allowonepo') }}" method="POST" id="update_allowonepoForm" enctype="multipart/form-data"> 
                                        @csrf
                                            <h3 class="text-center mt-4 mb-4">ความคิดเห็น</h3>
                                            <div class="row ">
                                                <div class="col-md-2 mt-3 ms-3">
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="car_service_status" id="bookrep_comment_a" value="allow"/>
                                                    <label class="form-check-label" for="bookrep_comment_a"> อนุมัติ</label>
                                                  </div>
                                                </div>
                                                <div class="col-md-2 mt-3 ms-3">
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="car_service_status" id="bookrep_comment_b"  value="noallow"/>
                                                    <label class="form-check-label" for="bookrep_comment_b">ไม่อนุมัติ </label>
                                                  </div> 
                                                </div>
                                                <div class="col-md-2 mt-3 ms-3">
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="car_service_status" id="bookrep_comment_b"  value="confirmcancel"/>
                                                      <label class="form-check-label" for="bookrep_comment_b">ยกเลิก </label>
                                                    </div> 
                                                  </div>
                                                
                                              </div>
                                            <h3 class="mt-4 mb-4 text-center">Digital Signature</h3>
                                            <div id="signature-pad" class="mt-2 text-center mb-5 ms-3 me-3"> 
                                                    <div style="border:solid 1px teal;height:120px;"> 
                                                    <div id="note" onmouseover="my_function();" class="text-center">The
                                                        signature should be inside box</div>
                                                    <canvas id="the_canvas" width="320px" height="100px"></canvas>
                                                </div>
                                        
                                                <input type="hidden" id="signature" name="signature">
                                                <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                                <input type="hidden" id="car_service_no" name="car_service_no" value="{{ $refnumber }}">   
                                                <input type="hidden" id="car_service_id" name="car_service_id" value="{{$dataedits->car_service_id}}">
          
                                                <button type="button" id="clear_btn"
                                                class="btn btn-secondary btn-sm mt-4 ms-3 me-2" data-action="clear"><span
                                                    class="glyphicon glyphicon-remove"></span> Clear</button>
                                            
                                                <button type="button" id="save_btn"
                                                class="btn btn-info btn-sm mt-4 me-2 text-white" data-action="save-png"
                                                onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                                Create</button>
                                            
                                                <button type="submit" class="btn btn-success btn-sm mt-4 me-2">
                                                    <i class="fa-solid fa-circle-check text-white me-2"></i>
                                                    อนุมัติ
                                                </button>
                                        
                                                <a href="{{url('po/allow_all')}}" class="btn btn-danger btn-sm mt-4 me-2" >
                                                    <i class="fa-solid fa-xmark me-2"></i>
                                                    ปิด
                                                </a>
                                        
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
    //   alert("Please provide signature first.");
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
    $('#update_allowonepoForm').on('submit', function(e) {
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
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = "{{url('po/allow_all')}}";     
                                    }
                                }) 
                            }else if (data.status == 150) {
                                Swal.fire(
                                    'กรุณาเลือกความคิดเห็น !',
                                    'You clicked the button !',
                                    'warning'
                                    )
                            }else if (data.status == 50) {
                                Swal.fire(
                                    'กรุณาลงลายชื่อ !',
                                    'You clicked the button !',
                                    'warning'
                                    ) 
                            } else {                               
                                    // Swal.fire(
                                    // 'ไม่มีข้อมูลต้องการจัดการ !',
                                    // 'You clicked the button !',
                                    // 'warning'
                                    // )                                                              
                            }
                        }
                    });
                });


            
        });
</script>

@endsection
