@extends('layouts.staff')
@section('title', 'ZOFFice || Dashboard-Staff')

@section('menu')
<style>
  .btn{
     font-size:15px;
   }
</style>
    <div class="px-3 py-2 border-bottom">
        <div class="container"> 
        {{-- <a href="{{url("staff/home")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-secondary btn-sm text-white shadow me-2">Dashboard</a>   --}}
        <div class="text-end">
            {{-- <a type="button" class="btn btn-light text-dark me-2">Login</a> --}}
            <a href="{{url("setting/setting_index")}}" class="btn btn-danger btn-sm text-white shadow">ตั้งค่าข้อมูล</a>
        </div>
        </div>
    </div>
@endsection
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
<div class="container ">
    <div class="row mt-3">
        <div class="col-6 col-md-4 col-xl-2 mt-3">  
              <div class="card">
                  <div class="card-body shadow-lg">          
                      <a href="{{url("staff/home")}}" class="nav-link text-dark text-center">
                        <i class="fa-solid fa-3x fa-chart-line text-warning"></i>
                        <br>
                        <label for="" class="mt-2">Dashboard</label>
                      </a>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mt-3">   
          <div class="card">
            <div class="card-body shadow-lg">         
          <a href="{{url("person/person_index")}}" class="nav-link text-dark text-center">
            <i class="fa-solid fa-3x fa-user-tie text-primary "></i><br>
             <label for="" class="mt-2">บุคคลากร</label>
          </a>
        </div>
      </div>
    </div>
        <div class="col-6 col-md-4 col-xl-2 mt-3"> 
          <div class="card">
            <div class="card-body shadow-lg">           
          <a href="{{url("book/bookmake_index")}}" class="nav-link text-dark text-center">
            <i class="fa-solid fa-3x fa-book-open-reader text-secondary"></i>
            <br>
             <label for="" class="mt-2">สารบรรณ</label>
          </a>
        </div>
      </div>
    </div>
        <div class="col-6 col-md-4 col-xl-2 mt-3">    
          <div class="card">
            <div class="card-body shadow-lg">        
          <a href="{{url("car/car_narmal_calenda")}}" class="nav-link text-dark text-center"> 
            <i class="fa-solid fa-3x fa-truck-medical text-info"></i>
            <br>
             <label for="" class="mt-2">ยานพาหนะ</label>
          </a>
        </div>
      </div>
    </div>
        <div class="col-6 col-md-4 col-xl-2 mt-3">  
          <div class="card">
            <div class="card-body shadow-lg">         
            <a href="{{url("meetting/meettingroom_dashboard")}}" class="nav-link text-dark text-center">
              <i class="fa-solid fa-3x fa-house-laptop text-success"></i>             
              <br>
              <label for="" class="mt-2">ห้องประชุม</label>
            </a>
        </div>
      </div>

    </div>
        <div class="col-6 col-md-4 col-xl-2 mt-3">  
          <div class="card">
            <div class="card-body shadow-lg">          
            <a href="#" class="nav-link text-dark text-center">
              <i class="fa-solid fa-3x fa-screwdriver-wrench text-info"></i>
              <br>
               <label for="" class="mt-2">ซ่อมบำรุง</label>
            </a>
        </div>
      </div>
         
  </div>
