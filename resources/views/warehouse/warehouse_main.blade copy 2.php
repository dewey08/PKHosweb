{{-- @extends('layouts.accpk') --}}
@extends('layouts.warehouse_new')
@section('title', 'PK-OFFICER || คลังวัสดุ')
@section('content')

    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function warehouse_destroy(warehouse_rep_id) {
            Swal.fire({
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('warehouse/warehouse_destroy') }}" + '/' + warehouse_rep_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + warehouse_rep_id).remove();
                                    window.location.reload();
                                }
                            })
                        }
                    })
                }
            })
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
            @foreach ($warehouse_inven as $item)
                <div class="col-6 col-md-4 col-xl-2 mt-3">
                    <div class="card">
                        <div class="card-body shadow-lg">
                            <a href="{{url("warehouse/warehouse_main_detail/".$item->warehouse_inven_id)}}" class="nav-link text-dark text-center">

                            @if ($item->warehouse_inven_id == '1')
                            <i class="fa-solid fa-3x fa-warehouse text-primary"></i>
                            @elseif ($item->warehouse_inven_id == '2')
                            <i class="fa-solid fa-3x fa-warehouse text-success"></i>
                            @elseif ($item->warehouse_inven_id == '3')
                            <i class="fa-solid fa-3x fa-warehouse text-info"></i>
                            @elseif ($item->warehouse_inven_id == '4')
                            <i class="fa-solid fa-3x fa-warehouse text-warning"></i>
                            @elseif ($item->warehouse_inven_id == '5')
                            <i class="fa-solid fa-3x fa-warehouse text-danger"></i>
                            @elseif ($item->warehouse_inven_id == '6')
                            <i class="fa-solid fa-3x fa-warehouse text-secondary"></i>
                            @elseif ($item->warehouse_inven_id == '7')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: palevioletred"></i>
                            @elseif ($item->warehouse_inven_id == '8')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(216, 53, 107)"></i>
                            @elseif ($item->warehouse_inven_id == '9')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(2, 78, 44)"></i>
                            @elseif ($item->warehouse_inven_id == '10')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(241, 48, 0)"></i>
                            @elseif ($item->warehouse_inven_id == '11')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(132, 6, 144)"></i>
                            @elseif ($item->warehouse_inven_id == '12')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(138, 112, 216)"></i>
                            @elseif ($item->warehouse_inven_id == '13')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(39, 8, 38)"></i>
                            @elseif ($item->warehouse_inven_id == '14')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(229, 237, 10)"></i>
                            @elseif ($item->warehouse_inven_id == '15')
                            <i class="fa-solid fa-3x fa-warehouse" style="color: rgb(11, 88, 99)"></i>
                            @else

                            @endif
                            <br>
                            <label for="" class="mt-2">{{$item->warehouse_inven_name}}</label>
                            </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>


@endsection
