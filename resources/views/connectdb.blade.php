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

    <link href="{{ asset('sky16/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/style.css') }}" rel="stylesheet" />

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    }

    .container {
        position: relative;
    }

    .form {
        position: relative;
        z-index: 100;
        width: 500px;
        height: 650px;
        background-color: rgba(240, 248, 255, 0.158);
        border-radius: 20px;
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .logo {
        width: 200px;
        height: 200px;
        background:
            url(/pkbackoffice/public/sky16/images/logo250.png)no-repeat 50%;
        /* url(/sky16/images/logo250.png)no-repeat 25%; */
        background-size: cover;
        /* background-attachment: fixed; */
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

    .DB_HOST {
        width: 250px;
        background: none;
        outline: none;
        border: none;
        margin: 15px 0px;
        border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
        padding: 10px;
        color: aliceblue;
        font-size: 18px;
        transition: 0.2s ease-in-out;
        margin-top: 50px;
    }

    .DB_DATABASE {
        width: 250px;
        background: none;
        outline: none;
        border: none;
        margin: 5px 0px;
        border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
        padding: 10px;
        color: aliceblue;
        font-size: 18px;
        transition: 0.2s ease-in-out;
    }

    .DB_PORT {
        width: 250px;
        background: none;
        outline: none;
        border: none;
        margin: 5px 0px;
        border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
        padding: 10px;
        color: aliceblue;
        font-size: 18px;
        transition: 0.2s ease-in-out;
    }

    .DB_USERNAME {
        width: 250px;
        background: none;
        outline: none;
        border: none;
        margin: 5px 0px;
        border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
        padding: 10px;
        color: aliceblue;
        font-size: 18px;
        transition: 0.2s ease-in-out;
    }

    .DB_PASSWORD {
        width: 250px;
        background: none;
        outline: none;
        border: none;
        margin: 5px 0px;
        border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
        padding: 10px;
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

    .btn {
        width: 190px;
        height: 40px;
        margin-top: 30px;
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
        width: 390px;
        height: 390px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: 50%;
        left: 80%;
        z-index: -1;
        animation: float 2s 0.5s ease-in-out infinite;
    }

    .circle2 {
        position: absolute;
        width: 170px;
        height: 170px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: -15%;
        right: 25%;
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
        right: 80%;
        z-index: -1;
        animation: float 2s 0.7s ease-in-out infinite;
    }

    .circle4 {
        position: absolute;
        width: 120px;
        height: 120px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: 10%;
        right: 65%;
        z-index: -1;
        animation: float 2s ease-in-out infinite;
    }

    .circle5 {
        position: absolute;
        width: 160px;
        height: 160px;
        background: rgba(240, 248, 255, 0.1);
        border-radius: 50%;
        top: 20%;
        right: 95%;
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
    <div class="container">
        <div class="circle1"> </div>
        <div class="circle2"> </div>
        <div class="circle3"> </div>
        <div class="circle4"> </div>
        <div class="circle5"> </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-4 form">

                {{-- <form class="form">
                    @csrf --}}
                <div class="logo"> </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" placeholder="SERVER IP" name="DB_HOST" id="DB_HOST" class="DB_HOST">

                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" placeholder="DATABASE" name="DB_DATABASE" id="DB_DATABASE" class="DB_DATABASE">

                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" placeholder="PORT" name="DB_PORT" id="DB_PORT" class="DB_PORT">

                </div>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" placeholder="USERNAME" name="DB_USERNAME" id="DB_USERNAME" class="DB_USERNAME">

                </div>
                <div>
                    <i class="fa-solid fa-key"></i>
                    <input type="password" placeholder="PASSWORD" name="DB_PASSWORD" id="DB_PASSWORD" class="DB_PASSWORD">
                </div>
                <button type="button" class="btn" id="Savebtn">Connect</button>
                {{-- </form> --}}
            </div>
            <div class="col"></div>
        </div>
        <div class="row mt-3">
            <?php
            $datadetail = DB::connection('mysql')->select('select * from orginfo where orginfo_id = 1');
            ?>

            <div class="col-md-12 text-center">
                @foreach ($datadetail as $item)
                    <label for="" class=" ms-5" style="color: white">2023 © {{ $item->orginfo_name }}</label>
                @endforeach

            </div>
        </div>


        <div class="row text-center">
            <div class="col-md-12 ">
                <label for="" class=" ms-5" style="color: white"> Create By ทีมพัฒนา PK-OFFICER</label>
            </div>
        </div>


    </div>

    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
         $(document).ready(function() {
            // $('#example').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#Savebtn').click(function() {

                var DB_HOST = $('#DB_HOST').val();
                var DB_DATABASE = $('#DB_DATABASE').val();
                var DB_PORT = $('#DB_PORT').val();
                var DB_USERNAME = $('#DB_USERNAME').val();
                var DB_PASSWORD = $('#DB_PASSWORD').val(); 
                $.ajax({
                    url: "{{ route('db.connectdb_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        DB_HOST, DB_DATABASE,DB_PORT,DB_USERNAME,DB_PASSWORD
                    },
                    success: function(data) {
                        if (data.status == 200) { 
                            Swal.fire({
                                title: 'เชื่อมต่อ Database สำเร็จ',
                                text: "You Connect Database data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                        window.location="{{route('login')}}";
                                    // window.location
                                    //     .reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'เชื่อมต่อ Database ไม่สำเร็จ',
                                text: "You Connect Database data Unsuccess",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
 
                                }
                            })
                        }

                    },
                });
            });
        });
    </script>
</body>

</html>
