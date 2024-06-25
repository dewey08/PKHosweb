@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || KTB')

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
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
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
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
 

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                      
                        <h4 class="card-title">การตรวจหลังคลอด ANC</h4>
                        <p class="card-title-desc">รายการกิจกรรมย่อย การตรวจหลังคลอด ANC</p>


                        <div id="accordion" class="custom-accordion">
                            <div class="card mb-1 shadow-none">
                                <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse"
                                                aria-expanded="true"
                                                aria-controls="collapseOne">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            ยาเสริมธาตุเหล็กหลังคลอด***B60
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseOne" class="collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        ยาเสริมธาตุเหล็กหลังคลอด
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life
                                        accusamus terry richardson ad squid. 3 wolf moon officia
                                        aute, non cupidatat skateboard dolor brunch. Food truck
                                        quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                        nulla assumenda shoreditch et.
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-1 shadow-none">
                                <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse"
                                                aria-expanded="false"
                                                aria-controls="collapseTwo">
                                    <div class="card-header" id="headingTwo">
                                        <h6 class="m-0">
                                            การตรวจหลังคลอดไม่เกิน 8-15 วัน ***P14
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordion">
                                    <div class="card-body">
                                        การตรวจหลังคลอดไม่เกิน 8-15 วัน
                                        sunt aliqua put a bird on it squid single-origin coffee
                                        nulla assumenda shoreditch et. Nihil anim keffiyeh
                                        helvetica, craft beer labore wes anderson cred nesciunt
                                        Leggings occaecat craft beer farm-to-table, raw denim
                                        accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-0 shadow-none">
                                <a href="#collapseThree" class="text-dark collapsed" data-bs-toggle="collapse"
                                                aria-expanded="false"
                                                aria-controls="collapseThree">
                                    <div class="card-header" id="headingThree">
                                        <h6 class="m-0">
                                            การตรวจหลังคลอดไม่เกิน 16-42 วัน***P98
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseThree" class="collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        การตรวจหลังคลอดไม่เกิน 16-42 วัน
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life
                                        accusamus terry richardson ad squid. 3 wolf moon officia
                                        aute, non cupidatat skateboard dolor brunch. Food truck
                                        sunt aliqua put a bird on it squid single-origin coffee
                                        nulla assumenda anderson cred nesciunt
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

    <script>
        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#stamp').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });
            $('.Updateprescb').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk:checked").each(function() {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                    }).then((result) => {

                    })
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการปรับรายการที่เลือกใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, UPdate it.!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var check = true;
                            if (check == true) {
                                var join_selected_values = allValls.join(",");
                                $.ajax({
                                    url: $(this).data('url'),
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    data: 'ids=' + join_selected_values,
                                    success: function(data) {
                                        if (data.status == 200) {
                                            $(".sub_chk:checked").each(function() {
                                                $(this).parents("tr").remove();
                                            });
                                            Swal.fire({
                                                title: 'ปรับ Prescbสำเร็จ',
                                                text: "You Debtor data success",
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
                                                    // window.location="{{ url('warehouse/warehouse_index') }}";
                                                }
                                            })
                                        } else {

                                        }
                                    }
                                });
                                $.each(allValls, function(index, value) {
                                    $('table tr').filter("[data-row-id='" + value + "']")
                                        .remove();
                                });
                            }
                        }
                    })

                }
            });


            $('#stamp2').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk2").prop('checked', true);
                } else {
                    $(".sub_chk2").prop('checked', false);
                }
            });
            $('.Updatesvpid').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk2:checked").each(function() {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                    }).then((result) => {

                    })
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการปรับรายการที่เลือกใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, UPdate it.!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var check = true;
                            if (check == true) {
                                var join_selected_values = allValls.join(",");
                                $.ajax({
                                    url: $(this).data('url'),
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    data: 'ids2=' + join_selected_values,
                                    success: function(data) {
                                        if (data.status == 200) {
                                            $(".sub_chk2:checked").each(function() {
                                                $(this).parents("tr").remove();
                                            });
                                            Swal.fire({
                                                title: 'ปรับ SvPID สำเร็จ',
                                                text: "You Debtor data success",
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
                                                    // window.location="{{ url('warehouse/warehouse_index') }}";
                                                }
                                            })
                                        } else {

                                        }
                                    }
                                });
                                $.each(allValls, function(index, value) {
                                    $('table tr').filter("[data-row-id='" + value + "']")
                                        .remove();
                                });
                            }
                        }
                    })

                }
            });
        });
        $(document).on('click', '.Edit_prescb', function() {
            var ssop_dispensing_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ url('ssop_edit_prescb') }}" + '/' + ssop_dispensing_id,
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'แก้ไขข้อมูลสำเร็จ',
                            text: "You edit data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    data);

                                window.location
                                    .reload();
                            }
                        })
                    } else {

                    }
                },
            });
        });

        $(document).on('click', '.Edit_svpid', function() {
            var ssop_opservices_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ url('ssop_edit_svpid') }}" + '/' + ssop_opservices_id,
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'แก้ไขข้อมูลสำเร็จ',
                            text: "You edit data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    data);

                                window.location
                                    .reload();
                            }
                        })
                    } else {

                    }
                },
            });
        });
    </script>
@endsection
