@extends('layouts.admin')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    .chartMenu {
        width: 100vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(255, 26, 104, 1);
    }

    .chartMenu p {
        padding: 10px;
        font-size: 20px;
    }

    .chartCard {
        width: 100vw;
        height: calc(100vh - 40px);
        background: rgba(255, 26, 104, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(255, 26, 104, 1);
        background: white;
    }
    .chartgooglebar{
          width:auto;
          height:auto;        
      }
      .chartgoogle{
          width:auto;
          height:auto;        
      }
</style>   

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Preloader</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                        <li class="breadcrumb-item active">Preloader</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
 
    <div class="row">
      <div class="col-6 col-md-4 col-xl-2 mt-3">  
        <div class="card">
          <div class="card-body bg-light shadow-lg">          
        <a href="{{url("admin/home")}}" class="nav-link text-dark text-center">
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
  <div class="row">
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
        <div class="card-body bg-light shadow-lg">  
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
        <div class="card-body bg-light shadow-lg">          
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
        <div class="card-body bg-light shadow-lg">          
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

  <div class="row">

    <div class="col-6 col-md-4 col-xl-2 mt-3">  
      <div class="card">
        <div class="card-body bg-light shadow-lg">          
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
        <div class="card-body bg-light shadow-lg">          
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
        <div class="card-body bg-light shadow-lg">         
            <a href="#" class="nav-link text-dark text-center">
              <i class="fa-solid fa-3x fa-person-booth text-danger"></i>  
              <br>
            <label for="" class="mt-2">จ่ายกลาง</label>                
            </a>
        </div>
      </div>
    </div>
     
    <div class="col-6 col-md-4 col-xl-2 mt-3">   
      <div class="card" >
        <div class="card-body bg-light shadow-lg" >         
            <a href="#" class="nav-link text-dark text-center" > 
              <i class="fa-solid fa-3x fa-shop text-dark"></i>
              <br>
            <label for="" class="mt-2">สหกรณ์ร้านค้า</label>                
            </a>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2 mt-3">   
      <div class="card" >
        <div class="card-body shadow-lg" >         
            <a href="{{url('pkclaim/pkclaim_info')}}" class="nav-link text-dark text-center" >  
              <i class="fa-solid fa-3x fa-sack-dollar text-primary"></i>
              <br>
            <label for="" class="mt-2">PKClaim</label>                
            </a>
        </div>
      </div>
    </div>
      

  </div>


</div>  

@endsection
@section('footer')

 
@endsection
