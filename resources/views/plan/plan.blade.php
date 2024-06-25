@extends('layouts.plannew')
@section('title','PK-OFFICER || Plan')
@section('content')
<style>
    .table th {
        font-family: sans-serif;
        font-size: 12px;
    }
    .table td {
        font-family: sans-serif;
        font-size: 12px;
    }
</style>
<?php
     use App\Http\Controllers\karnController;
     use Illuminate\Support\Facades\DB; 
 ?>
 
        <div class="tabs-animation">
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div> 
            </div> 
            <div id="preloader">
                <div id="status">
                    <div class="spinner"> 
                    </div>
                </div>
            </div>
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Detail Plan</h4>
            
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Detail Plan</a></li>
                                    <li class="breadcrumb-item active">Plan</li>
                                </ol>
                            </div>
            
                        </div>
                    </div>
                </div> 
            </div> 

        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">                     
                    <div class="card-body p-4">  
                        <img src="{{ asset('images/p1.png') }}" height="500px" width="auto" class="rounded mx-auto d-block">                                             
                    </div>                    
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">                     
                    <div class="card-body p-4">  
                        <img src="{{ asset('images/p2.png') }}" height="500px" width="auto" class="rounded mx-auto d-block">                                             
                    </div>                    
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">                     
                    <div class="card-body p-4">  
                        <img src="{{ asset('images/p3.png') }}" height="500px" width="auto" class="rounded mx-auto d-block">                                             
                    </div>                    
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">                     
                    <div class="card-body p-4">  
                        <img src="{{ asset('images/p4.png') }}" height="500px" width="auto" class="rounded mx-auto d-block">                                             
                    </div>                    
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">                     
                    <div class="card-body p-4">  
                        <img src="{{ asset('images/p5.png') }}" height="500px" width="auto" class="rounded mx-auto d-block">                                             
                    </div>                    
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">                     
                    <div class="card-body p-4">  
                        <img src="{{ asset('images/p6.png') }}" height="500px" width="auto" class="rounded mx-auto d-block">                                             
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
                $('#example3').DataTable();

                $('select').select2();
                $('#ECLAIM_STATUS').select2({
                    dropdownParent: $('#detailclaim')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                              
            });
           
        </script>    
       
    @endsection
