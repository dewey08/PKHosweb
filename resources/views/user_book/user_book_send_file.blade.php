@extends('layouts.user')
@section('title','PK-OFFICER || หนังสือเข้า')
 
<script src="{{ asset('js/signature.js') }}"></script>


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

<div class="container-fluid" style="width: 97%">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                
            </div>
        </div>
    </div>
        <div class="row">
         
            <div class="col-md-12 ">  
                <div class="card-body shadow">  
                    <!-- Pills navs -->
                        <ul class="nav nav-pills" id="ex1" role="tablist">

                            <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_bookdetail/'.$dataedits->bookrep_id)}}" ><label class="xl">รายละเอียด</label> </a>
                            </li>
                            {{-- <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_book_send_deb/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;<label class="xl">ส่งกลุ่มงาน</label>&nbsp;&nbsp; </a>
                            </li> --}}
                            {{-- <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_book_send_debsub/'.$dataedits->bookrep_id)}}" >&nbsp;<label class="xl">ส่งฝ่าย/แผนก</label>&nbsp;</a>
                            </li> --}}
                            {{-- <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_book_send_person/'.$dataedits->bookrep_id)}}" ><label class="xl">ส่งบุคคลากร</label> </a>
                            </li> --}}
                            {{-- <li class="nav-item" role="presentation"> 
                                <a class="nav-link " href="{{url('user_book/user_book_send_team/'.$dataedits->bookrep_id)}}" ><label class="xl">ส่งทีมนำองค์กร</label> </a>
                            </li> --}}
                            <li class="nav-item" role="presentation">
                               
                                <a class="nav-link " href="{{url('user_book/user_book_send_fileplus/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;&nbsp;&nbsp;<label class="xl">ไฟล์แนบ</label>&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation">
                               
                                <a class="nav-link " href="{{url('user_book/user_book_send_fileopen/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;&nbsp;<label class="xl">การเปิดอ่าน</label>&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                
                                <a class="nav-link active" href="{{url('user_book/user_book_send_file/'.$dataedits->bookrep_id)}}" >&nbsp;&nbsp;&nbsp;&nbsp;<label class="xl">ไฟล์ที่ส่ง</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </a>
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
                           
                        <div class="tab-pane fade show active" id="ex1-pills-8" role="tabpanel" aria-labelledby="ex1-tab-8">
                            <div class="row">
                                <div class="col-md-12">   
                                        <div class="card-body fpdf shadow-lg ">  
                                            @if($dataedits->bookrep_file == '' || $dataedits->bookrep_file == null)
                                                ไม่มีข้อมูลไฟล์อัปโหลด 
                                            @else
                                                <?php list($a,$b,$c,$d) = explode('/',$url); ?>
                                                    <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedits->bookrep_file) }}" height="100%" width="100%"></iframe>
                                            @endif                                       
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
