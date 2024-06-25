@extends('layouts.reportall')
@section('title', 'PK-BACKOFFice || Report')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
    ?>
    <style>
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
            border: 10px #ddd solid;
            border-top: 10px #fd6812 solid;
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
    <?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    ?>

        <div class="tabs-animation">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">
    
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div>
            </div>





            <div class="row"> 
                <div class="col-md-3">
                    <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                    <p class="card-title-desc">(refer) จำนวนผู้ป่วย unplan referout ipd</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}"/>                     
                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport" id="Pulldata">
                            <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                            เรียกข้อมูล
                        </button>    
                    </div>  
                </div> 
            </div>

        <div class="row">
            <div class="col-xl-12"> 
                    <div class="card cardreport">                 
                            <div class="table-responsive p-4">
                                <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                                style=" border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>                                          
                                            <th width="5%" class="text-center">ลำดับ</th>
                                            <th class="text-center" width="5%">refer_date</th> 
                                            <th class="text-center">hn</th>
                                            <th class="text-center" >an</th>
                                            <th class="text-center" >ptname</th>
                                            <th class="text-center">sexname</th>
                                            <th class="text-center">referhos</th>  
                                            <th class="text-center">pdx</th> 
                                            <th class="text-center">dx0</th>
                                            <th class="text-center">dx1</th>  
                                            <th class="text-center">dx2</th>
                                            <th class="text-center">dx3</th>
                                            <th class="text-center">dx4</th>
                                            <th class="text-center">dx5</th>
                                            <th class="text-center">datereg</th>
                                            <th class="text-center">timerefer</th>      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($hos_01 as $item) 
                                            <tr id="tr_{{$item->acc_debtor_id}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>                                                 
                                                <td class="text-center" width="5%"><input type="checkbox" class="sub_chk" data-id="{{$item->acc_debtor_id}}"> </td> 
                                                <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                                <td class="text-center" width="5%">{{ $item->an }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                                <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                <td class="p-2" >{{ $item->ptname }}</td> 
                                                <td class="text-center" width="10%">{{ $item->vstdate }}</td>   
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td> 
                                                <td class="text-center" style="color:rgb(201, 119, 248)" width="5%">{{ $item->hospmain }}</td> 
                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->subinscl }}</td>  
                                                <td class="text-center" width="10%">{{ number_format($item->debit_total, 2) }}</td> 
 
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                    </div> 
            </div>
        </div>
   

@endsection
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
 

        });
    </script>
@endsection
