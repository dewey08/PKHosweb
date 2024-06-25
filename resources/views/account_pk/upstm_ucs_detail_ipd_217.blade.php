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
            border-top: 10px #fd6812 solid;
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
        .bar{
            height: 50px;
            background-color: rgb(10, 218, 55);
        }
        .percent{
            position: absolute;
            left: 50%;
            color: black;
        }       
        
    </style>
    <?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    ?>

        <div class="tabs-animation">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">    
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div> 
            </div>
            <div class="row"> 
                <div class="col-md-2"> 
                    <h4 class="card-title">STM DETAIL GROUP</h4>
                    <p class="card-title-desc">รายการ stm ที่อัพโหลดแล้ว</p> 
                </div>
                <div class="col"></div> 
                <div class="col-md-2 text-end">
                    <a href="{{url('upstm_ucs_ipd217')}}" class="ladda-button btn-pill btn btn-primary d-shadow me-2 ms-4" data-style="expand-left">
                        <span class="ladda-label"> <i class="far fa-arrow-alt-circle-left text-primary text-white me-2"></i>Back</span>
                        <span class="ladda-spinner"></span>
                    </a> 
                </div>
            </div>  

     
            <div class="row">
                <div class="col-md-3">                               
                    <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <div class="card p-4 card_pink">
                            <h4 class="card-title" style="color:rgb(10, 151, 85)">STM DETAIL UCS IPD 217</h4>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th class="text-center">STMDoc</th> 
                                            <th class="text-center">total</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $number = 0;
                                        $total1 = 0; ?>
                                        @foreach ($ucs_217 as $item_1)
                                            <?php $number++; ?> 
                                            <tr height="20"> 
                                                <td class="text-start" style="color:rgb(34, 90, 243);font-size:15px"> 
                                                    <a href="{{url('upstm_ucs_detail_ipd_217/'.$item_1->STMDoc)}}"> {{ $item_1->STMDoc }}</a>  
                                                    <td class="text-end" style="color:rgb(10, 151, 85);font-size:15px" width="30%">{{ number_format($item_1->total, 2) }}</td>
                                                </td>   
                                            </tr>
                                        @endforeach 
                                    </tbody> 
                                </table>
                            </div>
                        </div> 
                    </div>  
                </div>
                <div class="col-md-9">
                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                        <div class="tab-pane fade show active" id="v-pills-ucs" role="tabpanel" aria-labelledby="v-pills-ucs-tab">
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="card p-4 card_pink">
                                        <h4 class="card-title" style="color:rgb(10, 151, 85)">STM DETAIL UCS IPD :::: >> {{$STMDoc}}</h4>
                                        <div class="table-responsive">
                                            {{-- <table id="example2" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ลำดับ</th> 
                                                        <th class="text-center">an</th> 
                                                        <th class="text-center">hn</th>
                                                        <th class="text-center">cid</th> 
                                                        <th class="text-center">vstdate</th> 
                                                        <th class="text-center">ptname</th> 
                                                        <th class="text-center">income</th> 
                                                        <th class="text-center">ลูกหนี้ที่ตั้ง</th>   
                                                        <th class="text-center">STM 217</th>   
                                                        <th class="text-center">total_approve</th>   
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $number = 0; $total1 = 0;$total2 = 0;$total3 = 0;$total4 = 0; ?>
                                                    @foreach ($datashow as $item)
                                                        <?php $number++; ?>                    
                                                        <tr height="20">
                                                            <td class="text-center" width="4%">{{ $number }}</td>
                                                            <td class="text-center" width="7%">{{ $item->an }}</td>
                                                            <td class="text-center" width="7%">{{ $item->hn }}</td>
                                                            <td class="text-center" width="7%">{{ $item->cid }}</td>
                                                            <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                                            <td class="text-start" style="color:rgb(34, 90, 243);font-size:15px"> {{ $item->ptname }}</td>  
                                                            <td class="text-center" style="color:rgb(233, 83, 14);font-size:15px" width="10%">{{ number_format($item->income, 2) }}</td>
                                                            <td class="text-center" style="color:rgb(18, 118, 233);font-size:15px" width="10%">{{ number_format($item->debit_total, 2) }}</td>
                                                            <td class="text-center" style="color:rgb(35, 204, 125);font-size:15px" width="10%">{{ number_format($item->total_217, 2) }}</td> 
                                                            <td class="text-center" style="color:rgb(10, 151, 85);font-size:15px" width="10%">{{ number_format($item->total_approve, 2) }}</td>  
                                                           
                                                        </tr>
                                                        <?php
                                                                $total1 = $total1 + $item->income;
                                                                $total2 = $total2 + $item->debit_total;
                                                                $total3 = $total3 + $item->total_217;  
                                                                $total4 = $total4 + $item->total_approve;  
                                                        ?> 
                                                    @endforeach                    
                                                </tbody> 
                                                <tr style="background-color: #f3fca1">
                                                    <td colspan="6" class="text-end" style="background-color: #ffdede"></td>
                                                    <td class="text-center" style="background-color: rgb(233, 83, 14)"><label for="" style="color: #FFFFFF">{{ number_format($total1,2) }}</label></td>
                                                    <td class="text-center" style="background-color: rgb(18, 118, 233)"><label for="" style="color: #FFFFFF">{{ number_format($total2,2) }}</label></td>
                                                    <td class="text-center" style="background-color: rgb(10, 151, 85)"><label for="" style="color: #FFFFFF">{{ number_format($total3,2) }}</label> </td>  
                                                    <td class="text-center" style="background-color: rgb(35, 204, 125)"><label for="" style="color: #FFFFFF">{{ number_format($total4,2) }}</label> </td> 
                                                </tr>  
                                            </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            $('#example6').DataTable();
            $('#example7').DataTable();
            $('#example8').DataTable();
            $('#example9').DataTable();
            $('#example10').DataTable();
            $('#example11').DataTable();

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            var bar = $('.bar');
            var percent = $('.percent');
            $('form').ajaxForm({
                beforeSend: function() {
                    var percentVal = '0%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete+'%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                complete: function(xhr) { 
                    Swal.fire({
                        title: 'UP STM สำเร็จ',
                        text: "You UP STM success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "{{ url('upstm_ucs') }}";
                        }
                    })
                }
            })

            $('#Upstm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                // alert('OJJJJOL');
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'Up Statment สำเร็จ',
                                text: "You Up Statment data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })

                        } else {
                            Swal.fire({
                                title: 'UP Statment ซ้ำ',
                                text: "You Up Statment data success",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            });

            //    $('#UpdateHN').click(function() {
            //             var datepicker = $('#datepicker').val();
            //             var datepicker2 = $('#datepicker2').val();

            //             $.ajax({
            //                 url: "{{ route('acc.upstm_hn') }}",
            //                 type: "POST",
            //                 dataType: 'json',
            //                 data: {
            //                     datepicker,datepicker2
            //                 },
            //                 success: function(data) {
            //                     if (data.status == 200) {
            //                         Swal.fire({
            //                             title: 'อัพเดทข้อมูลสำเร็จ',
            //                             text: "You Update data success",
            //                             icon: 'success',
            //                             showCancelButton: false,
            //                             confirmButtonColor: '#06D177',
            //                             confirmButtonText: 'เรียบร้อย'
            //                         }).then((result) => {
            //                             if (result
            //                                 .isConfirmed) {
            //                                 console.log(
            //                                     data);
            //                                 window.location.reload();
            //                                 // window.location="{{ url('warehouse/warehouse_index') }}";
            //                             }
            //                         })
            //                     } else {

            //                     }

            //                 },
            //             });
            //     });

        });
    </script>
@endsection
