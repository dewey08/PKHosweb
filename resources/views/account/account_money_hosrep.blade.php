 
@extends('layouts.accountnew')
@section('title', 'PK-OFFICE || Account')
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
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SuppliesController;
    use App\Http\Controllers\StaticController;
    $refnumber = SuppliesController::refnumber();
    $count_product = StaticController::count_product();
    $count_service = StaticController::count_service();
    ?>
    <div class="container-fluid">
        <div class="row "> 
            @foreach ($users_hos as $item)
                <div class="col-6 col-md-4 col-xl-4 mt-3">  
                    <div class="card">
                        <div class="card-body shadow-lg">          
                            <a href="{{url("account_money_rep/".$item->users_hos_id)}}" class="nav-link text-dark text-center"> 
                            @if ($item->users_hos_id == '1')
                            <i class="fa-solid fa-3x fa-hospital text-primary"></i> 
                            @elseif ($item->users_hos_id == '2')
                            <i class="fa-solid fa-3x fa-hospital text-success"></i> 
                            @elseif ($item->users_hos_id == '3')
                            <i class="fa-solid fa-3x fa-hospital text-info"></i> 
                            @elseif ($item->users_hos_id == '4')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(132, 6, 144)"></i> 
                            @elseif ($item->users_hos_id == '5')
                            <i class="fa-solid fa-3x fa-hospital text-danger"></i> 
                            @elseif ($item->users_hos_id == '6')
                            <i class="fa-solid fa-3x fa-hospital text-secondary"></i> 
                            @elseif ($item->users_hos_id == '7')
                            <i class="fa-solid fa-3x fa-hospital" style="color: palevioletred"></i> 
                            @elseif ($item->users_hos_id == '8')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(216, 53, 107)"></i>
                            @elseif ($item->users_hos_id == '9')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(2, 78, 44)"></i>
                            @elseif ($item->users_hos_id == '10')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(241, 48, 0)"></i>
                            @elseif ($item->users_hos_id == '11')
                            <i class="fa-solid fa-3x fa-hospital text-warning" ></i>
                            @elseif ($item->users_hos_id == '12')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(138, 112, 216)"></i>
                            @elseif ($item->users_hos_id == '13')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(39, 8, 38)"></i>
                            @elseif ($item->users_hos_id == '14')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(229, 237, 10)"></i>
                            @elseif ($item->users_hos_id == '15')
                            <i class="fa-solid fa-3x fa-hospital" style="color: rgb(11, 88, 99)"></i>
                            @else
                                
                            @endif
                            <br>
                            <label for="" class="mt-2 ms-3">{{$item->users_hos_name}}</label>
                            </a>
                    </div>
                </div>
            </div>
            @endforeach
       
        </div>
    </div>
    

@endsection
