@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || AIPN')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function aipn_billitems_destroy(d_abillitems_id) {
            Swal.fire({
                title: 'ต้องการลบข้อมูลใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('aipn_billitems_destroy') }}" + '/' + d_abillitems_id,
                        type: "GET",
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response == 200) {
                                Swal.fire({
                                    title: 'ลบข้อมูลสำเร็จ !!',
                                    text: "Delete Data Success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sidb" + d_abillitems_id).remove();
                                        window.location.reload();
                                        // window.location="{{ url('aipn') }}"; 
                                    }
                                })
                            } else {}
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
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
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
            border-top: 10px #1fdab1 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
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
 
            <div class="row">
                <div class="col"></div>  
                <div class="col-md-2 text-end">เลือกตาม วันที่</div>
                <div class="col-md-7 text-center">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' autocomplete="off" data-provide="datepicker"
                            data-date-autoclose="true" data-date-language="th-th" value="{{ $startdate }}" />
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' autocomplete="off" data-provide="datepicker" 
                            data-date-autoclose="true" data-date-language="th-th" value="{{ $enddate }}" />
                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Searchdata">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            ดึงข้อมูล
                        </button>
                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary" id="Processdata">
                            <i class="fa-solid fa-spinner text-primary me-2"></i>
                            ประมวลผล
                        </button>
                        {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success" id="Exportdata">
                            <i class="fa-solid fa-arrow-up-right-from-square text-success me-2"></i>
                            ส่งออก
                        </button>  --}}
                        <a href="{{ url('aipn_export') }}" class="btn-icon btn-shadow btn-dashed btn btn-outline-success"> <i class="fa-solid fa-arrow-up-right-from-square text-success me-2"></i>ส่งออก</a>
                        <a href="{{ url('aipn_zip') }}" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>
                        
                       
                    </div>
                </div> 
            </div>
 
            <br>
            <br>
            <div class="row">
                <div class="col"></div>
                <div class="col-md-2 text-end">เลือกตาม AN</div>
                <div class="col-md-7 text-center">
                    <div class="input-group" id="datepicker1">
                        <input type="text" class="form-control" name="AN" id="AN" placeholder="AN" required>
                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Searchdata_an">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            ดึงข้อมูล AN
                        </button>
                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary" id="Processdata_an">
                            <i class="fa-solid fa-spinner text-primary me-2"></i>
                            ประมวลผล AN
                        </button>
                        {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success" id="Exportdata_an">
                            <i class="fa-solid fa-arrow-up-right-from-square text-success me-2"></i>
                            ส่งออก AN
                        </button>  --}}
                        <a href="{{ url('aipn_export_an') }}" class="btn-icon btn-shadow btn-dashed btn btn-outline-success"> <i class="fa-solid fa-arrow-up-right-from-square text-success me-2"></i>ส่งออก AN</a>
                        {{-- <a href="{{ url('aipn_zip') }}" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a> --}}
                        {{-- <a href="{{ url('aipn_send_an') }}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a> --}}
                        {{-- <a href="{{ url('aipn_zip') }}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a> --}}  
                    </div>
                </div>
                {{-- <div class="col"></div> --}}
            </div>  
            
 
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h4 class="card-title">รายละเอียดประกันสังคมผู้ป่วยใน AIPN</h4>
                        {{-- <p class="card-title-desc">รายละเอียดประกันสังคมผู้ป่วยใน</p> --}}
                        <div class="btn-actions-pane-right">
                            {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger PulldataAll" >
                                <i class="fa-solid fa-arrows-rotate text-danger me-2"></i>
                                Sync Data All 
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body"> 

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            {{-- <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#BillItems" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">BillItems</span>    
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#AIPN" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">AIPN</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPADT" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">IPADT</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPDx" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IPDx</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPOp" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IPOp</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#BillItems" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">BillItems</span>
                                </a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">

                            <div class="tab-pane active" id="AIPN" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="selection-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>   
                                                    <th class="text-center">vn</th>
                                                    <th class="text-center">an</th>
                                                    <th class="text-center">hn</th>
                                                    <th class="text-center">cid</th>
                                                    <th class="text-center">dchdate</th>
                                                    <th class="text-center">ptname</th>
                                                    <th class="text-center">debit</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($d_aipn_main as $ite) 
                                                    <tr id="sidb{{$ite->d_aipn_main_id }}">   
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                        <td class="text-center" width="8%">{{ $ite->vn }} </td>
                                                        <td class="text-center" width="8%">{{ $ite->an }}</td>
                                                        <td class="text-center" width="5%">{{ $ite->hn }} </td>
                                                        <td class="text-center" width="5%">{{ $ite->cid }} </td>
                                                        <td class="text-center" width="8%">{{ $ite->dchdate }} </td>  
                                                        <td class="text-start">{{ $ite->ptname }} </td>   
                                                        <td class="text-center" width="8%">{{ number_format($ite->debit, 2) }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="IPADT" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center" width="5%">AN</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">IDTYPE</th>
                                                <th class="text-center">PIDPAT</th>
                                                <th class="text-center">TITLE</th>
                                                <th class="text-center">NAMEPAT</th>
                                                <th class="text-center">DOB</th>
                                                <th class="text-center" width="7%">SEX</th>
                                                <th class="text-center">MARRIAGE</th>
                                                <th class="text-center">CHANGWAT</th>
                                                <th class="text-center" width="8%">AMPHUR</th>
                                                <th class="text-center" width="8%">NATION</th>
                                                <th class="text-center" width="10%">AdmType</th>
                                                <th class="text-center">AdmSource</th>
                                                <th class="text-center">DTAdm_d</th>
                                                <th class="text-center">DTDisch_d</th>
                                                <th class="text-center">LeaveDay</th>

                                                <th class="text-center">DischStat</th>
                                                <th class="text-center">DishType</th>
                                                <th class="text-center">AdmWt</th>
                                                <th class="text-center">DishWard</th>
                                                <th class="text-center">Dept</th>
                                                <th class="text-center">HMAIN</th>
                                                <th class="text-center">ServiceType</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($d_aipadt as $item)
                                                <tr style="font-size: 12px;">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center" width="5%">{{ $item->AN }}</td>
                                                    <td class="text-center">{{ $item->HN }}</td>
                                                    <td class="text-center">{{ $item->IDTYPE }}</td>
                                                    <td class="text-center">{{ $item->PIDPAT }}</td>
                                                    <td class="text-center">{{ $item->TITLE }}</td>
                                                    <td class="text-center">{{ $item->NAMEPAT }}</td>
                                                    <td class="text-center">{{ $item->DOB }}</td>
                                                    <td class="text-center">{{ $item->SEX }}</td>
                                                    <td class="text-center">{{ $item->MARRIAGE }}</td>
                                                    <td class="text-start">{{ $item->CHANGWAT }}</td>
                                                    {{-- <td class="text-center">{{ number_format($item->Amount, 2) }}</td>  --}}
                                                    <td class="text-center">{{ $item->AMPHUR }}</td>
                                                    <td class="text-center">{{ $item->NATION }}</td>
                                                    <td class="text-center">{{ $item->AdmType }}</td>
                                                    <td class="text-center">{{ $item->AdmSource }}</td>
                                                    <td class="text-center">{{ $item->DTAdm_d }}</td>
                                                    <td class="text-center">{{ $item->DTDisch_d }}</td>
                                                    <td class="text-center">{{ $item->LeaveDay }}</td>

                                                    <td class="text-center">{{ $item->DischStat }}</td>
                                                    <td class="text-center">{{ $item->DishType }}</td>
                                                    <td class="text-center">{{ $item->AdmWt }}</td>
                                                    <td class="text-center">{{ $item->DishWard }}</td>
                                                    <td class="text-center">{{ $item->Dept }}</td>
                                                    <td class="text-center">{{ $item->HMAIN }}</td>
                                                    <td class="text-center">{{ $item->ServiceType }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="IPDx" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="key-datatable"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">an</th>
                                                <th class="text-center">sequence</th>
                                                <th class="text-center">DxType</th>
                                                <th class="text-center">CodeSys</th>
                                                <th class="text-center">Dcode</th>
                                                <th class="text-center">DiagTerm</th>
                                                <th class="text-center">DR</th>
                                                <th class="text-center">datediag</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($d_aipdx as $item3)
                                                <tr style="font-size: 12px;">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item3->an }} </td>
                                                    <td class="text-center">{{ $item3->sequence }}</td>
                                                    <td class="text-center">{{ $item3->DxType }} </td>
                                                    <td class="text-center">{{ $item3->CodeSys }} </td>
                                                    <td class="text-center">{{ $item3->Dcode }} </td>
                                                    <td class="text-start">{{ $item3->DiagTerm }}</td>
                                                    <td class="text-center">{{ $item3->DR }}</td>
                                                    <td class="text-center">{{ $item3->datediag }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="IPOp" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">an</th>
                                                <th class="text-center">sequence</th>
                                                <th class="text-center">CodeSys</th>
                                                <th class="text-center">Code</th>
                                                <th class="text-center">Procterm</th>
                                                <th class="text-center">DR</th>
                                                <th class="text-center">DateIn</th>
                                                <th class="text-center">DateOut</th>
                                                <th class="text-center">Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($d_aipop as $item4)
                                                <tr style="font-size: 12px;">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item4->an }}</td>
                                                    <td class="text-center">{{ $item4->sequence }} </td>
                                                    <td class="text-center">{{ $item4->CodeSys }} </td>
                                                    <td class="text-center">{{ $item4->Code }} </td>
                                                    <td class="text-start">{{ $item4->Procterm }}</td>
                                                    <td class="text-start">{{ $item4->DR }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-warning addicodeModal" value="{{ $item4->d_aipop_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="แก้ไข DateIn  DateOut">
                                                            <i class="fa-regular fa-pen-to-square me-2"></i>
                                                            {{ $item4->DateIn }}
                                                        </button> 
                                                    </td>
                                                    <td class="text-start" width="15%">

                                                        {{ $item4->DateOut }}
                                                    </td>
                                                    <td class="text-center">{{ $item4->Location }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="BillItems" role="tabpanel">

                            </div>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">

            <div class="col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <h4 class="card-title">รายละเอียด BillItems ผู้ป่วยใน</h4> 
                        <div class="btn-actions-pane-right"> 
                        </div>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="ex_1" class="table table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">AN</th>
                                                {{-- <th class="text-center">sequence</th> --}}
                                                {{-- <th class="text-center">ServDate</th> --}}
                                                {{-- <th class="text-center">ServTime</th> --}}
                                                <th class="text-center">BillGr</th>
                                                <th class="text-center">BillGrCS</th>
                                                <th class="text-center">CodeSys</th>
                                                <th class="text-center">CSCode</th>
                                                <th class="text-center">STDCode</th>
                                                <th class="text-center">ClaimCat</th>
                                                <th class="text-center">LCCode</th>
                                                <th class="text-center">Descript</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">UnitPrice</th>
                                                <th class="text-center">ChargeAmt</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($d_abillitems as $item2)
                                                <tr id="sidb{{ $item2->d_abillitems_id }}" style="font-size: 12px;">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item2->AN }} </td>
                                                    {{-- <td class="text-center">{{ $item2->sequence }}</td> --}}
                                                    {{-- <td class="text-center">{{ $item2->ServDate }} </td> --}}
                                                    {{-- <td class="text-center">{{ $item2->ServTime }} </td> --}}
                                                    <td class="text-center" width="5%">{{ $item2->BillGr }} </td>
                                                    <td class="text-center" width="5%">{{ $item2->BillGrCS }}</td>
                                                    @if ($item2->CodeSys == 'TMT' && $item2->STDCode == '')
                                                        <td class="text-center" style="background-color: rgb(241, 6, 45)"
                                                            width="5%">{{ $item2->CodeSys }} </td>
                                                    @elseif ($item2->CodeSys == 'TMLT' && $item2->STDCode == '')
                                                        <td class="text-center" style="background-color: rgb(252, 2, 44)"
                                                            width="5%">{{ $item2->CodeSys }} </td>
                                                    @else
                                                        <td class="text-center" width="5%">{{ $item2->CodeSys }} </td>
                                                    @endif
                                                    <td class="text-center" width="5%">{{ $item2->CSCode }}</td>
                                                    <td class="text-center" width="5%">{{ $item2->STDCode }} </td>
                                                    <td class="text-center" width="5%">{{ $item2->ClaimCat }} </td>
                                                    <td class="text-center" width="10%"> 
                                                        <a href="{{ url('aipn_billitems_destroy/' . $item2->d_abillitems_id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="ลบ" class="btn btn-outline-danger btn-sm">
                                                            <i class="fa-solid fa-trash-can text-danger me-2"></i>
                                                            {{ $item2->LCCode }}
                                                        </a>
                                                    </td>
                                                    <td class="text-start">{{ $item2->Descript }}</td>
                                                    <td class="text-center" width="5%">{{ $item2->QTY }}</td>
                                                    <td class="text-center" width="5%">
                                                        {{ number_format($item2->UnitPrice, 2) }}</td>
                                                    <td class="text-center" width="5%">
                                                        {{ number_format($item2->ChargeAmt, 2) }}</td> 
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

    </div>

    <!-- addicodeModal Modal -->
    <div class="modal fade" id="addicodeModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">รายการขอปรับเปลี่ยนวันที่ DateIn DateOut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">                            
                            <div class="col-md-12">
                                <label for="an" class="form-label">an</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="an_edit" name="an" readonly>  
                                </div>
                            </div> 
                        </div> 
                        <div class="row mt-2"> 
                            <div class="col-md-6">
                                <label for="DateOut" class="form-label">DateIn</label>
                            </div>
                            <div class="col-md-6">
                                <label for="DateOut" class="form-label">DateOut</label>
                            </div>
                        </div> 
                        <div class="row mt-2"> 
                            <div class="col-md-12"> 
                                <div class="input-daterange input-group" id="datepicker9" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="datein_edit" id="datein_edit" placeholder="DateIn" data-date-container='#datepicker9' autocomplete="off" data-provide="datepicker"
                                        data-date-autoclose="true" data-date-language="th-th"/>
                                    <input type="text" class="form-control" name="dateout_edit" placeholder="DateOut" id="dateout_edit" data-date-container='#datepicker9' autocomplete="off" data-provide="datepicker" 
                                        data-date-autoclose="true" data-date-language="th-th" />




                                {{-- <label for="DateIn" class="form-label">DateIn</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="date" class="form-control" id="datein_edit" name="DateIn" >  
                                </div> --}}
                            </div> 
                            </div> 
                            {{-- <div class="col-md-6">
                                <label for="TimeIn" class="form-label">TimeIn</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="time" class="form-control" id="timein_edit" name="TimeIn" >  
                                </div>
                            </div>  --}}
                        </div>
                        <div class="row mt-2"> 
                            {{-- <div class="col-md-6">
                                <label for="DateOut" class="form-label">DateOut</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="date" class="form-control" id="dateout_edit" name="DateOut" >  
                                </div>
                            </div>  --}}
                            <div class="col-md-6">
                                <label for="TimeIn" class="form-label">TimeIn</label>
                                <div class="input-group input-group-sm"> 
                                    {{-- <input type="time" class="form-control" id="timein_edit" name="TimeIn" >   --}}
                                    <input class="form-control" data-provide="timepicker" data-minute-step="1" type="text" id="timein_edit" name="TimeIn" >
                                </div>
                            </div>
                            {{-- <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group timepicker">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                    </div>
                                    <input class="form-control" id="timeout_edit" placeholder="Select time" type="text"/>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <label for="TimeOut" class="form-label">TimeOut</label>
                                {{-- <div class="input-group input-group-sm">  --}}
                                    {{-- <input class="form-control" data-provide="timepicker" data-minute-step="1" type="text" id="timeout_edit" name="TimeOut" >  --}}
                                    <input class="form-control" data-provide="timepicker" data-minute-step="1" type="text" id="timeout_edit" name="TimeOut" > 
                                    {{-- <input type="text" class="form-control" name="TimeOut" id="TimeOut" placeholder="Start Date" data-date-container='#TimeOut' autocomplete="off" data-provide="TimeOut" data-date-autoclose="true" data-date-language="th-th" />  --}}
                                    {{-- data-format="dd/MM/yyyy hh:mm:ss" --}}
                                    {{-- <div id="datetimepicker3" class="input-append">
                                        <input data-format="hh:mm:ss" type="text"></input>
                                        <span class="add-on">
                                          <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                          </i>
                                        </span>
                                      </div> --}}
                                      {{-- data-time-format="Hms" --}}
                                {{-- </div> --}}
                                
                            </div> 
                        </div>     
                    <input type="hidden" name="d_aipop_id" id="d_aipop_id_edit"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatedata_time">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                    </button>
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
                // format: 'DD-MM-YYYY HH:mm:ss'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            // $(function() {
            //     $('#datetimepicker3').datepicker({
            //     pickDate: false
            //     });
            // });
            // $('#TimeOut').datepicker({
            //     // format: 'yyyy-mm-dd'
            //     format: 'hh:mm:ss'
            // });
           
            $('#datein_edit').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#dateout_edit').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#timein_edit, #addicodeModal').timepicker({ 
                format: 'hh:mm:ss',
                minuteStep: 1, 
                showSeconds: true,
                showMeridian: false,
                snapToStep: true
            });

            $('#timeout_edit, #addicodeModal').timepicker({ 
                format: 'hh:mm:ss',
                minuteStep: 1, 
                showSeconds: true,
                showMeridian: false,
                snapToStep: true
            });
            // $('#TimeIn').datepicker({
            // //     format: 'hh:mm:ss'
            // timeFormat: 'hh:mm:ss'
            // });
            // $('#TimeOut').datepicker({
            //     format: 'hh:mm:ss'
            // });

            $('#ex_1').DataTable();
            $('#ex_2').DataTable();
            $('#ex_3').DataTable();

            $("#spinner-div").hide(); //Request is complete so hide spinner
           
            $('#Searchdata').click(function() {
                    var datepicker = $('#datepicker').val(); 
                    var datepicker2 = $('#datepicker2').val(); 
                    Swal.fire({
                            title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                            text: "You Warn Pull Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_main') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datepicker,
                                            datepicker2                        
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'ดึงข้อมูลสำเร็จ',
                                                    text: "You Pull data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });
            $('#Exportdata').click(function() {
                    var datepicker = $('#datepicker').val(); 
                    var datepicker2 = $('#datepicker2').val(); 
                    Swal.fire({
                            title: 'ต้องการส่งออกข้อมูลใช่ไหม ?',
                            text: "You Warn Export Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_export') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datepicker,
                                            datepicker2                        
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'ส่งออกข้อมูลสำเร็จ',
                                                    text: "You Export data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });

            $('#Processdata').click(function() {
                    var datepicker = $('#datepicker').val(); 
                    var datepicker2 = $('#datepicker2').val(); 
                    Swal.fire({
                            title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                            text: "You Warn Process Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_process') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datepicker,
                                            datepicker2                        
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'ประมวลผลข้อมูลสำเร็จ',
                                                    text: "You Process data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });

            $('#Zipdata').click(function() {
                    var datepicker = $('#datepicker').val(); 
                    var datepicker2 = $('#datepicker2').val(); 
                    Swal.fire({
                            title: 'ต้องการสร้างไฟล์ Zip ใช่ไหม ?',
                            text: "You Warn Create Zip File!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_zip') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datepicker,
                                            datepicker2                        
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'สร้างไฟล์ Zip สำเร็จ',
                                                    text: "You Create Zip File success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });

            // *************** AN *******************
            $('#Searchdata_an').click(function() {
                    var AN = $('#AN').val();  
                    Swal.fire({
                            title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                            text: "You Warn Pull Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_main_an') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            AN                        
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'ดึงข้อมูลสำเร็จ',
                                                    text: "You Pull data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });
            $('#Processdata_an').click(function() {
                    var datepicker = $('#datepicker').val(); 
                    var datepicker2 = $('#datepicker2').val(); 
                    Swal.fire({
                            title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                            text: "You Warn Process Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_process_an') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datepicker,
                                            datepicker2                        
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'ประมวลผลข้อมูลสำเร็จ',
                                                    text: "You Process data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });

            $('#Exportdata_an').click(function() {
                    var datepicker = $('#datepicker').val(); 
                    var datepicker2 = $('#datepicker2').val(); 
                    Swal.fire({
                            title: 'ต้องการส่งออกข้อมูลใช่ไหม ?',
                            text: "You Warn Export Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_export_an') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datepicker,
                                            datepicker2                        
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'ส่งออกข้อมูลสำเร็จ',
                                                    text: "You Export data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });

            $(document).on('click', '.addicodeModal', function() {
                var d_aipop_id = $(this).val(); 
                $('#addicodeModal').modal('show');
                // alert(d_aipop_id);
                $.ajax({
                    type: "GET",
                    url: "{{ url('aipn_ipop_edit') }}" + '/' + d_aipop_id,
                    success: function(data) {
                        console.log(data.data_ipop.d_aipop_id);  
                        $('#an_edit').val(data.data_ipop.an) 
                        $('#datein_edit').val(data.data_ipop.Date_In)
                        $('#timein_edit').val(data.data_ipop.Time_In)
                        $('#dateout_edit').val(data.data_ipop.Date_Out)
                        $('#timeout_edit').val(data.data_ipop.Time_Out)
                        $('#d_aipop_id_edit').val(data.data_ipop.d_aipop_id)
                   
                    },
                });
            });
            $('#Updatedata_time').click(function() {
                    var DateIn = $('#datein_edit').val(); 
                    var TimeIn = $('#timein_edit').val(); 
                    var DateOut = $('#dateout_edit').val(); 
                    var TimeOut = $('#timeout_edit').val(); 
                    var d_aipop_id_edit = $('#d_aipop_id_edit').val();
                    Swal.fire({
                            title: 'ต้องการแก้ไขข้อมูลใช่ไหม ?',
                            text: "You Edit Data!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, pull it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 
                                    
                                    $.ajax({
                                        url: "{{ route('claim.aipn_ipop_update') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            DateIn, TimeIn ,DateOut,TimeOut ,d_aipop_id_edit                      
                                        },
                                        success: function(data) {
                                            if (data.status == 200) { 
                                                Swal.fire({
                                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                                    text: "You Edit data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner').hide();//Request is complete so hide spinner
                                                            setTimeout(function(){
                                                                $("#overlay").fadeOut(300);
                                                            },500);
                                                    }
                                                })
                                            } else {
                                                
                                            }
                                        },
                                    });
                                    
                                }
                    })
            });



        });
    </script>
@endsection
