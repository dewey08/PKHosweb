@extends('layouts.user')
@section('title','ZOffice || ผู้ใช้งานทั่วไป')
@section('content')

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
      use App\Http\Controllers\UsersuppliesController;
            use App\Http\Controllers\StaticController;
            use App\Models\Products_request_sub;
        
            $refnumber = UsersuppliesController::refnumber();    
            $checkhn = StaticController::checkhn($iduser);
            $checkhnshow = StaticController::checkhnshow($iduser);
            $count_suprephn = StaticController::count_suprephn($iduser);
            $count_bookrep_rong = StaticController::count_bookrep_rong();
            $count_bookrep_po = StaticController::count_bookrep_po();
            $countpesmiss_per = StaticController::countpesmiss_per($iduser);
            $countpesmiss_book = StaticController::countpesmiss_book($iduser);
            $countpesmiss_car = StaticController::countpesmiss_car($iduser);
            $countpesmiss_meetting = StaticController::countpesmiss_meetting($iduser);
            $countpesmiss_repair = StaticController::countpesmiss_repair($iduser);
            $countpesmiss_com = StaticController::countpesmiss_com($iduser);
            $countpesmiss_medical = StaticController::countpesmiss_medical($iduser);
            $countpesmiss_hosing = StaticController::countpesmiss_hosing($iduser);
            $countpesmiss_plan = StaticController::countpesmiss_plan($iduser);
            $countpesmiss_asset = StaticController::countpesmiss_asset($iduser);
            $countpesmiss_supplies = StaticController::countpesmiss_supplies($iduser);
            $countpesmiss_store = StaticController::countpesmiss_store($iduser);
            $countpesmiss_store_dug = StaticController::countpesmiss_store_dug($iduser);
            $countpesmiss_pay = StaticController::countpesmiss_pay($iduser);
  ?>
@section('menu')
<style>
      body{
          font-size:14px;
      }
      .btn{
        font-size:15px;
      }
    
      .page{
            width: 90%;
            margin: 10px;
            box-shadow: 0px 0px 5px #000;
            animation: pageIn 1s ease;
            transition: all 1s ease, width 0.2s ease;
        }
        @keyframes pageIn{
        0%{
            transform: translateX(-300px);
            opacity: 0;
        }
        100%{
            transform: translateX(0px);
            opacity: 1;
        }
        }

</style>
   
