<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
     <!-- Bootstrap Css -->
     <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> 
     <!-- App Css-->
     <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<style>
    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;   
        }
</style>
<?php

    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    ?>
    {{-- <body onload="window.print()"> --}}
<body >
    <br> <br> <br> <br><br> <br><br> <br>
    <div class="row mt-5">
        <div class="col"></div>
        <div class="col-md-10 text-center">
           
            @if ($data_detail->fire_imgname == '')
            {{-- <img src="data:image/png;base64,{{ $pic_fire }}" height="40px" alt="" class="img-thumbnail"> --}}
            <img src="{{asset('assets/images/defailt_img.jpg')}}" height="850px" width="500px" alt="" > 
            @else
            <img src="{{asset('storage/fire/'.$data_detail->fire_imgname)}}" height="550px" width="500px" alt="">   
            @endif
            
            <br> <br>
            <label for="" style="font-size: 50px;">ยังไม่ได้มีการตรวจถังดับเพลิง<br> รหัส {{$arnum}} เลย</label>
        </div>
        <div class="col"></div>
         
    </div>

     
    
     
     
     <!-- JAVASCRIPT -->
     <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>

     <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script> 
</body>
        
                     
