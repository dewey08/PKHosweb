@extends('layouts.user')
@section('title','ZOffice || หนังสือเข้า')


@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function bookmake_sendretire(bookrep_id)
        {
        // alert(bookrep_id);
        Swal.fire({
        title: 'ต้องการเสนอหัวหน้าบริหารใช่ไหม?',
        text: "ข้อมูลนี้จะถูกส่งไปยังหัวหน้าบริหารเพื่อทำการเกษียณหนังสือ",
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
                    url:"{{url('book/bookmake_sendretire')}}" +'/'+ bookrep_id, 
                    success:function(response)
                    {          
                        Swal.fire({
                        title: 'ส่งหนังสือสำเร็จ!',
                        text: "You Send data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                        if (result.isConfirmed) {                  
                            
                            window.location.reload(); 
                            // window.location = "/book/bookmake_index"; //   
                            
                        }
                        }) 
                    }
                    })        
                }
            })
    }
    function bookmake_sendpo(bookrep_id)
        {
        // alert(bookrep_id);
        Swal.fire({
        title: 'ต้องการเสนอผู้อำนวยการใช่ไหม?',
        text: "ข้อมูลนี้จะถูกส่งไปยังผู้อำนวยการเพื่อทำการอนุมติหนังสือ",
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
                    url:"{{url('book/bookmake_sendpo')}}" +'/'+ bookrep_id, 
                    success:function(response)
                    {          
                        Swal.fire({
                        title: 'ส่งหนังสือสำเร็จ!',
                        text: "You Send data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                        if (result.isConfirmed) {                  
                            
                            window.location.reload(); 
                            // window.location = "/book/bookmake_index"; //   
                            
                        }
                        }) 
                    }
                    })        
                }
            })
    }
    function booksendteam_destroy(sendteam_id)
          {
            Swal.fire({
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({ 
                url:"{{url('book/bookmake_sendteam_destroy')}}" +'/'+ sendteam_id,  
                type:'DELETE',
                data:{
                    _token : $("input[name=_token]").val()
                },
                success:function(response)
                {          
                    Swal.fire({
                      title: 'ลบข้อมูล!',
                      text: "You Delet data success",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177', 
                      confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                      if (result.isConfirmed) {                  
                        $("#sid"+sendteam_id).remove();     
                        window.location.reload(); 
                        // window.location = "/book/bookmake_index"; //     
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
  use App\Http\Controllers\BookController;
    $refnumber = BookController::refnumber();
  ?>
 
  <style>
    body{
        font-size:13px;
    }
    .btn{
       font-size:14px;
     }
     .xl{
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
     .page{
          width: 90%;
          margin: 5px;
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
      #zoom-in{
          
      }
      #zoom-percent{
          display: inline-block;
      }
      #zoom-percent::after{
          content: "%";
      }
      #zoom-out{
          
      }
      .fpdf{
          width:auto;
          height:800px;
          /* height:auto; */
          margin:0;
          
          overflow:scroll;
          background-color: #FFFFFF;
      }
   
  
</style>
{{-- <div class="px-3 py-2 border-bottom">
      <div class="container d-flex flex-wrap justify-content-center"> 
          <a href="{{url("book/bookmake_index")}}" class="btn btn-light btn-sm text-dark me-2 mt-2">หนังสือรับ</a> 
          <a href=" " class="btn btn-primary btn-sm text-white me-2 mt-2">ส่งหนังสือ</a> 
          @if ($bookcount == 0) 
          <button type="button" class="btn btn-light text-dark btn-sm me-2 mt-2" data-bs-toggle="modal" data-bs-target="#saexampleModal">
              ความคิดเห็น
              </button>
      @endif   
      
      @if ($adcount == 0) 
      <button type="button" class="btn btn-light text-dark btn-sm me-2 mt-2" data-bs-toggle="modal" data-bs-target="#poModal">
        เสนอผู้อำนวยการ
        </button>   
        @endif 
        
          <div class="text-end"> 
             
          </div>
      </div>
  </div>
  @endsection   --}}
<div class="container-fluid" style="width: 97%">
        <div class="row"> 
            <div class="col-md-12 ">  
                <div class="card-body shadow">  
                    <!-- Pills navs -->
                        <ul class="nav nav-pills" id="ex1" role="tablist">

                            <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_bookdetail/'.$dataedits->bookrep_id)}}" ><label class="xl">รายละเอียด</label> </a>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_book_send_deb/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;<label class="xl">ส่งกลุ่มงาน</label>&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_book_send_debsub/'.$dataedits->bookrep_id)}}" >&nbsp;<label class="xl">ส่งฝ่าย/แผนก</label>&nbsp;</a>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_book_send_person/'.$dataedits->bookrep_id)}}" ><label class="xl">ส่งบุคคลากร</label> </a>
                            </li>
                            <li class="nav-item" role="presentation"> 
                                <a class="nav-link active" href="{{url('user_book/user_book_send_team/'.$dataedits->bookrep_id)}}" ><label class="xl">ส่งทีมนำองค์กร</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                               
                                <a class="nav-link" href="{{url('user_book/user_book_send_fileplus/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;&nbsp;&nbsp;<label class="xl">ไฟล์แนบ</label>&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation">
                               
                                <a class="nav-link" href="{{url('user_book/user_book_send_fileopen/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;&nbsp;<label class="xl">การเปิดอ่าน</label>&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                
                                <a class="nav-link" href="{{url('user_book/user_book_send_file/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;&nbsp;&nbsp;<label class="xl">ไฟล์ที่ส่ง</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                        </ul>
                    <!-- Pills navs -->
                </div>  
            </div>   
        </div> 
        <div class="row">
            <div class="col-md-12 "> 
                <div class="card-body shadow-lg "> 
                    <!-- Pills content -->
                    <div class="tab-content" id="ex1-content">
                        
                        <!-- ************ ส่งทีมนำองค์กร ********************** -->
                        <div class="tab-pane fade show active" id="ex1-pills-5" role="tabpanel" aria-labelledby="ex1-tab-5">
                            {{-- <form action="{{route('book.bookmake_index_sendteam')}}" id="Save_sendteam" method="POST">
                                @csrf                             
                                <div class="row text-center">                                    
                                        <input type="hidden" name="bookrep_id" id="bookrep_id" value=" {{ $dataedits->bookrep_id }}">
                                        <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <select id="org_team_id" name="org_team_id" class="form-control" style="width: 100%" required>                      
                                                <option value=""></option>
                                                @foreach ($org_team as $team )
                                                    <option value="{{ $team->org_team_id}}">{{ $team->org_team_detail}}</option>
                                                @endforeach                             
                                            </select>   
                                        </div>
                                    </div> 
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <select id="book_objective5" name="book_objective5" class="form-control" style="width: 100%" required>                      
                                                <option value=""></option>
                                                @foreach ($book_objective as $book )
                                                    <option value="{{ $book->objective_id}}">{{ $book->objective_name}}</option>
                                                @endforeach                             
                                            </select>   
                                        </div>
                                    </div> 
                                    <div class="col-md-2 mt-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                ส่ง 
                                            </button> 
                                            
                                        </div>
                                    </div>                                                                  
                                </div> 
                            </form>  --}}

                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example4">
                                            <thead>
                                                <tr height="10px">
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center">ทีมนำองค์กร</th> 
                                                    <th width="10%" class="text-center">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num = 1; $date =  date('Y'); ?>      
                                                @foreach ($book_sendteam as $item5)
                                        
                                                    <tr id="sid{{ $item5->sendteam_id }}">
                                                        <td class="text-center" width="5%">{{ $num++ }}</td>
                                                        <td class="p-2">{{ $item5->sendteam_team_name }}</td>               
                                                        <td class="text-center" width="10%"> 
                                                        
                                                            {{-- <a class="text-danger" href="javascript:void(0)"
                                                                onclick="booksendteam_destroy({{ $item5->sendteam_id.'/'.$dataedits->bookrep_id}})"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a> --}}
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
                    <!-- Pills content -->                   
                </div>
            </div> 
        </div> 

    </div> 
     
</div> 

 <!-- Modal -->
 <div class="modal fade" id="saexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">บันทึกความคิดเห็น หนังสือเลขที่ {{$dataedits->bookrep_repbooknum}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="custom-validation" action="{{ route('book.comment1_save') }}" method="POST" id="comment1_saveForm" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="bookrep_id" id="bookrep_id" class="form-control" value="{{$dataedits->bookrep_id}}">

            <div class="row">
                <div class="col-md-2">
                    <label for="pcustomer_code">ชื่อเรื่อง </label>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="pcustomer_code">{{$dataedits->bookrep_name}} </label> 
                    </div>
                </div>            
            </div>
            <div class="row mt-3">
                <div class="col-md-2">
                    <label for="pcustomer_code">ผู้บันทึก </label>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="pcustomer_code">{{$dataedits->bookrep_usersend_name}} </label> 
                    </div>
                </div>            
            </div>
            <div class="row mt-3">
                <div class="col-md-2">
                    <label for="pcustomer_code">ความเห็นที่ 1</label>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <textarea name="bookrep_comment1" id="bookrep_comment1" rows="3" class="form-control"></textarea>
                       
                    </div>
                </div>            
            </div>
        </div>
        <div class="modal-footer"> 
          <button type="submit" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-floppy-disk me-2"></i>
            บันทึกความคิดเห็น</button>
          <a href="javascript:void(0)" onclick="bookmake_sendretire({{$dataedits->bookrep_id}})" class="btn btn-primary btn-sm text-white">
            <i class="fa-solid fa-user-tie me-2"></i>
            เสนอหัวหน้าบริหาร</a>
         
        </div>
    </form>
      </div>
    </div>
  </div>

   <!-- Modal -->
 <div class="modal fade" id="poModal" tabindex="-1" aria-labelledby="poModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="poModalLabel">บันทึกความคิดเห็น หนังสือเลขที่ {{$dataedits->bookrep_repbooknum}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="custom-validation" action="{{ route('book.comment1_save') }}" method="POST" id="comment1po_saveForm" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="bookrep_id" id="bookrep_id" class="form-control" value="{{$dataedits->bookrep_id}}">

            <div class="row">
                <div class="col-md-2">
                    <label for="pcustomer_code">ชื่อเรื่อง </label>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="pcustomer_code">{{$dataedits->bookrep_name}} </label> 
                    </div>
                </div>            
            </div>
            <div class="row mt-3">
                <div class="col-md-2">
                    <label for="pcustomer_code">ผู้บันทึก </label>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="pcustomer_code">{{$dataedits->bookrep_usersend_name}} </label> 
                    </div>
                </div>            
            </div>
            <div class="row mt-3">
                <div class="col-md-2">
                    <label for="pcustomer_code">ความเห็นที่ 1</label>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <textarea name="bookrep_comment1" id="bookrep_comment1" rows="3" class="form-control"></textarea>
                       
                    </div>
                </div>            
            </div>
        </div>
        <div class="modal-footer"> 
          <button type="submit" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-floppy-disk me-2"></i>
            บันทึกความคิดเห็น</button>
          <a href="javascript:void(0)" onclick="bookmake_sendpo({{$dataedits->bookrep_id}})" class="btn btn-success btn-sm text-white">
            <i class="fa-solid fa-user-tie me-2"></i>
            เสนอผู้อำนวยการ</a>
         
        </div>
    </form>
      </div>
    </div>
  </div>
<script src="{{ asset('pdfupload/pdf_up.js') }}"></script>
{{-- <script src="{{ asset('js/globalFunction.js') }}"></script> --}}
{{-- <script src="{{ asset('js/book.js') }}"></script>    --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 
   
@endsection
