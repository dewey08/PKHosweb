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
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Detail</h4>
    
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Detail</a></li>
                                <li class="breadcrumb-item active">1102050101.202</li>
                            </ol>
                        </div>
    
                    </div>
                </div>
            </div>
            <!-- end page title -->
        </div> <!-- container-fluid -->

        <div class="row ">
            <div class="col-md-12">
                <div class="card cardacc">
                    {{-- <div class="card-header">
                    รายละเอียด 1102050101.202
                        <div class="btn-actions-pane-right">

                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center" width="5%">vn</th>
                                    <th class="text-center">an</th>
                                    <th class="text-center" >hn</th>
                                    <th class="text-center" >cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">Adjrw</th> 
                                    <th class="text-center">Adjrw*8350</th>
                                    <th class="text-center">vstdate</th>
                                    <th class="text-center">dchdate</th>
                                    <th class="text-center">pttype</th>
                                    {{-- <th class="text-center">สปสช</th> --}}
                                    {{-- <th class="text-center">income</th> --}}
                                    <th class="text-center">ลูกหนี้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; 
                                 $total1 = 0;
                                $total2 = 0;
                                $total3 = 0;
                                $total4 = 0;?>
                                @foreach ($data as $item)
                                    <?php $number++; ?>
                                    <tr height="20">
                                        <td class="text-font" style="text-align: center;" width="5%">{{ $number }}</td>
                                        <td class="text-center" width="10%">{{ $item->vn }}</td>
                                                <td class="text-center" width="10%">{{ $item->an }}</td>
                                                <td class="text-center" width="5%">
                                                   
                                                    <button type="button" class="btn btn-icon btn-shadow btn-dashed btn-outline-primary" data-bs-toggle="modal" data-bs-target="#DetailModal{{ $item->an }}" data-bs-placement="right" title="ค่าใช้จ่าย"> {{ $item->hn }}</button>
                                                </td>
                                                <td class="text-center" width="10%">{{ $item->cid }}</td>
                                                <td class="p-2" >{{ $item->ptname }}</td>
                                                <td class="text-center" width="7%">{{ $item->adjrw }}</td>
                                                <td class="text-center" width="7%">{{ $item->total_adjrw_income }}</td>
                                                <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                                <td class="text-center" width="7%">{{ $item->dchdate }}</td>
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td>
                                                {{-- <td class="text-center" style="color:rgb(14, 108, 196)" width="5%">{{ $item->subinscl }}</td> --}}
                                                {{-- <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->income_group }}</td> --}}
                                                <td class="text-end" width="10%">
                                                   
                                                        {{ number_format($item->debit_total,2)}} 
                      
                                                </td>
                                    </tr>
                                    <?php
                                    $total1 = $total1 + $item->debit_total;
                                    $total2= $total2 + $item->total_adjrw_income;
                            ?>
                                    {{-- <div class="modal fade" id="DetailModal{{ $item->an }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        รายละเอียดค่าใช้จ่าย
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php

                                                        $detail_ =  DB::connection('mysql')->select('
                                                            SELECT an,vn,hn,icode,name as dname,qty,unitprice,sum_price
                                                                FROM acc_opitemrece_stm
                                                                WHERE an ="'.$item->an.'"
                                                        ');
                                                    ?> 
                                                     <div class="row">
                                                        <div class="col-md-2 text-primary">
                                                            <label for="">icode </label>
                                                        </div>
                                                        <div class="col-md-4 text-primary">
                                                            <label for="">รายการ </label>
                                                        </div>
                                                        <div class="col-md-2 text-primary">
                                                            <label for="">จำนวน </label>
                                                        </div>
                                                        <div class="col-md-2 text-primary">
                                                            <label for="">ราคา </label>
                                                        </div>
                                                        <div class="col-md-2 text-primary">
                                                            <label for="" >รวม</label>
                                                        </div>
                                                    </div>
                                                    @foreach ($detail_ as $items)
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">{{$items->icode}} </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">{{$items->dname}} </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">{{$items->qty}}</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">{{$items->unitprice}}</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">{{$items->sum_price}}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="row">
                                                        <div class="col"> </div>
                                                        <div class="col-md-2 text-danger"> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-md-12 text-end">
                                                        <div class="form-group">
                                                            <button type="button"
                                                                class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                                                data-bs-dismiss="modal"><i class="fa-solid fa-xmark me-2"></i>Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="7" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-center" style="background-color: #f08640"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label> </td> 
                                <td colspan="3" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-center" style="background-color: #44E952"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label> </td> 
                                
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
