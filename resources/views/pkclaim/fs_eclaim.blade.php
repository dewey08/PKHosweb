@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || FS EClaim')
 
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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
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

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

   <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
       
        <div class="row "> 
            @foreach ($datashow as $item)   
                <div class="col-xl-3 col-md-6">
                    <div class="main-card mb-3 card">   
            
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="d-flex text-start">
                                        <div class="flex-grow-1 ">
                                                
                                            <div class="row">
                                                <div class="col-md-5 text-start mt-4 ms-4">
                                                    <h4 >{{$item->hipdata}}</h4> 
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-4 text-end mt-2 me-4">
                                                    <a href="{{url('fs_eclaim_inhos/'.$item->icodex)}}" target="_blank" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger"> 
                                                        <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="อุปกรณ์ ECLaim & Hos แยกสิทธิ์ {{$item->hipdata}}"> 
                                                            <h4 class="text-end">{{$item->icodex}}</h4> 
                                                        </div> 
                                                    </a>      
                                                                                                         
                                                </div>
                                            </div>
                                        
                                        </div>     
                                    </div>   
                                </div> 
                            </div>                                           
                        </div> 
                                                
                    </div> 
                </div> 
            @endforeach
        </div>

        <div class="row ">    
            <div class="col-xl-5 col-md-5">
                <div class="main-card mb-3 card">   
                        <div class="table-responsive mt-2 ms-2 me-2">
                            <table id="example1" class="table table-striped table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                {{-- example --}}
                                {{-- datatable --}}
                                <thead>
                                    <tr> 
                                        <th class="text-center" width="5%">income</th> 
                                        <th class="text-center">name</th>
                                        <th class="text-center" width="5%">FS-Hos</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ii = 1; ?>
                                    @foreach ($datashow2 as $item2) 
                                    <tr id="tr_{{$item2->fs_eclaim_id}}">   
                                        <td class="text-center" width="5%">{{ $item2->income }}</td> 
                                        <td class="text-start">{{ $item2->iname }}</td> 
                                        <td class="text-end" width="5%">
                                            <a href="{{url('fs_eclaim_instu_eclaim/'.$item2->income)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                                {{ $item2->billcode }}
                                            </a>  
                                        </td>    
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                </div>
            </div>
         
            <div class="col-xl-7 col-md-7">
                <div class="main-card mb-3 card">   
                        <div class="table-responsive mt-2 ms-2 me-2">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr> 
                                        <th class="text-center" width="5%">income</th> 
                                        <th class="text-center">name</th>
                                        <th class="text-center" >Hosxp</th> 
                                        <th class="text-center" >xxx</th> 
                                        <th class="text-center" >999</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ii = 1; ?>
                                    @foreach ($datashow3 as $item3) 
                                    <tr>  
                                        <td class="text-center" width="5%">
                                            {{-- <a href="{{url('fs_eclaim_inhos/'.$item3->income)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"> --}}
                                                {{ $item3->income }}
                                            {{-- </a>  --}}
                                        </td> 
                                        <td class="text-start">{{ $item3->iname }}</td> 
                                        <td class="text-end" width="5%">
                                            <a href="{{url('fs_eclaim_inhos/'.$item3->income)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                                {{ $item3->hosicode }}
                                            </a> 
                                        </td> 
                                        <td class="text-end" width="5%">{{ $item3->xxxicode }}</td>     
                                        <td class="text-end" width="5%">{{ $item3->icode999 }}</td>  
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                </div>
            </div>
        </div>

    </div>

@endsection
@section('footer')
    <script>
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

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
