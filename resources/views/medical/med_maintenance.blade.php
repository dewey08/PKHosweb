@extends('layouts.medicalslide')
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
                                    </button> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 ms-3">
                                                
                                     
                                           @if ( $article_data->article_img == '')
                                           <img src="{{ asset('assets/images/default-image.jpg') }}" alt="Image" class="img-thumbnail" width="250px" height="150px"> 
                                           @else
                                           <img src="{{asset('storage/article/'.$article_data->article_img)}}" alt="Image" class="img-thumbnail" width="250px" height="150px">   
                                           @endif

                                           
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-2 text-end">
                                                    <label for="article_num">เลขครุภัณฑ์ </label>
                                                </div>
                                                <div class="col-md-4"> 
                                                    <label for="article_num">{{$article_data->article_num}} </label>
                                                </div> 
                                                <div class="col-md-2 text-end">
                                                    <label for="article_recieve_date">วันที่รับเข้า </label>
                                                </div>
                                                <div class="col-md-4"> 
                                                    <label for="article_recieve_date">{{ DateThai($article_data->article_recieve_date)}} </label>
                                                </div>  
                                            </div>  
                                            <div class="row mt-3">
                                                <div class="col-md-2 text-end">
                                                    <label for="article_name">ชื่อครุภัณฑ์ </label>
                                                </div>
                                                <div class="col-md-4"> 
                                                    <label for="article_name">{{$article_data->article_name}} </label>
                                                </div> 
                                                <div class="col-md-2 text-end">
                                                    <label for="article_price">ราคา </label>
                                                </div>
                                                <div class="col-md-4"> 
                                                    <label for="article_price"> {{ number_format($article_data->article_price, 2) }} ฿</label>
                                                </div>  
                                            </div>  
                                            <div class="row mt-3">
                                                <div class="col-md-2 text-end">
                                                    <label for="DEPARTMENT_SUB_SUB_NAME">ประจำหน่วยงาน </label>
                                                </div>
                                                <div class="col-md-4"> 
                                                    <label for="DEPARTMENT_SUB_SUB_NAME">{{$article_data->DEPARTMENT_SUB_SUB_NAME}} </label>
                                                </div>  
                                            </div>  
                                            <div class="row mt-3">
                                                <div class="col-md-2 text-end">
                                                    <label for="brand_name">ยี่ห้อ </label>
                                                </div>
                                                <div class="col-md-4"> 
                                                    <label for="brand_name">{{$article_data->brand_name}} </label>
                                                </div> 
                                                <div class="col-md-2 text-end">
                                                    <label for="article_status_name">สถานะ </label>
                                                </div>
                                                <div class="col-md-4"> 
                                                    <label for="article_status_name">{{$article_data->article_status_name}} </label>
                                                </div>  
                                            </div>  
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>


                        <!-- Pills navs -->
                        <ul class="nav nav-pills" id="ex1" role="tablist">

                            <li class="nav-item" role="presentation">
                                <a class="nav-link active shadow me-1 mt-2"
                                    href="{{ url('book/bookmake_index_send') }}">
                                    <i class="fa-solid fa-clipboard-list me-1 text-warning"></i> 
                                    <label class="xl">รายการสอบเทียบ</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_deb' ) }}"> 
                                    <i class="fa-solid fa-list-check me-1 text-danger"></i>
                                    <label class="xl ">รายการบำรุงรักษา</label>  </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_debsub') }}"> 
                                    <i class="fa-solid fa-list-check me-1 text-info"></i>
                                    <label class="xl">แผนสอบเทียบ</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_person') }}">
                                    <i class="fa-solid fa-list-check me-1 text-success"></i>
                                    <label class="xl">แผนบำรุงรักษา</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_team') }}">
                                    <i class="fa-solid fa-list-check me-1 text-primary"></i> 
                                    <label class="xl">ตรวจเช็คบำรุงรักษา(PM)</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_fileplus') }}"> 
                                    <i class="fa-solid fa-swatchbook me-1 text-secondary"></i>
                                    <label class="xl">สอบเทียบคุณภาพ(CAL)</label> </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link me-1 ms-1 mt-2" style="background-color: rgb(231, 227, 227)"
                                    href="{{ url('book/bookmake_index_send_open' ) }}"> 
                                    <i class="fa-solid fa-tachograph-digital me-1 text-info"></i> 
                                    <label class="xl">ประวัติการซ่อม(CM)</label> </a>
                            </li>
                            
                        </ul>
                        <!-- Pills navs -->
                        <!-- Pills content -->
                        <div class="tab-content" id="ex1-content">                           
                            <div class="tab-pane fade show active" id="ex1-pills-8" role="tabpanel" aria-labelledby="ex1-tab-8">
                                
                                {{-- <form action="{{ route('book.bookmake_index_senddep') }}" id="Save_senddep" method="POST">
                                @csrf --}}
                                <div class="row text-center">
                                    <div class="col"></div>
                                    <input type="hidden" name="article_id" id="article_id" value=" {{ $article_data->article_id }}">
                                    <input type="hidden" id="user_id" name="user_id"
                                        value=" {{ Auth::user()->id }}">
                                    <div class="col-md-2 mt-3 mb-3 text-end">
                                        <div class="form-group">
                                            <label for="">รายการสอบเทียบ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-3 mb-3">
                                        <div class="form-group">
                                            <input type="text" id="UNIT_INSERT" name="UNIT_INSERT" class="form-control form-control-sm shadow" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-1 mt-3 mb-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-sm shadow">
                                                <i class="fa-solid fa-folder-plus me-2"></i>
                                                เพิ่ม
                                            </button>

                                        </div>
                                    </div>
                                    <div class="col"></div>
                                </div>
                            {{-- </form> --}}
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-sm myTable"
                                            style="width: 100%;" id="example">
                                            <thead>
                                                <tr height="10px">
                                                    <th width="5%" class="text-center">ลำดับ</th>
                                                    <th class="text-center">รายการสอบเทียบ</th> 
                                                    <th width="10%" class="text-center">จัดการ</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                <?php $num = 1;
                                                $date = date('Y'); ?>
                                                @foreach ($book_senddep as $item2)
                                                    <tr id="sid{{ $item2->senddep_id }}">
                                                        <td class="text-center" width="5%">
                                                            {{ $num++ }}</td>
                                                        <td class="p-2">
                                                            {{ $item2->senddep_dep_name }}</td>
                                                        <td class="p-2">
                                                            {{ $item2->objective_name }}</td>
                                                        <td class="text-center" width="10%">

                                                            <a class="text-danger" href="javascript:void(0)"
                                                                onclick="bookdep_destroy({{ $item2->senddep_id }})"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip"
                                                                title="ลบ">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
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
  
  @endsection
@section('footer')
    <script src="{{ asset('pdfupload/pdf_up.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script> 
@endsection
