@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Report')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    
</script>
    <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
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
    <?php
    use App\Http\Controllers\karnController;
    use Illuminate\Support\Facades\DB;
    ?>


    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md-4"><h5 class="mb-sm-0">รายละเอียดผู้ป่วย โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</h5></div>
            <div class="col"></div>
            <div class="col-md-2">
                <a href="{{url('prb_repipd_subsuban_print/'.$an)}}" class="btn btn-outline-primary btn-sm" target="_blank"> 
                    <i class="fa-solid fa-print me-3 ms-3 mt-2" style="color: rgb(5, 165, 245)">&nbsp;&nbsp;&nbsp;&nbsp;พิมพ์ </i>
              
                </a>
            </div>
        </div>
        <div class="row">
            {{-- <h5 class="mb-sm-0">รายละเอียดผู้ป่วย โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</h5> --}}
            {{-- <div class="text-end">22 --}}
                {{-- <a href="{{url('prb_repipd_subsuban_print/'.$an)}}" class="btn btn-outline-primary"> 
                    <i class="fa-solid fa-print"  style="color: rgb(5, 165, 245)"></i> 
                </a> --}}
            {{-- </div> --}}
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">เลขบัตร</th>
                                        <th class="text-center">วันที่รักษา</th>
                                        <th class="text-center">วันที่จำหน่าย</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_subsuban as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item->regdate}}</td> 
                                            <td>{{$item->fullname}}</td> 
                                            <td>{{$item->cid}}</td> 
                                            <td>{{$item->regdate }} </td>
                                            <td>{{ $item->dchdate }} </td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">รายการ icd10 ผู้ป่วยใน</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ICD10&ICD9</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">ชื่อไทย</th>
                                        <th class="text-center">diag type</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_icd as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item2->icd10}}</td> 
                                            <td>{{$item2->nameen}}</td> 
                                            <td>{{$item2->tname}}</td> 
                                            <td> {{$item2->diagtype }} </td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">รายการ icd9 ผู้ป่วยใน</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ICD10&ICD9</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">diag type</th>
                                        <th class="text-center">วันที่เข้า</th> 
                                        <th class="text-center">เวลาเข้า</th> 
                                        <th class="text-center">วันที่ออก</th> 
                                        <th class="text-center">เวลาเออก</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_icd9 as $item3)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item3->icd9}}</td> 
                                            <td>{{$item3->name}}</td> 
                                            <td>{{$item3->priority}}</td> 
                                            <td>{{$item3->opdate }} </td> 
                                            <td>{{$item3->optime }} </td> 
                                            <td>{{$item3->enddate }} </td> 
                                            <td>{{$item3->endtime }} </td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">รายการค่าใช้จ่าย</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสหมวด</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_reportpay as $item3)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item3->income}}</td> 
                                            <td>{{$item3->name}}</td> 
                                            <td>{{$item3->qty}}</td> 
                                            <td>{{$item3->paidst }}</td> 
                                            <td>{{$item3->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">รายการค่าใช้จ่ายค่าห้อง</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_room as $item4)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item4->billcode}}</td> 
                                            <td>{{$item4->name}}</td> 
                                            <td>{{$item4->qty}}</td> 
                                            <td>{{$item4->paidst }}</td> 
                                            <td>{{$item4->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าอวัยวะเทียม/อุปกรณ์ในการบำบัดรักษา</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_ti as $item5)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item5->billcode}}</td> 
                                            <td>{{$item5->name}}</td> 
                                            <td>{{$item5->qty}}</td> 
                                            <td>{{$item5->paidst }}</td> 
                                            <td>{{$item5->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่ายาในบัญชียาหลักแห่งชาติ</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_drugnation as $item6)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item6->icode}}</td> 
                                            <td>{{$item6->name}}</td> 
                                            <td>{{$item6->qty}}</td> 
                                            <td>{{$item6->paidst }}</td> 
                                            <td>{{$item6->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่ายานอกบัญชียาหลักแห่งชาติ</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_drugopd as $item7)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item7->icode}}</td> 
                                            <td>{{$item7->name}}</td> 
                                            <td>{{$item7->qty}}</td> 
                                            <td>{{$item7->paidst }}</td> 
                                            <td>{{$item7->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่ายากลับบ้าน</h5>
            <div class="col-xl-12 mt-2">
            
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_drughome as $item8)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item8->nicode}}</td> 
                                            <td>{{$item8->namedrug}}</td> 
                                            <td>{{$item8->qty}}</td> 
                                            <td>{{$item8->paidst }}</td> 
                                            <td>{{$item8->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าเวชภัณฑ์ที่มิใช่ยา</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_nondrug as $item9)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item9->nicode}}</td> 
                                            <td>{{$item9->namedrug}}</td> 
                                            <td>{{$item9->qty}}</td> 
                                            <td>{{$item9->paidst }}</td> 
                                            <td>{{$item9->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าตรวจวินิจฉัยทางเทคนิคการแพทย์และพยาธิวิทยา</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_tecnic as $item10)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item10->nicode}}</td> 
                                            <td>{{$item10->namedrug}}</td> 
                                            <td>{{$item10->qty}}</td> 
                                            <td>{{$item10->paidst }}</td> 
                                            <td>{{$item10->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าตรวจวินิจฉัยและรักษาทางรังสีวิทยา</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_rungsee as $item11)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item11->nicode}}</td> 
                                            <td>{{$item11->namedrug}}</td> 
                                            <td>{{$item11->qty}}</td> 
                                            <td>{{$item11->paidst }}</td> 
                                            <td>{{$item11->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าอุปกรณ์ของใช้และเครื่องมือทางการแพทย์</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_medical as $item12)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item12->nicode}}</td> 
                                            <td>{{$item12->namedrug}}</td> 
                                            <td>{{$item12->qty}}</td> 
                                            <td>{{$item12->paidst }}</td> 
                                            <td>{{$item12->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าทำหัตถการ และวิสัญญี</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_huttakarn as $item13)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item13->nicode}}</td> 
                                            <td>{{$item13->namedrug}}</td> 
                                            <td>{{$item13->qty}}</td> 
                                            <td>{{$item13->paidst }}</td> 
                                            <td>{{$item13->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าบริการทางพยาบาล</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_nurst as $item14)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item14->nicode}}</td> 
                                            <td>{{$item14->namedrug}}</td> 
                                            <td>{{$item14->qty}}</td> 
                                            <td>{{$item14->paidst }}</td> 
                                            <td>{{$item14->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าบริการทางกายภาพบำบัดและเวชกรรมฟื้นฟู</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_bumbad as $item15)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item15->nicode}}</td> 
                                            <td>{{$item15->namedrug}}</td> 
                                            <td>{{$item15->qty}}</td> 
                                            <td>{{$item15->paidst }}</td> 
                                            <td>{{$item15->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่ารถส่งตัว</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_carrefer as $item16)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item16->nicode}}</td> 
                                            <td>{{$item16->namedrug}}</td> 
                                            <td>{{$item16->qty}}</td> 
                                            <td>{{$item16->paidst }}</td> 
                                            <td>{{$item16->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">ค่าอื่นๆที่ไม่เกี่ยวข้องกับการรักษาพยาบาล</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_other as $item17)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item17->nicode}}</td> 
                                            <td>{{$item17->namedrug}}</td> 
                                            <td>{{$item17->qty}}</td> 
                                            <td>{{$item17->paidst }}</td> 
                                            <td>{{$item17->nopaidst }}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5 class="mb-sm-0">รายการ COVID</h5>
            <div class="col-xl-12 mt-2">          
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">เบิกได้</th> 
                                        <th class="text-center">เบิกไม่ได้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($prb_repipd_covid19 as $item18)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$item18->nicode}}</td> 
                                            <td>{{$item18->namedrug}}</td> 
                                            <td>{{$item18->qty}}</td> 
                                            <td>{{$item18->paidst }}</td> 
                                            <td>{{$item18->nopaidst }}</td> 
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





@endsection
@section('footer')
    <script>
       
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
           
        });
    </script>


@endsection
