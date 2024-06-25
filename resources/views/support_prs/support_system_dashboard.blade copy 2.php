@extends('layouts.support_prs')
@section('title', 'PK-OFFICER || Support-System')

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


        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pe-2">
                                        <i class="lnr-apartment opacity-6"></i>
                                    </span>
                                    <span class="d-inline-block">ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ
                                        Dashboard</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a>
                                                    <i aria-hidden="true" class="fa fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a>Dashboards</a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page">
                                                Inspection and maintenance Dashboard
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="page-title-actions">
                            {{-- <div class="d-inline-block pe-3">
                                <select id="custom-inp-top" type="select" class="form-select">
                                    <option>Select period...</option>
                                    <option>Last Week</option>
                                    <option>Last Month</option>
                                    <option>Last Year</option>
                                </select>
                            </div> --}}
                            {{-- <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                class="btn btn-dark" title="Show a Toastr Notification!">
                                <i class="fa fa-battery-three-quarters"></i>
                            </button> --}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-danger border-danger card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (RED)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <span class="opacity-10 text-danger pe-2">
                                                    <i class="fa fa-angle-left"></i>
                                                </span>
                                                {{ $count_red }}
                                                <small class="opacity-5 ps-1">ถัง</small>
                                            </div>
                                            {{-- <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                <div class="circle-progress circle-progress-danger-sm d-inline-block">
                                                    <small></small>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-success border-success card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (GREEN)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <span class="opacity-10 text-success pe-2">
                                                    <i class="fa fa-angle-left"></i>
                                                </span>
                                                {{ $count_green }}
                                                <small class="opacity-5 ps-1">ถัง</small>
                                            </div>
                                            {{-- <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                <div class="circle-progress circle-progress-success-sm d-inline-block">
                                                    <small></small>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-danger border-danger card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (RED สำรอง)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <small class="text-danger pe-1">+</small>
                                                {{ $count_red_back }}
                                                <small class="opacity-5 ps-1">ถัง</small>
                                            </div>
                                            {{-- <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                <div class="circle-progress circle-progress-warning-sm d-inline-block">
                                                    <small></small>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div
                            class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-success border-success card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <div class="widget-title opacity-5 text-uppercase">ถังดับเพลิง (GREEN สำรอง)</div>
                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                        <div class="widget-chart-flex align-items-center">
                                            <div>
                                                <small class="text-success pe-1">+</small>
                                                {{ $count_green_back }}
                                                <small class="opacity-5 ps-1">ถัง</small>
                                            </div>
                                            {{-- <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                <div class="circle-progress circle-progress-success-sm d-inline-block">
                                                    <small></small>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-sm-12 col-md-7 col-lg-8">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">
                                    Traffic Sources
                                </div>
                                <div class="btn-actions-pane-right text-capitalize">
                                    <button class="btn btn-warning">Actions</button>
                                </div>
                            </div>
                            <div class="pt-0 card-body">
                                <div id="chart-combined"></div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">ถังดับเพลิง (RED)
                                </div>
                                <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                    {{-- <div class="btn-group">
                                        <button type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                            <i class="lnr-cog btn-icon-wrapper"></i>
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu dropdown-menu-right">
                                            <h6 tabindex="-1" class="dropdown-header">
                                                Header
                                            </h6>
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
                                    </div> --}}
                                </div>
                            </div>
                            <div class="p-0 card-body">
                                <div id="radials"></div>

                                <div class="widget-content pt-0 w-100">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left pe-2 fsize-1">
                                                <div class="widget-numbers mt-0 fsize-3 text-warning">32%</div>
                                            </div>
                                            <div class="widget-content-right w-100">
                                                <div class="progress-bar-xs progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 32%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left fsize-1">
                                            <div class="text-muted opacity-6">Spendings Target</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">ถังดับเพลิง (GREEN)
                                </div>
                                <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                    {{-- <div class="btn-group">
                                        <button type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                            <i class="lnr-cog btn-icon-wrapper"></i>
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu dropdown-menu-right">
                                            <h6 tabindex="-1" class="dropdown-header">
                                                Header
                                            </h6>
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
                                    </div> --}}
                                </div>
                            </div>
                            <div class="p-0 card-body">
                                <div id="radials_green"></div>
                                <div class="widget-content pt-0 w-100">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left pe-2 fsize-1">
                                                <div class="widget-numbers mt-0 fsize-3 text-warning">32%</div>
                                            </div>
                                            <div class="widget-content-right w-100">
                                                <div class="progress-bar-xs progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 32%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-left fsize-1">
                                            <div class="text-muted opacity-6">Spendings Target</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <h6 class="widget-subheading">Income</h6>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers mb-0 w-100">
                                            <div class="widget-chart-flex">
                                                <div class="fsize-4">
                                                    <small class="opacity-5">$</small>
                                                    5,456
                                                </div>
                                                <div class="ms-auto">
                                                    <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                        <span class="text-success ps-2">+14%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <h6 class="widget-subheading">Expenses</h6>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers mb-0 w-100">
                                            <div class="widget-chart-flex">
                                                <div class="fsize-4 text-danger">
                                                    <small class="opacity-5 text-muted">$</small>
                                                    4,764
                                                </div>
                                                <div class="ms-auto">
                                                    <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                        <span class="text-danger ps-2">
                                                            <span class="pe-1">
                                                                <i class="fa fa-angle-up"></i>
                                                            </span>
                                                            8%
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
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <h6 class="widget-subheading">Spendings</h6>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers mb-0 w-100">
                                            <div class="widget-chart-flex">
                                                <div class="fsize-4">
                                                    <span class="text-success pe-2">
                                                        <i class="fa fa-angle-down"></i>
                                                    </span>
                                                    <small class="opacity-5">$</small>
                                                    1.5M
                                                </div>
                                                <div class="ms-auto">
                                                    <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                        <span class="text-success ps-2">
                                                            <span class="pe-1">
                                                                <i class="fa fa-angle-down"></i>
                                                            </span>
                                                            15%
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
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content">
                                    <h6 class="widget-subheading">Totals</h6>
                                    <div class="widget-chart-flex">
                                        <div class="widget-numbers mb-0 w-100">
                                            <div class="widget-chart-flex">
                                                <div class="fsize-4">
                                                    <small class="opacity-5">$</small>
                                                    31,564
                                                </div>
                                                <div class="ms-auto">
                                                    <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                        <span class="text-warning ps-2">+76%</span>
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
                {{-- <div class="mbg-3 h-auto ps-0 pe-0 bg-transparent no-border card-header">
                    <div class="card-header-title fsize-2 text-capitalize fw-normal">Target Section</div>
                    <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                        <button class="btn btn-link btn-sm">View Details</button>
                    </div>
                </div> --}}
                {{-- <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-content p-0 w-100">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left pe-2 fsize-1">
                                            <div class="widget-numbers mt-0 fsize-3 text-danger">71%</div>
                                        </div>
                                        <div class="widget-content-right w-100">
                                            <div class="progress-bar-xs progress">
                                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="71"
                                                    aria-valuemin="0" aria-valuemax="100"  style="width: 71%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left fsize-1">
                                        <div class="text-muted opacity-6">Income Target</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-content p-0 w-100">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left pe-2 fsize-1">
                                            <div class="widget-numbers mt-0 fsize-3 text-success">54%</div>
                                        </div>
                                        <div class="widget-content-right w-100">
                                            <div class="progress-bar-xs progress">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 54%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left fsize-1">
                                        <div class="text-muted opacity-6">Expenses Target</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-content p-0 w-100">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left pe-2 fsize-1">
                                            <div class="widget-numbers mt-0 fsize-3 text-warning">32%</div>
                                        </div>
                                        <div class="widget-content-right w-100">
                                            <div class="progress-bar-xs progress">
                                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="32"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 32%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left fsize-1">
                                        <div class="text-muted opacity-6">Spendings Target</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                            <div class="widget-content p-0 w-100">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left pe-2 fsize-1">
                                            <div class="widget-numbers mt-0 fsize-3 text-info">89%</div>
                                        </div>
                                        <div class="widget-content-right w-100">
                                            <div class="progress-bar-xs progress">
                                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="89"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 89%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left fsize-1">
                                        <div class="text-muted opacity-6">Totals Target</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">Total Sales</div>
                                <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                    <div class="btn-group dropdown">
                                        <button type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                            <i class="lnr-cog btn-icon-wrapper"></i>
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
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
                            <div class="card-body">
                                <div id="chart-col-1"></div>
                            </div>
                            <div class="p-0 d-block card-footer">
                                <div class="grid-menu grid-menu-2col">
                                    <div class="g-0 row">
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-car text-primary opacity-7 btn-icon-wrapper mb-2"></i>
                                                Admin
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-bullhorn text-danger opacity-7 btn-icon-wrapper mb-2"></i>
                                                Blog
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-bug text-success opacity-7 btn-icon-wrapper mb-2"></i>
                                                Register
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-heart text-warning opacity-7 btn-icon-wrapper mb-2"></i>
                                                Directory
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">Daily Sales</div>
                                <div class="btn-actions-pane-right text-capitalize">
                                    <button class="btn-wide btn-outline-2x btn btn-outline-focus btn-sm">View All</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart-col-2"></div>
                            </div>
                            <div class="p-0 d-block card-footer">
                                <div class="grid-menu grid-menu-2col">
                                    <div class="g-0 row">
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-apartment text-dark opacity-7 btn-icon-wrapper mb-2"></i>
                                                Overview
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-database text-dark opacity-7 btn-icon-wrapper mb-2"></i>
                                                Support
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-printer text-dark opacity-7 btn-icon-wrapper mb-2"></i>
                                                Activities
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-dark">
                                                <i class="lnr-store text-dark opacity-7 btn-icon-wrapper mb-2"></i>
                                                Marketing
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize fw-normal">Total Expenses</div>
                                <div class="btn-actions-pane-right text-capitalize">
                                    <button class="btn-wide btn-outline-2x btn btn-outline-primary btn-sm">View All</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart-col-3"></div>
                            </div>
                            <div class="p-0 d-block card-footer">
                                <div class="grid-menu grid-menu-2col">
                                    <div class="g-0 row">
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-success">
                                                <i class="lnr-lighter text-success opacity-7 btn-icon-wrapper mb-2"></i>
                                                Accounts
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                <i class="lnr-construction text-warning opacity-7 btn-icon-wrapper mb-2"></i>
                                                Contacts
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-info">
                                                <i class="lnr-bus text-info opacity-7 btn-icon-wrapper mb-2"></i>
                                                Products
                                            </button>
                                        </div>
                                        <div class="p-2 col-sm-6">
                                            <button class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-alternate">
                                                <i class="lnr-gift text-alternate opacity-7 btn-icon-wrapper mb-2"></i>
                                                Services
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="card-header-title font-size-lg text-capitalize fw-normal">
                            Company Agents Status
                        </div>
                        <div class="btn-actions-pane-right">
                            <button type="button" class="btn-icon btn-wide btn-outline-2x btn btn-outline-focus btn-sm d-flex">
                                Actions Menu
                                <span class="ps-2 align-middle opacity-7">
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle text-truncate mb-0 table table-borderless table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Company</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Due Date</th>
                                    <th class="text-center">Target Achievement</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center text-muted" style="width: 80px;">#54</td>
                                    <td class="text-center" style="width: 80px;">
                                        <img width="40" class="rounded-circle" src="images/avatars/4.jpg" alt="">
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)">Juan C. Cargill</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)">Micro Electronics</a>
                                    </td>
                                    <td class="text-center">
                                        <div class="badge rounded-pill bg-danger">Canceled</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="pe-2 opacity-6">
                                            <i class="fa fa-business-time"></i>
                                        </span>
                                        12 Dec
                                    </td>
                                    <td class="text-center" style="width: 200px;">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left pe-2">
                                                        <div class="widget-numbers fsize-1 text-danger">71%</div>
                                                    </div>
                                                    <div class="widget-content-right w-100">
                                                        <div class="progress-bar-xs progress">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                aria-valuenow="71" aria-valuemin="0"
                                                                aria-valuemax="100" style="width: 71%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div role="group" class="btn-group-sm btn-group">
                                            <button class="btn-shadow btn btn-primary">Hire</button>
                                            <button class="btn-shadow btn btn-primary">Fire</button>
                                        </div>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block p-4 text-center card-footer">
                        <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-dark btn-lg">
                            <span class="me-2 opacity-7">
                                <i class="fa fa-cog fa-spin"></i>
                            </span>
                            <span class="me-1">View Complete Report</span>
                        </button>
                    </div>
                </div> --}}

            </div>

        </div>

    </div>

@endsection
@section('footer')
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"> </script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script> --}}
    <script>
     $(document).ready(function() {
            var xmlhttp = new XMLHttpRequest();
            var url = "{{ url('support_system_dashboard') }}";
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var datas = JSON.parse(this.responseText);
                    console.log(datas); 
                    
                    count_color = datas.Dataset1.map(function(e) {
                        return e.count_color;
                    });
                     
                      
                            // Radial 
                            // var options_red = {
                            //     series: count_color,
                            //     chart: {
                            //         height: 350,
                            //         type: 'radialBar',
                            //         toolbar: {
                            //             show: true
                            //         }
                            //     },
                            //     plotOptions: {
                            //         radialBar: {
                            //             startAngle: -135,
                            //             endAngle: 225,
                            //             hollow: {
                            //                 margin: 0,
                            //                 size: '70%',
                            //                 background: '#fff',
                            //                 image: undefined,
                            //                 imageOffsetX: 0,
                            //                 imageOffsetY: 0,
                            //                 position: 'front',
                            //                 dropShadow: {
                            //                     enabled: true,
                            //                     top: 3,
                            //                     left: 0,
                            //                     blur: 4,
                            //                     opacity: 0.24
                            //                 }
                            //             },
                            //             track: {
                            //                 background: '#fff',
                            //                 strokeWidth: '67%',
                            //                 margin: 0, // margin is in pixels
                            //                 dropShadow: {
                            //                     enabled: true,
                            //                     top: -3,
                            //                     left: 0,
                            //                     blur: 4,
                            //                     opacity: 0.35
                            //                 }
                            //             },

                            //             dataLabels: {
                            //                 show: true,
                            //                 name: {
                            //                     offsetY: -10,
                            //                     show: true,
                            //                     color: '#888',
                            //                     fontSize: '17px'
                            //                 },
                            //                 value: {
                            //                     formatter: function(val) {
                            //                         return parseInt(val);
                            //                     },
                            //                     color: '#111',
                            //                     fontSize: '36px',
                            //                     show: true,
                            //                 }
                            //             }
                            //         }
                            //     },
                            //     fill: {
                            //         type: 'gradient',
                            //         gradient: {
                            //             shade: 'dark',
                            //             type: 'horizontal',
                            //             shadeIntensity: 0.5,
                            //             gradientToColors: ['#ABE5A1'],
                            //             inverseColors: true,
                            //             opacityFrom: 1,
                            //             opacityTo: 1,
                            //             stops: [0, 100]
                            //         }
                            //     },
                            //     stroke: {
                            //         lineCap: 'round'
                            //     },
                            //     labels: ['Percent'],
                            // };
                            // var chart = new ApexCharts(document.querySelector("#radials"), options_red);
                            // chart.render();

                            // // **************************************

                            // var options_green = {
                            //     series: [55],
                            //     chart: {
                            //         height: 350,
                            //         type: 'radialBar',
                            //         toolbar: {
                            //             show: true
                            //         }
                            //     },
                            //     plotOptions: {
                            //         radialBar: {
                            //             startAngle: -135,
                            //             endAngle: 225,
                            //             hollow: {
                            //                 margin: 0,
                            //                 size: '70%',
                            //                 background: '#fff',
                            //                 image: undefined,
                            //                 imageOffsetX: 0,
                            //                 imageOffsetY: 0,
                            //                 position: 'front',
                            //                 dropShadow: {
                            //                     enabled: true,
                            //                     top: 3,
                            //                     left: 0,
                            //                     blur: 4,
                            //                     opacity: 0.24
                            //                 }
                            //             },
                            //             track: {
                            //                 background: '#fff',
                            //                 strokeWidth: '67%',
                            //                 margin: 0, // margin is in pixels
                            //                 dropShadow: {
                            //                     enabled: true,
                            //                     top: -3,
                            //                     left: 0,
                            //                     blur: 4,
                            //                     opacity: 0.35
                            //                 }
                            //             },

                            //             dataLabels: {
                            //                 show: true,
                            //                 name: {
                            //                     offsetY: -10,
                            //                     show: true,
                            //                     color: '#888',
                            //                     fontSize: '17px'
                            //                 },
                            //                 value: {
                            //                     formatter: function(val) {
                            //                         return parseInt(val);
                            //                     },
                            //                     color: '#111',
                            //                     fontSize: '36px',
                            //                     show: true,
                            //                 }
                            //             }
                            //         }
                            //     },
                            //     fill: {
                            //         type: 'gradient',
                            //         gradient: {
                            //             shade: 'dark',
                            //             type: 'horizontal',
                            //             shadeIntensity: 0.5,
                            //             gradientToColors: ['#ABE5A1'],
                            //             inverseColors: true,
                            //             opacityFrom: 1,
                            //             opacityTo: 1,
                            //             stops: [0, 100]
                            //         }
                            //     },
                            //     stroke: {
                            //         lineCap: 'round'
                            //     },
                            //     labels: ['Percent'],
                            // };
                            // var chart = new ApexCharts(document.querySelector("#radials_green"), options_green);
                            // chart.render();

                }
             }

        });
    </script>

@endsection
