@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
    ?>

    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>

    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
       
        <form action="{{ route('acc.account_pk_dash') }}" method="POST">
            @csrf
            <div class="row"> 
                <div class="col-md-4">
                    <h4 class="card-title">Dashboard Account </h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล </p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>  
                    </div> 
                </div>
                <div class="col-md-2 text-start">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                     
                </div>
            </div>
        </form> 

        <div class="row">
            <div class="col-lg-6 col-xl-4">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize fw-normal">
                            <i class="header-icon lnr-shirt me-3 text-muted opacity-6"></i>
                            Top Sellers
                        </div>
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <div class="btn-group dropdown">
                                <button type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                    <i class="pe-7s-menu btn-icon-wrapper"></i>
                                </button>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                    <button type="button" tabindex="0" class="dropdown-item">
                                        <i class="dropdown-icon lnr-inbox"></i>
                                        <span>Menus</span>
                                    </button>
                                    <button type="button" tabindex="0" class="dropdown-item">
                                        <i class="dropdown-icon lnr-file-empty"></i>
                                        <span>Settings</span>
                                    </button>
                                    <button type="button" tabindex="0" class="dropdown-item">
                                        <i class="dropdown-icon lnr-book"></i>
                                        <span>Actions</span>
                                    </button>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <div class="p-1 text-end">
                                        <button class="me-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                        <button class="me-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-chart widget-chart2 text-start p-0">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content widget-chart-content-lg">
                                <div class="widget-chart-flex">
                                    <div class="widget-title opacity-5 text-muted text-uppercase">New accounts since 2018</div>
                                </div>
                                <div class="widget-numbers">
                                    <div class="widget-chart-flex">
                                        <div>
                                            <span class="opacity-10 text-success pe-2">
                                                <i class="fa fa-angle-up"></i>
                                            </span>
                                            <span>9</span>
                                            <small class="opacity-5 ps-1">%</small>
                                        </div>
                                        <div class="widget-title ms-2 font-size-lg fw-normal text-muted">
                                            <span class="text-danger ps-2">+14% failed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-chart-wrapper widget-chart-wrapper-xlg opacity-10 m-0">
                                <div id="dashboard-sparkline-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 pb-0 card-body">
                        <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 fw-normal">Authors</h6>
                        <div class="scroll-area-md shadow-overflow">
                            <div class="scrollbar-container">
                                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <img width="38" class="rounded-circle"
                                                        src="images/avatars/1.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Viktor Martin</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$152</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        <span>752</span>
                                                        <small class="text-warning ps-2">
                                                            <i class="fa fa-angle-down"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <img width="38" class="rounded-circle"
                                                        src="images/avatars/2.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Denis Delgado</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$53</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        <span>587</span>
                                                        <small class="text-danger ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <img width="38" class="rounded-circle"
                                                        src="images/avatars/3.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Shawn Galloway</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$239</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        <span>163</span>
                                                        <small class="text-muted ps-2">
                                                            <i class="fa fa-angle-down"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <img width="38" class="rounded-circle"
                                                        src="images/avatars/4.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Latisha Allison</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$21</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        653
                                                        <small class="text-primary ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <img width="38" class="rounded-circle"
                                                        src="images/avatars/5.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Lilly-Mae White</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$381</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        629
                                                        <small class="text-muted ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <img width="38" class="rounded-circle"
                                                        src="images/avatars/8.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Julie Prosser</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$74</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        462
                                                        <small class="text-muted ps-2">
                                                            <i class="fa fa-angle-down"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="border-bottom-0 list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <img width="38" class="rounded-circle"
                                                        src="images/avatars/8.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Amin Hamer</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$7</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        956
                                                        <small class="text-success ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-block text-center rm-border card-footer">
                        <button class="btn btn-primary">
                            View complete report
                            <span class="text-white ps-2 opacity-3">
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize fw-normal">
                            <i class="header-icon lnr-laptop-phone me-3 text-muted opacity-6"></i>
                            Best Selling Products
                        </div>
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <div class="btn-group dropdown">
                                <button data-bs-toggle="dropdown" type="button" aria-haspopup="true"
                                    aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                    <i class="pe-7s-menu btn-icon-wrapper"></i>
                                </button>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                    <button type="button" tabindex="0" class="dropdown-item">
                                        <i class="dropdown-icon lnr-inbox"></i>
                                        <span>Menus</span>
                                    </button>
                                    <button type="button" tabindex="0" class="dropdown-item">
                                        <i class="dropdown-icon lnr-file-empty"></i>
                                        <span>Settings</span>
                                    </button>
                                    <button type="button" tabindex="0" class="dropdown-item">
                                        <i class="dropdown-icon lnr-book"></i>
                                        <span>Actions</span>
                                    </button>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <div class="p-1 text-end">
                                        <button class="me-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                        <button class="me-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-chart widget-chart2 text-start p-0">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content widget-chart-content-lg">
                                <div class="widget-chart-flex">
                                    <div class="widget-title opacity-5 text-muted text-uppercase">
                                        Toshiba Laptops
                                    </div>
                                </div>
                                <div class="widget-numbers">
                                    <div class="widget-chart-flex">
                                        <div>
                                            <span class="opacity-10 text-warning pe-2">
                                                <i class="fa fa-dot-circle"></i>
                                            </span>
                                            <span>$984</span>
                                        </div>
                                        <div class="widget-title ms-2 font-size-lg fw-normal text-muted">
                                            <span class="text-success ps-2">+14</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-chart-wrapper widget-chart-wrapper-xlg opacity-10 m-0">
                                <div id="dashboard-sparkline-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 pb-0 card-body">
                        <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 fw-normal">
                            Top Performing
                        </h6>
                        <div class="scroll-area-md shadow-overflow">
                            <div class="scrollbar-container">
                                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress circle-progress-gradient">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Asus Laptop</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$152</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        <span>752</span>
                                                        <small class="text-warning ps-2">
                                                            <i class="fa fa-angle-down"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress circle-progress-danger">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Dell Inspire</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$53</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        <span>587</span>
                                                        <small class="text-danger ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress circle-progress-primary">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Lenovo IdeaPad</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$239</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        <span>163</span>
                                                        <small class="text-muted ps-2">
                                                            <i class="fa fa-angle-down"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress circle-progress-info">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Asus Vivobook</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$21</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        653
                                                        <small class="text-primary ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress circle-progress-warning">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Apple Macbook</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$381</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        629
                                                        <small class="text-muted ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress circle-progress-dark">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">HP Envy 13"</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$74</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        462
                                                        <small class="text-muted ps-2">
                                                            <i class="fa fa-angle-down"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="border-bottom-0 list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="progress-circle-wrapper">
                                                                <div class="circle-progress circle-progress-alternate">
                                                                    <small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Gaming Laptop HP</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge rounded-pill bg-dark">$7</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="fsize-1 text-focus">
                                                        <small class="opacity-5 pe-1">$</small>
                                                        956
                                                        <small class="text-success ps-2">
                                                            <i class="fa fa-angle-up"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-block text-center rm-border card-footer">
                        <button class="btn btn-primary">
                            View all participants
                            <span class="text-white ps-2 opacity-3">
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-4">
                <div class="mb-3 card">
                    <div class="rm-border pb-0 responsive-center card-header">
                        <div>
                            <h5 class="menu-header-title text-capitalize">Portfolio Performance</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xl-12">
                            <div class="no-shadow rm-border bg-transparent widget-chart text-start card">
                                <div class="progress-circle-wrapper">
                                    <div class="circle-progress circle-progress-gradient-lg">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">Capital Gains</div>
                                    <div class="widget-numbers text-success">
                                        <span>$563</span>
                                    </div>
                                    <div class="widget-description text-focus">
                                        Increased by
                                        <span class="text-warning ps-1">
                                            <i class="fa fa-angle-up"></i>
                                            <span class="ps-1">7.35%</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-12">
                            <div class="card no-shadow rm-border bg-transparent widget-chart text-start mt-2">
                                <div class="progress-circle-wrapper">
                                    <div class="circle-progress circle-progress-gradient-alt-lg">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">Withdrawals</div>
                                    <div class="widget-numbers text-danger">
                                        <span>$194</span>
                                    </div>
                                    <div class="widget-description opacity-8 text-focus">
                                        Down by
                                        <span class="text-success ps-1 pe-1">
                                            <i class="fa fa-angle-down"></i>
                                            <span class="ps-1">21.8%</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mx-auto mt-3">
                        <div role="group" class="btn-group-sm btn-group nav">
                            <a class="btn-shadow ps-3 pe-3 active btn btn-primary" data-bs-toggle="tab" href="#sales-tab-1">Income</a>
                            <a class="btn-shadow pe-3 ps-3  btn btn-primary" data-bs-toggle="tab" href="#sales-tab-2">Expenses</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="sales-tab-1">
                                <div class="text-center">
                                    <h5 class="menu-header-title">Target Sales</h5>
                                    <h6 class="menu-header-subtitle opacity-6">Total performance for this month</h6>
                                </div>
                                <div id="dashboard-sparklines-primary"></div>
                            </div>
                            <div class="tab-pane fade" id="sales-tab-2">
                                <div class="text-center">
                                    <h5 class="menu-header-title">Tabbed Content</h5>
                                    <h6 class="menu-header-subtitle opacity-6">Example of various options built with ArchitectUI</h6>
                                </div>
                                <div class="card-hover-shadow-2x widget-chart widget-chart2 bg-premium-dark text-start mt-3 card">
                                    <div class="widget-chart-content text-white">
                                        <div class="widget-chart-flex">
                                            <div class="widget-title">Sales</div>
                                            <div class="widget-subtitle opacity-7">Monthly Goals</div>
                                        </div>
                                        <div class="widget-chart-flex">
                                            <div class="widget-numbers text-success">
                                                <small>$</small>
                                                <span>976</span>
                                                <small class="opacity-8 ps-2">
                                                    <i class="fa fa-angle-up"></i>
                                                </small>
                                            </div>
                                            <div class="widget-description ms-auto opacity-7">
                                                <i class="fa fa-angle-up"></i>
                                                <span class="ps-1">175%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-success btn-lg">
                                        <span class="me-2 opacity-7">
                                            <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                                        </span>
                                        <span class="me-1">View Complete Report</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="row">
            <div class="col-md-2">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-8">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            <canvas id="myChartNew"></canvas>
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="main-card card">
                    <h6 class="card-title mt-2 ms-2">Report </h6> 
                        <div style="height:auto;" class="p-2"> 
                            00
                        <br>
                        <h6 class="text-center" style="color:rgb(241, 137, 155)">OPD แยกตามสิทธิ์ </h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row ms-2 me-3">
            <div class="col-xl-3 col-md-3">
                <div class="main-card card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="no-shadow rm-border bg-transparent widget-chart text-start card">
                                        <div class="progress-circle-wrapper">
                                            <div class="circle-progress circle-progress-gradient-lg">
                                                <small></small>
                                            </div>
                                        </div>
                                        <div class="widget-chart-content">
                                            <div class="widget-subheading">Capital Gains</div>
                                            <div class="widget-numbers text-success">
                                                <span>$563</span>
                                            </div>
                                            <div class="widget-description text-focus">
                                                Increased by
                                                <span class="text-warning ps-1">
                                                    <i class="fa fa-angle-up"></i>
                                                    <span class="ps-1">7.35%</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}



    </div>
    {{-- @apexchartsScripts --}}
