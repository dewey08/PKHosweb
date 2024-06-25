@extends('layouts.timesystem')
@section('title', 'PK-OFFICER || DASHBOARD')


@section('content')

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
            border-top: 10px rgb(11, 170, 165) solid;
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
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $iddep = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 543;
    $mo = date('m');
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        <div class="row">

            @foreach ($dep_show_all as $item)
                <?php
                    $depsub_count_ = DB::connection('mysql6')->select(' 
                            SELECT COUNT(DISTINCT p.ID) as CountID
                                FROM checkin_index c
                                LEFT JOIN checkin_type ct on ct.CHECKIN_TYPE_ID=c.CHECKIN_TYPE_ID
                                LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID
                                LEFT JOIN hrd_department h on h.HR_DEPARTMENT_ID = p.HR_DEPARTMENT_ID
                                LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                                LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                                
                                LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                                LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                                LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                                LEFT JOIN hrd_position hp on hp.HR_POSITION_ID=p.HR_POSITION_ID
                                WHERE c.CHEACKIN_DATE = CURDATE()
                                AND hs.HR_DEPARTMENT_SUB_ID = "' .$item->HR_DEPARTMENT_SUB_ID .'"
                                        
                    ',);
                    foreach ($depsub_count_ as $key => $value) {
                        $depsub_count = $value->CountID;
                    }
                     $perdep_ = DB::connection('mysql6')->select('
                        SELECT COUNT(DISTINCT ID) as ccd
                        FROM hrd_person WHERE HR_STATUS_ID ="1" AND HR_DEPARTMENT_SUB_ID = "' . $item->HR_DEPARTMENT_SUB_ID . '"           
                    ');
                    foreach ($perdep_ as $key => $value2) {
                        $perdep = $value2->ccd;
                    }
                ?>

                <div class="col-xl-4 col-md-3">
                    <div class="main-card mb-3 card" style="height: 150px">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-start mb-2" style="font-size: 17px">
                                                    {{ $item->HR_DEPARTMENT_SUB_NAME }}</p>
                                                <h3 class="text-start mb-2 text-primary">{{ $depsub_count }} / {{$perdep}} คน</h3>
                                            </div>
                                            <div class="avatar-sm me-2" style="height: 120px">
                                                <a href="{{ url('time_dashboard_detail_sub/' . $item->HR_DEPARTMENT_SUB_ID) }}"
                                                    target="_blank">
                                                    <span class="avatar-title bg-light rounded-3 mt-3" style="height: 70px">
                                                        <p style="font-size: 10px;">
                                                            <button type="button" style="height: 100px;width: 100px"
                                                                class="mt-4 me-4 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                                <i class="fa-solid fa-people-group font-size-24"></i><br>
                                                                Detail
                                                            </button>
                                                        </p>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card cardot2">
                    <div class="card-header">
                        ลงเวลาเข้า-ออก => {{ $dep }}
                        <div class="btn-actions-pane-right">
                            <a href="{{ url('time_dashboard_detail_excel/'.$id) }}"
                                class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                <i class="fa-solid fa-file-excel me-2"></i>
                                Export To Excel
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover"
                                id="example">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>วันที่</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>หน่วยงาน</th> 
                                        <th>เวลาเข้า</th>
                                        <th>เวลาออก</th>
                                        <th>ประเภท</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow_ as $item)
                                        <tr>
                                            <td>{{ $ia++ }}</td>
                                            <td>{{ Datethai($item->CHEACKIN_DATE )}}</td> 
                                            <td>{{ $item->hrname }}</td>
                                            <td>{{ $item->HR_DEPARTMENT_SUB_SUB_NAME }}</td>  
                                            <td>{{ $item->CHEACKINTIME }}</td>
                                            <td>{{ $item->CHEACKOUTTIME }}</td>
                                            <td>{{ $item->OPERATE_TYPE_NAME }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>
@endsection
