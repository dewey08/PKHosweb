@extends('layouts.meettingnew')
@section('title', 'PK-OFFICER || ห้องประชุม')
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
               border: 5px #ddd solid;
               border-top: 10px #24e373 solid;
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
    <div class="tabs-animation">
    
        <div class="row text-center">   
              
              <div id="preloader">
                <div id="status">
                    <div class="spinner">
                        
                    </div>
                </div>
            </div>
        </div> 
       
        <div class="main-card mb-3 card"> 
            <div class="card-header">               
                <div class="btn-actions-pane-right">
                    <div class="nav"> 
                        {{-- <a href="{{ url('time_dep') }}" class="btn-pill btn-wide btn btn-outline-alternate btn-sm">กลุ่มภารกิจ</a>
                        <a href="{{ url('time_depsub') }}" class="btn-pill btn-wide me-1 ms-1 active btn btn-outline-alternate btn-sm">กลุ่มงาน/ฝ่าย</a>
                        <a href="{{ url('time_depsubsub') }}" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm">หน่วยงาน</a> --}}
                    </div>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
    
    @endsection
    @section('footer')

    <script>
        
        $(document).ready(function() { 
    
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
    
            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });
      
    
            $("#spinner-div").hide(); //Request is complete so hide spinner
      
        });
    </script>
    
    @endsection
