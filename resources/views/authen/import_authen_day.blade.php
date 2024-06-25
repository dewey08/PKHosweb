@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Authen')

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

        <div class="row">

            <div class="col"></div>
            <div class="col-xl-8 col-md-6">
                <div class="card cardacc">
                    <div class="grid-menu-col">
                        <form action="{{ route('claim.import_authen_daysave') }}" method="POST" enctype="multipart/form-data"> 
                            @csrf
                            <div class="row">
                                <div class="col"></div>
                                <div class="col-md-8">
                                    <div class="mb-3 mt-3">
                                        <label for="formFileLg" class="form-label">UP STM EXCEL => UP STM => ส่งข้อมูล</label>
                                        <input class="form-control form-control-lg" id="formFileLg" name="file" type="file" required>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                    @if ($countc > 0)
                                        <a href="{{ url('import_authen_daysend') }}" class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งข้อมูล"></i>
                                                ส่งข้อมูล
                                        </a>
                                    @else
                                        <button type="submit"
                                            class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="fa-solid fa-cloud-arrow-up me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="UP STM"></i>
                                            UP STM
                                        </button>
                                    @endif
                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="progress" style="height: 50px;">
                       <div class="bar"></div>
                       <div class="percent" style="font-size: 30px">0%</div> 
                    </div>
                </div> 
                <br> 
            </div>
            <div class="col"></div>

        </div>

        <div class="row">

            <div class="col"></div>
            <div class="col-xl-8 col-md-6">
                <div class="card p-3 cardacc">
                    <div class="grid-menu-col">
                        {{-- datatable-buttons --}}
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                           
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">hcode</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">fullname</th>
                                    <th class="text-center">homtel</th>
                                    <th class="text-center">claimcode</th>
                                    <th class="text-center">claimtype</th>
                                    <th class="text-center">vstdate</th>
                                    <th class="text-center">hncode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?> 
                                    <tr height="14">
                                        <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>
                                        <td class="text-center" width="7%"> {{ $item->hcode }}</td> 
                                        <td class="text-end"width="7%"> {{ $item->cid }}</td>
                                        <td class="p-2"> {{ $item->fullname }}</td>
                                        <td class="text-end" width="7%"> {{ $item->homtel }}</td>
                                        <td class="text-end" width="7%"> {{ $item->claimcode }}</td>
                                        <td class="text-end" width="7%"> {{ $item->claimtype }}</td>
                                        <td class="text-end" width="7%"> {{ $item->vstdate }}</td>
                                        <td class="text-end" width="7%"> {{ $item->hncode }}</td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
 
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
                complete: function(data) { 
                    if (data.status == 100) {
                            Swal.fire({
                            title: 'ไม่เจอไฟล์',
                            text: "File IS NULL",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            // cancelButtonColor: '#d33', 
                        })
                    } else {
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
                                window.location = "{{ url('import_authen_day') }}";
                            }
                        })
                    }
                    // Swal.fire({
                    //     title: 'UP STM สำเร็จ',
                    //     text: "You UP STM success",
                    //     icon: 'success',
                    //     showCancelButton: false,
                    //     confirmButtonColor: '#06D177',
                    //     // cancelButtonColor: '#d33',
                    //     confirmButtonText: 'เรียบร้อย'
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         window.location = "{{ url('upstm_ucs') }}";
                    //     }
                    // })
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