</div>
    <div class="row mt-3">
      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
            <div class="card-body shadow-lg">          
              <a href="{{url('computer/com_staff_calenda')}}" class="nav-link text-dark text-center">
                <i class="fa-solid fa-3x fa-computer text-secondary"></i>
                <br>
                <label for="" class="mt-2">คอมพิวเตอร์</label>
              </a>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-xl-2 mt-3"> 
        <div class="card">
          <div class="card-body shadow-lg">  
                <a href="{{url('medical/med_dashboard')}}" class="nav-link text-dark text-center">
                  <i class="fa-solid fa-3x fa-pump-medical text-warning"></i> 
                  <br>
                  <label for="" class="mt-2">เครื่องมือแพทย์</label>
                </a> 
            </div>
          </div>
      </div>
      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
          <div class="card-body shadow-lg">          
            <a href="{{url('housing/housing_dashboard')}}" class="nav-link text-dark text-center"> 
              <i class="fa-solid fa-3x fa-house-chimney-user text-info"></i>
              <br>
              <label for="" class="mt-2">บ้านพัก</label>
            </a>
        </div>
      </div>
    </div>

      <div class="col-6 col-md-4 col-xl-2 mt-3">   
        <div class="card">
          <div class="card-body shadow-lg">          
            <a href="{{url("supplies/supplies_index")}}" class="nav-link text-dark text-center"> 
              <i class="fa-solid fa-3x fa-clipboard text-danger"></i>
              <br>
              <label for="" class="mt-2"> แผนงาน</label>
            </a>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-xl-2 mt-3">   
        <div class="card">
          <div class="card-body shadow-lg">          
            <a href="{{url("article/article_dashboard")}}" class="nav-link text-dark text-center">
              {{-- <i class="fa-solid fa-3x fa-boxes-packing text-secondary"></i> --}}
              <i class="fa-solid fa-3x fa-building-shield text-secondary"></i>
              <br>
              <label for="" class="mt-2"> ทรัพย์สิน</label>
            </a>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-xl-2 mt-3">   
        <div class="card">
          <div class="card-body shadow-lg">          
            <a href="{{url("supplies/supplies_dashboard")}}" class="nav-link text-dark text-center">  
              <i class="fa-solid fa-3x fa-paste text-success"></i>
              <br>
              <label for="" class="mt-2"> พัสดุ</label>
            </a>
          </div>
        </div>
      </div>
        
       

      </div>

    <div class="row mt-3">

      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
          <div class="card-body shadow-lg">          
          <a href="#" class="nav-link text-dark text-center"> 
            <i class="fa-solid fa-3x fa-shop-lock text-primary"></i>
            <br>
             <label for="" class="mt-2">คลังวัสดุ</label>
          </a>
      </div>
    </div>
  </div>
      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
          <div class="card-body shadow-lg">          
        <a href="#" class="nav-link text-dark text-center">
          <i class="fa-solid fa-3x fa-prescription text-success"></i> 
          <br>
           <label for="" class="mt-2">คลังยา</label>
        </a>
      </div>
  </div>         
  </div>
      <div class="col-6 col-md-4 col-xl-2 mt-3">   
        <div class="card">
          <div class="card-body shadow-lg">         
              <a href="#" class="nav-link text-dark text-center">
                <i class="fa-solid fa-3x fa-person-booth text-danger"></i>  
                <br>
              <label for="" class="mt-2">จ่ายกลาง</label>                
              </a>
          </div>
        </div>
      </div>
       
      
        {{-- <div class="col-6 col-md-4 col-xl-2">  
          <div class="card">
            <div class="card-body shadow-lg">          
            <a href="#" class="nav-link text-dark text-center">
              <i class="fa-solid fa-3x fa-prescription text-success"></i> 
              <br>
              <label for="" class="mt-2">คลังยา</label>
            </a>
            </div>
        </div>         
      </div>
        <div class="col-6 col-md-4 col-xl-2">  
          <div class="card">
            <div class="card-body shadow-lg">          
              <a href="#" class="nav-link text-dark text-center">
                <i class="fa-solid fa-3x fa-computer text-secondary"></i>
                <br>
                <label for="" class="mt-2">คอมพิวเตอร์</label>
              </a>
          </div>
        </div>
      </div> --}}
        {{-- <div class="col-6 col-md-4 col-xl-2"> 
          <div class="card">
            <div class="card-body shadow-lg">  
                  <a href="#" class="nav-link text-dark text-center">
                    <i class="fa-solid fa-3x fa-pump-medical text-warning"></i> 
                    <br>
                    <label for="" class="mt-2">เครื่องมือแพทย์</label>
                  </a> 
              </div>
            </div>
        </div>
       
        <div class="col-6 col-md-4 col-xl-2">   
          <div class="card">
            <div class="card-body shadow-lg">         
              <a href="#" class="nav-link text-dark text-center">
                <i class="fa-solid fa-3x fa-person-booth text-danger"></i>  
                <br>
              <label for="" class="mt-2">จ่ายกลาง</label>
                
              </a>
          </div>
        </div> --}}

    </div>



</div>
@endsection
