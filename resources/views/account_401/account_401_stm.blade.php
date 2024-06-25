@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
@section('content')
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
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="card-title" style="color:green">Detail STM 1102050101.401</h4> 
            
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Detail STM</a></li>
                                    <li class="breadcrumb-item active">1102050101.401</li>
                                </ol>
                            </div>
            
                        </div>
                    </div>
                </div> 
            </div> 

        <div class="row">
            <div class="col-md-12">
                <div class="card card_audit_4c">
                   
                    <div class="card-body">
                            {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center" width="5%">vn</th> 
                                    {{-- <th class="text-center" >an</th> --}}
                                    <th class="text-center" >hn</th>
                                    <th class="text-center" >cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">vstdate</th> 
                                    <th class="text-center">pttype</th> 
                                    <th class="text-center">ลูกหนี้</th>
                                    <th class="text-center">ยอดชดเชย</th>
                                    <th class="text-center">STMdoc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; 
                                  $total1 = 0;
                                $total2 = 0;
                                $total3 = 0;
                                $total4 = 0;?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?>
                                    <tr height="20" style="font-size: 14px;">
                                        <td class="text-font" style="text-align: center;" width="4%">{{ $number++ }} </td> 
                                        <td class="text-center" width="8%">{{ $item->vn }}</td>
                                        {{-- <td class="text-center" width="8%">{{ $item->an }}</td> --}}
                                        <td class="text-center" width="5%">{{ $item->hn }}</td>
                                        <td class="text-center" width="10%">{{ $item->cid }}</td>
                                        <td class="p-2">{{ $item->ptname }}</td>
                                        <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                        {{-- <td class="text-center" width="7%">{{ $item->dchdate }}</td> --}}
                                        <td class="text-center" width="5%">{{ $item->pttype }}</td>
                                        
                                        <td class="text-end" style="color:rgb(12, 100, 201)" width="7%"> {{ number_format($item->debit_total, 2) }}</td> 
                                        @if ($item->stm_money < $item->debit_total)
                                            <td class="text-end" style="color:rgb(243, 74, 45)" width="7%"> {{ number_format($item->stm_money, 2) }}</td>
                                        @else
                                            <td class="text-end" style="color:rgb(4, 143, 73)" width="7%"> {{ number_format($item->stm_money, 2) }}</td>
                                        @endif
                                        <td class="text-center" width="12%">{{ $item->STMdoc }}</td>
                                    </tr>
                                    <?php
                                            $total1 = $total1 + $item->debit_total;
                                            $total2 = $total2 + $item->stm_money; 
                                    ?>
 
                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="7" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-center" style="background-color: #1d80dd"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                <td class="text-center" style="background-color: #098f88" ><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                <td class="text-end" style="background-color: #fca1a1"></td>
                            </tr>  
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
