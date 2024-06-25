@extends('layouts.userpo')
@section('title','ZOffice || ผู้อำนวยการ')
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
@section('menu')
<style>
  body{
      font-size:14px;
  }
  .btn{
     font-size:15px;
   }
   .bgc{
    background-color: #264886;
   }
   .bga{
      background-color: #FCFF9A;
     }
     .bgon{
      background-color: #FFF48F;
     }
   .boxpdf{
    /* height: 1150px; */
    height: auto;
   }
   .fpdf{
        width:auto;
        height:695px;
        /* height: auto; */
        margin:0;
        
        overflow:scroll;
        background-color: #FFFFFF;
    }
   
</style>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">  
        <a href="{{url('po/po_bookindex/'.Auth::user()->id)}}" class="btn btn-success btn-sm text-white me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือราชการ<span class="badge bg-danger ms-2">{{$count_bookrep_po}}</span>&nbsp;&nbsp;&nbsp;</a>   
        <a href="{{url('po/po_leaveindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การลา<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
        <a href="{{url('po/po_trainindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">ประชุม/อบรม/ดูงาน<span class="badge bg-danger ms-2">0</span></a> 
        <a href="{{url('po/po_purchaseindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;จัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">{{$count_suprephn}}</span>&nbsp;</a> 
        <a href="{{url('po/po_storeindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;คลังวัสดุ<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;</a> 
        <div class="text-end"> 
        </div>
        </div>
    </div>
@endsection

<div class="container-fluid " style="width: 97%">
  <div class="row">
    <div class="col-md-12">  
        <div class="card">
          <div class="card-header"> 

            {{-- <div class="container-fluid d-flex flex-wrap">  
            <button href="" class="col-6 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark">เกษียณหนังสือ</button> 
            <div class="text-end"> 
                    
            </div>
            </div> --}}

            <div class="d-flex">
                <div class="p-2">{{ __('หนังสือราชการ') }}
                </div> 
                <div class="ms-auto p-2">
                  {{-- <a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#saexampleModal">อนุมัติทั้งหมด</a> --}}
                  {{-- <button href="" class="col-6 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark">เกษียณหนังสือ</button>  --}}
                </div>
            </div>


        </div>
            <div class="card-body shadow-lg">    
              <div class="row"> 
                {{-- {{$bookcount}} --}}
                @if ($bookcount > 0)                               
                        <div class="col-md-6">                            
                                <div class="fpdf mt-2 text-center" id="pages">            
                                        @if($dataedits->bookrep_file == '' || $dataedits->bookrep_file == null)
                                                ไม่มีข้อมูลไฟล์อัปโหลด 
                                        @else                               
                                        <!-- <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedits->bookrep_file) }}" height="100%" width="100%"></iframe> --> 
                                            <iframe src="{{ url('po/po_bookindex_printdetail/'.$dataedits->bookrep_id) }}" height="100%" width="100%"></iframe>                                      
                                        @endif                            
                                    </div>                       
                        </div>
                   
                    <div class="col-md-6" > 
                            <form class="custom-validation" action="{{ route('po.bookmake_retirepo') }}" method="POST" id="signature_retiepoForm" enctype="multipart/form-data">
                                @csrf
                                
                                    <div class="mt-2 text-center">
                                        <h3>ความคิดเห็น</h3>
                                        {{-- <textarea name="bookrep_comment3" id="bookrep_comment3"  rows="3" class="form-control"></textarea> --}}
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
                                          <div class="row">
                                            <div class="col-md-3">  </div>
                                            <div class="col-md-6">
                                        <h3 class="mt-2">Digital Signature</h3>
                                        <div id="signature-pad" >
                                            <div style="border:solid 1px teal; width:320px;height:120px;padding:3px;position:relative;">
                                                <div id="note" onmouseover="my_function();" class="text-center">The signature should be inside box</div>
                                                <canvas id="the_canvas" width="320px" height="100px" ></canvas>
                                            </div> 
                                                <input type="hidden" id="signature" name="signature">
                                                <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                                <input type="hidden" name="bookrep_id" id="bookrep_id" value=" {{ $dataedits->bookrep_id }}">

                                                <button type="button" id="clear_btn" class="btn btn-danger btn-sm mt-3" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                                                <button type="button" id="save_btn" class="btn btn-info btn-sm mt-3" data-action="save-png" onclick="create()"><span class="glyphicon glyphicon-ok"></span> Create</button>
                                                {{-- <button type="submit" class="btn btn-primary btn-sm mt-3" data-action="save-png"><span class="glyphicon glyphicon-ok"></span> Save  </button> --}}
                                    </div>
                                </div>
                                <div class="col-md-3">  </div>
                                <div class="modal-footer d-flex justify-content-center mt-3"> 
                                    <button type="submit" class="btn btn-success btn-sm ">
                                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                                        อนุมัติหนังสือ</button>
                                   
                                  </div>
                                <form>                    
                    </div>
                    @else
                    <div class="row"> 
                        <div class="col-md-12">                            
                            <div class="fpdf mt-2 text-center" id="pages">            
                                    @if($dataedits->bookrep_file == '' || $dataedits->bookrep_file == null)
                                            ไม่มีข้อมูลไฟล์อัปโหลด 
                                    @else                               
                                    <!-- <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedits->bookrep_file) }}" height="100%" width="100%"></iframe> --> 
                                        <iframe src="{{ url('po/po_bookindex_printdetail/'.$dataedits->bookrep_id) }}" height="100%" width="100%"></iframe>                                      
                                    @endif                            
                            </div>                       
                    </div>

                @endif
                
            </div> 
              
            </div>
        </div>
    </div>
</div>


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

 
        // $('#signature_saveForm').on('submit',function(e){
        //       e.preventDefault();  
        //       var form = this; 
        //       $.ajax({
        //         url:$(form).attr('action'),
        //         method:$(form).attr('method'),
        //         data:new FormData(form),
        //         processData:false,
        //         dataType:'json',
        //         contentType:false,
        //         beforeSend:function(){
        //           $(form).find('span.error-text').text('');
        //         },
        //         success:function(data){
        //           if (data.status == 0 ) {
                    
        //           } else {          
        //             Swal.fire({
        //               title: 'บันทึกข้อมูลสำเร็จ',
        //               text: "You Insert data success",
        //               icon: 'success',
        //               showCancelButton: false,
        //               confirmButtonColor: '#06D177',
        //               // cancelButtonColor: '#d33',
        //               confirmButtonText: 'เรียบร้อย'
        //             }).then((result) => {
        //               if (result.isConfirmed) {                  
        //                 window.location.reload(); 
        //               }
        //             })      
        //           }
        //         }
        //       });
        // });

   
</script>


@endsection
