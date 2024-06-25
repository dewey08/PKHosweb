@extends('layouts.reportall')
@section('title', 'PK-OFFICER || Report')

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

            <div class="col-md-12"> 
                    <div class="card-body ">

                        <h4 class="card-title">ตัวชี้วัดสำคัญใน โรงพยาบาล</h4>
                        <p class="card-title-desc">ตัวชี้วัดสำคัญใน โรงพยาบาล</p> 

                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-ucs" role="tabpanel" aria-labelledby="v-pills-ucs-tab">
                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <div class="card p-4 cardreport">
                                                    <h4 class="card-title" style="color:rgb(10, 151, 85)">ตัวชี้วัดสำคัญใน โรงพยาบาล</h4>
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-striped table-bordered "
                                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <p class="card-title-desc">1. <a href="{{ url('report_hos_01') }}">(refer) จำนวนผู้ป่วย unplan referout ipd</p></a>
                                                            <p class="card-title-desc">2. <a href="{{ url('report_hos_02') }}">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ ด้วย covid IPD >=15ปี</p></a>
                                                            <p class="card-title-desc">3. <a href="{{ url('report_hos_03') }}">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ ด้วย IPD unexpected dead</p></a>
                                                            <p class="card-title-desc">4. <a href="{{ url('report_hos_04') }}">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ ด้วย soft skin and soft tissue infection</p></a>
                                                            <p class="card-title-desc">5. <a href="{{ url('report_hos_05') }}">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ.ER</p></a>
                                                            <p class="card-title-desc">6. <a href="{{ url('report_hos_06') }}">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ.IPD</p></a>
                                                            <p class="card-title-desc">7. <a href="{{ url('report_hos_07') }}">Delivery (O800-O849) AN</p></a>
                                                            <p class="card-title-desc">8. <a href="{{ url('report_hos_08') }}">จำนวน DFIU (O364) with GDM (O244) IPD</p></a>
                                                            <p class="card-title-desc">9. <a href="{{ url('report_hos_09') }}">จำนวน DFIU (O364) IPD</p></a>
                                                            <p class="card-title-desc">10. <a href="{{ url('report_hos_10') }}">จำนวน GDM IPD ทั้งหมด : GDM (O244) IPD AN</p></a>
                                                            <p class="card-title-desc">11. <a href="{{ url('report_hos_11') }}">จำนวน Pneumonia with covid IPD >=15ปี</p></a>
                                                            <p class="card-title-desc">12. <a href="{{ url('report_hos_12') }}">จำนวน Respiratory failure with covid IPD >=15ปี</p></a>
                                                            <p class="card-title-desc">13. <a href="{{ url('report_hos_13') }}">จำนวน Severe Birth asphyxia</p></a>
                                                            <p class="card-title-desc">14. <a href="{{ url('report_hos_14') }}">จำนวนการ readmit ในผู้ป่วย COPD ใน 1 เดือน</p></a>
                                                            <p class="card-title-desc">15. <a href="{{ url('report_hos_15') }}">จำนวนการเกิด Hypovolemic Shock จาก PPH</p></a>
                                                            <p class="card-title-desc">16. <a href="{{ url('report_hos_16') }}">จำนวนการเกิด Respiratory failure ในผู้ป่วย Pneumonia >= 15ปี</p></a>
                                                            <p class="card-title-desc">17. <a href="{{ url('report_hos_17') }}">จำนวนการเกิด Respiratory failure ในผู้ป่วย Pneumonia ในเด็ก < 15 ปี</p></a>
                                                            <p class="card-title-desc">18. <a href="{{ url('report_hos_18') }}">จำนวนคนที่เกิด PPH : (O720- O723)</p></a>
                                                            <p class="card-title-desc">19. <a href="{{ url('report_hos_19') }}">จำนวนครั้งที่มารับบริการใน IPD ทั้งหมด (AN)</p></a>
                                                            <p class="card-title-desc">20. <a href="{{ url('report_hos_20') }}">จำนวนผู้ป่วย CT Scan ทั้งหมด</p></a>
                                                            <p class="card-title-desc">21. <a href="{{ url('report_hos_21') }}">จำนวนผู้ป่วย ESRD+EGFRน้อยกว่า6 HD CAPD</p></a>
                                                            <p class="card-title-desc">22. <a href="{{ url('report_hos_22') }}">จำนวนผู้ป่วย ESRD+EGFRน้อยกว่า6</p></a>
                                                            <p class="card-title-desc">23. <a href="{{ url('report_hos_23') }}">จำนวนผู้ป่วย IPD Cardiac arrest</p></a>
                                                            <p class="card-title-desc">24. <a href="{{ url('report_hos_24') }}">จำนวนผู้ป่วย NF IPD ทั้งหมด</p></a>
                                                            <p class="card-title-desc">25. <a href="{{ url('report_hos_25') }}">จำนวนผู้ป่วย NF+DBภายใน24</p></a>
                                                            <p class="card-title-desc">26. <a href="{{ url('report_hos_26') }}">จำนวนผู้ป่วย OPD Cardiac arrest เฉพาะ ER</p></a>
                                                            <p class="card-title-desc">27. จำนวนผู้ป่วย OPD Cardiac arrest ไม่นับ ER</p>
                                                            <p class="card-title-desc">28. <a href="{{ url('report_hos_28') }}">จำนวนผู้ป่วย readmit <28</p></a>
                                                            <p class="card-title-desc">29. <a href="{{ url('report_hos_29') }}">จำนวนผู้ป่วย unplan จาก ward ย้ายไป ICU <6 ชม</p></a>
                                                            <p class="card-title-desc">30. <a href="{{ url('report_hos_30') }}">จำนวนผู้ป่วย upper abdominal with pneumonia</p></a>
                                                            <p class="card-title-desc">31. <a href="{{ url('report_hos_31') }}">จำนวนผู้ป่วย ผ่าตัด upper abdominal</p></a>
                                                            <p class="card-title-desc">32. <a href="{{ url('report_hos_32') }}">จำนวนผู้ป่วยที่มารับบริการใน IPD ทั้งหมด (HN)</p></a>
                                                            <p class="card-title-desc">33. <a href="{{ url('report_hos_33') }}">จำนวนผู้ป่วยที่มีศักยภาพดูแลได้ IPD</p></a>
                                                            <p class="card-title-desc">34. <a href="{{ url('report_hos_34') }}">ประชากรในอำเภอภูเขียว มีค่า BMI > 25</p></a>
                                                            {{-- <thead>
                                                                <tr>
                                                                    <th class="text-center">ลำดับ</th> 
                                                                    <th class="text-center">STMDoc</th> 
                                                                    <th class="text-center">total</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $number = 0;
                                                                $total1 = 0; ?>
                                                                @foreach ($ucs_ti as $item)
                                                                    <?php $number++; ?>
                                
                                                                    <tr height="20">
                                                                        <td class="text-font" style="text-align: center;" width="4%" style="color:rgb(248, 12, 12)">{{ $number }}</td>
                                                                        <td class="text-start" style="color:rgb(34, 90, 243);font-size:15px">  
                                                                            <a href="{{url('upstm_ucs_ti_detail/'.$item->STMDoc)}}" target="_blank"> {{ $item->STMDoc }}</a>  
                                                                        </td>  
                                                                        <td class="text-end" style="color:rgb(10, 151, 85);font-size:15px" width="30%">{{ number_format($item->total, 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                
                                                            </tbody>  --}}
                                                        </table>
                                                    </div>
                                                </div> 
                                            </div> 
                                            {{-- <div class="col-md-8"> 
                                                    <div class="card p-4 card-ucsti">
                                                        <h4 class="card-title" style="color:rgb(10, 151, 85)">STM DETAIL UCS TI :::: >> {{$STMDoc}}</h4>
                                                            <div class="table-responsive"> 
                                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">ลำดับ</th> 
                                                                            <th class="text-center">vn</th> 
                                                                            <th class="text-center">hn</th>
                                                                            <th class="text-center">cid</th> 
                                                                            <th class="text-center">vstdate</th> 
                                                                            <th class="text-center">ptname</th> 
                                                                            <th class="text-center">income</th> 
                                                                            <th class="text-center">debit_total</th>     
                                                                            <th class="text-center">Total_amount</th>   
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $number = 0; $total1 = 0;$total2 = 0;$total3 = 0;$total4 = 0; ?>
                                                                        @foreach ($datashow as $item)
                                                                            <?php $number++; ?>                    
                                                                            <tr height="20">
                                                                                <td class="text-center" width="4%">{{ $number }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->vn }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->hn }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->cid }}</td>
                                                                                <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                                                                <td class="text-start" style="color:rgb(34, 90, 243);font-size:15px"> {{ $item->ptname }}</td>  
                                                                                <td class="text-center" style="color:rgb(233, 83, 14);font-size:15px" width="10%">{{ number_format($item->income, 2) }}</td>
                                                                                <td class="text-center" style="color:rgb(18, 118, 233);font-size:15px" width="10%">{{ number_format($item->debit_total, 2) }}</td>
                                                                                <td class="text-center" style="color:rgb(10, 151, 85);font-size:15px" width="10%">{{ number_format($item->Total_amount, 2) }}</td> 
                                                                            </tr>
                                                                            <?php
                                                                                    $total1 = $total1 + $item->income;
                                                                                    $total2 = $total2 + $item->debit_total;
                                                                                    $total3 = $total3 + $item->Total_amount;  
                                                                            ?> 
                                                                        @endforeach                    
                                                                    </tbody> 
                                                                    <tr style="background-color: #f3fca1">
                                                                        <td colspan="6" class="text-end" style="background-color: #ffdede"></td>
                                                                        <td class="text-center" style="background-color: rgb(233, 83, 14)"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                                                        <td class="text-center" style="background-color: rgb(18, 118, 233)"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                                                        <td class="text-center" style="background-color: rgb(10, 151, 85)"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label> </td>  
                                                                    </tr>  
                                                                </table>
                                                            </div>
                                                    </div>
                                                </div> 
                                            </div> --}}
                                        </div> 
                                    </div>
                                                                        
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                <!-- end card -->
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
