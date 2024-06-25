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
<body onload="window.print()">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
        </div>  
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-2 text-center">

                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
                
            </div>
            {{-- <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div> --}}
        </div>  
    </div>
    {{-- <div class="container">
        <div class="row mt-5">
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
            <div class="col-md-2 text-center">
                <div class="card">
                    <div class="body"><br>
                        {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!} 
                        <p style="font-size: 17px"> รหัส {{ $dataprint->fire_num }} <br>
                            แสกนตรวจสอบ<br>
                            สำหรับเจ้าหน้าที่</p>
                    </div> 
                </div> 
            </div>
        </div>  
    </div> --}}
     <!-- JAVASCRIPT -->
     <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>

     <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script> 
</body>
        
                     
