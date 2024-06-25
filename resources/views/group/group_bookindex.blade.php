@extends('layouts.usergroup')
@section('title','ZOffice || หัวหน้ากลุ่ม')
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
@section('menu')
<style>
  body{
      font-size:14px;
  }
  .btn{
     font-size:15px;
   }
   .btn-group{
    background-color: rgb(99, 100, 100);
   }
   /* .btn-group .active{
    background-color: rgb(99, 100, 100);
    color: black;
   } */
 
   .page{
        width: 90%;
        margin: 10px;
        box-shadow: 0px 0px 5px #000;
        animation: pageIn 1s ease;
        transition: all 1s ease, width 0.2s ease;
    }
    @keyframes pageIn{
    0%{
        transform: translateX(-300px);
        opacity: 0;
    }
    100%{
        transform: translateX(0px);
        opacity: 1;
    }
    }
   
 

</style>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">  
        <a href="{{url('group/group_bookindex/'.Auth::user()->id)}}" class="btn btn-dark btn-sm text-white me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือราชการ<span class="badge bg-danger ms-2">{{$count_bookrep_po}}</span>&nbsp;&nbsp;&nbsp;</a>   
        <a href="{{url('group/group_leaveindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การลา<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
        <a href="{{url('group/group_trainindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">ประชุม/อบรม/ดูงาน<span class="badge bg-danger ms-2">0</span></a> 
        <a href="{{url('group/group_purchaseindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;จัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">{{$count_suprephn}}</span>&nbsp;</a> 
        <a href="{{url('group/group_storeindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;คลังวัสดุ<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;</a> 
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
            <div class="d-flex">
              <div class="p-2">{{ __('หนังสือราชการ') }}
              </div> 
              <div class="ms-auto p-2">
                <a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#poModal">อนุมัติทั้งหมด</a> 
                {{-- <a href="javascript:void(0)" onclick="bookmake_allowpo({{$iduser}})" class="btn btn-success btn-sm text-white"> 
                  <i class="fa-solid fa-circle-check me-2"></i>
                  อนุมัติทั้งหมด
                </a> --}}
              </div>
          </div>
          
          </div>
            <div class="card-body shadow-lg">    
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
                                      <div class="dropdown">
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="poModalLabel">ทำรายการอนุมัติทั้งหมด</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex justify-content-center">
          <form class="custom-validation" action="{{ route('po.bookmake_allowpo') }}" method="POST" id="commentpo_saveForm" enctype="multipart/form-data">
              @csrf
 
          <div class="row">
              
            <div class="text-center">
              <h3>ความคิดเห็น</h3>
              <textarea name="bookrep_comment3" id="bookrep_comment3"  rows="3" class="form-control"></textarea>
              <h3 class="mt-2">Digital Signature</h3>
              <div id="signature-pad" >
                  <div style="border:solid 1px teal; width:365px;height:130px;padding:3px;position:relative;">
                      <div id="note" onmouseover="my_function();" class="text-center">The signature should be inside box</div>
                      <canvas id="the_canvas" width="365px" height="100px" ></canvas>
                  </div> 
                      <input type="hidden" id="signature" name="signature">
                      <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                      <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> 

                      <button type="button" id="clear_btn" class="btn btn-danger btn-sm mt-3" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                      <button type="button" id="save_btn" class="btn btn-info btn-sm mt-3" data-action="save-png" onclick="create()"><span class="glyphicon glyphicon-ok"></span> Create</button>
                      {{-- <button type="submit" class="btn btn-primary btn-sm mt-3" data-action="save-png"><span class="glyphicon glyphicon-ok"></span> Save  </button> --}}
              </div>
          </div>
            

          </div>
         
      </div>
      <div class="modal-footer d-flex justify-content-center"> 
        <button type="submit" class="btn btn-success btn-sm ">
          <i class="fa-solid fa-floppy-disk me-2"></i>
          อนุมติทั้งหมด</button>
       
      </div>
  </form>
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

</script>



@endsection
