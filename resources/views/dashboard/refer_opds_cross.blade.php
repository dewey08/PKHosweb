@extends('layouts.report_font')
@section('title', 'PK-BACKOFFice || REFER')
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
        
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Referข้าม CUP ภายในจังหวัด
                        <div class="btn-actions-pane-right">
                            <form action="{{ route('rep.refer_opds_cross') }}" method="POST">
                                @csrf
                                <div class="row"> 
                                    <div class="col-md-1 text-end">วันที่</div>
                                    <div class="col-md-7 text-center">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                            data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                data-date-language="th-th" value="{{ $startdate }}" />
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                data-date-language="th-th" value="{{ $enddate }}" /> 
                                        </div>
                                    </div> 
                                    <div class="col-md-2">  
                                        <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                        </button> 
                                    
                                        <a href="{{url('refer_opds_cross_excel/'.$startdate.'/'.$enddate)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                            <i class="fa-solid fa-file-excel me-2"></i>
                                            Export
                                        </a>
                                    
                                    </div>
                                </div> 
                            </form> 
                        </div>
                    </div>
                    <div class="card-body"> 
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">hn</th> 
                                    <th class="text-center">ชื่อ-นามสกุล</th> 
                                    <th class="text-center">Hmain</th>
                                    <th class="text-center">Hcode</th>
                                    <th class="text-center">วันที่รับบริการ</th>                                     
                                    <th class="text-center">pdx</th> 
                                    <th class="text-center">ค่าบริการ</th> 
                                    <th class="text-center">ยอดเรียกเก็บตามข้อตกลง</th> 
 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($datashow_ as $item)
                                    <?php $number++; ?>
                                    <tr height="20">
                                        <td class="text-font" style="text-align: center;">{{ $number }}</td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item->cid }}</td>   
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item->hn }}</td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item->fullname }} </td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item->hospmain }} </td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item->hcode }} </td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item->vstdate }} </td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item->pdx }} </td> 
                                        <td class="text-font text-pedding" style="text-align: right;">&nbsp;&nbsp; {{ number_format($item->uc_money,2) }} </td> 
                                        <td class="text-font text-pedding" style="text-align: right;"> &nbsp;&nbsp;{{ number_format($item->uc_money_kor_tok,2) }} </td>  
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
        });
    </script>
@endsection
