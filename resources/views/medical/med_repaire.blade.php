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
  use App\Http\Controllers\MedicalController;
    $refnumber = MedicalController::refnumber();
    date_default_timezone_set('Asia/Bangkok');
$date = date('Y') + 543;
$datefull = date('Y-m-d H:i:s');
$time = date("H:i:s");
$loter = $date.''.$time
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
                            <div class="p-2" style="font-size: 14px"> ส่งซ่อมเครื่องมือแพทย์</div>

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
                                {{-- <div class="card"> --}}
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 ms-3">                                                                                     
                                           @if ( $article_data->article_img == Null )
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
                                                <div class="col-md-10"> 
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

                                    <input type="hidden" name="medical_repaire_article_id" id="medical_repaire_article_id" value="{{$article_data->article_id}}">
                                    <input type="hidden" name="medical_repaire_users_id" id="medical_repaire_users_id" value="{{$iduser}}">

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_num">เลขที่ส่ง </label>
                                        </div>
                                        <div class="col-md-4">  
                                            <input type="text" id="medical_repaire_rep" name="medical_repaire_rep" class="form-control form-control-sm" value="{{$refnumber}}" />
                                        </div> 
                                        <div class="col-md-2 text-end">
                                            <label for="article_recieve_date">วันที่ส่ง </label>
                                        </div>
                                        <div class="col-md-4"> 
                                            <input type="datetime-local" id="medical_repaire_date" name="medical_repaire_date" class="form-control form-control-sm" value="{{$datefull}}" readonly/>
                                        </div>  
                                        
                                    </div>  
                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="medical_repaire_vender">ส่งซ่อมที่ร้าน </label>
                                        </div>
                                        <div class="col-md-4">  
                                            <input type="text" id="medical_repaire_vender" name="medical_repaire_vender" class="form-control form-control-sm" />
                                        </div> 
                                        <div class="col-md-2 text-end">
                                            <label for="medical_repaire_userrep">ผู้รับซ่อม </label>
                                        </div>
                                        <div class="col-md-4"> 
                                            <input type="text" id="medical_repaire_userrep" name="medical_repaire_userrep" class="form-control form-control-sm"/>
                                        </div>  
                                    </div>  

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="medical_repaire_because">เหตุผลที่ส่งซ่อม </label>
                                        </div>
                                        <div class="col-md-10">   
                                            <textarea class="form-control" name="medical_repaire_because" id="medical_repaire_because" rows="2"></textarea>
                                        </div> 
                                        
                                    </div>  

                                    <div class="row mt-3"> 
                                        <div class="col-md-2 text-end">
                                            <label for="medical_repaire_listgo">อุปกรณ์ที่ติดไปด้วย </label>
                                        </div>
                                        <div class="col-md-10"> 
                                            <textarea class="form-control" name="medical_repaire_listgo" id="medical_repaire_listgo" rows="2"></textarea>
                                             
                                        </div>  
                                    </div>  


                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                {{-- <button type="submit" class="btn btn-primary btn-sm"> --}}
                                <button type="button" id="SaveBtnmed" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <a href="{{ url('medical/med_index') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>
                            </div>
                        </div>
                    </div>
 
                </div>
            </div> 
        </div> 
    </div>    
</div> 
  
  @endsection
@section('footer')
    <script>
         $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            // $('.js-example-basic-single').select2();

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#SaveBtnmed').click(function() {
                var medical_repaire_rep = $('#medical_repaire_rep').val();
                var medical_repaire_date = $('#medical_repaire_date').val();
                var medical_repaire_vender = $('#medical_repaire_vender').val();
                var medical_repaire_userrep = $('#medical_repaire_userrep').val();
                var medical_repaire_because = $('#medical_repaire_because').val();
                var medical_repaire_listgo = $('#medical_repaire_listgo').val();
                var medical_repaire_article_id = $('#medical_repaire_article_id').val();
                var medical_repaire_users_id = $('#medical_repaire_users_id').val();
                $.ajax({
                    url: "{{ route('med.med_repaire_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        medical_repaire_rep,
                        medical_repaire_date,
                        medical_repaire_vender,
                        medical_repaire_userrep,
                        medical_repaire_because,
                        medical_repaire_listgo,
                        medical_repaire_article_id,
                        medical_repaire_users_id

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
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                        window.location="{{url('medical/med_index')}}";
                                    // window.location.reload(); 
                                }
                            })
                        } else {

                        }

                    },
                });
            });
        });
    </script>
@endsection
