@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER  || ผู้ใช้งานทั่วไป')

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
    $countpesmiss_money = StaticController::countpesmiss_money($iduser);
    $countpesmiss_claim = StaticController::countpesmiss_claim($iduser);

    $countpermiss_gleave = StaticController::countpermiss_gleave($iduser);
    $countpermiss_ot = StaticController::countpermiss_ot($iduser);
    $countpermiss_medicine = StaticController::countpermiss_medicine($iduser);
    $countpermiss_p4p = StaticController::countpermiss_p4p($iduser);
    $countpermiss_time = StaticController::countpermiss_time($iduser);

    $countpermiss_env = StaticController::countpermiss_env($iduser);
    $permiss_account = StaticController::permiss_account($iduser);
    
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
           border-top: 10px #12dafd solid;
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

    <div class="container ">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        <div class="row mt-3"> 
            @if ($countpesmiss_per != 0)                 
                <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                <h4 class="text-start mb-2">บุคคลากร</h4>                                                         
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('person/person_index') }}" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                <i class="fa-solid fa-3x fa-user-tie font-size-30 mt-3" style="color: rgb(164, 7, 179)"></i> 
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
            @endif

            @if($countpermiss_gleave != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">ระบบการลา</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('gleave') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                    <i class="fa-solid fa-3x fa-hospital-user font-size-30 mt-3" style="color: rgb(170, 7, 97)"></i>
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
            @endif


            @if ($countpesmiss_book != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">สารบรรณ</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('book/bookmake_index') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-book-open-reader font-size-30 mt-3" style="color: rgb(128, 5, 139)"></i> 
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
            @endif

            @if ($countpesmiss_car != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">ยานพาหนะ</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('car/car_narmal_calenda') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-truck-medical font-size-30 mt-3" style="color: rgb(21, 220, 238)"></i> 
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
            @endif

            @if ($countpesmiss_meetting != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">ห้องประชุม</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('meetting/meettingroom_dashboard') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                    <i class="fa-solid fa-3x fa-house-laptop font-size-30 mt-3" style="color: rgb(13, 205, 119)"></i>
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
            @endif

            @if ($countpesmiss_repair != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">ซ่อมบำรุง</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('repaire_narmal') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-screwdriver-wrench font-size-30 mt-3" style="color: rgb(42, 157, 245)"></i> 
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
            @endif



            @if ($countpesmiss_com != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">คอมพิวเตอร์</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('computer/com_staff_calenda') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-computer font-size-30 mt-3" style="color: rgb(85, 88, 87)"></i> 
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
            @endif

            @if ($countpesmiss_medical != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">เครื่องมือแพทย์</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('medical/med_calenda') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                    <i class="fa-solid fa-3x fa-microscope font-size-30 mt-3" style="color: rgb(248, 166, 44)"></i>
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
            @endif

            @if ($countpesmiss_hosing != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">บ้านพัก</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('housing/housing_dashboard') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-house-chimney-user font-size-30 mt-3" style="color: rgb(8, 71, 120)"></i> 
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
            @endif

            @if ($countpesmiss_plan != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">แผนงาน</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('plan') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-clipboard font-size-30 mt-3" style="color: rgb(198, 31, 31)"></i> 
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
            @endif

            @if ($countpesmiss_asset != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">ทรัพย์สิน</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('article/article_index') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-building-shield font-size-30 mt-3" style="color: rgb(126, 130, 128)"></i> 
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
            @endif

            @if ($countpesmiss_supplies != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">พัสดุ</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('supplies/supplies_index') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                    <i class="fa-solid fa-3x fa-paste font-size-30 mt-3" style="color: rgb(6, 159, 93)"></i>
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
            @endif


            @if ($countpesmiss_store != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">คลังวัสดุ</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('warehouse/warehouse_index') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-shop-lock font-size-30 mt-3" style="color: rgb(5, 125, 144)"></i> 
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
            @endif

            @if ($countpesmiss_store_dug != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">คลังยา</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-prescription font-size-30 mt-3" style="color: rgb(4, 112, 112)"></i> 
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
            @endif

            @if ($countpesmiss_pay != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">จ่ายกลาง</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-person-booth font-size-30 mt-3" style="color: rgb(155, 50, 50)"></i> 
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
            @endif

            @if ($countpesmiss_claim != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">งานประกัน</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('pkclaim/pkclaim_info') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                    <i class="fa-solid fa-3x fa-sack-dollar font-size-30 mt-3" style="color: rgb(221, 8, 89)"></i>
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
            @endif

            @if ($countpesmiss_money != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">การเงิน</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('account_info') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-money-check-dollar font-size-30 mt-3" style="color: rgb(182, 6, 82)"></i> 
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
            @endif

            @if ($permiss_account != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">การบัญชี</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('account_pk') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    <i class="fa-solid fa-3x fa-file-invoice-dollar font-size-30 mt-3" style="color: rgb(109, 105, 107)"></i> 
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
            @endif

            @if ($countpermiss_p4p != 0)
                <div class="col-xl-3 col-md-3">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover"> 
                                            <div class="d-flex">
                                                <div class="flex-grow-1">                                                    
                                                    <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                    <h4 class="text-start mb-2">P4P</h4>                                                         
                                                </div>    
                                                <div class="avatar-sm me-2">
                                                    <a href="{{ url('p4p') }}" target="_blank">
                                                        <span class="avatar-title bg-light text-primary rounded-3">
                                                            <p style="font-size: 10px;"> 
                                                                <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                    {{-- <i class="fa-solid fa-3x fa-person-booth font-size-30 mt-3" style="color: rgb(155, 50, 50)"></i>  --}}
                                                                    <i class="fa-solid fa-p text-danger font-size-50 mt-3"></i> 
                                                                    <i class="fa-solid fa-4 text-warning font-size-50 mt-3"></i>
                                                                    <i class="fa-solid fa-p text-info font-size-50 mt-3"></i>
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
            @endif

        @if ($countpermiss_medicine != 0)
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                <h4 class="text-start mb-2">แพทย์แผนไทย</h4>                                                         
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('medicine_salt') }}" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                <i class="fa-solid fa-3x fa-square-person-confined font-size-30 mt-3" style="color: rgb(159, 9, 197)"></i>
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
        @endif

        @if ($countpermiss_ot != 0)
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                <h4 class="text-start mb-2">โอที</h4>                                                         
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('otone') }}" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                <i class="fa-solid fa-3x fa-people-line font-size-30 mt-3" style="color: rgb(87, 37, 203)"></i> 
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
        @endif

        @if ($countpermiss_env != 0)
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                <h4 class="text-start mb-2">ENV</h4>                                                         
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('env_dashboard') }}" target="_blank">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                                <i class="fa-solid fa-3x fa-hand-holding-droplet font-size-30 mt-3" style="color: rgb(9, 169, 197)"></i> 
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
        @endif


        @if ($countpermiss_time != 0)
            <div class="col-xl-3 col-md-3">
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover"> 
                                        <div class="d-flex">
                                            <div class="flex-grow-1">                                                    
                                                <p class="text-start font-size-14 mb-2">PK-OFFICER</p>   
                                                <h4 class="text-start mb-2">ระบบลงเวลา</h4>                                                         
                                            </div>    
                                            <div class="avatar-sm me-2">
                                                <a href="{{ url('time_dashboard') }}" target="_blank">
                                                    <span class="avatar-title bg-light text-danger rounded-3">
                                                        <p style="font-size: 10px;"> 
                                                            <button class="mt-5 mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3"> 
                                                    
                                                                <i class="fa-regular fa-3x fa-clock font-size-30 mt-3" style="color: rgb(21, 198, 192)"></i>
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
        @endif

            <?php
            $datadetail = DB::connection('mysql')->select('   
                                        select * from orginfo 
                                        where orginfo_id = 1 
                                         ');
            ?>



</div>
            {{-- <footer class="footer">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-4">
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            @foreach ($datadetail as $item)
                                <label for="" style="color: rgb(82, 11, 148);font-size:17px"> ©
                                    {{ $item->orginfo_name }}</label>
                            @endforeach

                        </div>
                        <div class="col"></div>
                        <div class="col-md-4 text-center">
                            <label for="" style="color: rgb(82, 11, 148);font-size:17px"> By Pradit Raha -
                                งานประกัน</label>
                        </div>

                    </div>
                </div>
            </footer> --}}

    @endsection
