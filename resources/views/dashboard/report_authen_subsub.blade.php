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
                        รายชื่อคนไข้ที่มาใช้บริการแต่ไม่ออก Authen Code
                        <div class="btn-actions-pane-right">

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">vn</th>
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">pdx</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;$total1 = 0; $total2 = 0;$total3 = 0; ?>
                                @foreach ($datashow_ as $item)
                                    <?php $number++; ?>
                                    <tr height="20">
                                        <td class="text-font" style="text-align: center;width: 5%;">{{ $number }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 10%;" > {{ $item->cid }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 7%;"> {{ $item->hn }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 10%;"> {{ $item->vn }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 15%;"> {{ $item->vstdate }}</td>
                                        <td class="text-font text-pedding" style="text-align: left;"> {{ $item->Fullname }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 5%;"> {{ $item->pdx }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 5%;"> {{ $item->pttype }} </td>
                                        <td class="text-font text-pedding" style="text-align: right;width: 7%;color:#f02e0b"> &nbsp;&nbsp;{{ number_format(($item->debit),2) }} </td>
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
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

    @endsection