@endsection
{{-- 
<div class="container-fluid " style="width: 97%">
  <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">                    
                    {{ __('You are logged in!  USER_INDEX') }}    
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saexampleModal">
                         PAGE user_index 2321232131 หหหหหหหห
                      </button>                      
           
                      <div class="modal fade" id="saexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              ...
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>

                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="container ">
  <div class="row mt-3">
      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
          <div class="card-body shadow-lg">          
        <a href="" class="nav-link text-dark text-center">
          <i class="fa-solid fa-3x fa-chart-line text-warning"></i>
          <br>
           <label for="" class="mt-2">Dashboard</label>
        </a>
      </div>
    </div>
  </div>
 
  @if ($countpesmiss_per != 0)  
      <div class="col-6 col-md-4 col-xl-2 mt-3">   
        <div class="card">
          <div class="card-body shadow-lg">         
        <a href="{{url("person/person_index")}}" class="nav-link text-dark text-center" target="_blank">
          <i class="fa-solid fa-3x fa-user-tie text-primary "></i><br>
           <label for="" class="mt-2">บุคคลากร</label>
        </a>
      </div>
    </div>
  </div>
  @endif

  @if ($countpesmiss_book != 0) 
      <div class="col-6 col-md-4 col-xl-2 mt-3"> 
        <div class="card">
          <div class="card-body shadow-lg">           
        <a href="{{url("book/bookmake_index")}}" class="nav-link text-dark text-center" target="_blank"> 
          <i class="fa-solid fa-3x fa-book-open-reader text-secondary"></i>
          <br>
           <label for="" class="mt-2">สารบรรณ</label>
        </a>
      </div>
    </div>
  </div>
  @endif
  @if ($countpesmiss_car != 0) 
      <div class="col-6 col-md-4 col-xl-2 mt-3">    
        <div class="card">
          <div class="card-body shadow-lg">        
        <a href="{{url("car/car_narmal_index")}}" class="nav-link text-dark text-center" target="_blank"> 
          <i class="fa-solid fa-3x fa-truck-medical text-info"></i>
          <br>
           <label for="" class="mt-2">ยานพาหนะ</label>
        </a>
      </div>
    </div>
  </div>
  @endif
  @if ($countpesmiss_meetting != 0) 
      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
          <div class="card-body shadow-lg">         
          <a href="{{url("meetting/meettingroom_dashboard")}}" class="nav-link text-dark text-center" target="_blank">
            <i class="fa-solid fa-3x fa-house-laptop text-success"></i>             
            <br>
            <label for="" class="mt-2">ห้องประชุม</label>
          </a>
      </div>
    </div>
  </div>
  @endif
  @if ($countpesmiss_repair != 0) 
      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
          <div class="card-body shadow-lg">          
          <a href="#" class="nav-link text-dark text-center" target="_blank">
            <i class="fa-solid fa-3x fa-screwdriver-wrench text-info"></i>
            <br>
             <label for="" class="mt-2">ซ่อมบำรุง</label>
          </a>
      </div>
    </div>       
</div>
@endif
</div>
  <div class="row mt-3">
    @if ($countpesmiss_com != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">  
      <div class="card">
          <div class="card-body shadow-lg">          
            <a href="{{url('computer/com_dashboard')}}" class="nav-link text-dark text-center" target="_blank">
              <i class="fa-solid fa-3x fa-computer text-secondary"></i>
              <br>
              <label for="" class="mt-2">คอมพิวเตอร์</label>
            </a>
        </div>
      </div>
    </div>
    @endif

    @if ($countpesmiss_medical != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3"> 
      <div class="card">
        <div class="card-body shadow-lg">  
              <a href="{{url('medical/med_dashboard')}}" class="nav-link text-dark text-center" target="_blank">
                <i class="fa-solid fa-3x fa-pump-medical text-warning"></i> 
                <br>
                <label for="" class="mt-2">เครื่องมือแพทย์</label>
              </a> 
          </div>
        </div>
    </div>
    @endif

    @if ($countpesmiss_hosing != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">  
      <div class="card">
        <div class="card-body shadow-lg">          
          <a href="{{url('housing/housing_dashboard')}}" class="nav-link text-dark text-center" target="_blank"> 
            <i class="fa-solid fa-3x fa-house-chimney-user text-info"></i>
            <br>
            <label for="" class="mt-2">บ้านพัก</label>
          </a>
      </div>
    </div>
  </div>
@endif

@if ($countpesmiss_plan != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">   
      <div class="card">
        <div class="card-body shadow-lg">          
          <a href="{{url("supplies/supplies_index")}}" class="nav-link text-dark text-center" target="_blank"> 
            <i class="fa-solid fa-3x fa-clipboard text-danger"></i>
            <br>
            <label for="" class="mt-2"> แผนงาน</label>
          </a>
        </div>
      </div>
    </div>
    @endif

    @if ($countpesmiss_supplies != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">   
      <div class="card">
        <div class="card-body shadow-lg">          
          <a href="{{url("article/article_dashboard")}}" class="nav-link text-dark text-center" target="_blank">
            {{-- <i class="fa-solid fa-3x fa-boxes-packing text-secondary"></i> --}}
            <i class="fa-solid fa-3x fa-building-shield text-secondary"></i>
            <br>
            <label for="" class="mt-2"> ทรัพย์สิน</label>
          </a>
        </div>
      </div>
    </div>
@endif

    @if ($countpesmiss_store != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">   
      <div class="card">
        <div class="card-body shadow-lg">          
          <a href="{{url("supplies/supplies_dashboard")}}" class="nav-link text-dark text-center" target="_blank">  
            <i class="fa-solid fa-3x fa-paste text-success"></i>
            <br>
            <label for="" class="mt-2"> พัสดุ</label>
          </a>
        </div>
      </div>
    </div>
    @endif
     

    </div>

  <div class="row mt-3">

    @if ($countpesmiss_store != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">  
      <div class="card">
        <div class="card-body shadow-lg">          
        <a href="#" class="nav-link text-dark text-center" target="_blank"> 
          <i class="fa-solid fa-3x fa-shop-lock text-primary"></i>
          <br>
           <label for="" class="mt-2">คลังวัสดุ</label>
        </a>
    </div>
  </div>
</div>
@endif

@if ($countpesmiss_store_dug != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">  
      <div class="card">
        <div class="card-body shadow-lg">          
      <a href="#" class="nav-link text-dark text-center" target="_blank">
        <i class="fa-solid fa-3x fa-prescription text-success"></i> 
        <br>
         <label for="" class="mt-2">คลังยา</label>
      </a>
    </div>
</div>         
</div>
@endif

@if ($countpesmiss_pay != 0) 
    <div class="col-6 col-md-4 col-xl-2 mt-3">   
      <div class="card">
        <div class="card-body shadow-lg">         
            <a href="#" class="nav-link text-dark text-center" target="_blank">
              <i class="fa-solid fa-3x fa-person-booth text-danger"></i>  
              <br>
            <label for="" class="mt-2">จ่ายกลาง</label>                
            </a>
        </div>
      </div>
    </div>
    @endif
    
     

  </div>



</div>
@endsection
