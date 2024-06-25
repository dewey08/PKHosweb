@extends('layouts.fdh')
@section('title', 'PK-OFFICER || FDH')
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
                <div class="card card_fdh_4">
                    <div class="card-header">
                        FDH Auth Api
                        <div class="btn-actions-pane-right">
                            <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="pe-7s-science btn-icon-wrapper"></i>Check Auth
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center" >Username</th>
                                    <th class="text-center" >Password</th>
                                    <th class="text-center" >Token</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($data_auth as $item)
                                    <?php $number++; ?>

                                        <tr height="20" >
                                            <td class="text-center" width="4%">{{ $number}}</td>
                                            <td class="text-center" width="10%">{{ $item->api_neweclaim_user }}</td>
                                            <td class="text-center" width="8%">
                                                <input type="password" class="form-control form-control-sm" value="{{ $item->api_neweclaim_pass }}">
                                                {{-- {{ $item->api_neweclaim_pass }} --}}
                                            </td>
                                            <td class="p-2" style="font-size: 11px;"><textarea name="" id="" cols="100" rows="5" style="width: 100%">{{ $item->api_neweclaim_token }}</textarea></td>
                                        </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Check Auth</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="">@Username</span>
                        </div>
                        <input type="text" id="username" name="username" class="form-control">
                    </div>
                    <br>
                    <div class="input-group input-group-sm">
                        <div class="input-group-text">
                            <span class="">@Password</span>
                        </div>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="AuthSave">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                    </button>
                </div>
            </div>
        </div>
</div>

@endsection
@section('footer')

{{-- <script>
    $('#start').hide(); 
    $('#success').hide(); 
    window.setTimeout(function() {             
        window.location.reload();
    },10000); 
    $(document).ajaxStart(function() {
    
        }).ajaxSuccess(function() {
            
        });
        setTimeout(function(){
            // $('.progress-bar').css({width: "0%"});
            $i = 1000
            setTimeout(function(){
                // $('#success').html(data);
            }, 1000);
            $('#start').show(); 
            $('#success').hide(); 
            $('.progress-bar').css({width: "5%"});
                          
        }, 10000);
        $('.progress-bar').css({width: "100%"});
        $('#start').hide(); 
        $('#success').show(); 
</script> --}}

<script>
    $(document).ready(function() {

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#example').DataTable();
        $('#hospcode').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#AuthSave').click(function() {
            var username = $('#username').val();
            var password = $('#password').val();
            // alert(datepicker2);


        $.ajax({
                url: "{{ route('fdh.fdh_mini_dataset_api') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    username,
                    password
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
                        Swal.fire({
                            title: 'มีข้อมูลอยู่แล้ว อัพเดท Token เรียบร้อย',
                            text: "You Have data And Update Token success",
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
                    }
                },


        });



    });

    });
</script>

@endsection
