<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PK-AUTHEN</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo150.ico') }}">

    <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Plugin css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body >
<br><br> 
 
    {{-- <div class="flex justify-center mt-2">
        <div class="card-body text-center">            
                        <img src="{{ asset('images/spsch.jpg') }}" alt="Image" class="img-thumbnail" width="450px" height="350px">                     
        </div>
    </div> --}}
    <div class="container">
        <div class="flex justify-center mt-4">    
            
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <img src="{{ asset('images/spsch.jpg') }}" alt="Image" class="img-thumbnail" width="600px" height="130px">
                    {{-- <img src="{{ asset('images/dataaudit.jpg') }}" alt="Image" class="img-thumbnail" width="135px" height="135px"> --}}
                    {{--   <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail" width="135px" height="135px"> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('authencode') }}" method="POST" id="insert_AuthencodeForm">
                    @csrf

                    <div class="row mt-3">
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="pid" class="form-label">เลขบัตรประชาชน :</label>                           
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3"> 
                                <label for="pid" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection1 }}</label>
                                <input type="hidden" class="form-control" id="pid" name="pid" value="{{ $collection1 }}">
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="fname" class="form-label">ชื่อ-นามสกุล :</label>                           
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3"> 
                                <label for="fname" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection2 }} {{ $collection3 }}</label>
                                <input type="hidden" class="form-control" id="fname" value="{{ $collection2 }}">
                                <input type="hidden" class="form-control" id="lname" value="{{ $collection3 }}">
                            </div>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="mainInscl" class="form-label">สิทธิหลัก :</label>                           
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3"> 
                                <label for="mainInscl" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection6 }}</label>
                                <input type="hidden" class="form-control" id="mainInscl" value="{{ $collection6 }}">
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="subInscl" class="form-label">สิทธิ์ย่อย :</label>                           
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3"> 
                                <label for="subInscl" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection7 }}</label>
                                <input type="hidden" class="form-control" id="subInscl" value="{{ $collection7 }}"> 
                            </div>
                        </div>                                
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="birthDate" class="form-label">วันเกิด :</label>                           
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3"> 
                                <label for="birthDate" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection4 }}</label>
                                <input type="hidden" class="form-control" id="birthDate" value="{{ $collection4 }}">
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="checkDate" class="form-label">อายุ :</label>                           
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3"> 
                                <label for="checkDate" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection8 }}</label>
                                <input type="hidden" class="form-control" id="checkDate" value="{{ $collection8 }}"> 
                            </div>
                        </div>                                
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="correlationId" class="form-label">correlationId :</label>                           
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3"> 
                                <label for="correlationId" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection10 }}</label>
                                <input type="hidden" class="form-control" id="correlationId" name="correlationId" value="{{ $collection10 }}">
                            </div>
                        </div>  
                        <div class="col-md-1 text-end">
                            <div class="mb-3">
                                <label for="transDate" class="form-label">transDate :</label>                           
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3"> 
                                <label for="transDate" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection5 }}</label>
                                <input type="hidden" class="form-control" id="transDate" value="{{ $collection5 }}">
                            </div>
                        </div>                                                     
                    </div>
                    <div class="row">
                        <div class="col-md-2 text-end">
                            <div class="mb-3"> 
                                <label for="claimType" class="form-label">เลือกประเภทเข้ารับบริการ :</label>   
                            </div>
                        </div>
                        <div class="col-md-10 ">
                            <div class="mb-3"> 
                                <input class="form-check-input me-3" type="radio" name="claimType" id="claimType" value="PG0060001" checked> 
                                    <label class="form-check-label" for="claimType">
                                        เข้ารับบริการรักษาทั่วไป (OPD/ IPD/ PP) 
                                    </label> 
                            </div>
                        </div>                                                                     
                    </div>
                    <div class="row">
                        <div class="col-md-2 text-end">
                            <div class="mb-3"> 
                                <label for="claimType" class="form-label"> </label>   
                            </div>
                        </div>
                        <div class="col-md-10 ">
                            <div class="mb-3"> 
                                <input class="form-check-input me-3" type="radio" name="claimType" id="claimType2" value="PG0120001"> 
                                    <label class="form-check-label" for="claimType2">
                                        UCEP PLUS (ผู้ป่วยกลุ่มอาการสีเหลืองและสีแดง) 
                                    </label>
                          
                            </div>
                        </div>                                                                     
                    </div>
                    <div class="row">
                        <div class="col-md-2 text-end">
                            <div class="mb-3"> 
                                <label for="claimType" class="form-label"> </label>   
                            </div>
                        </div>
                        <div class="col-md-10 ">
                            <div class="mb-3"> 
                                <input class="form-check-input me-3" type="radio" name="claimType" id="claimType3" value="PG0130001"> 
                                    <label class="form-check-label" for="claimType3">
                                        บริการฟอกเลือดด้วยเครื่องไตเทียม (HD) 
                                    </label>                          
                            </div>
                        </div>                                                                     
                    </div>
                        @foreach ($patient as $item)    
                            <?php
                                    $datacid = DB::connection('mysql10')->table('patient')->where('cid','=',$collection1)->first();
                                    if ($datacid->hometel == null) {
                                        $cid = '';                                    
                                    } else {
                                        $cid = $datacid->hometel;
                                    } 
                            ?>
                        @endforeach 
                    <div class="row">
                        <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <label for="mobile" class="form-label">ยืนยันเบอร์โทรศัพท์ :</label>                           
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">   
                             @if ($cid == '')
                                    <input type="text" class="form-control" id="mobile" name="mobile" >
                                @else
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{$cid}}">
                                @endif
                               
                            </div>
                        </div>   
                        <div class="col-md-1 text-end">
                            <div class="mb-3">
                                <label for="checkDate" class="form-label">checkDate :</label>                           
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">  
                                <label for="checkDate" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection11 }}</label>
                                <input type="hidden" class="form-control" id="checkDate" value="{{ $collection11 }}">
                            </div>
                        </div>                                                                            
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-md-3"> 
                                <button type="submit" class="btn btn-info shadow-lg"><i class="fa-brands fa-medrt me-2"></i>ออก Authen Code</button> 
                                <a href="{{url('/login')}}" class="btn btn-danger shadow-lg"><i class="fa-solid fa-circle-arrow-left me-2"></i>ย้อนกลับ</a>  
                                
                        </div> 
                        <div class="col"></div>
                    </div>
                </div>
            </form>
                  
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            $(document).ready(function () {
                $('#insert_AuthencodeForm').on('submit',function(e){
                  e.preventDefault();              
                  var form = this;
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {
                        
                      } else {          
                        Swal.fire({
                          title: 'ออก Authen Code สำเร็จ',
                          text: "You Get Authen Code success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            // window.location.reload();  
                            window.location="{{url('/')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                // $('#AuthenCode').click(function() {
                // var pid = $('#pid').val();
                // var claimType = $('#claimType').val();
                // var correlationId = $('#correlationId').val();
                // var hcode = $('#hcode').val(); 
 
                // $.ajax({
                //     url: "{{ route('authencode') }}",
                //     type: "POST",
                //     dataType: 'json',
                //     data: {
                //         pid,
                //         claimType,
                //         correlationId,
                //         hcode
                //     },
                //     success: function(data) {
                //         if (data.status == 200) {
                //             Swal.fire({
                //                 title: 'ออก Authen Code สำเร็จ',
                //                 text: "You Get Authen Code success",
                //                 icon: 'success',
                //                 showCancelButton: false,
                //                 confirmButtonColor: '#06D177',
                //                 confirmButtonText: 'เรียบร้อย'
                //             }).then((result) => {
                //                 if (result
                //                     .isConfirmed) {
                //                     console.log(
                //                         data);
                //                     window.location.reload();
                //                 }
                //             })
                //         } else {

                //         }

                //     },
                // });
            });
            // });
           
    </script>

</body>

</html>
