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

    <div class="tabs-animation mb-5">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        รายละเอียดข้อมูล Visit ที่มีรายการค่าใช้จ่าย แต่ไม่มีการออกใบเสร็จ หรือลงค้าง IPD
                        <div class="btn-actions-pane-right">

                        </div>
                    </div>
                    <div class="card-body"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center" >an</th>
                                    <th class="text-center" >hn</th>
                                    <th class="text-center" >cid</th>
                                    <th class="text-center">ptname</th> 
                                    <th class="text-center">dchdate</th> 
                                    <th class="text-center">dchtime</th>
                                    <th class="text-center">pttype</th> 
                                    <th class="text-center">แผนก</th>                                 
                                    <th class="text-center">ค่าใช้จ่ายทั้งหมด</th> 
                                    <th class="text-center">ต้องชำระ</th> 
                                    <th class="text-center">ชำระแล้ว</th> 
                                    <th class="text-center">ค้างชำระ</th> 
                                    <th class="text-center">Finance No.</th> 
                                    <th class="text-center">เลขที่ใบเสร็จ</th> 
                                    <th class="text-center">total_amount</th>
                                    <th class="text-center">staff</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?>
                                   
                                        <tr height="20" style="font-size: 14px;">
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>  
                                            <td class="text-center" width="7%">{{ $item->an }}</td> 
                                            <td class="text-center" width="4%">{{ $item->hn }}</td>   
                                            <td class="text-center" width="7%">{{ $item->cid }}</td>  
                                            <td class="p-2" >{{ $item->ptname }}</td>  
                                            <td class="text-center" width="7%">{{ $item->dchdate }}</td>    
                                            <td class="text-center" width="4%">{{ $item->dchtime }}</td>  
                                            <td class="text-center" width="4%">{{ $item->pttype }}</td>  
                                            <td class="p-2" width="10%">{{ $item->department }}</td> 
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->income,2)}}</td> 
                                            <td class="text-end" style="color:rgb(248, 44, 44)" width="7%">{{ number_format($item->paid_money,2)}}</td> 
                                            <td class="text-end" style="color:rgb(125, 202, 23)" width="7%">{{ number_format($item->rcpt_money,2)}}</td> 
                                            <td class="text-end" style="color:rgb(235, 146, 30)" width="7%">{{ number_format($item->remain_money,2)}}</td> 
                                            <td class="text-center" width="7%">{{ $item->finance_number }}</td>
                                            <td class="text-center" width="7%">{{ $item->book_number }}</td>
                                            <td class="text-center" width="7%">{{ $item->total_amount }}</td>
                                            <td class="p-2" width="5%">{{ $item->staff }}</td> 
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