@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script>
        var Linechart;
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
 

            var xmlhttp = new XMLHttpRequest();
            var url = "{{ route('acc.account_dashline') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas);
                    label = datas.Dataset1.map(function(e) {
                        return e.label;
                    });
                    
                    count_vn = datas.Dataset1.map(function(e) {
                        return e.count_vn;
                    });
                    income = datas.Dataset1.map(function(e) {
                        return e.income;
                    });
                    rcpt_money = datas.Dataset1.map(function(e) {
                        return e.rcpt_money;
                    });
                    debit = datas.Dataset1.map(function(e) {
                        return e.debit;
                    });
                     // setup 
                    const data = {
                        // labels: ["ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"] ,
                        labels: label ,
                        datasets: [                        
                            // {
                            //     label: ['Visit OPD'],
                            //     // data: [0],
                            //     data: count_vn,
                            //     fill: false,
                            //     borderColor: 'rgba(255, 205, 86)',
                            //     lineTension: 0.4 
                            // },
                            {
                                label: ['income'], 
                                data: income,
                                fill: false,
                                borderColor: 'rgba(75, 192, 192)',
                                lineTension: 0.4 
                            },
                            {
                                label: ['rcpt_money'], 
                                data: rcpt_money,
                                fill: false,
                                borderColor: 'rgba(255, 99, 132)',
                                lineTension: 0.4 
                            },  
                            // {
                            //     label: ['looknee_sum_opd'], 
                            //     data: looknee_sum_opd,
                            //     fill: false,
                            //     borderColor: 'rgba(255, 99, 32)',
                            //     lineTension: 0.4 
                            // },  
                        ]
                    };
             
                    const config = {
                        type: 'line',
                        data:data,
                        options: { 
                            scales: { 
                                y: {
                                    beginAtZero: true 
                                }
                            } 
                        },                        
                        plugins:[ChartDataLabels],                        
                    };                    
                    // render init block
                    const myChart = new Chart(
                        document.getElementById('myChartNew'),
                        config
                    );
                    
                }
             }

        });
    </script>
    {{-- <script>
        var options1 = {
            chart: {
                height: 350,
                type: "radialBar",
            },
            series: [32, 98, 70, 61],
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        total: {
                            show: true,
                            label: 'TOTAL'
                        }
                    }
                }
            },
            labels: ['401', '402', '403', '404']
        };

        new ApexCharts(document.querySelector("#chart4"), options1).render();
    </script>
    <script>
        var options7 = {
            series: [{
                // data: data.slice()
                data: [1523, 2562, 2555, 2240]
            }],
            chart: {
                id: 'realtime',
                height: 350,
                type: 'line',
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: 'Dynamic Updating Chart',
                align: 'left'
            },
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime',
                range: XAXISRANGE,
            },
            yaxis: {
                max: 100
            },
            legend: {
                show: false
            },
        };

        var chart = new ApexCharts(document.querySelector("#linechart"), options7);
        chart.render();


        window.setInterval(function() {
            getNewSeries(lastDate, {
                min: 10,
                max: 90
            })

            chart.updateSeries([{
                data: data
            }])
        }, 1000)
    </script> --}}

@endsection
