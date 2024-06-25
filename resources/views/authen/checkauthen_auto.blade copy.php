@extends('layouts.authen')
@section('title', 'PK-OFFICER || Authen')
@section('content')

    <div class="tabs-animation">
        {{-- <form id="Insert_authen" action="{{route('au.authen_check')}}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row mb-2">
                    @foreach ($user_all as $item)
                    <input type="hidden" name="cid[]" id="cid" value="{{$item->cid}}">
                    @endforeach 
                    <div class="col"></div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-primary">ประมวลผล</button> 
                    </div>
                </div>
        </form> --}}

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        PULL Authen Auto
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="active btn btn-focus">สปสช</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-lg-2 col-xl-2">
                                <div class="loader mx-auto text-center">
                                    <div class="line-scale-pulse-out">
                                        <div class="bg-success" style="height: 150px;width: 20px"></div>
                                        <div class="bg-danger" style="height: 150px;width: 20px"></div>
                                        <div class="bg-primary" style="height: 150px;width: 20px"></div>
                                        <div class="bg-info" style="height: 150px;width: 20px"></div>
                                        <div class="bg-warning" style="height: 150px;width: 20px"></div>
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
                                    {{-- <div class="progress">
                                        <div class="progress-bar progress-bar-animated-alt" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                        </div>
                                        <div class="progress-bar progress-bar-animated-alt bg-success" role="progressbar"
                                            aria-valuenow="30" aria-valuemin="0"  aria-valuemax="100" style="width: 30%;">
                                        </div>
                                        <div class="progress-bar progress-bar-animated-alt bg-warning" role="progressbar"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                                        </div>
                                        <div class="progress-bar progress-bar-animated-alt bg-danger" role="progressbar"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                                        </div>
                                    </div> --}}                                    
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>

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
        },2000); 
        $(document).ajaxStart(function() {
        // show loader on start
                // $("#loader").css("display","block");
                // $('#start').css("display","block");
                // $("#success").css("display","none");
                // $('#start').show(); 
                // $('#success').hide(); 
            }).ajaxSuccess(function() {
                // hide loader on success
                // $("#loader").css("display","none");
                // $("#start").css("display","none");
                // $("#success").css("display","block");
                // $('#success').show(); 
            });
            setTimeout(function(){
                // $('.progress-bar').css({width: "0%"});
                $i = 100
                setTimeout(function(){
                    $('.my-box').html(data);
                }, 100);
                $('#start').show(); 
                $('#success').hide(); 
                $('.progress-bar').css({width: "5%"});
                // if ($i = 200) {
                //     $('.progress-bar').css({width: "20%"});
                // if else ($i = 400) {
                //     $('.progress-bar').css({width: "40%"});
                // } else {                    
                // }                
            }, 2000);
            $('.progress-bar').css({width: "100%"});
            $('#start').hide(); 
            $('#success').show(); 
    </script>
@endsection
