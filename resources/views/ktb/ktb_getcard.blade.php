@extends('layouts.ktbfont')
@section('title', 'PK-OFFICER || KTB')

   


@section('content')
   
    <?php  
        $ynow = date('Y')+543;
        $mo =  date('m');
    ?>  
     
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
               border-top: 10px rgb(255, 132, 152) solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(360deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
      <?php
      use App\Http\Controllers\StaticController;
      use Illuminate\Support\Facades\DB;   
      $count_meettingroom = StaticController::count_meettingroom();
  ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>  

        <div class="flex justify-center">
            <div class="row">
                <div class="col"></div>
                <div class="col-md-8">&nbsp;&nbsp;
                    <div class="card shadow-lg">
                        <div class="card-header text-center">
                            <img src="{{ asset('images/ktb.jpg') }}" alt="Image"
                                class="img-thumbnail shadow-lg me-4" width="300px" height="50px"> 
                            <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail"
                                width="100px" height="100px">
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col"></div>
                                <div class="col-md-2">&nbsp;&nbsp; 
                                    @if ($image_ == '')
                                    <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail" width="250px" height="135px">
                                    @else
                                    <img class="me-4 mt-3" src="data:image/png;base64,{{ $image_ }}" alt="Image" class="img-thumbnail" width="116px" height="135px">
                                    @endif
                                   
                                </div>

                            </div> --}}
                            <div class="row mt-5">
                                <div class="col"></div>
                                <div class="col-md-8 text-center">
                                    <div class="mb-2">

                                        @if ($smartcard == 'NO_CONNECT')
                                                <img src="http://localhost:8189/assets/images/smartcard-connected.png" alt="" width="320px"><br> <br>
                                                <p for="pid" class="form-label" style="color: rgb(197, 8, 33);font-size:30px">ไม่พบเครื่องอ่านบัตร</p>
                                            <br> 
                                        @else

                                        <div class="row mt-5">
                                            <div class="col-md-3 text-end">
                                                <div class="mb-3">
                                                    <p for="pid" class="form-label">เลขบัตรประชาชน :</p>                           
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-start">
                                                <div class="mb-3"> 
                                                    <p for="pid" class="form-label" style="color: rgb(197, 8, 33)">{{ $pid }}</p> 
                                                </div>
                                            </div>
                                                         
                                            <div class="col-md-3 text-end">
                                                <div class="mb-3">
                                                    <p for="fname" class="form-label">ชื่อ-นามสกุล : </p>                           
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-start">
                                                <div class="mb-3"> 
                                                    <p for="fname" class="form-label" style="color: rgb(197, 8, 33)">{{ $fullNameTH }} </p> 
                                                </div>
                                            </div>                    
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 text-end">
                                                <div class="mb-3">
                                                    <p for="pid" class="form-label">เกิดวันที่ :</p>                           
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-start">
                                                <div class="mb-3"> 
                                                    <p for="pid" class="form-label" style="color: rgb(197, 8, 33)">{{ $birthTH }}</p> 
                                                </div>
                                            </div>
                                                         
                                            <div class="col-md-3 text-end">
                                                <div class="mb-3">
                                                    <p for="fname" class="form-label">Date of Birth : </p>                           
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-start">
                                                <div class="mb-3"> 
                                                    <p for="fname" class="form-label" style="color: rgb(197, 8, 33)">{{ $birthEN }} </p> 
                                                </div>
                                            </div>                    
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 text-end">
                                                <div class="mb-3">
                                                    <p for="address" class="form-label">ที่อยู่ :</p>                           
                                                </div>
                                            </div>
                                            <div class="col-md-9 text-start">
                                                <div class="mb-3"> 
                                                    <p for="address" class="form-label" style="color: rgb(197, 8, 33)">{{ $address }}</p> 
                                                </div>
                                            </div>                                                              
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 text-end">
                                                <div class="mb-3">
                                                    <p for="pid" class="form-label">วันที่ออกบัตร :</p>                           
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-start">
                                                <div class="mb-3"> 
                                                    <p for="pid" class="form-label" style="color: rgb(197, 8, 33)">{{ $dateIssueTH }}</p> 
                                                </div>
                                            </div>
                                                         
                                            <div class="col-md-3 text-end">
                                                <div class="mb-3">
                                                    <p for="fname" class="form-label">Date of Birth : </p>                           
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-start">
                                                <div class="mb-3"> 
                                                    <p for="fname" class="form-label" style="color: rgb(197, 8, 33)">{{ $dateExpTH }} </p> 
                                                </div>
                                            </div>                    
                                        </div>
                                           
                                        @endif
 
                                    </div>
                                </div>
                                <div class="col"></div>
                                <div class="col-md-2"> 
                                    @if ($image_ == '')
                                    <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail" width="250px" height="135px">
                                    @else
                                    <img class="me-4 mt-3" src="data:image/png;base64,{{ $image_ }}" alt="Image" class="img-thumbnail" width="116px" height="135px">
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
        
            {{-- <div class="row">             
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12"> --}}
                                    {{-- <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">ห้องผ่าตัด</p> 
                                                    <h4 class="text-start mb-2">3222 Visit</h4> 
                                                </div>                                                    
                                                <div class="avatar-sm me-2"> 
                                                </div> 
                                                <div class="avatar-sm me-2"> 
                                                </div>
                                            </div> 
                                    </div>--}}
                                {{-- </div>  
                            </div>                                           
                        </div> 
                    </div> 
                </div> 
            </div> --}}
 
       
    </div>
  

    @endsection
    @section('footer')
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
              
        });
    </script>
    @endsection
