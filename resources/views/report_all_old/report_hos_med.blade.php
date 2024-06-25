@extends('layouts.reportall')
@section('title', 'PK-OFFICER || Report-ตัวชี้วัดสำคัญใน (MED)')

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
      
                        @if ($id == 35)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED) </h5>
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
                                </div>
                                
                        @elseif ($id == 36)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-6">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item36) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item36->hn }}</td> 
                                                                <td class="text-center" width="5%">{{ $item36->an }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item36->ptname }}</td>  
                                                                <td class="text-center" width="5%">{{ $item36->age_y }}</td>
                                                                <td class="text-center" width="5%">{{ $item36->pdx }}</td> 
                                                                <td class="text-center" width="5%">{{ $item36->dx0 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item36->dx1 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item36->dx2 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item36->dx3 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item36->dx4 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item36->dx5 }}</td> 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>

                        @elseif ($id == 37)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item37) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item37->hn }}</td> 
                                                                <td class="text-center" width="5%">{{ $item37->an }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item37->ptname }}</td>  
                                                                <td class="text-center" width="5%">{{ $item37->age_y }}</td>
                                                                <td class="text-center" width="5%">{{ $item37->pdx }}</td> 
                                                                <td class="text-center" width="5%">{{ $item37->dx0 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item37->dx1 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item37->dx2 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item37->dx3 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item37->dx4 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item37->dx5 }}</td> 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                                
                        @elseif ($id == 38)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
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
                                                        @foreach ($datashow as $item38) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item38->hn }}</td> 
                                                                <td class="text-center" width="5%">{{ $item38->an }}</td> 
                                                                <td class="text-start"  width="5%">{{ $item38->ptname }}</td>  
                                                                <td class="text-center" width="5%">{{ $item38->age_y }}</td>
                                                                <td class="text-center" width="5%">{{ $item38->pdx }}</td> 
                                                                <td class="text-center" width="5%">{{ $item38->dx0 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item38->dx1 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item38->dx2 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item38->dx3 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item38->dx4 }}</td> 
                                                                <td class="text-center" width="5%">{{ $item38->dx5 }}</td>
                                                                <td class="text-center" width="5%">{{ $item38->name }}</td> 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 39)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                </div>
                        @elseif ($id == 40)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">Total an</th>
                                                            <th class="text-center">Total hn</th>
                                                             
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item40) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item40->an }}</td> 
                                                                <td class="text-center" width="5%">{{ $item40->hn }}</td>                                                                 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 41)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">Total an</th>
                                                            <th class="text-center">Total hn</th>
                                                             
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item41) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="5%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item40->an }}</td> 
                                                                <td class="text-center" width="5%">{{ $item40->hn }}</td>                                                                 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 42)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">ชื่อ - สกุล</th>
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
                                                        @foreach ($datashow as $item42) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item42->hn }}</td> 
                                                                <td class="text-center" width="3%">{{ $item42->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->regdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->dchdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item42->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item42->dx5 }}</td>
                                                                <td class="text-center" width="5%">{{ $item42->name }}</td>                                                                                                                                 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 43)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">ชื่อ - สกุล</th>
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
                                                        @foreach ($datashow as $item43) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item43->hn }}</td> 
                                                                <td class="text-center" width="3%">{{ $item43->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->regdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->dchdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item43->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item43->dx5 }}</td>
                                                                <td class="text-center" width="5%">{{ $item43->name }}</td>                                                                                                                                 
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 44)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">ชื่อ - สกุล</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">icd10</th>
                                                            <th class="text-center">age</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item44) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item44->hn }}</td> 
                                                                <td class="text-center" width="3%">{{ $item44->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item44->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item44->icd10 }}</td>
                                                                <td class="text-center" width="5%">{{ $item44->age }}</td>                                                                                                                               
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 45)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">ชื่อ - สกุล</th>
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
                                                        @foreach ($datashow as $item45) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item45->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->regdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->dchdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item45->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item45->dx5 }}</td>
                                                                <td class="text-center" width="5%">{{ $item45->name }}</td>                                                                                                                               
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 46)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                </div>
                        @elseif ($id == 47)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">ชื่อ - สกุล</th>
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
                                                        @foreach ($datashow as $item47) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item47->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->regdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->dchdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item47->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item47->dx5 }}</td>
                                                                <td class="text-center" width="5%">{{ $item47->name }}</td>                                                                                                                               
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 48)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">ชื่อ - สกุล</th>
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
                                                        @foreach ($datashow as $item48) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item48->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->regdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->dchdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item48->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item48->dx5 }}</td>
                                                                <td class="text-center" width="5%">{{ $item48->name }}</td>                                                                                                                               
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 49)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">ชื่อ - สกุล</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">name</th>
                                                            <th class="text-center">death_date</th>                                                             
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item49) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item49->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->regdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->dchdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item49->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item49->dx5 }}</td>
                                                                <td class="text-center" width="5%">{{ $item49->name }}</td> 
                                                                <td class="text-center" width="5%">{{ $item49->death_date }}</td>                                                                                                                             
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 50)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                </div>
                        @elseif ($id == 51)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">vn</th>
                                                            <th class="text-center">ptname</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">vstdate</th>
                                                            <th class="text-center">vsttime</th>
                                                            <th class="text-center">refer_date</th>
                                                            <th class="text-center">refer_time</th>
                                                            <th class="text-center">ovstost</th>
                                                            <th class="text-center">referhos</th>
                                                            <th class="text-center">timerefer</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item51) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item51->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->vn }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->dx3 }}</td>>
                                                                <td class="text-center" width="5%">{{ $item51->vstdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->vsttime }}</td>                                                                
                                                                <td class="text-center" width="3%">{{ $item51->refer_date }}</td>
                                                                <td class="text-center" width="3%">{{ $item51->refer_time }}</td>
                                                                <td class="text-center" width="5%">{{ $item51->ovstost }}</td> 
                                                                <td class="text-center" width="5%">{{ $item51->referhos }}</td>
                                                                <td class="text-center" width="5%">{{ $item51->timerefer }}</td>                                                                                                                              
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 52)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">vn</th>
                                                            <th class="text-center">vstdate</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">age_y</th>
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>
                                                            <th class="text-center">vsttime</th>
                                                            <th class="text-center">refer_time</th>
                                                            <th class="text-center">refer_date</th>
                                                            <th class="text-center">ovstost</th>
                                                            <th class="text-center">referhos</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item52) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item52->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->vn }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->vstdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->dx3 }}</td>>
                                                                <td class="text-center" width="3%">{{ $item52->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->dx5 }}</td>                                                                
                                                                <td class="text-center" width="3%">{{ $item52->vsttime }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->refer_time }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->refer_date }}</td> 
                                                                <td class="text-center" width="3%">{{ $item52->ovstost }}</td>
                                                                <td class="text-center" width="3%">{{ $item52->referhos }}</td>                                                                                                                              
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 53)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                </div>
                        @elseif ($id == 54)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">จำนวน hn</th>
                                                                                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item54) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item54->totalHN }}</td>                                                                                                                                                                                             
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 55)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">จำนวน hn</th>
                                                                                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item55) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item55->totalHN }}</td>                                                                                                                                                                                             
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 56)
                                {{-- <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                        @elseif ($id == 57)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">เพศ</th>
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
                                                        @foreach ($datashow as $item57) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item57->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->an }}</td>
                                                                <td class="text-center" width="5%">{{ $item57->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->sexname }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->dx5 }}</td>                                                                
                                                                <td class="text-center" width="3%">{{ $item57->name }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->op0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->op1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->op2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->op3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->op4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->op5 }}</td>
                                                                <td class="text-center" width="3%">{{ $item57->op6 }}</td>                                                                
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 58)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th class="text-center">vn</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">เลขบัตรประชาชน</th>
                                                            <th class="text-center">vstdate</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th> 
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>                           
                                                            <th class="text-center">op0</th>
                                                            <th class="text-center">op1</th>
                                                            <th class="text-center">op2</th>
                                                            <th class="text-center">op3</th>
                                                            <th class="text-center">op4</th>
                                                            <th class="text-center">op5</th>
                                                            <th class="text-center">shortname</th>                                                                                                                       
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item58) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item58->vn }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->hn }}</td>
                                                                <td class="text-center" width="5%">{{ $item58->cid }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->vstdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->fullname }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->dx5 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->op0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->op1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->op2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->op3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->op4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->op5 }}</td>
                                                                <td class="text-center" width="3%">{{ $item58->shortname }}</td>                                                            
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 59)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">vn</th>
                                                            <th class="text-center">vstdate</th>
                                                            <th class="text-center">ชื่อ - นามสกุล</th>
                                                            <th class="text-center">อายุ</th>
                                                            <th class="text-center">เพศ</th>                                                                                                                                                                                  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item59) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item59->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item59->vn }}</td>
                                                                <td class="text-center" width="5%">{{ $item59->vstdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item59->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item59->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item59->sexname }}</td>                                                                                                                                
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 60)
                                {{-- <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                        @elseif ($id == 61)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ-นามสกุล</th>
                                                            <th class="text-center">อายุ</th> 
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>                                                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item61) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item61->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->regdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item61->dchdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item61->dx5 }}</td>                                                            
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 62)
                                <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                                            <th width="3%" class="text-center">ลำดับ</th>
                                                            <th class="text-center">hn</th>
                                                            <th class="text-center">regdate</th>
                                                            <th class="text-center">dchdate</th>
                                                            <th class="text-center">an</th>
                                                            <th class="text-center">ชื่อ-นามสกุล</th>
                                                            <th class="text-center">อายุ</th> 
                                                            <th class="text-center">pdx</th>
                                                            <th class="text-center">dx0</th>
                                                            <th class="text-center">dx1</th>
                                                            <th class="text-center">dx2</th>
                                                            <th class="text-center">dx3</th>
                                                            <th class="text-center">dx4</th>
                                                            <th class="text-center">dx5</th>                                                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($datashow as $item62) 
                                                            <tr>                                                  
                                                                <td class="text-center" width="3%">{{ $i++ }}</td> 
                                                                <td class="text-center" width="3%">{{ $item62->hn }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->regdate }}</td>
                                                                <td class="text-center" width="5%">{{ $item62->dchdate }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->an }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->ptname }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->age_y }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->pdx }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->dx0 }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->dx1 }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->dx2 }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->dx3 }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->dx4 }}</td>
                                                                <td class="text-center" width="3%">{{ $item62->dx5 }}</td>                                                            
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                        @elseif ($id == 63)
                                {{-- <form action="{{ url('report_hos_med/'.$id) }}" method="GET">
                                    @csrf 
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <h5 class="card-title" style="color:blueviolet">ตัวชี้วัดสำคัญใน (MED)</h5>
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
                                </div>                                                        --}}
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
