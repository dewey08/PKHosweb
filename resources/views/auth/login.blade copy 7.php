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
    <link href="{{ asset('css/loginheader.css') }}" rel="stylesheet" />
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
        height: 100%;
        background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
            url(/pkbackoffice/public/sky16/images/bgPK.jpg)no-repeat 50%; 
        background-size: cover;
        /* background-attachment: fixed; */
        /* display: flex; */
        /* align-items: center; */
        justify-content: center;
        /* min-height: 58rem; */
        /* padding-top: 2.5rem; */
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
  
    .popic {
        position: absolute;
        width: 210px;
        height: 210px;
        background:
            url(/pkbackoffice/public/images/ponews.png)no-repeat 100%;
        /* url(/sky16/images/logo250.png)no-repeat 25%; */
        background-size: cover;
        top: 1%;
        right: 1%;
        z-index: -1;
        animation: float 2s ease-in-out infinite;
    }

    .popic_name {
        position: absolute;
        width: 250px;
        height: 50px;
        background:
            url(/pkbackoffice/public/images/po.png)no-repeat 100%;
        /* url(/sky16/images/logo250.png)no-repeat 25%; */
        background-size: cover;
        top: 25%;
        right: 2%;
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
    <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="height: 100px;">
        <div class="container">
            @foreach ($datadetail as $item)
                {{-- <img src="{{ asset('images/sto.png') }}" class="bi me-2" width="30" height="45" alt=""> --}}
                <img src="{{ asset('images/logo150.png') }}" class="bi me-4" width="45" height="45"
                    alt="">
                <a class="navbar-brand" href="#" style="font-size: 22px">{{ $item->orginfo_name }}</a>
            @endforeach

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('sit_auto') }}" target="bank">Auto
                            Systems</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report_dashboard') }}" target="bank">Report</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    {{-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> --}}
                    <button class="btn btn-outline-warning" type="button" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="fa-solid fa-fingerprint text-warning"></i>
                        เข้าสู่ระบบ
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="circle1"> </div>
        <div class="circle2"> </div>
        <div class="circle3"> </div>
        <div class="circle4"> </div>
        <div class="circle5"> </div>
        <div class="popic"> </div>
        <div class="popic_name"> </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card"
                    style="background-color:rgba(230, 232, 232, 0.097);backdrop-filter: blur(2px);border-radius: 30px;">
                    <div class="card-header"
                        style="background-color:rgba(226, 241, 248, 0.566);border-radius: 30px;">
                        ประชาสัมพันธ์
                    </div>
                    <div class="card-body" style="height: 500px;">
                        <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel"
                            data-bs-theme="light">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0"
                                    class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"
                                    aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"
                                    aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('images/Vision01.jpg') }}" class="bd-placeholder-img"
                                        width="100%" height="100%">
                                    <div class="container">
                                        <div class="carousel-caption text-end">
                                            {{-- <h1>Example headline.</h1> --}}
                                            {{-- <p class="opacity-75">Some representative placeholder content for the first slide of the carousel.</p> --}}
                                            <p><a class="btn btn-lg btn-primary" href="#">Detail</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/Vision02.jpg') }}" class="bd-placeholder-img"
                                        width="100%" height="100%">
                                    <div class="container">
                                        <div class="carousel-caption text-end">
                                            {{-- <h1>Another example headline.</h1> --}}
                                            {{-- <p>Some representative placeholder content for the second slide of the carousel.</p> --}}
                                            <p><a class="btn btn-lg btn-primary" href="#">Detail</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/Vision01.jpg') }}" class="bd-placeholder-img"
                                        width="100%" height="100%">
                                    <div class="container">
                                        <div class="carousel-caption text-end">
                                            {{-- <h1>One more for good measure.</h1> --}}
                                            {{-- <p>Some representative placeholder content for the third slide of this carousel.</p> --}}
                                            <p><a class="btn btn-lg btn-primary" href="#">Detail</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card"
                    style="background-color:rgba(230, 232, 232, 0.097);backdrop-filter: blur(2px);border-radius: 30px;">
                    <div class="card-header"
                        style="background-color:rgba(226, 241, 248, 0.566);border-radius: 30px;">
                        ประกาศข่าว
                    </div>
                    <div class="card-body" style="height: 500px;">

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">

                    <img src="{{ asset('images/logo150.png') }}" class="bi me-2" width="40" height="40"
                        alt="">
                </a>
                <span class="mb-3 mb-md-0 text-body-secondary">
                    <label for="" class=" ms-2 mt-2" style="color: white"> By Team PK-OFFICER</label></span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3">
                    <a class="text-body-secondary" href="#">
                        <i class="fa-brands fa-2x fa-twitter" style="color: white"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="text-body-secondary" href="https://www.facebook.com/profile.php?id=100058772592423">
                        <i class="fa-brands fa-2x fa-facebook" style="color: white"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="text-body-secondary" href="#">
                        <i class="fa-brands fa-2x fa-line" style="color: white"></i>
                    </a>
                </li>
            </ul>
        </footer>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">เข้าสู่ระบบ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:rgba(255, 192, 203, 0.962);">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-md-8 text-center">
                                {{-- <img src="{{ asset('images/sto.png') }}" class="bi me-2" width="120" height="150" alt=""> --}}
                                <img src="{{ asset('images/logo150.png') }}" class="bi mb-3" width="150"
                                    height="150" alt="">
                            </div>
                            <div class="col"></div>
                        </div>

                        <div class="row">
                            <div class="col"></div>
                            <div class="col-md-8 text-center">
                                <div class="input-group mb-3">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="button-addon1">Username</button>
                                    <input type="text" class="form-control" name="username"
                                        placeholder="Username" aria-label="Example text with button addon"
                                        aria-describedby="button-addon1" required>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-md-8 text-center">
                                <div class="input-group mb-3">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="button-addon1">Password</button>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Password" aria-label="Example text with button addon"
                                        aria-describedby="button-addon1" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col"></div>
                        </div>


                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa-solid fa-fingerprint text-primary"></i>
                        เข้าสู่ระบบ
                    </button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js53/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
