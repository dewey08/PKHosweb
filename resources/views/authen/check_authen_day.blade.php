@extends('layouts.report_font')
@section('title', 'PK-OFFICER || checksit')
@section('content')
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
           border-top: 10px #1fdab1 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% {
               transform: rotate(390deg);
           }
           }
           .is-hide{
           display:none;
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
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-12">
                 <div class="card cardreport">
                    <div class="card-header">
                        รายงานคนไข้ที่มาใช้บริการ Check Authen
                        <div class="btn-actions-pane-right">  
                            <form action="{{ route('claim.check_authen_day') }}" method="POST">
                                @csrf
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                        <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $start }}" autocomplete="off" required/>
                                        <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $end }}" autocomplete="off"/>  
                                        <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                        </button>
                               
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body"> 
                        {{-- <div class="table-responsive"> --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                           
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>vn</th>
                                        <th>hn</th>
                                        <th>cid</th>
                                        <th>tel</th>
                                        <th>vstdate</th>
                                        <th>fullname</th>
                                        <th>pttype Hos</th> 
                                        <th>pttype สปสช</th> 
                                        <th>claimcode</th>
                                        <th>staff</th>
                                        <th>main_dep</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($data_sit as $item) 
                                        <tr style="background-color: rgb(255, 255, 255)">
                                            <td>{{ $ia++ }}</td>
                                            <td>{{ $item->vn }}</td>
                                            <td>{{ $item->hn }}</td>
                                            <td>{{ $item->cid }}</td>
                                            <td>{{ $item->hometel }}</td>
                                            <td>{{ $item->vstdate }}</td>
                                            <td>{{ $item->fullname }}</td>
                                            <td>{{ $item->pttype }}</td> 
                                            <td>{{ $item->subinscl }}</td> 
                                                @if ($item->claimcode == '') 
                                                    <td style="background-color: rgb(250, 139, 139)">{{ $item->claimcode }}</td>
                                                @else 
                                                    <td>{{ $item->claimcode }}</td>
                                                @endif
                                            <td>{{ $item->staff_name }}</td>
                                            <td>{{ $item->department }}</td>
                                        </tr>
                                

                                    @endforeach

                                </tbody>
                            </table>
                        {{-- </div> --}}

                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Token</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="">@cid</span>
                    </div>
                    <input type="text" id="cid" name="cid" class="form-control">
                </div>
                <br>
                <div class="input-group input-group-sm">
                    <div class="input-group-text">
                        <span class="">@Token</span>
                    </div>
                    <input type="text" class="form-control" id="token" name="token">
                </div>
            </div>
            <div class="modal-footer">
                <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="TokenSave">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')

<script>
    //  window.setTimeout(function() {
    //         window.location.reload();
    //     },500000);
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#PullCheck').click(function() {
                var datestart = $('#datepicker').val();
                var dateend = $('#datepicker2').val();
                // alert(datepicker2);

                    Swal.fire({
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You won't pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner-div").show(); //Load button clicked show spinner
                                // url: "{{ route('claim.check_sit_daysearch') }}",
                                $.ajax({
                                        url: "{{ route('claim.check_sit_pull') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datestart,
                                            dateend
                                        },
                                        success: function(data) {
                                            if (data.status == 200) {
                                                Swal.fire({
                                                    title: 'ดึงข้อมูลสำเร็จ',
                                                    text: "You Pull data success",
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
                                                        $('#spinner-div').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                    }
                                                })
                                            } else {
                                            }
                                        },
                                        complete: function () {
                                            // $('#spinner-div').hide();//Request is complete so hide spinner
                                        }
                                    // }).done(function() {
                                    // setTimeout(function(){
                                    //     $("#overlay").fadeOut(300);
                                    // },500);
                                });

                            }
                        })

        });
        $('#Checksitbtn').click(function() {
                var datestart = $('#datepicker').val();
                var dateend = $('#datepicker2').val();
                // alert(datepicker);
                Swal.fire({
                        title: 'ต้องการตรวจสอบสิทธิ์ใช่ไหม ?',
                        text: "You won't Chaeck Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Chaeck it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner-div").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('claim.check_sit_font') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datestart,
                                        dateend
                                    },
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({
                                                title: 'ปรับข้อมูลสำเร็จ',
                                                text: "You Update data success",
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
                                                    $('#spinner-div').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(300);
                                                    },500);
                                                }
                                            })

                                        } else {
                                            Swal.fire({
                                                title: 'ปรับข้อมูลอีกครั้ง',
                                                text: "You Update data Again",
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
                                                    $('#spinner-div').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(300);
                                                    },500);
                                                }
                                            })
                                        }

                                    },
                                    // complete: function (data) {
                                    //     $('#spinner-div').hide();//Request is complete so hide spinner
                                    //     setTimeout(function(){
                                    //         $("#overlay").fadeOut(300);
                                    //     },500);
                                    // }
                                    })
                                    // .done(function() {
                                        // setTimeout(function(){
                                        //     $("#overlay").fadeOut(300);
                                        // },500);
                                    // });
                            }
                        })






        });

        $('#TokenSave').click(function() {
                var cid = $('#cid').val();
                var token = $('#token').val();
                // alert(datepicker2);


            $.ajax({
                    url: "{{ route('claim.check_sit_token') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        cid,
                        token
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                text: "You Insert data success",
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
                                }
                            })
                        } else {
                        }
                    },
                    complete: function () {

                    }

            });



        });
    });
</script>
@endsection

