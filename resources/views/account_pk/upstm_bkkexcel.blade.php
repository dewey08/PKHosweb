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
            {{-- <div class="col"></div> --}}
            <div class="col-xl-12 col-md-12">
                <div class="card cardacc">
                    <div class="grid-menu-col">
                        <form action="{{ route('acc.upstm_ofcexcel_save') }}" method="POST" enctype="multipart/form-data">
                            {{-- id="Upstmti" --}}
                            @csrf
                            <div class="row">

                                <div class="col"></div>
                                <div class="col-md-5">
                                    <div class="mb-3 mt-3">
                                        <label for="formFileLg" class="form-label">UP STM EXCEL => UP STM => ส่งข้อมูล</label>
                                        <input class="form-control form-control-lg" id="formFileLg" name="file"
                                            type="file" required>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div> 
                                <div class="col"></div>

                            </div>
                            @if ($countc > 0)
                           <div class="row">
                            <div class="col"></div>
                            <div class="col-md-2 mb-3">
                                <select name="type" id="type" class="form-control form-control-sm cardacc"> 
                                    <option value="BKK">BKK</option>
                                </select>
                            </div>
                            <div class="col-md-4"> 
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-warning cardacc" data-style="expand-left" id="Sendstm803">
                                    <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>กระทบลูกหนี้ 803</span>
                                    <span class="ladda-spinner"></span>
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-danger cardacc" data-style="expand-left" id="Sendstm804">
                                    <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>กระทบลูกหนี้ 804</span>
                                    <span class="ladda-spinner"></span>
                                </button>

                            </div>
                          <div class="col"></div>
                           </div>
                           @else
                           <div class="row">
                            <div class="col"></div>
                            <div class="col-md-2">
                                <button type="submit"
                                class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                <i class="fa-solid fa-cloud-arrow-up me-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="UP STM"></i>
                                UP STM
                            </button> 
                            </div>
                            <div class="col"></div>
                           </div>
                            @endif



                        </form>
                    </div>
                </div>
                <div class="form-group">
                    <div class="progress" style="height: 50px;">
                       <div class="bar"></div>
                       <div class="percent" style="font-size: 30px">0%</div>
                       {{-- <div class="progress-bar progress-bar-striped progress-bar-animated bg-info percent" role="progressbar"
                       aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> </div> --}}
                    </div>
                </div> 
                <br> 
            </div>
            {{-- <div class="col"></div> --}}
        </div>


        <div class="row">

            <div class="col"></div>
            <div class="col-xl-8 col-md-6">
                <div class="card cardacc p-3">
                    <div class="grid-menu-col">
                        {{-- <div class="row mt-3 mb-3">
                            <div class="col"></div>
                            <div class="col-md-1 text-end mt-2">วันที่</div>
                            <div class="col-md-4 text-end">
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="startdate" id="datepicker"
                                        placeholder="Start Date" data-date-container='#datepicker1'
                                        data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                        required />
                                    <input type="text" class="form-control" name="enddate" placeholder="End Date"
                                        id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker"
                                        data-date-autoclose="true" data-date-language="th-th" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit"
                                    class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                    <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="UPDATE HN IS NULL"></i>
                                    UPDATE HN IS NULL
                                </button>
                            </div>
                            <div class="col"></div>
                        </div> --}}
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            {{-- <table id="example" class="table table-striped table-bordered "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">repno</th>
                                    <th class="text-center">months</th>
                                    <th class="text-center">filename</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?>

                                    <tr height="20" >
                                        <td class="text-font" style="text-align: center;" width="4%" >{{ $number }}</td>
                                        <td class="text-center" width="10%" > {{ $item->repno }}</td>
                                        @if ($item->months == '1')
                                        <td width="10%" class="text-center" >มกราคม </td>
                                    @elseif ($item->months == '2')
                                        <td width="10%" class="text-center">กุมภาพันธ์  </td>
                                    @elseif ($item->months == '3')
                                        <td width="10%" class="text-center">มีนาคม  </td>
                                    @elseif ($item->months == '4')
                                        <td width="10%" class="text-center">เมษายน </td>
                                    @elseif ($item->months == '5')
                                        <td width="10%" class="text-center">พฤษภาคม</td>
                                    @elseif ($item->months == '6')
                                        <td width="10%" class="text-center">มิถุนายน </td>
                                    @elseif ($item->months == '7')
                                        <td width="10%" class="text-center">กรกฎาคม</td>
                                    @elseif ($item->months == '8')
                                        <td width="10%" class="text-center">สิงหาคม </td>
                                    @elseif ($item->months == '9')
                                        <td width="10%" class="text-center">กันยายน </td>
                                    @elseif ($item->months == '10')
                                        <td width="10%" class="text-center">ตุลาคม </td>
                                    @elseif ($item->months == '11')
                                        <td width="10%" class="text-center">พฤษจิกายน </td>
                                    @else
                                        <td width="10%" class="text-center">ธันวาคม</td>
                                    @endif
                                        <td class="p-2" style="color:rgb(248, 12, 12)" width="7%"> {{ $item->STMdoc }}</td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>


        {{-- <form action="{{ route('acc.upstm_hn') }}" method="POST" id="Upstmti" enctype="multipart/form-data">
            @csrf --}}
        {{-- <div class="row">

            <div class="col"></div>
            <div class="col-md-8">
                <div class="main-card mb-2 card" style="height: 400px;">
                    <div class="grid-menu-col">
                        <div class="row mt-3 mb-3">
                            <div class="col"></div>
                            <div class="col-md-1 text-end mt-2">วันที่</div>
                            <div class="col-md-4 text-end">
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="startdate" id="datepicker"
                                        placeholder="Start Date" data-date-container='#datepicker1'
                                        data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                        required />
                                    <input type="text" class="form-control" name="enddate" placeholder="End Date"
                                        id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker"
                                        data-date-autoclose="true" data-date-language="th-th" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit"
                                    class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                    <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="UPDATE HN IS NULL"></i>
                                    UPDATE HN IS NULL
                                </button>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div> --}}

        {{-- </form> --}}

    </div>


@endsection
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
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
                            window.location = "{{ url('upstm_ofcexcel') }}";
                        }
                    })
                }
            })

            $('#Upstmti').on('submit', function(e) {
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

            $('#Sevedata').on('submit',function(e){
                    e.preventDefault();

                    var form = this;
                      //   alert('OJJJJOL');
                    $.ajax({
                      url:$(form).attr('action'),
                      method:$(form).attr('method'),
                      data:new FormData(form),
                      processData:false,
                      dataType:'json',
                      contentType:false,
                      beforeSend:function(){
                        $(form).find('span.error-text').text('');
                      },
                      success:function(data){
                        if (data.status == 0 ) {

                        } else {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                window.location="{{url('upstm_ofcexcel')}}";
                                }
                            })
                        }
                      }
                    });
            });

            $('#Senddata').click(function() {
                    var type = $('#type').val(); 
                    Swal.fire({
                        title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                        text: "You Warn Send Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 

                                $.ajax({
                                    url: "{{ route('acc.upstm_ofcexcel_senddata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        type 
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'บันทึกข้อมูลสำเร็จ',
                                                text: "You Send data success",
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
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

            $('#Sendstmdata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการกระทบลูกหนี้ใช่ไหม ?',
                        text: "You Warn Affects debtors Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.upstm_ofcexcel_sendstmdata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'กระทบลูกหนี้สำเร็จ',
                                                text: "You Affects debtors data success",
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
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

            $('#Sendstmipddata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการกระทบลูกหนี้ใช่ไหม ?',
                        text: "You Warn Affects debtors Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.upstm_ofcexcel_sendstmipddata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'กระทบลูกหนี้สำเร็จ',
                                                text: "You Affects debtors data success",
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
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

            $('#Sendstm803').click(function() {
                var type = $('#type').val();  
                
                Swal.fire({
                        title: 'ต้องการกระทบลูกหนี้ใช่ไหม ?',
                        text: "You Warn Affects debtors Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.upstm_bkk803_senddata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {type },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'กระทบลูกหนี้สำเร็จ',
                                                text: "You Affects debtors data success",
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
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

            $('#Sendstm804').click(function() {
                var type = $('#type').val();  
                
                Swal.fire({
                        title: 'ต้องการกระทบลูกหนี้ใช่ไหม ?',
                        text: "You Warn Affects debtors Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.upstm_bkk804_senddata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {type },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'กระทบลูกหนี้สำเร็จ',
                                                text: "You Affects debtors data success",
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
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
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
