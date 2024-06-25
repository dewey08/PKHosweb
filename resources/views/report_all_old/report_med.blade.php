@extends('layouts.reportall')
@section('title', 'PK-OFFICER || Report')

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
            border: 10px #ddd solid;
            border-top: 10px #fd6812 solid;
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
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    ?>

        <div class="tabs-animation">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">
    
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div>
        
            </div>

        <div class="row">

            <div class="col-md-12"> 
                    <div class="card-body ">

                        <h4 class="card-title">ตัวชี้วัดสำคัญใน MED</h4>
                        <p class="card-title-desc">ตัวชี้วัดสำคัญใน MED</p> 

                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-ucs" role="tabpanel" aria-labelledby="v-pills-ucs-tab">
                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <div class="card p-4 cardreport">
                                                    <h4 class="card-title" style="color:rgb(10, 151, 85)">ตัวชี้วัดสำคัญใน MED</h4>
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">                                                        
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">ลำดับ</th> 
                                                                    <th class="text-center">ชื่อรายงาน</th> 
                                                                    <th class="text-center">active</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    $number = 0;
                                                                    $total1 = 0; ?>
                                                                @foreach ($report_med as $item)
                                                                    <?php $number++; ?>
                                
                                                                    <tr height="20">
                                                                        <td class="text-font" style="text-align: center;" width="4%" style="color:rgb(248, 12, 12)">{{ $number }}</td>
                                                                        <td class="text-start" style="color:rgb(34, 90, 243);font-size:15px">  
                                                                            <a href="{{url('report_hos_med/'.$item->report_hos_id)}}" target="_blank"> {{ $item->report_hos_name }}</a>  
                                                                        </td>  
                                                                        <td class="text-end" style="color:rgb(10, 151, 85);font-size:15px" width="10%">{{ $item->active}}</td>
                                                                    </tr>
                                                                @endforeach
                                
                                                            </tbody> 
                                                        </table>
                                                    </div>
                                                </div> 
                                            </div> 
                                            {{-- <div class="col-md-8"> 
                                                    <div class="card p-4 card-ucsti">
                                                        <h4 class="card-title" style="color:rgb(10, 151, 85)">STM DETAIL UCS TI :::: >> {{$STMDoc}}</h4>
                                                            <div class="table-responsive"> 
                                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">ลำดับ</th> 
                                                                            <th class="text-center">vn</th> 
                                                                            <th class="text-center">hn</th>
                                                                            <th class="text-center">cid</th> 
                                                                            <th class="text-center">vstdate</th> 
                                                                            <th class="text-center">ptname</th> 
                                                                            <th class="text-center">income</th> 
                                                                            <th class="text-center">debit_total</th>     
                                                                            <th class="text-center">Total_amount</th>   
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $number = 0; $total1 = 0;$total2 = 0;$total3 = 0;$total4 = 0; ?>
                                                                        @foreach ($datashow as $item)
                                                                            <?php $number++; ?>                    
                                                                            <tr height="20">
                                                                                <td class="text-center" width="4%">{{ $number }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->vn }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->hn }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->cid }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                                                                <td class="text-start" style="color:rgb(34, 90, 243);font-size:15px"> {{ $item->ptname }}</td>  
                                                                                <td class="text-center" style="color:rgb(233, 83, 14);font-size:15px" width="10%">{{ number_format($item->income, 2) }}</td>
                                                                                <td class="text-center" style="color:rgb(18, 118, 233);font-size:15px" width="10%">{{ number_format($item->debit_total, 2) }}</td>
                                                                                <td class="text-center" style="color:rgb(10, 151, 85);font-size:15px" width="10%">{{ number_format($item->Total_amount, 2) }}</td> 
                                                                            </tr>
                                                                            <?php
                                                                                    $total1 = $total1 + $item->income;
                                                                                    $total2 = $total2 + $item->debit_total;
                                                                                    $total3 = $total3 + $item->Total_amount;  
                                                                            ?> 
                                                                        @endforeach                    
                                                                    </tbody> 
                                                                    <tr style="background-color: #f3fca1">
                                                                        <td colspan="6" class="text-end" style="background-color: #ffdede"></td>
                                                                        <td class="text-center" style="background-color: rgb(233, 83, 14)"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                                                        <td class="text-center" style="background-color: rgb(18, 118, 233)"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                                                        <td class="text-center" style="background-color: rgb(10, 151, 85)"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label> </td>  
                                                                    </tr>  
                                                                </table>
                                                            </div>
                                                    </div>
                                                </div> 
                                            </div> --}}
                                        </div> 
                                    </div>
                                                                        
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                <!-- end card -->
            </div>
        </div>
   

@endsection
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
 

        });
    </script>
@endsection
