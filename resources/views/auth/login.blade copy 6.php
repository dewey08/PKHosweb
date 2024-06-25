<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>เข้าสู่ระบบ</title>

    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('apkclaim/images/logo150.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('sky16/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('sky16/css/bootstrap-extended.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/css53/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/navbar-fixed.css') }}" rel="stylesheet">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Edu VIC WA NT Beginner', cursive;
    }

    body {
        width: 100%;
        height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
            url(/pkbackoffice/public/sky16/images/bgPK.jpg)no-repeat 50%;
        /* url(/sky16/images/bgPK.jpg)no-repeat 50%; */
        /* url(/sky16/images/logo.png)no-repeat 50%; */
        background-size: cover;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 75rem;
        padding-top: 4.5rem;
    }

    .container-fluid {
        position: relative;
    }
    /* .form {
        position: relative;
        z-index: 100;
        margin-top: 35%;
        width: 270px;
        height: 300px;
        background-color: rgba(240, 248, 255, 0.158);
        border-radius: 30px;
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    } */
    .form {
        position: relative;
        z-index: 100;
        margin-top: 10%;
        width: auto;
        height: 300px;
        background-color: rgba(240, 248, 255, 0.158);
        border-radius: 30px;
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .logo {
        width: 100px;
        height: 100px;
        background:
            url(/pkbackoffice/public/sky16/images/logo250.png)no-repeat 50%;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .h1 {
        color: rgb(255, 255, 255);
        font-weight: 500;
        margin-bottom: 20px;
        font-size: 50px;
        margin-top: 20px;
    }

    .username {
        width: 180px;
        background: none;
        outline: none;
        border: none;
        margin: 10px 0px;
        border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
        padding: 5px;
        color: aliceblue;
        font-size: 18px;
        transition: 0.2s ease-in-out;
        margin-top: 30px;
    }

    .password {
        width: 180px;
        background: none;
        outline: none;
        border: none;
        margin: 5px 0px;
        border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
        padding: 5px;
        color: aliceblue;
        font-size: 18px;
        transition: 0.2s ease-in-out;
    }

    ::placeholder {
        color: rgba(255, 255, 255, 0.582);
    }

    ::focus {
        border-bottom: aliceblue 1px solid;
    }

    .fa-solid {
        transition: 0.2s ease-in-out;
        color: rgba(240, 248, 255, 0.59);
        margin-right: 10px;
        /* margin-top: 50px; */
    }

    /* .btn {
        width: 110px;
        height: 30px;
        margin-top: 10px;
        font-weight: 500;
        color: aliceblue;
        outline: none;
        border: none;
        background: rgba(240, 248, 255, 0.2);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        font-size: 15px;
        transition: 0.2s;
    } */

    .footer {
        width: 400px;
        height: 40px;
        margin-top: 100px;
        font-weight: 500;
        color: aliceblue;
        outline: none;
        border: none;
        background: rgba(240, 248, 255, 0.2);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        font-size: 20px;
        transition: 0.2s;
    }

    &::hover {
        background: aliceblue;
        color: gray;
        font-weight: 500;
    }

    .circle1 {
        position: absolute;
        width: 290px;
        height: 290px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: 60%;
        left: 70%;
        z-index: -1;
        animation: float 2s 0.5s ease-in-out infinite;
    }

    .circle2 {
        position: absolute;
        width: 170px;
        height: 170px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: -30%;
        right: 35%;
        z-index: -1;
        animation: float 2s ease-in-out infinite;
    }

    .circle3 {
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: 50%;
        right: 50%;
        z-index: -1;
        animation: float 2s 0.7s ease-in-out infinite;
    }

    .circle4 {
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: 20%;
        left: 2%;
        z-index: -1;
        animation: float 2s 0.5s ease-in-out infinite;
    }

    .circle5 {
        position: absolute;
        width: 320px;
        height: 320px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: 20%;
        left: 28%;
        z-index: -1;
        animation: float 2s 0.5s ease-in-out infinite;
    }

    .po {
        position: relative;
        z-index: 100;
        margin-top: 7%;
        width: 800px;
        height: auto;
        background-color: rgba(240, 248, 255, 0.158);
        border-radius: 20px;
        backdrop-filter: blur(1px);
        /* display: flex; */
        align-items: right;
        justify-content: right;
        flex-direction: column;
    }

    .popic {
        position: absolute;
        width: 300px;
        height: 300px;
        background:
            url(/pkbackoffice/public/images/ponews.png)no-repeat 50%;
        /* url(/sky16/images/logo250.png)no-repeat 25%; */
        background-size: cover;
        top: -35%;
        right: 7%;
        z-index: -1;
        animation: float 2s ease-in-out infinite;
    }


    @keyframes float {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0);
        }
    }
