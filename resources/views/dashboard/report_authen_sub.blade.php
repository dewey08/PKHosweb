@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Dashboard')


@section('content')

    <?php
        $ynow = date('Y')+543;
        $mo =  date('m');
    ?>

     <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
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
               border-top: 10px rgb(212, 106, 124) solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% {
                   transform: rotate(360deg);
               }
               }
               .is-hide{
               display:none;
               }
    </style>

    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        <div class="row">

            {{-- @foreach ($data_year as $item)
                <div class="col-sm-12 col-md-3">
                    <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-start card">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content">
                                <h5 class="text-start">{{$item->staff}}</h5>
                                <div class="widget-chart-flex">
                                    <div class="widget-numbers mb-0 w-100">
                                        <div class="widget-chart-flex">
                                            <div class="fsize-3 text-primary">
                                                <small class="opacity-5 text-muted"><i class="fa-solid fa-person-walking-arrow-right me-2"></i></small>
                                                <label for="" style="font-size: 12px">{{$item->countvn}} คน</label>

                                            </div>

                                            <div class="ms-auto">
                                                <a href="{{url('report_authen_subsub/'.$item->month.'/'.$item->year.'/'.$item->staff)}}" target="_blank">
                                                    <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                            <span class="text-danger ps-2">
                                                                <span class="pe-1">
                                                                    <i class="fa fa-angle-left"></i>
                                                                </span>
                                                                <label for="" style="font-size: 14px">ไม่ Authen {{$item->noAuthen}} คน</label>
                                                            </span>
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
            @endforeach --}}
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        แยกตามรายชื่อเจ้าหน้าที่
                        <div class="btn-actions-pane-right">

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">vn</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">ค่าใช้จ่าย Hosxp ที่ไม่ Authen Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;$total1 = 0; $total2 = 0;$total3 = 0; ?>
                                @foreach ($data_year as $item)
                                    <?php $number++; ?>
                                    <tr height="20">
                                        <td class="text-font" style="text-align: center;width: 5%;">{{ $number }}</td>
                                        <td class="text-font text-pedding" style="text-align: left;">{{ $item->vn }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 15%;">{{ $item->hn }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 15%;">{{ $item->cid }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 15%;">{{ $item->ptname }} 
                                            {{-- <a href="{{url('report_authen_subsub/'.$month.'/'.$year.'/'.$item->staff)}}" class="text-danger" target="_blank">000</a> --}}
                                            {{-- <a href="{{url('report_authen_subsub/'.$item->month.'/'.$item->year.'/'.$item->staff)}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm" target="_blank">{{ $item->noAuthen }}</a> --}}
                                        {{-- </td> --}}
                                        <td class="text-font text-pedding" style="text-align: right;width: 20%;color:#f02e0b"> &nbsp;&nbsp;{{ number_format(($item->debit),2) }} </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

    @endsection
