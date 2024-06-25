@extends('layouts.user')
@section('title', 'PKClaim || ผู้ใช้งานทั่วไป')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    // $NAME_USER = Auth::user()->name;
    //   $url = Request::url();
    //   $pos = strrpos($url, '/') + 1;
    
    // if($status=='ADMIN'){
    //     $user_id = substr($url, $pos);
    // }else{
    //     $user_id = $iduser;
    // }
    
    use App\Http\Controllers\UsersuppliesController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    
    $refnumber = UsersuppliesController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_rong = StaticController::count_bookrep_rong();
    $count_bookrep_po = StaticController::count_bookrep_po();
    $countpesmiss_per = StaticController::countpesmiss_per($iduser);
    $countpesmiss_book = StaticController::countpesmiss_book($iduser);
    $countpesmiss_car = StaticController::countpesmiss_car($iduser);
    $countpesmiss_meetting = StaticController::countpesmiss_meetting($iduser);
    $countpesmiss_repair = StaticController::countpesmiss_repair($iduser);
    $countpesmiss_com = StaticController::countpesmiss_com($iduser);
    $countpesmiss_medical = StaticController::countpesmiss_medical($iduser);
    $countpesmiss_hosing = StaticController::countpesmiss_hosing($iduser);
    $countpesmiss_plan = StaticController::countpesmiss_plan($iduser);
    $countpesmiss_asset = StaticController::countpesmiss_asset($iduser);
    $countpesmiss_supplies = StaticController::countpesmiss_supplies($iduser);
    $countpesmiss_store = StaticController::countpesmiss_store($iduser);
    $countpesmiss_store_dug = StaticController::countpesmiss_store_dug($iduser);
    $countpesmiss_pay = StaticController::countpesmiss_pay($iduser);
    $countpesmiss_money = StaticController::countpesmiss_money($iduser);
    $countpesmiss_claim = StaticController::countpesmiss_claim($iduser);
    ?>



    <style>
        /* body {
            font-size: 14px;
        }

        .btn {
            font-size: 15px;
        }

        .page {
            width: 90%;
            margin: 10px;
            box-shadow: 0px 0px 5px #000;
            animation: pageIn 1s ease;
            transition: all 1s ease, width 0.2s ease;
        }

        @keyframes pageIn {
            0% {
                transform: translateX(-300px);
                opacity: 0;
            }

            100% {
                transform: translateX(0px);
                opacity: 1;
            }
        } */



        /* li {
                position: absolute;
                left: 0;
                list-style: none;
                transform-origin: 320px;
                transition: 0.5s;
                transition-delay: calc(0.1s * var(--i));
                transform: rotate(0deg) translateX(280px);
            } */

        .cir {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 150px;
            background: #fff;
            border-radius: 50%;
            /* transform: rotate(calc(360deg / -15 * var(--i))); */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .backgnd {
            /* width: 200px; */
            width: 100vh;
            height: 100vh;
            background: url(/pkclaim/public/sky16/images/bgPK.jpg)no-repeat 50%;
            /* url(/sky16/images/logo250.png)no-repeat 25%; */
            background-size: cover;
            /* background-attachment: fixed; */
            display: flex;
            /* align-items: center; */
            /* justify-content: center; */
        }
    </style>



    <div class="container ">
        <div class="row mt-3">
            {{-- <div class="col-6 col-md-4 col-xl-2 mt-3">  
          <div class="card cir">
            <div class="card-body cir shadow-lg">          
                <a href="" class="nav-link text-dark text-center">
                    <i class="fa-solid fa-3x fa-chart-line text-warning"></i>
                    <br>
                  <label for="" class="mt-2">Dashboard</label>
                </a>
            </div>
          </div>
      </div> --}}

{{-- <div class="col"></div> --}}
            @if ($countpesmiss_per != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('person/person_index') }}" class="nav-link text-dark text-center" target="_blank">
                                <i class="fa-solid fa-3x fa-user-tie text-primary "></i><br>
                                <label for="" class="mt-2">บุคคลากร</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif


            @if ($countpesmiss_book != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('book/bookmake_index') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-book-open-reader text-secondary"></i>
                                <br>
                                <label for="" class="mt-2">สารบรรณ</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_car != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('car/car_narmal_calenda') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-truck-medical text-info"></i>
                                <br>
                                <label for="" class="mt-2">ยานพาหนะ</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_meetting != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('meetting/meettingroom_dashboard') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-house-laptop text-success"></i>
                                <br>
                                <label for="" class="mt-2">ห้องประชุม</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_repair != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('repaire_narmal') }}" class="nav-link text-dark text-center" target="_blank">
                                <i class="fa-solid fa-3x fa-screwdriver-wrench text-info"></i>
                                <br>
                                <label for="" class="mt-2">ซ่อมบำรุง</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif



            @if ($countpesmiss_com != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('computer/com_staff_calenda') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-computer text-secondary"></i>
                                <br>
                                <label for="" class="mt-2">คอมพิวเตอร์</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_medical != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('medical/med_dashboard') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-pump-medical text-warning"></i>
                                <br>
                                <label for="" class="mt-2">เครื่องมือแพทย์</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_hosing != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('housing/housing_dashboard') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-house-chimney-user text-info"></i>
                                <br>
                                <label for="" class="mt-2">บ้านพัก</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_plan != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('plan') }}" class="nav-link text-dark text-center" target="_blank">
                                <i class="fa-solid fa-3x fa-clipboard text-danger"></i>
                                <br>
                                <label for="" class="mt-2"> แผนงาน</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_supplies != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('article/article_dashboard') }}" class="nav-link text-dark text-center"
                                target="_blank">

                                <i class="fa-solid fa-3x fa-building-shield text-secondary"></i>
                                <br>
                                <label for="" class="mt-2"> ทรัพย์สิน</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_store != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('supplies/supplies_dashboard') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-paste text-success"></i>
                                <br>
                                <label for="" class="mt-2"> พัสดุ</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif


            @if ($countpesmiss_store != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('warehouse/warehouse_dashboard') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-shop-lock text-primary"></i>
                                <br>
                                <label for="" class="mt-2">คลังวัสดุ</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_store_dug != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="#" class="nav-link text-dark text-center" target="_blank">
                                <i class="fa-solid fa-3x fa-prescription text-success"></i>
                                <br>
                                <label for="" class="mt-2">คลังยา</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_pay != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="#" class="nav-link text-dark text-center" target="_blank">
                                <i class="fa-solid fa-3x fa-person-booth text-danger"></i>
                                <br>
                                <label for="" class="mt-2">จ่ายกลาง</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_claim != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('pkclaim/pkclaim_info') }}" class="nav-link text-dark text-center"
                                target="_blank">
                                <i class="fa-solid fa-3x fa-sack-dollar text-danger"></i>
                                <br>
                                <label for="" class="mt-2">งานประกัน</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($countpesmiss_money != 0)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card cir">
                        <div class="card-body cir shadow-lg">
                            <a href="{{ url('account_info') }}" class="nav-link text-dark text-center" target="_blank">
                                <i class="fa-solid fa-3x fa-file-invoice-dollar text-warning"></i>
                                <br>
                                <label for="" class="mt-2">การเงิน & บัญชี</label>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <?php
            $datadetail = DB::connection('mysql')->select('   
                                        select * from orginfo 
                                        where orginfo_id = 1 
                                         ');
            ?>



</div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-4">
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            @foreach ($datadetail as $item)
                                <label for="" style="color: rgb(82, 11, 148);font-size:17px"> ©
                                    {{ $item->orginfo_name }}</label>
                            @endforeach

                        </div>
                        <div class="col"></div>
                        <div class="col-md-4 text-center">
                            <label for="" style="color: rgb(82, 11, 148);font-size:17px"> By Pradit Raha -
                                งานประกัน</label>
                        </div>

                    </div>
                </div>
            </footer>

    @endsection
