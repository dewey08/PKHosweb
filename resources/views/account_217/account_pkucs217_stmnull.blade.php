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
$datenow = date('Y-m-d');
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
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Detail</h4>
    
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Detail</a></li>
                                <li class="breadcrumb-item active">1102050101.217</li>
                            </ol>
                        </div>
    
                    </div>
                </div>
            </div>
            <!-- end page title -->
        </div> <!-- container-fluid -->
        
        <div class="row">
            <div class="col-md-12">
                <div class="card cardacc">
                   
                    <div class="card-body">  
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center">stm_trainid</th>
                                    <th class="text-center">an</th>
                                    <th class="text-center" >hn</th> 
                                    <th class="text-center">ptname</th> 
                                    <th class="text-center">dchdate</th>  
                                    <th class="text-center">ลูกหนี้</th> 
                                    <th class="text-center">Stm 217</th> 
                                    <th class="text-center">ส่วนต่าง</th>  
                                    <th class="text-center">ชดเชย</th>  
                                    <th class="text-center">VA</th>  
                                    <th class="text-center">STMdoc</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; 
                                $total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;
                                ?>
                                @foreach ($data as $item)
                                    <?php $number++; ?>
                                    <tr height="20" style="font-size: 14px;">
                                        <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>  
                                        <td class="text-center" width="6%">{{ $item->stm_trainid }}</td>
                                        <td class="text-center" width="6%">{{ $item->an }}</td> 
                                        <td class="text-center" width="5%">{{ $item->hn }}</td>   
                                        <td class="p-2" width="10%">{{ $item->ptname }}</td>   
                                        <td class="text-center" width="6%">{{ $item->dchdate }}</td>  
                                        <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->debit_total,2)}}</td> 
                                        <td class="text-end" style="color:rgb(184, 12, 169)" width="7%">{{ number_format(($item->stm_money),2)}}</td> 
                                        <td class="text-end" style="color:rgb(216, 95, 14)" width="7%">{{ number_format($item->debit_total-$item->stm_money,2)}}</td> 
                                        <td class="text-end" style="color:rgb(9, 196, 180)" width="8%">{{ number_format($item->stm_total,2)}}</td>  
                                        <td class="text-center" width="6%">{{ $item->va }}</td> 
                                        <td class="p-2" width="10%">{{ $item->STMdoc }}</td>  
                                    </tr>
                                        <?php
                                            $total1 = $total1 + $item->debit_total;
                                            $total2 = $total2 + $item->stm_money; 
                                            $total3 = $total3 + $item->debit_total-$item->stm_money;
                                            $total4 = $total4 + $item->stm_total;
                                        ?>
 
                                @endforeach  
                               
                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="6" class="text-end" style="background-color: #ff9d9d"></td>
                                <td class="text-end" style="background-color: #ace5fc">{{ number_format($total1,2)}}</td> 
                                <td class="text-end" style="background-color: #e09be9">{{ number_format($total2,2)}}</td> 
                                <td class="text-end" style="background-color: #f5a382">{{ number_format($total3,2)}}</td> 
                                <td class="text-end" style="background-color: #bbf0e3">{{ number_format($total4,2)}}</td>  
                                <td colspan="2" class="text-end" style="background-color: #ff9d9d"></td> 
                            </tr>   
                        </table>
                    </div>
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
