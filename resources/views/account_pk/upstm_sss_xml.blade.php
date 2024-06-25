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

    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col"></div>
            <div class="col-xl-8 col-md-6"> 
                <div class="main-card mb-3 card">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <form action="{{ route('acc.upstm_sss_xmlsave') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                        <div class="mb-3">
                                            <label for="file" class="form-label">UP STM XML</label>
                                            <input class="form-control form-control-lg" id="file" name="file"
                                                type="file" required>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                        <button type="submit"
                                            class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="UP STM"></i>
                                            UP STM
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="progress" style="height: 50px;">
                       <div class="bar"></div>
                       <div class="percent" style="font-size: 30px">0%</div>
                       {{-- <div class="progress-bar progress-bar-striped progress-bar-animated bg-info percent" role="progressbar"
                       aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> </div> --}}
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



            $('#Upstmti').on('submit', function(e) {
                e.preventDefault();
                var form = this;
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

                        }
                    }
                });
            });

            // $('#insert_stmForm').on('submit',function(e){
            //         e.preventDefault();

            //         var form = this;
            //           //   alert('OJJJJOL');
            //         $.ajax({
            //           url:$(form).attr('action'),
            //           method:$(form).attr('method'),
            //           data:new FormData(form),
            //           processData:false,
            //           dataType:'json',
            //           contentType:false,
            //           beforeSend:function(){
            //             $(form).find('span.error-text').text('');
            //           },
            //           success:function(data){
            //             if (data.status == 0 ) {

            //             } else {
            //                 Swal.fire({
            //                     title: 'บันทึกข้อมูลสำเร็จ',
            //                     text: "You Insert data success",
            //                     icon: 'success',
            //                     showCancelButton: false,
            //                     confirmButtonColor: '#06D177',
            //                     // cancelButtonColor: '#d33',
            //                     confirmButtonText: 'เรียบร้อย'
            //                 }).then((result) => {
            //                     if (result.isConfirmed) {
            //                     window.location="{{ url('upstm_tixml') }}";
            //                     }
            //                 })
            //             }
            //           }
            //         });
            // });

            // $('#fileUploadForm').ajaxForm({
            //     beforeSend: function() {
            //         var percentage = '0';

            //     },
            //     uploadProgress: function(event, position, total, percentComplete) {
            //         var percentage = percentComplete;
            //         $('.progress .progress-bar').css("width", percentage + '%', function() {
            //             return $(this).attr("aria-valuenow", percentage) + "%";
            //         })
            //     },
            //     complete: function(xhr) {
            //         console.log('File has uploaded');
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
            //                 window.location = "{{ url('upstm_tixml') }}";
            //             }
            //         })
            //     }
            // });

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
                    if (data.status == '200') {
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
                                window.location = "{{ url('upstm_tixml') }}";
                            }
                        })
                    } else {
                        
                    }
                    
                }
            })

        });
    </script>
@endsection
