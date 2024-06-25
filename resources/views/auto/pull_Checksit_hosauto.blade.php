@extends('layouts.auto')
@section('title', 'PK-OFFICER || Auto')
@section('content')

    <div class="tabs-animation">
       
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pull Data Hos Auto
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="active btn btn-focus">Checksit Auto สปสช</button>
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


@endsection
@section('footer')
    <script>
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
    </script>
@endsection
