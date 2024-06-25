@extends('layouts.fdh_font')
@section('title', 'PK-OFFICER || FDH')
@section('content')

    <div class="tabs-animation">
       
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card_fdh_4">
                    <div class="card-header">
                        Login Minidataset Auto
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="active btn btn-focus">สปสช</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row"> 
                            <div class="col-lg-2 col-xl-2">
                                <div class="loader mx-auto text-center">
                                    <div class="line-scale-pulse-out">
                                        <div class="bg-success" style="height: 130px;width: 20px"></div>
                                        <div class="bg-danger" style="height: 130px;width: 20px"></div>
                                        <div class="bg-primary" style="height: 130px;width: 20px"></div>
                                        <div class="bg-info" style="height: 130px;width: 20px"></div>
                                        <div class="bg-warning" style="height: 130px;width: 20px"></div>
                                    </div>
                                    <div class="divider"></div>
                                    <div id="loader">
                                    </div>
                                    <div id="start">
                                        <label for="">Loading.....</label>
                                    </div>
                                    <div id="success">
                                        <label for="">Tranfer Data Success...</label>
                                    </div>                                    
                                    <div class="mb-3 progress-bar-animated-alt progress bg-warning" >
                                        <div class="progress-bar" role="progressbar" aria-valuenow="10"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 10%;" aria-placeholder=" Loading .....">
                                        </div> 
                                    </div>                                  
                                                                     
                                </div>
                            </div>

                            <div class="col"></div>
                           
                            <div class="col-lg-4 col-xl-4">
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
                                <br>
                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="AuthSave">
                                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                                </button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#AuthSave').click(function() {
            var username = $('#username').val();
            var password = $('#password').val(); 
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

    </script>
@endsection
