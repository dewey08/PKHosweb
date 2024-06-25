@extends('layouts.anc')
@section('title', 'PK-OFFICER || ทาลัสซีเมีย')

<?php
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\DB;
$count_meettingroom = StaticController::count_meettingroom();
use App\Models\Lab_order_image;
?>

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
    ?>
    <style>
        body {
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }

        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        </div>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        <form action="{{ url('thalassemia_opd_new') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control card_anc_4" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control card_anc_4" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}"/>  
                   
                            <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary card_anc_4" data-style="expand-left" id="Pulldata">
                                <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i></i>ค้นหา</span>
                              
                            </button>    
                  
                </div>   

            </div>
        </form>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card card_anc_4">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>จำนวนผู้ป่วย Thalassemia OPD ให้เลือด</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <p class="mb-0">
                                    {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr style="font-size: 13px"> 
                                            <th class="text-center">hn</th>
                                            <th class="text-center">cid</th>
                                            <th class="text-center">ptname</th>
                                            {{-- <th class="text-center">pttype</th> --}}
                                            <th class="text-center">vstdate</th>
                                            {{-- <th class="text-center">icd10</th> --}}
                                            {{-- <th class="text-center">drugname</th> --}}
                                            <th class="text-center">sum_price</th>
                                            {{-- <th class="text-center">ferritin</th> --}}
                                            <th class="text-center">lab_name</th>
                                            <th class="text-center">order_result</th>
                                            <th class="text-center">Hct</th>
                                            <th class="text-center">image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $number = 0; ?>
                                        @foreach ($d_talassemia as $item1)
                                            <?php $number++; 
                                                // $data_image = DB::connection('mysql14')->select('SELECT * FROM lab_order_image WHERE lab_order_number = "' .$item1->lab_order_number .'"');
                                                //     foreach ($data_image as $key => $value) {
                                                //         $image_ = $value->image1; 
                                                //         $image_blob = base64_encode($image_); 
                                                //         $image2 = base64_encode(file_get_contents($image_));
                                                //     } 
                                                    // $image_s = $image_; 
                                            ?>

                                            <tr height="20" style="font-size: 12px;"> 
                                                <td class="text-center" width="5%">{{ $item1->hn }}</td>
                                                <td class="text-center" width="5%">{{ $item1->cid }}</td>
                                                <td class="text-start">{{ $item1->ptname }}</td>
                                                {{-- <td class="text-center" width="5%">{{ $item1->pttype }}</td> --}}
                                                <td class="text-center" width="8%">{{ DateThai($item1->vstdate) }}</td>
                                                {{-- <td class="text-start" width="5%">{{ $item1->icd10 }}</td> --}}
                                                {{-- <td class="text-start">{{ $item1->drugname }}</td> --}}
                                                <td class="text-center" width="7%">{{ $item1->sum_price }}</td>
                                                {{-- <td class="text-start" width="12%">{{ $item1->ferritin }}</td> --}}
                                                <td class="text-start" width="10%">{{ $item1->lab_name_cc }}</td>
                                                <td class="text-start" width="10%">{{ $item1->lab_order_result }}</td>
                                                <td class="text-start" width="10%">{{ $item1->lab_items_normal_value_ref }}</td>
                                                <td class="text-center" width="7%">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item1->lab_order_number }}">
                                                        Image
                                                      </button>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $item1->lab_order_number }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Lab Number {{ $item1->lab_order_number }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body"> 
                                                        <?php  
                                                                $data_image = DB::connection('mysql14')->select('SELECT * FROM lab_order_image WHERE lab_order_number = "' .$item1->lab_order_number .'" LIMIT 1');
                                                                // $data_image = Lab_order_image::where('lab_order_number','=',$item1->lab_order_number)->get();
                                                                    // foreach ($data_image as $key => $value) {
                                                                    //     $image_ = $value->image1; 
                                                                    //     $image_blob = base64_encode($image_); 
                                                                    //     $image2 = base64_encode(file_get_contents($image_));
                                                                    // } 
                                                                // if ($sig->image1 != '') {
                                                                //     $signat = $sig->image1;
                                                                //     $signature = base64_encode(file_get_contents($signat));
                                                                // } else {
                                                                //     $signature = '';
                                                                    
                                                                // }
                                                                
                                                               
                                                        ?>
                                                      @foreach ($data_image as $item_s)
                                                      {{file_get_contents($item_s->image1)}}
                                                      <img src="data:image/png;base64,{{$item_s->image1}}" height="500px" width="500px" /> 
                                                     {{$data = base64_encode($img);}} 
                                                      @endforeach
                                                        {{-- <img src="data:image/png;base64,{{$image_blob}}" alt=""> --}}
                                                            {{-- <img src="data:image/jpg;base64,'.{{$image_}}.'" height="100px" width="100px" alt="Image" class="img-thumbnail">                                   --}}
                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                    </div>
                                                </div>
                                                </div>
                                            </div> 


                                        @endforeach

                                    </tbody>
                                </table>
                                </p>
 

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>


@endsection
@section('footer')
    <script>
        $(document).ready(function() {

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#spinner-div").hide(); //Request is complete so hide spinner


        });
    </script>


@endsection
