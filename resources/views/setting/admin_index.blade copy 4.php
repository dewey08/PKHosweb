@extends('layouts.pkclaim')

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
        <div class="col-md-6">

            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Import</a>
                                <a class="dropdown-item" href="#">Download Report</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Email Sent</h4> 
                </div>
                <div class="card-body">
                    
                    <div class="bg-white rounded shadow">
                      
                            <div id="chart_div" class="chartgooglebar"></div>
                       
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-md-6">

            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Import</a>
                                <a class="dropdown-item" href="#">Download Report</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Email Sent</h4> 
                </div>
                <div class="card-body ">
                    
                    <div class="bg-white rounded shadow">
                       
                            <div id="series_chart_div" class="chartgoogle"></div>
                            {{-- <div id="series_chart_div" style="width: 900px; height: 500px;"></div> --}}
                      
                    </div>
                </div>
            </div>
             
        </div>
       
    </div>
    <!-- end row -->

    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Import</a>
                                <a class="dropdown-item" href="#">Download Report</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Email Sent</h4> 
                </div>
                <div class="card-body ">
                    
                    <div class="bg-white rounded shadow">
                       
                            <div id="series_chart_div" class="chartgoogle"></div>
                           
                      
                    </div>
                </div>
            </div>             
        </div>             
    </div> --}}
    <!-- end row -->


</div>  

@endsection
@section('footer')

 
@endsection
