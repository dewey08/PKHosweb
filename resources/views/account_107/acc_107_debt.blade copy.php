@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
{{-- <link href="{{ asset('fonts') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Srisakdi&display=swap" rel="stylesheet"> --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Srisakdi:wght@400;700&display=swap" rel="stylesheet">
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
 

        function acc_107_debt_outbook(acc_1102050102_107_id) {
            Swal.fire({
                title: 'ต้องการออกจดหมายใช่ไหม?',
                // text: "ข้อมูลนี้จะถูก !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ออกเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('acc_107_debt_outbook') }}" + '/' + acc_1102050102_107_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            // if (response.status == 200) {
                            Swal.fire({
                                title: 'ออกจดหมายสำเร็จ!',
                                text: "You Send letter success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // $("#sid" + acc_1102050102_106_id).remove();
                                    // window.location.reload();
                                      window.location = "acc_107_debt_print"+ '/' + acc_1102050102_107_id; //     
                                }
                            })
                            // } else {

                            // }

                        }
                    })
                }
            })
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
        .Head1{
			font-family: 'Srisakdi', sans-serif;
            font-size: 17px;
            /* font-style: normal; */
          font-weight: 500;
		}
        .detail{
            font-size: 13px;
        }
    </style>
    <?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    use App\Models\Acc_107_debt_print;
    ?>
    <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        </div>
      
        <div class="row">
           
            <div class="col-md-4">
                <h4 class="card-title">Detail</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล ทวงหนี้</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-5 text-end">
                <form action="{{ route('acc.acc_107_debt') }}" method="GET">
                    @csrf
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required />
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}" required />

                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger PulldataAll" >
                        <i class="fa-solid fa-arrows-rotate text-danger me-2"></i>
                        Sync Data All 
                    </button>
                </form>
                </div>
            </div>
      
        </div>
   

    @if ($startdate =='')
        <div class="row">
            <div class="col-md-12">
                <div class="main-card card p-2">
                    <div class="grid-menu-col">
                        <table id="example" class="table table-striped table-bordered "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="Head1">
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">an</th> 
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ชื่อ-สกุล</th>
                                    <th class="text-center">วันที่จำหน่าย</th>
                                    <th class="text-center">สิทธิ์การรักษา</th>
                                    <th class="text-center">ค่าใช้จ่ายทั้งหมด</th>
                                    <th class="text-center">ยอดที่ต้องชำระ</th>
                                    <th class="text-center">ชำระแล้ว</th>
                                    <th class="text-center">ค้างชำระ</th>
                                    <th class="text-center">ออกจดหมาย</th> 
                                    <th class="text-center">จำนวนที่ออก</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; 
                                    $check_count = Acc_107_debt_print::where('an', $item->an)->count();
                                    
                                    ?>
                                    <tr height="20" class="detail">
                                        <td class="text-center" width="4%">{{ $number }}</td>
                                        <td class="text-center" width="8%">{{ $item->an }}</td> 
                                        <td class="text-center" width="5%">{{ $item->hn }}</td> 
                                        <td class="text-center" width="7%">{{ $item->cid }}</td> 
                                        <td class="text-start">{{ $item->ptname }}</td> 
                                        <td class="text-center" width="7%">{{ $item->dchdate }}</td> 
                                        <td class="text-center" width="7%">{{ $item->pttype }}</td>
                                        
                                        @if ($item->paid_money <> ($item->sumtotal_amount+$item->debit_total))
                                            <td class="text-end" width="8%" style="font-size:12px;color: rgb(243, 141, 7)">{{ number_format($item->income, 2) }}</td> 
                                        @else
                                            <td class="text-end" width="8%" style="font-size:12px;color: rgb(54, 230, 156)">{{ number_format($item->income, 2) }}</td> 
                                        @endif
                                        <td class="text-end" width="8%">{{ number_format($item->paid_money, 2) }}</td> 
                                        @if ($item->sumtotal_amount == $item->debit_total)
                                            <td class="text-end" width="6%" style="font-size:12px;color: rgb(11, 222, 110))">{{ number_format($item->sumtotal_amount, 2) }}</td> 
                                            <td class="text-end" width="6%" style="font-size:12px;color: rgb(11, 222, 110))">{{ number_format($item->debit_total, 2) }}</td>
                                        @else
                                            <td class="text-end" width="6%" style="font-size:12px;color: rgb(245, 25, 25)">{{ number_format($item->sumtotal_amount, 2) }}</td> 
                                            <td class="text-end" width="6%" style="font-size:12px;color: rgb(245, 25, 25)">{{ number_format($item->debit_total, 2) }}</td>
                                        @endif
                                        
                                        <td class="text-center" width="6%">
                                            
                                            <a class="dropdown-item menu btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-info" href="javascript:void(0)"
                                                onclick="acc_107_debt_outbook({{ $item->acc_1102050102_107_id }})"
                                                data-bs-toggle="tooltip" data-bs-toggle="custom-tooltip"
                                                data-bs-placement="top" title="ออกจดหมาย">
                                                <i class="fa-solid fa-envelope ms-2 me-2" style="font-size:12px;color: rgb(111, 144, 252)"></i>
                                                <label for="" style="font-size:12px;color: rgb(111, 144, 252)">ออกจดหมาย</label>
                                            </a>
                                        </td> 
                                        <td class="text-center" width="5%">
                                            <i class="fa-solid fa-envelope me-3" style="font-size:12px;color: rgb(11, 222, 110))">  </i>
                                            <label for="" style="font-size:12px;color: rgb(245, 25, 25)">{{$check_count}}</label>
                                        </td> 
                                        
                                    </tr> 

                            
                                
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="main-card card p-2">
                    <div class="grid-menu-col">
                        <table id="example" class="table table-striped table-bordered "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="Head1">
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">an</th> 
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ชื่อ-สกุล</th>
                                    <th class="text-center">วันที่จำหน่าย</th>
                                    <th class="text-center">สิทธิ์การรักษา</th>
                                    <th class="text-center">ค่าใช้จ่ายทั้งหมด</th>
                                    <th class="text-center">ยอดที่ต้องชำระ</th>
                                    <th class="text-center">ชำระแล้ว</th>
                                    <th class="text-center">ค้างชำระ</th>
                                    <th class="text-center">ออกจดหมาย</th> 
                                    <th class="text-center">จำนวนที่ออก</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; 
                                    $check_count = Acc_107_debt_print::where('an', $item->an)->count();
                                    
                                    ?>
                                    <tr height="20" class="detail">
                                    <td class="text-center" width="4%">{{ $number }}</td>
                                    <td class="text-center" width="8%">{{ $item->an }}</td> 
                                    <td class="text-center" width="5%">{{ $item->hn }}</td> 
                                    <td class="text-center" width="7%">{{ $item->cid }}</td> 
                                    <td class="text-start">{{ $item->ptname }}</td> 
                                    <td class="text-center" width="7%">{{ $item->dchdate }}</td> 
                                    <td class="text-center" width="7%">{{ $item->pttype }}</td>
                                    <td class="text-end" width="8%">{{ number_format($item->income, 2) }}</td> 
                                    <td class="text-end" width="8%">{{ number_format($item->paid_money, 2) }}</td> 
                                    <td class="text-end" width="6%">{{ number_format($item->sumtotal_amount, 2) }}</td> 
                                    <td class="text-end" width="6%">{{ number_format($item->debit_total, 2) }}</td>  
                                    <td class="text-center" width="6%">
                                        
                                        <a class="dropdown-item menu btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-info" href="javascript:void(0)"
                                            onclick="acc_106_debt_outbook({{ $item->acc_1102050102_107_id }})"
                                            data-bs-toggle="tooltip" data-bs-toggle="custom-tooltip"
                                            data-bs-placement="top" title="ออกจดหมาย">
                                            <i class="fa-solid fa-envelope ms-2 me-2" style="font-size:12px;color: rgb(111, 144, 252)"></i>
                                            <label for="" style="font-size:12px;color: rgb(111, 144, 252)">ออกจดหมาย</label>
                                        </a>
                                    </td> 
                                    <td class="text-center" width="5%">
                                        <i class="fa-solid fa-envelope me-3" style="font-size:12px;color: rgb(11, 222, 110))">  </i>
                                        <label for="" style="font-size:12px;color: rgb(245, 25, 25)">{{$check_count}}</label>
                                    </td> 
                                    
                                </tr> 

                            
                                
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

         
       
    </div>

    @endsection
    @section('footer')
        <script src="{{ asset('pdfupload/pdf_up.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script src="{{ asset('js/gcpdfviewer.js') }}"></script>
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

                $('#datepicker3').datepicker({
                    format: 'yyyy-mm-dd'
                });

                $('.PulldataAll').click(function() {  
                    var months = $('#months').val();
                    var year = $('#year').val();
                    // alert(months);
                    Swal.fire({
                            title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
                            text: "You Sync Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Sync it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show();  
                                    
                                    $.ajax({
                                        url: "{{ url('acc_107_debt_sync') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {months,year},
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'ซิ้งค์ข้อมูลสำเร็จ',
                                                    text: "You Sync data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })

                                            } else if (data.status == 100) { 
                                                Swal.fire({
                                                    title: 'ยังไม่ได้ลงเลขที่หนังสือ',
                                                    text: "Please enter the number of the book.",
                                                    icon: 'warning',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                    
                                                    }
                                                })
                                                
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                        })
                });

            });


        </script>


    @endsection
