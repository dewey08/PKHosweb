@extends('layouts.reportall')
@section('title', 'PK-OFFICER || Report-ตัวชี้วัดสำคัญใน รพ')

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
      
                        @if ($id == 1)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
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
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                          
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">refer_date</th>  
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ptname</th>
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
                                                        @foreach ($datashow as $item) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="7%">{{$item->refer_date}} </td> 
                                                                <td class="text-center" width="5%">{{ $item->hn }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->an }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item->ptname }}</td>  
                                                                <td class="text-center" width="5%">{{ $item->sexname }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item->referhos }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->pdx }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->dx0 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->dx1 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->dx2 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->dx3 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->dx4 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->dx5 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->datereg }}</td> 
                                                                <td class="text-center" width="5%">{{ $item->timerefer }}</td>  
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                
                        @elseif ($id == 2)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ ด้วย covid IPD >=15ปี</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">death_date</th>
                                                            <th class="text-center">ptname</th>
                                                            <th class="text-center">sexname</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">death_diag_1</th>  
                                                            <th class="text-center">death_diag_2</th> 
                                                            <th class="text-center">death_diag_3</th>
                                                            <th class="text-center">death_diag_4</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">admdate</th>
                                                            <th class="text-center">wardname</th>
                                                            <th class="text-center">doctorname</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item2) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="7%">{{$item2->hn}} </td> 
                                                                <td class="text-center" width="5%">{{ $item2->death_date }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->ptname }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item2->sexname }}</td>  
                                                                <td class="text-center" width="5%">{{ $item2->age_y }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item2->death_diag_1 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->death_diag_2 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->death_diag_3 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->death_diag_4 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->an }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->regdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->dchdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->admdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->wardname }}</td> 
                                                                <td class="text-center" width="5%">{{ $item2->doctorname }}</td>  
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>

                        @elseif ($id == 3)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ ด้วย IPD unexpected dead</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">death_date</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">เพศ</th>
                                                            <th class="text-center">dx1</th>  
                                                            <th class="text-center">dx2</th> 
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>                                            
                                                            <th class="text-center">แพทย์</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">admdate</th>
                                                            <th class="text-center">firstward</th>
                                                            <th class="text-center">wardname</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item3) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{ $item3->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item3->death_date }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item3->ptname }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item3->sexname }}</td>                                                
                                                                <td class="text-center" width="3%">{{ $item3->death_diag_1 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item3->death_diag_2 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item3->death_diag_3 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item3->death_diag_4 }}</td> 
                                                                <td class="text-start"  width="4%">{{ $item3->name }}</td> 
                                                                <td class="text-center" width="5%">{{ $item3->regdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item3->dchdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item3->admdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item3->firstward }}</td> 
                                                                <td class="text-center" width="5%">{{ $item3->wardname }}</td>  
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                                
                        @elseif ($id == 4)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-4">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ ด้วย soft skin and soft tissue infection</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">death_date</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">เพศ</th>
                                                            <th class="text-center">dx1</th>  
                                                            <th class="text-center">dx2</th> 
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>                                            
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">admdate</th>
                                                            <th class="text-center">wardname</th>
                                                            <th class="text-center">doctorname</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item4) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{$item4->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item4->death_date }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item4->ptname }}</td> 
                                                                <td class="text-center" width="5%">{{ $item4->sexname }}</td>                                                
                                                                <td class="text-center" width="3%">{{ $item4->death_diag_1 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item4->death_diag_2 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item4->death_diag_3 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item4->death_diag_4 }}</td> 
                                                                <td class="text-start"  width="4%">{{ $item4->an }}</td> 
                                                                <td class="text-center" width="5%">{{ $item4->regdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item4->dchdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item4->admdate }}</td> 
                                                                <td class="text-center" width="5%">{{ $item4->wardname }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item4->doctorname }}</td>  
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 5)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ.ER</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">เพศ</th>
                                                            <th class="text-center">age</th>
                                                            <th class="text-center">dx1</th>  
                                                            <th class="text-center">dx2</th> 
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx_other</th>
                                                            <th class="text-center">doctorname</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item5) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item5->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item5->an}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item5->ptname }}</td> 
                                                                <td class="text-center" width="5%">{{ $item5->sexname }}</td>
                                                                <td class="text-center"  width="4%">{{ $item5->age }}</td>                                                
                                                                <td class="text-center" width="3%">{{ $item5->death_diag_1 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item5->death_diag_2 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item5->death_diag_3 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item5->death_diag_4 }}</td>
                                                                <td class="text-center" width="5%">{{ $item5->death_diag_other }}</td>
                                                                <td class="text-start"  width="5%">{{ $item5->doctorname }}</td>  
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 6)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">(Died) จำนวนผู้ป่วยที่เสียชีวิตใน รพ.IPD</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">death_date</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">เพศ</th>
                                                            <th class="text-center">dx1</th>  
                                                            <th class="text-center">dx2</th> 
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">name</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">admdate</th>
                                                            <th class="text-center">wardname</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item6) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{ $item6->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item6->death_date}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item6->ptname }}</td> 
                                                                <td class="text-center" width="5%">{{ $item6->sexname }}</td>
                                                                <td class="text-center" width="3%">{{ $item6->death_diag_1 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item6->death_diag_2 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item6->death_diag_3 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item6->death_diag_4 }}</td>
                                                                <td class="text-start"  width="4%">{{ $item6->name}}</td> 
                                                                <td class="text-center" width="5%">{{ $item6->regdate }}</td>
                                                                <td class="text-start"  width="5%">{{ $item6->dchdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item6->admdate }}</td>
                                                                <td class="text-start"  width="5%">{{ $item6->wardname }}</td>  
                                                            </tr>
                                                        @endforeach
                                                    </tbody>   
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 7)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">	Delivery (O800-O849) AN</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">pdx</th>  
                                                            <th class="text-center">dx0</th> 
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item7) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item7->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item7->an}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item7->ptname }}</td> 
                                                                <td class="text-center" width="3%">{{ $item7->age_y}}</td>
                                                                <td class="text-center" width="3%">{{ $item7->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{ $item7->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item7->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item7->dx2}}</td>
                                                                <td class="text-start"  width="3%">{{ $item7->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item7->dx4}}</td>
                                                                <td class="text-start"  width="3%">{{ $item7->dx5}}</td>
                                                                <td class="text-center" width="5%">{{ $item7->name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 8)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวน DFIU (O364) with GDM (O244) IPD</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">sexname</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">pdx</th>  
                                                            <th class="text-center">dx0</th> 
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">dctype</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item8) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{ $item8->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item8->an}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item8->ptname }}</td>
                                                                <td class="text-center" width="5%">{{ $item8->sexname}}</td>
                                                                <td class="text-center" width="5%">{{ $item8->age_y}}</td>
                                                                <td class="text-center" width="3%">{{ $item8->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{ $item8->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item8->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item8->dx2}}</td>
                                                                <td class="text-start"  width="3%">{{ $item8->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item8->dx4}}</td>
                                                                <td class="text-start"  width="3%">{{ $item8->dx5}}</td>
                                                                <td class="text-center" width="5%">{{ $item8->dctype}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>  
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 9)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวน DFIU (O364) IPD</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">เพศ</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>  
                                                            <th class="text-center">dx0</th> 
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">dctype</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item9) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{ $item9->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item9->an}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item9->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item9->sexname}}</td>
                                                                <td class="text-center" width="3%">{{ $item9->age_y}}</td>
                                                                <td class="text-center" width="3%">{{ $item9->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{ $item9->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item9->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item9->dx2}}</td>
                                                                <td class="text-start"  width="3%">{{ $item9->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item9->dx4}}</td>
                                                                <td class="text-start"  width="3%">{{ $item9->dx5}}</td>
                                                                <td class="text-center" width="5%">{{ $item9->dctype}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>  
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 10)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวน GDM IPD ทั้งหมด : GDM (O244) IPD AN</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>  
                                                            <th class="text-center">dx0</th> 
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item10) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{ $item10->hn}} </td> 
                                                                <td class="text-center" width="3%">{{ $item10->an}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item10->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item10->age_y}}</td>
                                                                <td class="text-center" width="3%">{{ $item10->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{ $item10->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item10->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item10->dx2}}</td>
                                                                <td class="text-start"  width="3%">{{ $item10->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item10->dx4}}</td>
                                                                <td class="text-start"  width="3%">{{ $item10->dx5}}</td>
                                                                <td class="text-center" width="5%">{{ $item10->name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 11)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวน Pneumonia with covid IPD >=15ปี</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>  
                                                            <th class="text-center">dx0</th> 
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item11) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item11->hn}} </td> 
                                                                <td class="text-center" width="3%">{{ $item11->an}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item11->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item11->age_y}}</td>
                                                                <td class="text-center" width="3%">{{ $item11->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{ $item11->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item11->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item11->dx2}}</td>
                                                                <td class="text-start"  width="3%">{{ $item11->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item11->dx4}}</td>
                                                                <td class="text-start"  width="3%">{{ $item11->dx5}}</td>
                                                                <td class="text-center" width="5%">{{ $item11->name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 12)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวน Respiratory failure with covid IPD >=15ปี</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>  
                                                            <th class="text-center">dx0</th> 
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                            <th class="text-center">op0</th> 
                                                            <th class="text-center">op1</th>
                                                            <th class="text-center">op2</th>
                                                            <th class="text-center">op3</th>
                                                            <th class="text-center">op4</th>
                                                            <th class="text-center">op5</th>
                                                            <th class="text-center">op6</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item12) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item12->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item12->an}}</td> 
                                                                <td class="text-start"  width="4%">{{ $item12->ptname }}</td>
                                                                <td class="text-center" width="2%">{{ $item12->age_y}}</td>
                                                                <td class="text-center" width="3%">{{ $item12->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{ $item12->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item12->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item12->dx2}}</td>
                                                                <td class="text-center" width="3%">{{ $item12->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item12->dx4}}</td>
                                                                <td class="text-center" width="3%">{{ $item12->dx5}}</td>
                                                                <td class="text-center" width="4%">{{ $item12->name}}</td>
                                                                <td class="text-center" width="3%">{{ $item12->op0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item12->op1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item12->op2}}</td>
                                                                <td class="text-center" width="3%">{{ $item12->op3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item12->op4}}</td>
                                                                <td class="text-center" width="3%">{{ $item12->op5}}</td>
                                                                <td class="text-center" width="3%">{{ $item12->op6}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 13)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวน Severe Birth asphyxia</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">เพศ</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>  
                                                            <th class="text-center">dx0</th> 
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item13) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item13->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item13->an}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item13->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item13->sexname }}</td>
                                                                <td class="text-center" width="3%">{{ $item13->age_y}}</td>
                                                                <td class="text-center" width="3%">{{ $item13->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{ $item13->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item13->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item13->dx2}}</td>
                                                                <td class="text-center" width="3%">{{ $item13->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{ $item13->dx4}}</td>
                                                                <td class="text-center" width="3%">{{ $item13->dx5}}</td>
                                                                <td class="text-center" width="5%">{{ $item13->dctype}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 14)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนการ readmit ในผู้ป่วย COPD ใน 1 เดือน</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">lastan</th>
                                                            <th class="text-center">lastdate</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">อายุ</th>  
                                                            <th class="text-center">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center">เพศ</th>
                                                            <th class="text-center">lastvisit</th>
                                                            <th class="text-center">admdate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item14) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item14->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item14->an}}</td> 
                                                                <td class="text-center" width="5%">{{ $item14->lastan }}</td>
                                                                <td class="text-center" width="5%">{{ $item14->lastdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item14->regdate}}</td>
                                                                <td class="text-center" width="3%">{{ $item14->age_y}}</td> 
                                                                <td class="text-center"  width="3%">{{ $item14->ptname}}</td> 
                                                                <td class="text-center" width="3%">{{ $item14->sexname}}</td> 
                                                                <td class="text-center" width="3%">{{ $item14->lastvisit}}</td>
                                                                <td class="text-center" width="4%">{{ $item14->admdate}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 15)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนการเกิด Hypovolemic Shock จาก PPH</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>  
                                                            <th class="text-center">dx1</th> 
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item15) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item15->hn}} </td> 
                                                                <td class="text-center" width="3%">{{ $item15->an}}</td> 
                                                                <td class="text-center" width="5%">{{ $item15->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item15->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item15->pdx}}</td>
                                                                <td class="text-center" width="3%">{{ $item15->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item15->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item15->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item15->dx3}}</td>
                                                                <td class="text-center" width="3%">{{ $item15->dx4}}</td>
                                                                <td class="text-center" width="3%">{{ $item15->dx5}}</td>
                                                                <td class="text-center" width="4%">{{ $item15->name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 16)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนการเกิด Respiratory failure ในผู้ป่วย Pneumonia >= 15ปี</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>  
                                                            <th class="text-center">dx1</th> 
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                            <th class="text-center">op0</th>  
                                                            <th class="text-center">op1</th> 
                                                            <th class="text-center">op2</th>
                                                            <th class="text-center">op3</th>
                                                            <th class="text-center">op4</th>
                                                            <th class="text-center">op5</th>
                                                            <th class="text-center">op6</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item16) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item16->hn}} </td> 
                                                                <td class="text-center" width="3%">{{ $item16->an}}</td> 
                                                                <td class="text-center" width="5%">{{ $item16->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item16->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item16->pdx}}</td>
                                                                <td class="text-center" width="3%">{{ $item16->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item16->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item16->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item16->dx3}}</td>
                                                                <td class="text-center" width="3%">{{ $item16->dx4}}</td>
                                                                <td class="text-center" width="3%">{{ $item16->dx5}}</td>
                                                                <td class="text-center" width="4%">{{ $item16->name}}</td>
                                                                <td class="text-center" width="3%">{{ $item16->op0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item16->op1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item16->op2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item16->op3}}</td>
                                                                <td class="text-center" width="3%">{{ $item16->op4}}</td>
                                                                <td class="text-center" width="3%">{{ $item16->op5}}</td>
                                                                <td class="text-center" width="3%">{{ $item16->op6}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 17)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนการเกิด Respiratory failure ในผู้ป่วย Pneumonia ในเด็ก < 15 ปี</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>  
                                                            <th class="text-center">dx1</th> 
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                            <th class="text-center">op0</th>  
                                                            <th class="text-center">op1</th> 
                                                            <th class="text-center">op2</th>
                                                            <th class="text-center">op3</th>
                                                            <th class="text-center">op4</th>
                                                            <th class="text-center">op5</th>
                                                            <th class="text-center">op6</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item17) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item17->hn}} </td> 
                                                                <td class="text-center" width="3%">{{ $item17->an}}</td> 
                                                                <td class="text-center" width="5%">{{ $item17->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item17->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item17->pdx}}</td>
                                                                <td class="text-center" width="3%">{{ $item17->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item17->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item17->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item17->dx3}}</td>
                                                                <td class="text-center" width="3%">{{ $item17->dx4}}</td>
                                                                <td class="text-center" width="3%">{{ $item17->dx5}}</td>
                                                                <td class="text-center" width="4%">{{ $item17->name}}</td>
                                                                <td class="text-center" width="3%">{{ $item17->op0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item17->op1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item17->op2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item17->op3}}</td>
                                                                <td class="text-center" width="3%">{{ $item17->op4}}</td>
                                                                <td class="text-center" width="3%">{{ $item17->op5}}</td>
                                                                <td class="text-center" width="3%">{{ $item17->op6}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 18)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนคนที่เกิด PPH : (O720- O723)</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">hn</th>  
                                                            <th class="text-center" width="5%">an</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>
                                                            <th class="text-center" width="5%">อายุ</th>
                                                            <th class="text-center" width="5%">pdx</th>
                                                            <th class="text-center" width="5%">dx0</th>  
                                                            <th class="text-center" width="5%">dx1</th> 
                                                            <th class="text-center" width="5%">dx2</th>
                                                            <th class="text-center" width="5%">dx3</th>
                                                            <th class="text-center" width="5%">dx4</th>
                                                            <th class="text-center" width="5%">dx5</th>
                                                            <th class="text-center" width="5%">name</th>                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item18) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item18->hn}} </td> 
                                                                <td class="text-center" width="3%">{{ $item18->an}}</td> 
                                                                <td class="text-center" width="5%">{{ $item18->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item18->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item18->pdx}}</td>
                                                                <td class="text-center" width="3%">{{ $item18->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{ $item18->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item18->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item18->dx3}}</td>
                                                                <td class="text-center" width="3%">{{ $item18->dx4}}</td>
                                                                <td class="text-center" width="3%">{{ $item18->dx5}}</td>
                                                                <td class="text-center" width="4%">{{ $item18->name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 19)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนครั้งที่มารับบริการใน IPD ทั้งหมด (AN)</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">จำนวน AN</th>                                   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item19) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{ $item19->totIPDAN}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 20)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย CT Scan ทั้งหมด</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">vstdate</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center" width="3%">อายุ</th> 
                                                            <th class="text-center" width="5%">รายการ CT</th> 
                                                            <th class="text-center" width="3%">ราคารวม</th> 
                                                            <th class="text-center" width="5%">แพทย์</th>
                                                            <th class="text-center" width="3%">icode</th>                                     
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item20) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item20->hn}}</td>
                                                                <td class="text-center" width="3%">{{ $item20->vstdate}}</td>
                                                                <td class="text-center" width="5%">{{ $item20->ptname}}</td>
                                                                <td class="text-center" width="3%">{{ $item20->age}}</td>
                                                                <td class="text-center" width="5%">{{ $item20->ctname}}</td>
                                                                <td class="text-center" width="3%">{{ $item20->sum_price}}</td>
                                                                <td class="text-center" width="5%">{{ $item20->doctor}}</td>
                                                                <td class="text-center" width="3%">{{ $item20->icode}}</td>                                                
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 21)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย ESRD+EGFR น้อยกว่า 6 HD CAPD</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">vn</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">vstdate</th> 
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center" width="3%">อายุ</th> 
                                                            <th class="text-center" width="5%">lab_order_result</th>                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item21) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item->vn}}</td>
                                                                <td class="text-center" width="3%">{{$item->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item->vstdate}}</td>
                                                                <td class="text-center" width="5%">{{$item->ptname}}</td>
                                                                <td class="text-center" width="3%">{{$item->age_y}}</td>
                                                                <td class="text-center" width="5%">{{$item->lab_order_result}}</td>                                      
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 22)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย ESRD+EGFR น้อยกว่า 6</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="2%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">vn</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">vstdate</th> 
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center" width="3%">อายุ</th> 
                                                            <th class="text-center" width="5%">lab_order_result</th>                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item22) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item22->vn}}</td>
                                                                <td class="text-center" width="3%">{{$item22->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item22->vstdate}}</td>
                                                                <td class="text-center" width="5%">{{$item22->ptname}}</td>
                                                                <td class="text-center" width="3%">{{$item22->age_y}}</td>
                                                                <td class="text-center" width="5%">{{$item22->lab_order_result}}</td>                                      
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 23)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย IPD Cardiac arrest</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">an</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">dchdate</th> 
                                                            <th class="text-center" width="3%">อายุ</th> 
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center" width="3%">pdx</th>
                                                            <th class="text-center" width="3%">dx0</th>  
                                                            <th class="text-center" width="3%">dx1</th> 
                                                            <th class="text-center" width="3%">dx2</th>
                                                            <th class="text-center" width="3%">dx3</th>
                                                            <th class="text-center" width="3%">dx4</th>
                                                            <th class="text-center" width="3%">dx5</th>
                                                            <th class="text-center" width="5%">แพทย์</th>
                                                            <th class="text-center" width="5%">wardname</th>                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item23) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item23->an}}</td>
                                                                <td class="text-center" width="3%">{{$item23->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item23->dchdate}}</td>
                                                                <td class="text-center" width="3%">{{$item23->age_y}}</td>
                                                                <td class="text-center" width="5%">{{$item23->fullname}}</td>
                                                                <td class="text-center" width="3%">{{$item23->pdx}}</td>
                                                                <td class="text-center" width="3%">{{$item23->dx0}}</td> 
                                                                <td class="text-center"  width="3%">{{$item23->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{$item23->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{$item23->dx3}}</td>
                                                                <td class="text-center" width="3%">{{$item23->dx4}}</td>
                                                                <td class="text-center" width="3%">{{$item23->dx5}}</td>
                                                                <td class="text-center" width="5%">{{$item23->doctorname}}</td>
                                                                <td class="text-center" width="3%">{{$item23->wardname}}</td>                                     
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 24)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย NF IPD ทั้งหมด</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">an</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center" width="3%">อายุ</th>
                                                            <th class="text-center" width="3%">pdx</th>
                                                            <th class="text-center" width="3%">dx0</th>  
                                                            <th class="text-center" width="3%">dx1</th> 
                                                            <th class="text-center" width="3%">dx2</th>
                                                            <th class="text-center" width="3%">dx3</th>
                                                            <th class="text-center" width="3%">dx4</th>
                                                            <th class="text-center" width="3%">dx5</th>
                                                            <th class="text-center" width="5%">wardname</th>
                                                            <th class="text-center" width="5%">dcdoctor</th>                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item24) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item24->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item24->an}}</td>
                                                                <td class="text-center" width="5%">{{$item24->ptname}}</td>
                                                                <td class="text-center" width="3%">{{$item24->age_y}}</td>
                                                                <td class="text-center" width="3%">{{$item24->pdx}}</td>
                                                                <td class="text-center" width="3%">{{$item24->dx0}}</td> 
                                                                <td class="text-start"  width="3%">{{$item24->dx1}}</td> 
                                                                <td class="text-center" width="3%">{{$item24->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{$item24->dx3}}</td>
                                                                <td class="text-center" width="3%">{{$item24->dx4}}</td>
                                                                <td class="text-center" width="3%">{{$item24->dx5}}</td>
                                                                <td class="text-center" width="4%">{{$item24->wardname}}</td>
                                                                <td class="text-center" width="3%">{{$item24->dcdoctor}}</td>                                     
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 25)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย NF+DB ภายใน 24</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">an</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center" width="3%">code</th>
                                                            <th class="text-center" width="3%">regdate</th>
                                                            <th class="text-center" width="3%">regtime</th>  
                                                            <th class="text-center" width="3%">enter_date</th> 
                                                            <th class="text-center" width="3%">enter_time</th>
                                                            <th class="text-center" width="3%">date</th>                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item25) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item25->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item25->an}}</td>
                                                                <td class="text-center" width="5%">{{$item25->ptname}}</td>
                                                                <td class="text-center" width="3%">{{$item25->code}}</td>
                                                                <td class="text-center" width="3%">{{$item25->regdate}}</td>
                                                                <td class="text-center" width="3%">{{$item25->regtime}}</td> 
                                                                <td class="text-center"  width="3%">{{$item25->enter_date}}</td> 
                                                                <td class="text-center" width="3%">{{$item25->enter_time}}</td> 
                                                                <td class="text-center" width="3%">{{$item25->date}}</td>                                    
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 26)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย OPD Cardiac arrest เฉพาะ ER</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">vn</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">เลขบัตรประชาชน</th> 
                                                            <th class="text-center" width="3%">vstdate</th>
                                                            <th class="text-center" width="3%">อายุ</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>  
                                                            <th class="text-center" width="3%">pdx</th> 
                                                            <th class="text-center" width="3%">dx0</th>
                                                            <th class="text-center" width="3%">dx1</th>
                                                            <th class="text-center" width="3%">dx2</th>
                                                            <th class="text-center" width="3%">dx3</th>
                                                            <th class="text-center" width="3%">dx4</th>
                                                            <th class="text-center" width="3%">dx5</th>
                                                            <th class="text-center" width="5%">แพทย์</th>                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item26) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item26->vn}}</td>
                                                                <td class="text-center" width="3%">{{$item26->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item26->cid}}</td>
                                                                <td class="text-center" width="3%">{{$item26->vstdate}}</td>
                                                                <td class="text-center" width="3%">{{$item26->age_y}}</td>
                                                                <td class="text-center" width="3%">{{$item26->fullname}}</td> 
                                                                <td class="text-center" width="3%">{{$item26->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{$item26->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{$item26->dx1}}</td>
                                                                <td class="text-center" width="3%">{{$item26->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{$item26->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{$item26->dx4}}</td>
                                                                <td class="text-center" width="3%">{{$item26->dx5}}</td>
                                                                <td class="text-center" width="3%">{{$item26->doctorname}}</td>                                      
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 27)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย OPD Cardiac arrest ไม่นับ ER</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">vn</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">เลขบัตรประชาชน</th> 
                                                            <th class="text-center" width="3%">vstdate</th>
                                                            <th class="text-center" width="3%">อายุ</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>  
                                                            <th class="text-center" width="3%">pdx</th> 
                                                            <th class="text-center" width="3%">dx0</th>
                                                            <th class="text-center" width="3%">dx1</th>
                                                            <th class="text-center" width="3%">dx2</th>
                                                            <th class="text-center" width="3%">dx3</th>
                                                            <th class="text-center" width="3%">dx4</th>
                                                            <th class="text-center" width="3%">dx5</th>
                                                            <th class="text-center" width="5%">แพทย์</th>                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item27) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item27->vn}}</td>
                                                                <td class="text-center" width="3%">{{$item27->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item27->cid}}</td>
                                                                <td class="text-center" width="3%">{{$item27->vstdate}}</td>
                                                                <td class="text-center" width="3%">{{$item27->age_y}}</td>
                                                                <td class="text-center" width="5%">{{$item27->fullname}}</td> 
                                                                <td class="text-center" width="3%">{{$item27->pdx}}</td> 
                                                                <td class="text-center" width="3%">{{$item27->dx0}}</td> 
                                                                <td class="text-center" width="3%">{{$item27->dx1}}</td>
                                                                <td class="text-center" width="3%">{{$item27->dx2}}</td> 
                                                                <td class="text-center" width="3%">{{$item27->dx3}}</td> 
                                                                <td class="text-center" width="3%">{{$item27->dx4}}</td>
                                                                <td class="text-center" width="3%">{{$item27->dx5}}</td>
                                                                <td class="text-center" width="5%">{{$item27->doctorname}}</td>                                      
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 28)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย readmit < 28</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">an</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>
                                                            <th class="text-center" width="3%">อายุ</th>
                                                            <th class="text-center" width="5%">lastdate</th>  
                                                            <th class="text-center" width="5%">regdate</th> 
                                                            <th class="text-center" width="5%">lastvisit</th>
                                                            <th class="text-center" width="3%">dchdate</th>
                                                            <th class="text-center" width="3%">admdate</th>
                                                            <th class="text-center" width="5%">wardname</th>                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item28) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item28->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item28->an}}</td>
                                                                <td class="text-center" width="5%">{{$item28->ptname}}</td>
                                                                <td class="text-center" width="3%">{{$item28->age_y}}</td>
                                                                <td class="text-center" width="3%">{{$item28->lastdate}}</td> 
                                                                <td class="text-center" width="3%">{{$item28->regdate}}</td> 
                                                                <td class="text-center" width="3%">{{$item28->lastvisit}}</td> 
                                                                <td class="text-center" width="3%">{{$item28->dchdate}}</td>
                                                                <td class="text-center" width="3%">{{$item28->admdate}}</td> 
                                                                <td class="text-center" width="3%">{{$item28->wardname}}</td>                                     
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 29)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย unplan จาก ward ย้ายไป ICU < 6 ชม</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">an</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">regdate</th>
                                                            <th class="text-center" width="3%">dchdate</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>  
                                                            <th class="text-center" width="5%">อายุ</th> 
                                                            <th class="text-center" width="3%">admdate</th>
                                                            <th class="text-center" width="3%">pdx</th>
                                                            <th class="text-center" width="5%">name</th>
                                                            <th class="text-center" width="3%">doc</th>
                                                            <th class="text-center" width="3%">firstward</th>
                                                            <th class="text-center" width="5%">wardname</th>
                                                            <th class="text-center" width="3%">movetime</th>
                                                            <th class="text-center" width="3%">regtime</th>                          
                                                            <th class="text-center" width="3%">datemove</th>
                                                            <th class="text-center" width="3%">timemove</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item29) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item29->an}}</td>
                                                                <td class="text-center" width="3%">{{$item29->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item29->regdate}}</td>
                                                                <td class="text-center" width="3%">{{$item29->dchdate}}</td>
                                                                <td class="text-center" width="5%">{{$item29->ptname}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->age_y}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->admdate}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->pdx}}</td>
                                                                <td class="text-start"  width="3%">{{$item29->name}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->doc}}</td>
                                                                <td class="text-center" width="3%">{{$item29->firstward}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->wardname}}</td>                                      
                                                                <td class="text-center" width="3%">{{$item29->movetime}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->regtime}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->datemove}}</td> 
                                                                <td class="text-center" width="3%">{{$item29->timemove}}</td> 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 30)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย upper abdominal with pneumonia</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="2%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">an</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>
                                                            <th class="text-center" width="2%">อายุ</th>
                                                            <th class="text-center" width="2%">pdx</th> 
                                                            <th class="text-center" width="2%">dx0</th>
                                                            <th class="text-center" width="2%">dx1</th>
                                                            <th class="text-center" width="2%">dx2</th>
                                                            <th class="text-center" width="2%">dx3</th>
                                                            <th class="text-center" width="2%">dx4</th>
                                                            <th class="text-center" width="2%">dx5</th>
                                                            <th class="text-center" width="4%">name</th>
                                                            <th class="text-center" width="2%">op0</th>  
                                                            <th class="text-center" width="2%">op1</th> 
                                                            <th class="text-center" width="2%">op2</th>
                                                            <th class="text-center" width="2%">op3</th>
                                                            <th class="text-center" width="2%">op4</th>
                                                            <th class="text-center" width="2%">op5</th>
                                                            <th class="text-center" width="2%">op6</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item30) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>
                                                                <td class="text-center" width="3%">{{ $item30->hn}}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item30->an}}</td>
                                                                <td class="text-center" width="5%">{{ $item30->ptname}}</td>
                                                                <td class="text-center" width="2%">{{ $item30->age_y}}</td>
                                                                <td class="text-center" width="2%">{{ $item30->pdx}}</td> 
                                                                <td class="text-center" width="2%">{{ $item30->dx0}}</td> 
                                                                <td class="text-center" width="2%">{{ $item30->dx1}}</td>
                                                                <td class="text-start"  width="2%">{{ $item30->dx2}}</td> 
                                                                <td class="text-center" width="2%">{{ $item30->dx3}}</td> 
                                                                <td class="text-center" width="2%">{{ $item30->dx4}}</td>
                                                                <td class="text-center" width="2%">{{ $item30->dx5}}</td>
                                                                <td class="text-center" width="5%">{{ $item30->name}}</td>
                                                                <td class="text-center" width="2%">{{ $item30->op0}}</td> 
                                                                <td class="text-center" width="2%">{{ $item30->op1}}</td> 
                                                                <td class="text-center" width="2%">{{ $item30->op2}}</td> 
                                                                <td class="text-center" width="2%">{{ $item30->op3}}</td>
                                                                <td class="text-center" width="2%">{{ $item30->op4}}</td>
                                                                <td class="text-center" width="2%">{{ $item30->op5}}</td>
                                                                <td class="text-center" width="2%">{{ $item30->op6}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 31)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วย ผ่าตัด upper abdominal</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">enter_date</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>
                                                            <th class="text-center" width="3%">an</th>
                                                            <th class="text-center" width="3%">เพศ</th> 
                                                            <th class="text-center" width="3%">อายุ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item31) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>
                                                                <td class="text-center" width="3%">{{$item31->hn}}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item31->enter_date}}</td>
                                                                <td class="text-center" width="5%">{{$item31->ptname}}</td>
                                                                <td class="text-center" width="3%">{{$item31->an}}</td>
                                                                <td class="text-center" width="3%">{{$item31->name}}</td> 
                                                                <td class="text-center" width="3%">{{$item31->age_y}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 32)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วยที่มารับบริการใน IPD ทั้งหมด (HN)</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="3%">จำนวน HN</th>                                   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item32) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item32->totIPDHN}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 33)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">จำนวนผู้ป่วยที่มีศักยภาพดูแลได้ IPD</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">total</th>                                   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item33) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{$item33->total}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 34)
                                <form action="{{ url('report_hos_new/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน โรงพยาบาล</h5>
                                            <p class="card-title-desc">ประชากรในอำเภอภูเขียว มีค่า BMI > 25</p>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>                     
                                                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardreport">
                                                    <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                                                    เรียกข้อมูล
                                                </button>    
                                            </div>  
                                        </div> 
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-xl-12"> 
                                        <div class="card cardreport"> 
                                            <div class="table-responsive p-4"> 
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> 
                                                    <thead>
                                                        <tr>                                          
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="text-center" width="5%">total</th>                                   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item34) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{$item34->total}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @else 
                            ("กรุณาเลือกรายงาน")
                        @endif                      

@endsection
@section('footer')
 
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