</style>

<body>
    <?php
    $datadetail = DB::connection('mysql')->select('select * from orginfo where orginfo_id = 1');
    ?>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container">
            @foreach ($datadetail as $item)
                <img src="{{ asset('images/logo150.png') }}" class="bi me-2" width="40" height="40"
                    alt="">
                <a class="navbar-brand" href="#">{{ $item->orginfo_name }}</a>
            @endforeach

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('sit_auto') }}">Auto Systems</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report_dashboard') }}">Report</a>
                    </li>

                </ul>
                <form class="d-flex" role="search">
                    {{-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> --}}
                    <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container-fluid">

        <div class="circle1"> </div>
        <div class="circle2"> </div>
        <div class="circle3"> </div>
        <div class="circle4"> </div>
        <div class="circle5"> </div>
        <div class="popic"> </div>
        <div class="row">
            <div class="col-md-12">
                <form  class="form">
                </form>
                {{-- <form method="POST" action="{{ route('login') }}" class="form">
                    @csrf
                    <div class="logo"> </div>
                    <div>
                        <i class="fa-solid fa-user"></i>
                        <input type="text" placeholder="Username" name="username" class="username" required>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <i class="fa-solid fa-key"></i>
                        <input type="password" placeholder="Password" name="password" class="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info">Login</button>
                </form> --}}
            {{-- </div> --}}
            {{-- <div class="col-md-4"> </div>
            <div class="col-md-2"> </div>
            <div class="col-md-1">
            </div>
            <div class="row ">
                <div class="col-md-4 text-center">
                    @foreach ($datadetail as $item)
                        <label for="" class="mt-2" style="color: white">2023 ©
                            {{ $item->orginfo_name }}</label>
                    @endforeach
                </div>
                <div class="col-md-8"></div>
            </div> --}}

            {{-- <div class="row text-center">
                <div class="col-md-1"></div>
                <div class="col-md-2 ">
                    <label for="" class=" ms-2 mt-2" style="color: white"> By ทีมพัฒนา PK-OFFICER</label>
                </div>
                <div class="col-md-9"></div>
            </div>
            <div class="row text-start">
                <div class="col-md-1 "> </div>
                <div class="col-md-4 "> &nbsp;&nbsp;&nbsp;
                    <a href="{{ url('report_dashboard') }}" class="btn btn-success btn-sm ms-2"
                        target="_blank">Report </a>
                    <a href="{{ url('sit_auto') }}" class="btn btn-warning btn-sm ms-2" target="_blank">Auto
                        Systems</a>
                </div>
                <div class="col-md-7 "> </div>
            </div> --}}

        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">เข้าสู่ระบบ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="{{ asset('images/logo150.png') }}" class="bi mb-3" width="200" height="200" alt="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Username</button>
                                <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Example text with button addon" aria-describedby="button-addon1" required>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Password</button>
                                <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Example text with button addon" aria-describedby="button-addon1" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                <button type="submit" class="btn btn-outline-info">Login </button>
                </div>

                </form>
            </div>
            </div>
        </div>

        <script src="{{ asset('assets/js53/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
