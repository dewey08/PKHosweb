@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
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
           border-top: 10px #1fdab1 solid;
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
           .align3{  
            text-align: center;  //ข้อความตรงกลาง
}

</style>
<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
$datenow = date('Y-m-d');
?>

@section('content')



<div class="container-fluid" style="width: 100%">
    <div class="row ">
        <div class="col-md-4">
            <h2 class="card-title">ประเภทบ่อบำบัด</h2>
            <p class="card-title-desc"></p>
        </div>
    </div>

    <div class="row" >  
        <div class="col"></div>

        <div class="col-md-3 ">
            <div class="card card_audit_4 main-card mb-3 card shadow" style="height: 300px " >

                <div class="card card_audit_4 card-header ">
                    <div class=" d-flex ">                        
                        <div class="card-body p-3">
                            <label for=""> บ่อปรับเสถียร </label>
                        </div> 
                        <div class="ms-auto">
                        </div>                           
                    </div>                            
                </div> 
                <div class="member-img text-center">
                    <a href="{{url('env_water_add_pond1/1')}}" target="_blank"> <img src="{{ asset('medical/assets/img/pond1.jpg') }}" height="150px" width="150px" class="rounded-circle me-3"> </a>                     
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card_audit_4 main-card mb-3 card shadow" style="height: 300px">                 
                <div class="card card_audit_4 card-header">
                    <div class="d-flex">
                        <div class="card-body p-3">
                            <label for=""> บ่อคลองวนเวียน </label>
                        </div>
                        <div class="ms-auto">
                        </div>                                   
                    </div>                            
                </div>
                <div class="member-img text-center">
                    <a href="{{url('env_water_add_pond2/2')}}" target="_blank"> <img src="{{ asset('medical/assets/img/pond2.jpg') }}" height="150px" width="150px" class="rounded-circle me-3"> </a>
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card_audit_4 main-card mb-3 card shadow" style="height: 300px">                 
                <div class="card card_audit_4 card-header">
                    <div class="d-flex">
                        <div class="card-body p-3">
                            <label for=""> บ่อสัมผัสคลอลีน </label>
                        </div>
                        <div class="ms-auto">
                        </div>                                   
                    </div>                            
                </div>
                <div class="member-img text-center">
                    <a href="{{url('env_water_add_pond3/3')}}" target="_blank"> <img src="{{ asset('medical/assets/img/pond3.jpg') }}" height="150px" width="150px" class="rounded-circle me-3"> </a>
                </div> 
            </div>
        </div> 

        <div class="col"></div>

    </div>
</div>

@endsection
@section('footer')
{{-- <script>
    
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        // ช่องค้นหาชื่อ
        $('#water_user1').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        // ช่องค้นหาชื่อ
            $('#env_pond').select2({
            placeholder: "--เลือก--",
            allowClear: true
        }); 
       
       
    });
</script> --}}

@endsection
