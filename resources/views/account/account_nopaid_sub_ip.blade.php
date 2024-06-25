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
            border-top: 10px #1fdab1 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
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
    <form action="{{ url('account_nopaid_sub') }}" method="GET">
        @csrf
    <div class="row"> 
        <div class="col-md-5">
            <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">   Detail Overdue IPD</h4>
            <p class="card-title-desc">รายละเอียดข้อมูล Visit ที่มีรายการค่าใช้จ่าย แต่ไม่มีการออกใบเสร็จ หรือลงค้าง IPD</p>
        </div>
        <div class="col"></div>
        <div class="col-md-4">
            {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                <input type="text" class="form-control inputmedsalt" name="startdate" id="datepicker" placeholder="Start Date"
                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $startdate }}" required/>
                <input type="text" class="form-control inputmedsalt" name="enddate" placeholder="End Date" id="datepicker2"
                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $enddate }}" required/> 
                    <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary inputmedsalt" data-style="expand-left" id="Pulldata">
                        <span class="ladda-label"><i class="pe-7s-search btn-icon-wrapper me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button>   
            </div>  --}}
        </div> 
    </div>
</form>
        <div class="row ">
            <div class="col-md-12">
                <div class="card cardfinan"> 
                    <div class="card-body"> 
                        {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center" >an</th>
                                    <th class="text-center" >hn</th>
                                    {{-- <th class="text-center" >cid</th> --}}
                                    <th class="text-center">ptname</th> 
                                    <th class="text-center">dchdate</th>  
                                    <th class="text-center">pttype</th> 
                                    {{-- <th class="text-center">แผนก</th> --}}
                                    <th class="text-center">income</th> 
                                    <th class="text-center">สิทธิ์ที่ 1</th> 
                                    <th class="text-center">สิทธิ์ที่ 2</th> 
                                    <th class="text-center">paidmoney</th> 
                                    <th class="text-center">ชำระแล้ว</th> 
                                    <th class="text-center">ต้องลงค้าง</th> 
                                    <th class="text-center">ต้องลงส่วนลด</th>
                                    <th class="text-center">Finance No.</th>  
                                    <th class="text-center">total_amount</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?>
                                
                                        <tr height="20" style="font-size: 14px;">
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>  
                                            <td class="text-center" width="6%">{{ $item->an }}</td> 
                                            <td class="text-center" width="4%">{{ $item->hn }}</td>   
                                            {{-- <td class="text-center" width="6%">{{ $item->cid }}</td>   --}}
                                            <td class="p-2">{{ $item->ptname }}</td>  
                                            <td class="text-center" width="6%">{{ $item->dchdate }}</td>   
                                            <td class="text-center" width="4%">{{ $item->pttype }}</td> 
                                            {{-- <td class="p-2" width="10%">{{ $item->department }}</td>  --}}
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="5%">{{ number_format($item->income,2)}}</td> 
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="5%">{{ number_format($item->pttype_1,2)}}</td> 
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="5%">{{ number_format($item->pttype_2,2)}}</td> 
                                            <td class="text-end" style="color:rgb(243, 61, 55)" width="5%">{{ number_format($item->paid_money,2)}}</td> 
                                            <td class="text-end" style="color:rgb(125, 202, 23)" width="5%">{{ number_format($item->rcpt_money,2)}}</td> 
                                            
                                                @if ($item->pttype_1 > 0 || $item->pttype ='15')
                                                    @if ($item->pttype_1 < 1)
                                                        <td class="text-end" style="color:rgb(4, 128, 111)" width="5%"> {{ number_format($item->pttype_1,2)}} </td> 
                                                        <td class="text-end" style="color:rgb(240, 25, 25);font-size:17px" width="5%"> {{ number_format($item->paid_money- $item->discount_money- $item->rcpt_money,2)}} </td> 
                                                    @else
                                                        @if ($item->rcpt_money == $item->pttype_1)
                                                            <td class="text-end" style="background-color:rgb(15, 202, 177);color:white;font-size:17px" width="5%"> 0.00 </td> 
                                                            <td class="text-end" style="background-color:rgb(5, 192, 167);color:white;font-size:17px" width="5%"> 0.00 </td> 
                                                        @else
                                                            <td class="text-end" style="background-color: rgb(248, 55, 21);color:white;font-size:17px" width="5%"> {{ number_format($item->pttype_1 - $item->discount_money- $item->rcpt_money,2)}} </td> 
                                                            <td class="text-end" style="color:rgb(240, 25, 25);font-size:17px" width="5%"> {{ number_format($item->paid_money- $item->discount_money- $item->rcpt_money,2)}} </td> 
                                                        @endif 
                                                    @endif
                                                    
                                                @else
                                                    <td class="text-end" style="color:rgb(235, 146, 30)" width="5%">  {{ number_format($item->income,2)}} </td> 
                                                @endif
                                               
                                          
                                            
                                            @if ($item->book_number == '')
                                            <td class="text-center" width="7%"></td>
                                            @else
                                            <td class="text-center" width="7%">{{ $item->book_number }}/{{ $item->finance_number }}</td> 
                                            @endif
                                            <td class="text-center" style="color:rgb(125, 202, 23)" width="7%"> {{ number_format($item->rp_total_amount,2)}}</td> 
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
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
        });

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
@endsection
