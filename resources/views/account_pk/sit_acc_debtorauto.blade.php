@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
@section('content')

    <div class="tabs-animation">
       
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pull Data Hos To Checksit Auto
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                {{-- <button class="active btn btn-focus">สปสช</button> --}}
                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-science btn-icon-wrapper"></i>Token
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col"></div>
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
                        </div>
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
        $('#start').hide(); 
        $('#success').hide(); 
        window.setTimeout(function() {             
            window.location.reload();
        },3000); 
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
    </script>
    <script>
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
    </script>
@endsection
