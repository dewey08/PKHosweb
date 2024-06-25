@extends('layouts.medical')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')

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
        font-size:14px;
    }
    .btn{
       font-size:15px;
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
    
      
      @media (min-width: 950px) {
        .modal {
            --bs-modal-width: 950px;
        }
    }

    @media (min-width: 1500px) {
        .modal-xls {
            --bs-modal-width: 1500px;
        }
    }

    @media (min-width: 1500px) {
        .container-fluids {
            width: 1500px;
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right
        }

        .dataTables_wrapper .dataTables_length {
            float: left
        }

        .dataTables_info {
            float: left;
        }

        .dataTables_paginate {
            float: right
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
        }

        .table thead tr th {
            font-size: 14px;
        }

        .table tbody tr td {
            font-size: 13px;
        }

        .menu {
            font-size: 13px;
        }
    }

    .hrow {
        height: 2px;
        margin-bottom: 9px;
    }
  
  </style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="row invoice-card-row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <div class="d-flex">
                            <div class="p-2" style="font-size: 14px"> การบำรุงรักษา</div>

                            <div class="ms-auto">                               
                                    {{-- <button type="button" class="btn btn-outline-primary btn-sm me-2"
                                        data-bs-toggle="modal" data-bs-target="#saexampleModal">
                                        <i class="fa-solid fa-paper-plane me-2"></i>
                                        ความคิดเห็น
                                    </button>                                --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow">
                        <!-- Pills navs -->
                        <ul class="nav nav-pills" id="ex1" role="tablist">

                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send') }}">
                                    <i class="fa-solid fa-book me-2 text-warning"></i>
                                    <label class="xl">รายละเอียด</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_deb' ) }}">&nbsp;&nbsp;
                                    <i class="fa-solid fa-address-book me-2 text-white"></i>
                                    <label class="xl ">ส่งกลุ่มงาน</label>&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_debsub') }}">&nbsp;
                                    <i class="fa-solid fa-address-book me-2 text-info"></i>
                                    <label class="xl">ส่งฝ่าย/แผนก</label>&nbsp;</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_person') }}">
                                    <i class="fa-solid fa-address-book me-2 text-success"></i>
                                    <label class="xl">ส่งบุคคลากร</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_team') }}">
                                    <i class="fa-solid fa-address-book me-2 text-primary"></i>
                                    <label class="xl">ส่งทีมนำองค์กร</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_fileplus') }}">&nbsp;&nbsp;&nbsp;&nbsp;
                                    <i class="fa-solid fa-swatchbook me-2 text-secondary"></i>
                                    <label class="xl">ไฟล์แนบ</label>&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_open' ) }}">&nbsp;&nbsp;&nbsp;
                                    <i class="fa-solid fa-book-open me-2 text-info"></i>
                                    <label class="xl">การเปิดอ่าน</label>&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active shadow me-1 ms-1 mt-2" 
                                    href="{{ url('book/bookmake_index_send_file' ) }}">&nbsp;&nbsp;&nbsp;&nbsp;
                                    <i class="fa-solid fa-swatchbook me-2 text-danger"></i>
                                    <label class="xl">ไฟล์ที่ส่ง</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </a>
                            </li>
                        </ul>
                        <!-- Pills navs -->
                    <!-- Pills content -->
                    <div class="tab-content" id="ex1-content">                           
                        <div class="tab-pane fade show active" id="ex1-pills-8" role="tabpanel" aria-labelledby="ex1-tab-8">
                            <div class="row">
                                <div class="col-md-12 mt-4">   
                                        <div class="card-body fpdf shadow-lg ">  
                                                                             
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
  
  @endsection
@section('footer')
    <script src="{{ asset('pdfupload/pdf_up.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script> 
@endsection
