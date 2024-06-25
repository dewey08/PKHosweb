@extends('layouts.pkclaim_refer')

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
  <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">การลงข้อมูลรถ Refer</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">การลงข้อมูลรถ Refer</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">                     
                        <div class="card-body py-0 px-2 mt-2"> 
                            <div class="row">
                                <div class="col-6 col-md-4 col-xl-2 mt-3">
                                    <div class="card">
                                        <div class="card-body bg-light shadow-lg">
                                            <a href="{{ url('report_refer_2561') }}" class="nav-link text-dark text-center"> 
                                                <i class="fa-solid fa-2x fa-truck-medical text-info"></i> 
                                                <br>
                                                <label for="" class="mt-2">2561</label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xl-2 mt-3">
                                    <div class="card">
                                        <div class="card-body bg-light shadow-lg">
                                            <a href="{{ url('report_refer_2562') }}" class="nav-link text-dark text-center">
                                                <i class="fa-solid fa-2x fa-truck-medical text-primary"></i> 
                                                <br>
                                                <label for="" class="mt-2">2562</label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xl-2 mt-3">
                                    <div class="card">
                                        <div class="card-body bg-light shadow-lg">
                                            <a href="{{ url('report_refer_2563') }}" class="nav-link text-dark text-center">
                                                <i class="fa-solid fa-2x fa-truck-medical text-warning"></i> 
                                                <br>
                                                <label for="" class="mt-2">2563</label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xl-2 mt-3">
                                    <div class="card">
                                        <div class="card-body bg-light shadow-lg">
                                            <a href="{{ url('report_refer_2564') }}" class="nav-link text-dark text-center">
                                                <i class="fa-solid fa-2x fa-truck-medical text-success"></i> 
                                                <br>
                                                <label for="" class="mt-2">2564</label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xl-2 mt-3">
                                    <div class="card">
                                        <div class="card-body bg-light shadow-lg">
                                            <a href="{{ url('report_refer_2565') }}" class="nav-link text-dark text-center">
                                                <i class="fa-solid fa-2x fa-truck-medical text-danger"></i> 
                                                <br>
                                                <label for="" class="mt-2">2565</label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-xl-2 mt-3">
                                    {{-- <div class="card">
                                        <div class="card-body bg-light shadow-lg">
                                            <a href="{{ url('admin/home') }}" class="nav-link text-dark text-center">
                                                <i class="fa-solid fa-3x fa-chart-line text-warning"></i>
                                                <br>
                                                <label for="" class="mt-2">2566</label>
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                                
                        </div>
                    
                </div>
            </div>
        </div>

         

    </div> 
    @endsection
    @section('footer')
        
        
    @endsection
