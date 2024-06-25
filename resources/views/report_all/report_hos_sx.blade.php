@extends('layouts.reportall')
@section('title', 'PK-BACKOFFice || Report-ตัวชี้วัดสำคัญใน (SX)')

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
      
                        @if ($id = 91)
                                {{-- <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                    
                                                </table>
                                            </div>
                                        </div> 
                                    </div>
                                </div> --}}
                                
                        @elseif ($id = 92)
                                <form action="{{ url('report_hos_sx/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-6">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (SX)</h5>
                                            <p class="card-title-desc">{{$report_name_show}}</p>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ptname</th>
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
                                                        <?php $i92 = 1; ?>
                                                        @foreach ($datashow as $item92) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i92++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item92->hn }}</td> 
                                                                <td class="text-center" width="3%">{{ $item92->an }}</td> 
                                                                <td class="text-start"  width="3%">{{ $item92->ptname }}</td>  
                                                                <td class="text-center" width="3%">{{ $item92->sexname }}</td>
                                                                <td class="text-center" width="3%">{{ $item92->age_y }}</td> 
                                                                <td class="text-center" width="3%">{{ $item92->pdx }}</td> 
                                                                <td class="text-start"  width="3%">{{ $item92->dx0 }}</td>  
                                                                <td class="text-center" width="3%">{{ $item92->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item92->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item92->dx3 }}</td> 
                                                                <td class="text-center" width="3%">{{ $item92->dx4 }}</td> 
                                                                <td class="text-start"  width="3%">{{ $item92->dx5 }}</td>  
                                                                <td class="text-center" width="3%">{{ $item92->dctype }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        {{-- @elseif ($id == 93)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                
                        @elseif ($id == 94)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-4">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 95)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 96)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 97)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 98)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 99)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 100)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 101)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 102)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                        @elseif ($id == 103)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center">vstdate</th>
                                                            <th class="text-center">vsttime</th>
                                                            <th class="text-center">startscreen</th>
                                                            <th class="text-center">send2doctor</th>
                                                            <th class="text-center">startexam</th>  
                                                            <th class="text-center">finishexam</th> 
                                                            <th class="text-center">card2screen</th>
                                                            <th class="text-center">screen2senddoctor</th>
                                                            <th class="text-center">senddoctor2doctor</th>
                                                            <th class="text-center">doctor2finishdoctor</th>
                                                            <th class="text-center">screen2doctor</th>
                                                            <th class="text-center">card2doctor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item76) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item76->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item76->vstdate}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item76->vsttime }}</td>
                                                                <td class="text-center" width="3%">{{ $item76->startscreen }}</td>
                                                                <td class="text-center" width="3%">{{ $item76->send2doctor}}</td>
                                                                <td class="text-center" width="3%">{{ $item76->startexam}}</td> 
                                                                <td class="text-center" width="3%">{{ $item76->finishexam}}</td> 
                                                                <td class="text-center" width="3%">{{ $item76->card2screen}}</td> 
                                                                <td class="text-center" width="3%">{{ $item76->screen2senddoctor}}</td>
                                                                <td class="text-center" width="3%">{{ $item76->senddoctor2doctor}}</td> 
                                                                <td class="text-center" width="3%">{{ $item76->doctor2finishdoctor}}</td>
                                                                <td class="text-center" width="3%">{{ $item76->screen2doctor}}</td>
                                                                <td class="text-center" width="5%">{{ $item76->card2doctor}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 104)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center">ptname</th>
                                                            <th class="text-center">day_1</th>
                                                            <th class="text-center">time_1</th>
                                                            <th class="text-center">icd10_1</th>
                                                            <th class="text-center">icdname_1</th>  
                                                            <th class="text-center">doctor_name1</th> 
                                                            <th class="text-center">day_2</th>
                                                            <th class="text-center">time_2</th>
                                                            <th class="text-center">icd10_2</th>
                                                            <th class="text-center">icdname_2</th>
                                                            <th class="text-center">doctor_name2</th>
                                                            <th class="text-center">revist_time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item77) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item77->hn}} </td> 
                                                                <td class="text-center" width="2%">{{ $item77->ptname}}</td> 
                                                                <td class="text-center" width="5%">{{ $item77->day_1 }}</td>
                                                                <td class="text-center" width="5%">{{ $item77->time_1 }}</td>
                                                                <td class="text-center" width="5%">{{ $item77->icd10_1}}</td>
                                                                <td class="text-center" width="3%">{{ $item77->icdname_1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item77->doctor_name1}}</td> 
                                                                <td class="text-center" width="3%">{{ $item77->day_2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item77->time_2}}</td>
                                                                <td class="text-center" width="4%">{{ $item77->icd10_2}}</td>
                                                                <td class="text-center" width="3%">{{ $item77->icdname_2}}</td> 
                                                                <td class="text-center" width="3%">{{ $item77->doctor_name2}}</td>
                                                                <td class="text-center" width="4%">{{ $item77->revist_time}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 105)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="5%">pdx</th>  
                                                            <th class="text-center">icdname</th>
                                                            <th class="text-center">pdx_count</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item78) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item78->pdx}} </td> 
                                                                <td class="text-center" width="3%">{{ $item78->icdname}}</td> 
                                                                <td class="text-center" width="5%">{{ $item78->pdx_count }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 106)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="5%">pdx</th>  
                                                            <th class="text-center">icdname</th>
                                                            <th class="text-center">pdx_count</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item79) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item79->pdx}} </td> 
                                                                <td class="text-center" width="3%">{{ $item79->icdname}}</td> 
                                                                <td class="text-center" width="5%">{{ $item79->pdx_count }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 107)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center">vn</th>
                                                            <th class="text-center">vstdate</th>
                                                            <th class="text-center">ptname</th>
                                                            <th class="text-center">pttype</th>
                                                            <th class="text-center">age</th>  
                                                            <th class="text-center">ctname</th> 
                                                            <th class="text-center">fulladdressname</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item80) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item80->hn}} </td> 
                                                                <td class="text-center" width="3%">{{ $item80->vn}}</td> 
                                                                <td class="text-center" width="5%">{{ $item80->vstdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item80->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item80->pttype}}</td>
                                                                <td class="text-center" width="3%">{{ $item80->age}}</td> 
                                                                <td class="text-center" width="3%">{{ $item80->ctname}}</td> 
                                                                <td class="text-center" width="3%">{{ $item80->fulladdressname}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 108)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="5%">regdate</th>  
                                                            <th class="text-center" width="5%">hn</th>
                                                            <th class="text-center" width="5%">ชื่อ - นามสกุล</th>
                                                            <th class="text-center" width="5%">อายุ</th>
                                                            <th class="text-center" width="5%">pttname</th>
                                                            <th class="text-center" width="5%">icd10name</th>                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item81) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item81->regdate}} </td> 
                                                                <td class="text-center" width="3%">{{ $item81->hn}}</td> 
                                                                <td class="text-center" width="5%">{{ $item81->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item81->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item81->pttname}}</td>
                                                                <td class="text-center" width="3%">{{ $item81->icd10name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 109)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="5%">vstdate</th>
                                                            <th class="text-center" width="5%">hn</th> 
                                                            <th class="text-center" width="5%">ptname</th> 
                                                            <th class="text-center" width="5%">age_y</th> 
                                                            <th class="text-center" width="5%">pttname</th> 
                                                            <th class="text-center" width="5%">icd10name</th> 
                                                            <th class="text-center" width="5%">department</th> 
                                                            <th class="text-center" width="5%">income</th>                                    
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item82) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="5%">{{ $item82->vstdate}}</td>
                                                                <td class="text-center" width="5%">{{ $item82->hn}}</td>
                                                                <td class="text-center" width="5%">{{ $item82->ptname}}</td>
                                                                <td class="text-center" width="5%">{{ $item82->age_y}}</td>
                                                                <td class="text-center" width="5%">{{ $item82->pttname}}</td>
                                                                <td class="text-center" width="5%">{{ $item82->icd10name}}</td>
                                                                <td class="text-center" width="5%">{{ $item82->department}}</td>
                                                                <td class="text-center" width="5%">{{ $item82->income}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 110)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="3%">vn</th>
                                                            <th class="text-center" width="5%">vstdate</th> 
                                                            <th class="text-center" width="3%">fullname</th> 
                                                            <th class="text-center" width="5%">age</th> 
                                                            <th class="text-center" width="3%">name</th> 
                                                            <th class="text-center" width="5%">rxtime</th>
                                                            <th class="text-center" width="3%">timeoper</th>  
                                                            <th class="text-center" width="3%">department</th>                                    
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item83) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{ $item83->hn}}</td>
                                                                <td class="text-center" width="3%">{{ $item83->vn}}</td>
                                                                <td class="text-center" width="5%">{{ $item83->vstdate}}</td>
                                                                <td class="text-center" width="3%">{{ $item83->fullname}}</td>
                                                                <td class="text-center" width="5%">{{ $item83->age}}</td>
                                                                <td class="text-center" width="3%">{{ $item83->name}}</td>
                                                                <td class="text-center" width="5%">{{ $item83->rxtime}}</td>
                                                                <td class="text-center" width="3%">{{ $item83->timeoper}}</td> 
                                                                <td class="text-center" width="3%">{{ $item83->department}}</td>                                                
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 111)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="3%">vstdate</th>
                                                            <th class="text-center" width="3%">hn</th>
                                                            <th class="text-center" width="3%">ptname</th> 
                                                            <th class="text-center" width="5%">age_y</th> 
                                                            <th class="text-center" width="3%">pttname</th> 
                                                            <th class="text-center" width="5%">icd10name</th> 
                                                            <th class="text-center" width="5%">nationname</th> 
                                                            <th class="text-center" width="3%">citizen_name</th> 
                                                            <th class="text-center" width="5%">region_name</th>                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item84) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item84->vstdate}}</td>
                                                                <td class="text-center" width="3%">{{$item84->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item84->ptname}}</td>
                                                                <td class="text-center" width="5%">{{$item84->age_y}}</td>
                                                                <td class="text-center" width="3%">{{$item84->pttname}}</td>
                                                                <td class="text-center" width="5%">{{$item84->icd10name}}</td>
                                                                <td class="text-center" width="5%">{{$item84->nationname}}</td>
                                                                <td class="text-center" width="3%">{{$item84->citizen_name}}</td>
                                                                <td class="text-center" width="5%">{{$item84->region_name}}</td>                                      
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 112)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="3%">cid</th>
                                                            <th class="text-center" width="3%">pname</th> 
                                                            <th class="text-center" width="5%">fname</th> 
                                                            <th class="text-center" width="3%">lname</th> 
                                                            <th class="text-center" width="5%">dx</th>
                                                            <th class="text-center" width="5%">บ้านเลขที่</th>
                                                            <th class="text-center" width="3%">หมู่ที่</th>
                                                            <th class="text-center" width="3%">ตำบล</th>
                                                            <th class="text-center" width="3%">อำเภอ</th> 
                                                            <th class="text-center" width="5%">จังหวัด</th> 
                                                            <th class="text-center" width="3%">อายุ</th> 
                                                            <th class="text-center" width="5%">regdate</th>                       
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item85) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item85->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item85->cid}}</td>
                                                                <td class="text-center" width="3%">{{$item85->pname}}</td>
                                                                <td class="text-center" width="5%">{{$item85->fname}}</td>
                                                                <td class="text-center" width="3%">{{$item85->lname}}</td>
                                                                <td class="text-center" width="5%">{{$item85->dx}}</td>
                                                                <td class="text-center" width="5%">{{$item85->add}}</td>
                                                                <td class="text-center" width="3%">{{$item85->moo}}</td>
                                                                <td class="text-center" width="3%">{{$item85->t3}}</td>
                                                                <td class="text-center" width="3%">{{$item85->t2}}</td>
                                                                <td class="text-center" width="5%">{{$item85->t1}}</td>
                                                                <td class="text-center" width="3%">{{$item85->age_y}}</td>
                                                                <td class="text-center" width="5%">{{$item85->regdate>}}</td>                                
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 113)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="3%">cid</th>
                                                            <th class="text-center" width="3%">pname</th> 
                                                            <th class="text-center" width="5%">fname</th> 
                                                            <th class="text-center" width="3%">lname</th> 
                                                            <th class="text-center" width="5%">dx</th>
                                                            <th class="text-center" width="5%">บ้านเลขที่</th>
                                                            <th class="text-center" width="3%">หมู่ที่</th>
                                                            <th class="text-center" width="3%">ตำบล</th>
                                                            <th class="text-center" width="3%">อำเภอ</th> 
                                                            <th class="text-center" width="5%">จังหวัด</th> 
                                                            <th class="text-center" width="3%">อายุ</th> 
                                                            <th class="text-center" width="5%">regdate</th>                       
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item86) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item86->hn}}</td>
                                                                <td class="text-center" width="3%">{{$item86->cid}}</td>
                                                                <td class="text-center" width="3%">{{$item86->pname}}</td>
                                                                <td class="text-center" width="5%">{{$item86->fname}}</td>
                                                                <td class="text-center" width="3%">{{$item86->lname}}</td>
                                                                <td class="text-center" width="5%">{{$item86->dx}}</td>
                                                                <td class="text-center" width="5%">{{$item86->add}}</td>
                                                                <td class="text-center" width="3%">{{$item86->moo}}</td>
                                                                <td class="text-center" width="3%">{{$item86->t3}}</td>
                                                                <td class="text-center" width="3%">{{$item86->t2}}</td>
                                                                <td class="text-center" width="5%">{{$item86->t1}}</td>
                                                                <td class="text-center" width="3%">{{$item86->age_y}}</td>
                                                                <td class="text-center" width="5%">{{$item86->regdate>}}</td>                                
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 114)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="3%">totalHN</th>
                                                            <th class="text-center" width="3%">totalAN</th>                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item87) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item87->totalHN}}</td>
                                                                <td class="text-center" width="3%">{{$item87->totalAN}}</td>                                     
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 115)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="3%">totalHN</th>
                                                            <th class="text-center" width="3%">totalVN</th>                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item88) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item88->totalHN}}</td>
                                                                <td class="text-center" width="3%">{{$item88->totalVN}}</td>                                    
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 116)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th class="text-center" width="3%">pname</th>
                                                            <th class="text-center" width="3%">fname</th>
                                                            <th class="text-center" width="3%">lname</th> 
                                                            <th class="text-center" width="3%">hn</th>                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item89) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="2%">{{ $i++ }}</td>                                                 
                                                                <td class="text-center" width="3%">{{$item89->pname}}</td>
                                                                <td class="text-center" width="3%">{{$item89->fname}}</td>
                                                                <td class="text-center" width="3%">{{$item89->lname}}</td>
                                                                <td class="text-center" width="3%">{{$item89->hn}}</td>                                      
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 117)
                                <form action="{{ url('report_hos_opd/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-6">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (OPD)</h5>
                                            <p class="card-title-desc">{{$report_name->report_hos_name}}</p>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">ptname</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">ครั้ง</th>
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">fulladdressname</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item90) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item90->hn}}</td> 
                                                                <td class="text-center" width="5%">{{ $item90->ptname}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item90->age_y }}</td>  
                                                                <td class="text-center" width="5%">{{ $item90->pdx}}</td>
                                                                <td class="text-center" width="3%">{{ $item90->dx0}}</td> 
                                                                <td class="text-center" width="5%">{{ $item90->dx1}}</td> 
                                                                <td class="text-start"  width="5%">{{ $item90->dx2 }}</td>  
                                                                <td class="text-center" width="5%">{{ $item90->fulladdressname}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div> --}}
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
