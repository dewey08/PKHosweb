@extends('layouts.ctnew')
@section('title', 'PK-OFFICER || CT')

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
            border-top: 10px #17c993 solid;
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
                        <h4 class="mb-sm-0">IMPORT EXCEL CT</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">IMPORT EXCEL</a></li>
                                <li class="breadcrumb-item active">CT</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
        </div> <!-- container-fluid -->


        <div class="row">

            <div class="col"></div>
            <div class="col-xl-6">
                <div class="card cardshadow">
                    <div class="grid-menu-col">
                        <form action="{{ route('ct.ct_rep_import_save') }}" method="POST" enctype="multipart/form-data"> 
                            @csrf

                            <div class="row">
                                <div class="col"></div>
                                <div class="col-md-8">
                                    <div class="mb-3 mt-3">
                                        <label for="formFileLg" class="form-label">IMPORT EXCEL</label>
                                        <input class="form-control form-control-lg" id="formFileLg" name="file"
                                            type="file" required>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                    @if ($countc > 0)
                                        {{-- <a href="{{ url('ct_rep_import_send') }}" class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งข้อมูล"></i>
                                                ส่งข้อมูล
                                        </a> --}}
                                    @else
                                        {{-- <button type="submit"
                                            class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="fa-solid fa-cloud-arrow-up me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="UP STM"></i>
                                            UP STM
                                        </button> --}}
                                        {{-- <button class="btn btn-danger ladda-button" data-style="expand-left"><span class="ladda-label">expand-left</span></button> --}}
                                        <button type="submit" class="me-2 btn-pill btn btn-primary d-shadow mb-3 me-2 ">
                                            {{-- <span class="ladda-label">  --}}
                                                <i class="fa-solid fa-cloud-arrow-up text-white me-2"></i>IMPORT
                                            {{-- </span> --}}
                                            {{-- <span class="ladda-spinner"></span> --}}
                                        </button> 
                                    @endif
                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
           
                {{-- <div class="form-group">
                    <div class="progress" style="height: 50px;">
                       <div class="bar"></div>
                       <div class="percent" style="font-size: 30px">0%</div> 
                    </div>
                </div>  --}}
                <br> 
            </div>
            <div class="col"></div>
        </div>


        <div class="row">

            {{-- <div class="col"></div> --}}
            <div class="col-xl-12">
                <div class="card cardshadow p-3">
                    <div class="grid-menu-col">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered "
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">cid</th>
                                        <th class="text-center">months</th>
                                        <th class="text-center">sumprice</th>
                                        {{-- <th class="text-center">paid</th> --}}
                                        {{-- <th class="text-center">remain</th> --}}
                                        <th class="text-center">filename</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0;
                                    $total1 = 0; ?>
                                    @foreach ($datashow as $item)
                                        <?php $number++; ?>

                                        <tr height="20" style="font-size: 14px;color:rgb(235, 6, 6)">
                                            <td class="text-font" style="text-align: center;" width="4%" style="color:rgb(248, 12, 12)">{{ $number }}</td>
                                            <td class="text-center" width="10%" style="color:rgb(248, 12, 12)"> {{ $item->cid }}</td>
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
                                            <td class="text-center" width="10%">{{ number_format($item->sumprice, 2) }}</td> 
                                            {{-- <td class="text-center" width="10%">{{ number_format($item->paid, 2) }}</td>  --}}
                                            {{-- <td class="text-center" width="10%">{{ number_format($item->remain, 2) }}</td>  --}}
                                            <td class="text-start" style="color:rgb(248, 12, 12)" > {{ $item->STMdoc }}</td>
                                        </tr>
                                    @endforeach

                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col"></div> --}}
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
            // $('form').ajaxForm({
            //     beforeSend: function() {
            //         var percentVal = '0%';
            //         bar.width(percentVal);
            //         percent.html(percentVal);
            //     },
            //     uploadProgress: function(event, position, total, percentComplete) {
            //         var percentVal = percentComplete+'%';
            //         bar.width(percentVal);
            //         percent.html(percentVal);
            //     },
            //     complete: function(xhr) { 
            //         Swal.fire({
            //             title: 'UP STM สำเร็จ',
            //             text: "You UP STM success",
            //             icon: 'success',
            //             showCancelButton: false,
            //             confirmButtonColor: '#06D177',
            //             // cancelButtonColor: '#d33',
            //             confirmButtonText: 'เรียบร้อย'
            //         }).then((result) => {
            //             if (result.isConfirmed) {
            //                 window.location = "{{ url('upstm_ucs') }}";
            //             }
            //         })
            //     }
            // })

            // $('#Upstm').on('submit', function(e) {
            //     e.preventDefault();
            //     var form = this;
            //     // alert('OJJJJOL');
            //     $.ajax({
            //         url: $(form).attr('action'),
            //         method: $(form).attr('method'),
            //         data: new FormData(form),
            //         processData: false,
            //         dataType: 'json',
            //         contentType: false,
            //         beforeSend: function() {
            //             $(form).find('span.error-text').text('');
            //         },
            //         success: function(data) {
            //             if (data.status == 200) {
            //                 Swal.fire({
            //                     title: 'Up Statment สำเร็จ',
            //                     text: "You Up Statment data success",
            //                     icon: 'success',
            //                     showCancelButton: false,
            //                     confirmButtonColor: '#06D177',
            //                     // cancelButtonColor: '#d33',
            //                     confirmButtonText: 'เรียบร้อย'
            //                 }).then((result) => {
            //                     if (result.isConfirmed) {
            //                         window.location.reload();
            //                     }
            //                 })

            //             } else {
            //                 Swal.fire({
            //                     title: 'UP Statment ซ้ำ',
            //                     text: "You Up Statment data success",
            //                     icon: 'warning',
            //                     showCancelButton: false,
            //                     confirmButtonColor: '#06D177',
            //                     // cancelButtonColor: '#d33',
            //                     confirmButtonText: 'เรียบร้อย'
            //                 }).then((result) => {
            //                     if (result.isConfirmed) {
            //                         window.location.reload();
            //                     }
            //                 })
            //             }
            //         }
            //     });
            // });

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
