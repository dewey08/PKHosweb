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

            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        รายชื่อเจ้าหน้าที่ไม่ Authen Code
                        <div class="btn-actions-pane-right">

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อ-นามสกุลเจ้าหน้าที่</th>
                                    <th class="text-center">เปิด Visit(คน)</th>
                                    <th class="text-center">authen(คน)</th>
                                    <th class="text-center">ไม่ authen(คน)</th>
                                    <th class="text-center">ค่าใช้จ่าย Hosxp ที่ไม่ Authen Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;$total1 = 0; $total2 = 0;$total3 = 0; ?>
                                @foreach ($data_yearipd as $item)
                                    <?php $number++; ?>
                                    <tr height="20">
                                        <td class="text-font" style="text-align: center;width: 5%;">{{ $number }}</td>
                                        <td class="text-font text-pedding" style="text-align: left;"> {{ $item->fullstaff }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 15%;"> {{ $item->countan }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 15%;"> {{ $item->authenIPD }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 15%;">
                                            <a href="{{url('report_authen_subsubipd/'.$item->month.'/'.$item->year.'/'.$item->staff)}}" class="text-danger" target="_blank">{{ $item->noAuthen }}</a>
                                            {{-- <a href="{{url('report_authen_subsub/'.$item->month.'/'.$item->year.'/'.$item->staff)}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm" target="_blank">{{ $item->noAuthen }}</a> --}}
                                        </td>
                                        <td class="text-font text-pedding" style="text-align: right;width: 20%;color:#f02e0b"> &nbsp;&nbsp;{{ number_format(($item->sumdebit),2) }} </td>
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
