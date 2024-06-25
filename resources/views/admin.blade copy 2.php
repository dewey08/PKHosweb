@extends('layouts.admindashboard')
@section('title', 'PK || ผู้ดูแลระบบ')

@section('content')
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

?>
<style>
     
    body {
        width: 100%;
        height: 100vh;
        /* background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
            url(/pkclaim/public/sky16/images/bgPK.jpg)no-repeat 50%; */
            background: url(/pkclaim/public/sky16/images/bgPK.jpg)no-repeat 50%;
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

    .box {
        position: relative;
        z-index: 100;
        width: auto;
        height: auto;
        background-color: rgba(169, 171, 173, 0.158);
        border-radius: 30px;
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        /* margin-bottom: 200px; */
    }
 
    .cir {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 130px;
        height: 130px;
        background: #fff;
        border-radius: 50%;
        /* transform: rotate(calc(360deg / -15 * var(--i))); */
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.2);
    }

 
</style>
{{-- <style>
    #button{
           display:block;
           margin:20px auto;
           padding:100px 100px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
           }
           .cv-spinner {
           height: 100%;
           display: flex;
           justify-content: center;
           align-items: center;  
           }
           .spinner {
           width: 250px;
           height: 250px;
           border: 5px #ddd solid;
           border-top: 10px #c2f116 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% { 
               transform: rotate(360deg); 
           }
           }
           .is-hide{
           display:none;
           }
</style> --}}
 
    <div class="container">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('person/person_index') }}" class="nav-link text-dark text-center"
                            target="_blank">
                            <i class="fa-solid fa-3x fa-user-tie" style="color: rgb(164, 7, 179)"></i><br>
                            <label for="" class="mt-2">บุคคลากร</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg" style="background-color:gray">
                        <a href="{{ url('gleave') }}" class="nav-link text-dark text-center"
                            target="_blank"> 
                            <i class="fa-solid fa-3x fa-hospital-user" style="color: rgb(170, 7, 97)"></i>
                            <br>
                            <label for="" class="mt-2">ระบบการลา</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('book/bookmake_index') }}" class="nav-link text-dark text-center"
                            target="_blank">
                            <i class="fa-solid fa-3x fa-book-open-reader" style="color: rgb(128, 5, 139)"></i>
                            <br>
                            <label for="" class="mt-2">สารบรรณ</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
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
            <div class="col-6 col-md-4 col-xl-2 mt-2">
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
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('repaire_narmal') }}" class="nav-link text-dark text-center"
                            target="_blank">
                            <i class="fa-solid fa-3x fa-screwdriver-wrench text-info"></i>
                            <br>
                            <label for="" class="mt-2">ซ่อมบำรุง</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
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
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('medical/med_calenda') }}" class="nav-link text-dark text-center"
                            target="_blank">
                            <i class="fa-solid fa-3x fa-microscope text-warning"></i> 
                            <br>
                            <label for="" class="mt-2">เครื่องมือแพทย์</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg" style="background-color:gray">
                        <a href="{{ url('housing/housing_dashboard') }}" class="nav-link text-dark text-center"
                            target="_blank">
                            <i class="fa-solid fa-3x fa-house-chimney-user text-info"></i>
                            <br>
                            <label for="" class="mt-2">บ้านพัก</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
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
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('article/article_index') }}" class="nav-link text-dark text-center"
                            target="_blank">

                            <i class="fa-solid fa-3x fa-building-shield text-secondary"></i>
                            <br>
                            <label for="" class="mt-2"> ทรัพย์สิน</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('supplies/supplies_index') }}" class="nav-link text-dark text-center"
                            target="_blank">
                            <i class="fa-solid fa-3x fa-paste text-success"></i>
                            <br>
                            <label for="" class="mt-2"> พัสดุ</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('warehouse/warehouse_index') }}" class="nav-link text-dark text-center"
                            target="_blank">
                            <i class="fa-solid fa-3x fa-shop-lock text-primary"></i>
                            <br>
                            <label for="" class="mt-2">คลังวัสดุ</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg" style="background-color:gray">
                        <a href="#" class="nav-link text-dark text-center" target="_blank">
                            <i class="fa-solid fa-3x fa-prescription text-success"></i>
                            <br>
                            <label for="" class="mt-2">คลังยา</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir" >
                    <div class="card-body cir shadow-lg" style="background-color:gray">
                        <a href="#" class="nav-link text-dark text-center" target="_blank">
                            <i class="fa-solid fa-3x fa-person-booth text-danger"></i>
                            <br>
                            <label for="" class="mt-2">จ่ายกลาง</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
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
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('account_info') }}" class="nav-link text-dark text-center" target="_blank">  
                            <i class="fa-solid fa-3x fa-money-check-dollar text-warning"></i>
                            <br>
                            <label for="" class="mt-2">การเงิน</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('account_pk') }}" class="nav-link text-dark text-center" target="_blank">
                            <i class="fa-solid fa-3x fa-file-invoice-dollar" style="color: gray"></i>
                            <br>
                            <label for="" class="mt-2">การบัญชี</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    {{-- <div class="card-body cir shadow-lg" style="background-color:gray"> --}}
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('p4p') }}" class="nav-link text-dark text-center" target="_blank"> 
                            <i class="fa-solid fa-2x fa-p text-danger"></i> <i class="fa-solid fa-2x fa-4 text-warning"></i><i class="fa-solid fa-2x fa-p text-info ms-2"></i>
                            {{-- <br>
                            <label for="" class="mt-2">P4P</label> --}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('medicine_salt') }}" class="nav-link text-dark text-center" target="_blank"> 
                            <i class="fa-solid fa-3x fa-square-person-confined" style="color: rgb(159, 9, 197)"></i> 
                            <br>
                            <label for="" class="mt-2">แพทย์แผนไทย</label> 
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('otone') }}" class="nav-link text-dark text-center" target="_blank"> 
                            <i class="fa-solid fa-3x fa-people-line" style="color: rgb(9, 106, 197)"></i> 
                            <br>
                            <label for="" class="mt-2">โอที</label> 
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mt-2">
                <div class="card cir">
                    <div class="card-body cir shadow-lg">
                        <a href="{{ url('env_dashboard') }}" class="nav-link text-dark text-center" target="_blank"> 
                            <i class="fa-solid fa-3x fa-hand-holding-droplet" style="color: rgb(9, 169, 197)"></i>  
                            <br>
                            <label for="" class="mt-2">ENV</label> 
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <?php
    $datadetail = DB::connection('mysql')->select('   
                                select * from orginfo 
                                where orginfo_id = 1 
                                 ');
    ?>
   {{-- <footer class="footer">
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
                <label for="" style="color: rgb(82, 11, 148);font-size:17px">PK-OFFICER</label>
            </div>

        </div>
    </div>
</footer> --}}
  @endsection

  {{-- <script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#spinner').hide();//Request is complete so hide spinner
        setTimeout(function(){
            $("#overlay").fadeOut(300);
        },500);
          
    });
</script> --}}
