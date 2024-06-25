@extends('layouts.timesystem')
@section('title', 'PK-OFFICER || DASHBOARD')
  

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
               border-top: 10px rgb(212, 106, 124) solid;
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
        
        <div class="row">
            
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">OPD ThaiRefer 1 Month</p>   
                                                    <h4 class="text-start mb-2">1111 Visit</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
                                    </div>                                           
                                </div>  
                            </div>                                           
                        </div> 
                    </div> 
                </div> 

                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">ข้อสะโพกย้อนหลัง 1เดือน</p>                                                    
                                                    <h4 class="text-start mb-2">11111 Visit</h4>                                                        
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
                                    </div>                                           
                                </div>  
                            </div>                                           
                        </div> 
                    </div> 
                </div>

                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">แผ่นโลหะกระดูกย้อนหลัง 1เดือน</p>                                                    
                                                    <h4 class="text-start mb-2">1111 Visit</h4>                                                        
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="" target="_blank">
                                                        <span class="avatar-title bg-light text-danger rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
                                    </div>                                           
                                </div>  
                            </div>                                           
                        </div> 
                    </div> 
                </div> 
                
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">ข้อเข่าย้อนหลัง 1เดือน</p>                                                    
                                                    <h4 class="text-start mb-2">1111 Visit</h4>                                                        
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning avatar-title bg-light text-primary rounded-3">
                                                                    <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                    Detail
                                                                </button> 
                                                            </p>
                                                        </span> 
                                                    </a>
                                                </div>
                                            </div> 
                                    </div>                                           
                                </div>  
                            </div>                                           
                        </div> 
                    </div> 
                </div>                     
                            
        </div>

        <div class="row">
            
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">OPD ThaiRefer 1 Month</p>   
                                                <h4 class="text-start mb-2">1111 Visit</h4>                                                         
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                Detail
                                                            </button> 
                                                        </p>
                                                    </span> 
                                                </a>
                                            </div>
                                        </div> 
                                </div>                                           
                            </div>  
                        </div>                                           
                    </div> 
                </div> 
            </div> 

            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">ข้อสะโพกย้อนหลัง 1เดือน</p>                                                    
                                                <h4 class="text-start mb-2">11111 Visit</h4>                                                        
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger avatar-title bg-light text-primary rounded-3">
                                                                <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                Detail
                                                            </button> 
                                                        </p>
                                                    </span> 
                                                </a>
                                            </div>
                                        </div> 
                                </div>                                           
                            </div>  
                        </div>                                           
                    </div> 
                </div> 
            </div>
            
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">แผ่นโลหะกระดูกย้อนหลัง 1เดือน</p>                                                    
                                                <h4 class="text-start mb-2">1111 Visit</h4>                                                        
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="" target="_blank">
                                                    <span class="avatar-title bg-light text-danger rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success avatar-title bg-light text-primary rounded-3">
                                                                <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                Detail
                                                            </button> 
                                                        </p>
                                                    </span> 
                                                </a>
                                            </div>
                                        </div> 
                                </div>                                           
                            </div>  
                        </div>                                           
                    </div> 
                </div> 
            </div> 
            
            {{-- <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">ข้อเข่าย้อนหลัง 1เดือน</p>                                                    
                                                <h4 class="text-start mb-2">1111 Visit</h4>                                                        
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button type="button" class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning avatar-title bg-light text-primary rounded-3">
                                                                <i class="pe-7s-search btn-icon-wrapper font-size-24 mt-3"></i>
                                                                Detail
                                                            </button> 
                                                        </p>
                                                    </span> 
                                                </a>
                                            </div>
                                        </div> 
                                </div>                                           
                            </div>  
                        </div>                                           
                    </div> 
                </div> 
            </div>                      --}}
                        
    </div>

           
       
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
