@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER || ช้อมูลการจองห้องประชุม')
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
</style>
{{-- <div class="container-fluid" >
  <div class="px-0 py-0 mb-2">
    <div class="d-flex flex-wrap justify-content-center">  
      <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>
    
      <div class="text-end"> 
        <a href="{{url('user_meetting/meetting_calenda')}}" class="btn btn-light btn-sm text-dark me-2">ปฎิทิน</a>
        <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-light btn-sm text-dark me-2">ช้อมูลการจองห้องประชุม</a>
        <a href="{{url('user_meetting/meetting_add')}}" class="btn btn-info btn-sm text-white me-2">จองห้องประชุม</a> 
      </div>
    </div>
  </div> --}}
  <div class="tabs-animation">
    
    <div class="row text-center">  
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
          
    </div> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
               
                <div class="card-body">  
                    <div class="row">
                          @foreach ( $building_level_room as $items )
                         
                              <div class="col-md-6 mt-3">
                                <div class="card shadow-lg">
                                  <label for="" class="text-center mt-3">{{$items->room_name}}</label>
                                      <div class="bg-image hover-overlay ripple text-center mb-4">
                                            <a href="{{url('user_meetting/meetting_choose/'.$items->room_id)}}">
                                                  <img src="{{asset('storage/meetting/'.$items->room_img)}}" height="auto" width="auto" alt="Image" class="img-thumbnail"> 
                                                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                                            </a>                                
                                      </div>
                                </div>
                              </div>
                          @endforeach                   
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')

@endsection

