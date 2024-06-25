@extends('layouts.accountnew')
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
        <form action="{{ url('account_nopaid') }}" method="GET">
            @csrf
            <div class="row "> 
                <div class="col-md-4">
                  
                    <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">   Detail Overdue OPD</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Visit ที่มีรายการค่าใช้จ่าย แต่ไม่มีการออกใบเสร็จ หรือลงค้าง OPD</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">เลือก</div>
         
                    @if ($budget_year =='')
                    <div class="col-md-2"> 
                        <select name="budget_year" id="budget_year" class="form-control inputmedsalt text-center" style="width: 100%">
                            @foreach ($dabudget_year as $item_y)
                                @if ($y == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif                                   
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-md-2"> 
                        <select name="budget_year" id="budget_year" class="form-control inputmedsalt text-center" style="width: 100%">
                            @foreach ($dabudget_year as $item_y)
                                @if ($budget_year == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif                                   
                            @endforeach
                        </select>
                    </div>
                @endif
                
                <div class="col-md-2 text-start"> 
                    <button type="submit" class="ladda-button btn-pill btn btn-primary cardfinan" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button> 
                </div> 
            </div>
        </form>  
            <div class="row"> 
            
                <div class="col-xl-5">                
                    <div class="card cardfinan">
                        <div class="card-body"> 
                            <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>                                          
                                                <th width="5%" class="text-center">ลำดับ</th>  
                                                <th class="text-center" width="5%">เดือน</th>  
                                                <th class="text-center" >income</th>
                                                <th class="text-center" >ต้องชำระ</th>
                                                <th class="text-center">ชำระแล้ว</th>
                                                <th class="text-center">ต้องลงค้าง</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($datashow as $item) 
                                            {{-- @foreach ($f_finance_opd as $item)  --}}
                                                <?php 
                                                    $y = $item->year;
                                                    $ynew = $y + 543; 
                                                ?>
                                                <tr style="font-size: 13px">                                                  
                                                    <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                    <td class="p-2" >{{$item->MONTH_NAME}} {{$item->year}}</td>  
                                                    <td class="text-center" width="10%">{{ number_format($item->sum_income, 2) }}</td> 
                                                    <td class="text-center" width="10%">{{ number_format($item->sum_paid_money, 2) }}</td>   
                                                    <td class="text-center" width="10%" style="color:rgb(7, 167, 113)">{{ number_format($item->sum_rcpt_money, 2) }}</td> 
                                                    <td class="text-center" width="10%" style="color:rgb(202, 55, 29)">
                                                        <a href="{{url('account_nopaid_sub/'.$item->months.'/'.$item->year)}}" target="_blank">{{ number_format($item->sum_Total, 2) }} </a> 
                                                        {{-- <div id="headingTwo" class="b-radius-0">   
                                                            <button type="button" data-bs-toggle="collapse" data-bs-target="#myCollapse" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-secondary" style="background-color: rgb(176, 205, 243);border-radius: 3em 3em 3em 3em"> 
                                                                {{ number_format($item->sum_Total, 2) }}
                                                            </button> --}}
                                                            {{-- <button type="button" id="myBtn" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-secondary" style="background-color: rgb(176, 205, 243);border-radius: 3em 3em 3em 3em"> 
                                                                {{ number_format($item->sum_Total, 2) }}
                                                            </button>   --}}
                                                            {{-- <button type="button" data-bs-toggle="collapse" data-bs-target="#myCollapse" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-secondary" style="background-color: rgb(176, 205, 243);border-radius: 3em 3em 3em 3em"> 
                                                                {{ number_format($item->sum_Total, 2) }}
                                                            </button> --}}
                                                            
                                                        {{-- </div>  --}}
                                                    </td> 
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div> 
                <div class="col-xl-7"> 
                    <div class="card cardfinan">
                        <div class="card-body"> 
                            <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example2" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>                                          
                                                <th width="5%" class="text-center">ลำดับ</th>   
                                                <th class="p-2">แผนก</th> 
                                                <th class="text-center" >income</th>
                                                <th class="text-center" >ต้องชำระ</th>
                                                <th class="text-center">ชำระแล้ว</th>
                                                <th class="text-center">ต้องลงค้าง</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($main_dep as $item2)  
                                                <tr style="font-size: 13px">                                                  
                                                    <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                    <td class="p-2" >{{$item2->department}}</td>  
                                                    <td class="text-center" width="10%">{{ number_format($item2->sum_income, 2) }}</td> 
                                                    <td class="text-center" width="10%">{{ number_format($item2->sum_paid_money, 2) }}</td>   
                                                    <td class="text-center" width="10%" style="color:rgb(7, 167, 113)">{{ number_format($item2->sum_rcpt_money, 2) }}</td> 
                                                    <td class="text-center" width="10%" style="color:rgb(202, 55, 29)">
                                                        {{-- {{ number_format($item2->sum_Total, 2) }} --}}
                                                        <a href="{{url('account_nopaid_sub/'.$item2->months.'/'.$item2->year)}}" target="_blank">{{ number_format($item2->sum_Total, 2) }} </a>  
                                                    </td> 
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="row"> 
                <div class="col-xl-12"> 
                </div> 
            </div>

            {{-- <div data-parent="#accordion" class="collapse show" id="myCollapse"> --}}
            <div data-parent="#accordion" id="myCollapse" class="collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card cardfinan">    
                                <div class="card-body ">  
                                    <div class="row">  
                                        <div class="col-md-12">     
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h4 class="card-title">รายการที่ต้องลงค้าง</h4>
                                                    </div>
                                                    <div class="col"></div>
                                                    
                                                </div>
                                               
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-bs-toggle="tab" href="#detail" role="tab">
                                                            <span class="d-block d-sm-none"><i class="fas fa-detail"></i></span>
                                                            <span class="d-none d-sm-block">รายละเอียด</span>    
                                                        </a>
                                                    </li>
                                                  
                                                </ul>
        
                                                <!-- Tab panes -->
                                                <div class="tab-content p-3 text-muted">
                                                    <div class="tab-pane active" id="detail" role="tabpanel">
                                                        <p class="mb-0">
                                                            <div class="table-responsive">
                                                                <table id="example2" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>                                          
                                                                            <th width="5%" class="text-center">ลำดับ</th>  
                                                                            <th class="text-center">vn</th>  
                                                                            <th class="text-center" width="5%">hn</th> 
                                                                            <th class="text-center" width="10%">income</th> 
                                                                            <th class="text-center" width="10%">ส่วนลด</th>
                                                                            <th class="text-center" width="10%">ต้องชำระ</th> 
                                                                            <th class="text-center" width="10%">ชำระแล้ว</th> 
                                                                            <th class="text-center" width="10%">ค้างชำระ</th> 
                                                                            <th class="text-center" width="10%">ต้องลงค้าง</th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </p>
                                                    </div>
                                                    
                                                </div> 
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>   
                    </div>
                </div>
            </div> 


    </div>

@endsection
@section('footer')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $("#myBtn").click(function(){
                $("#myCollapse").collapse("toggle");
            });

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
