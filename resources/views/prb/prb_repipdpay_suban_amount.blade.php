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

        <div class="row">
            <div class="col-xl-12">
                
                    <div class="row">
                        <div class="col">
                            <h5 class="mb-sm-0">รายละเอียดผู้ป่วย </h5>
                        </div>
                        <div class="col-md-1 text-end"> </div>
                        <div class="col-md-2 text-center">                            
                        </div>
                        <div class="col-md-1 text-center"> </div>
                        <div class="col-md-2 text-center">                             
                        </div>
                        <div class="col-md-2">                     
                        </div>
                        <div class="col"></div>
                
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive"> 
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">AN</th>
                                    <th class="text-center">เลขบัตรประชาชน</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">วันที่รับบริการ</th>
                                    <th class="text-center">วันที่จำหน่าย</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_detail as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item->hn}}</td> 
                                        <td>{{$item->an}}</td> 
                                        <td>{{$item->cid}}</td> 
                                        <td>{{$item->fullname}}</td> 
                                        <td> {{ $item->regdate }} </td> 
                                        <td>{{ $item->dchdate }}</td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">รายการ icd10 ผู้ป่วยใน </h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_icd as $item2)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item2->icd10}}</td> 
                                        <td>{{$item2->name}}</td> 
                                        <td>{{$item2->tname}}</td> 
                                        <td class="text-center">{{$item2->diagtype}}</td>  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">รายการ icd9 ผู้ป่วยใน </h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                    <th class="text-center">เวลาออก</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_detail_icd9 as $item3)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item3->icd9}}</td> 
                                        <td>{{$item3->name}}</td> 
                                        <td>{{$item3->priority}}</td> 
                                        <td class="text-center">{{$item3->opdate}}</td>  
                                        <td class="text-center">{{$item3->optime}}</td>  
                                        <td class="text-center">{{$item3->enddate}}</td>  
                                        <td class="text-center">{{$item3->endtime}}</td>  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">รายการค่าใช้จ่าย</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_paid as $item4)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item4->income}}</td> 
                                        <td>{{$item4->name}}</td> 
                                        <td>{{$item4->sqty}}</td> 
                                        <td class="text-center">{{$item4->reppay}}</td>  
                                        <td class="text-center">{{$item4->reppayno}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">รายการค่าใช้จ่ายค่าห้อง</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_room as $item5)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item5->billcode}}</td> 
                                        <td>{{$item5->name}}</td> 
                                        <td>{{$item5->sqty}}</td> 
                                        <td class="text-center">{{$item5->sum_price}}</td>  
                                        <td class="text-center">{{$item5->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าอวัยวะเทียม/อุปกรณ์ในการบำบัดรักษา</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_tium as $item6)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item6->billcode}}</td> 
                                        <td>{{$item6->name}}</td> 
                                        <td>{{$item6->sqty}}</td> 
                                        <td class="text-center">{{$item6->sum_price}}</td>  
                                        <td class="text-center">{{$item6->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่ายาในบัญชียาหลักแห่งชาติ</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_drug as $item7)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item7->income}}</td> 
                                        <td>{{$item7->name}}</td> 
                                        <td>{{$item7->sqty}}</td> 
                                        <td class="text-center">{{$item7->sum_price}}</td>  
                                        <td class="text-center">{{$item7->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่ายากลับบ้าน</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_drughome as $item8)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item8->income}}</td> 
                                        <td>{{$item8->name}}</td> 
                                        <td>{{$item8->sqty}}</td> 
                                        <td class="text-center">{{$item8->sum_price}}</td>  
                                        <td class="text-center">{{$item8->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าเวชภัณฑ์ที่มิใช่ยา</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_nondrug as $item9)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item9->income}}</td> 
                                        <td>{{$item9->name}}</td> 
                                        <td>{{$item9->sqty}}</td> 
                                        <td class="text-center">{{$item9->sum_price}}</td>  
                                        <td class="text-center">{{$item9->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าตรวจวินิจฉัยทางเทคนิคการแพทย์และพยาธิวิทยา</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_lab as $item10)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item10->income}}</td> 
                                        <td>{{$item10->name}}</td> 
                                        <td>{{$item10->sqty}}</td> 
                                        <td class="text-center">{{$item10->sum_price}}</td>  
                                        <td class="text-center">{{$item10->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าตรวจวินิจฉัยและรักษาทางรังสีวิทยา</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_labrung as $item11)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item11->income}}</td> 
                                        <td>{{$item11->name}}</td> 
                                        <td>{{$item11->sqty}}</td> 
                                        <td class="text-center">{{$item11->sum_price}}</td>  
                                        <td class="text-center">{{$item11->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าตรวจวินิจฉัยและรักษาทางรังสีวิทยา</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_med as $item12)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item12->income}}</td> 
                                        <td>{{$item12->name}}</td> 
                                        <td>{{$item12->sqty}}</td> 
                                        <td class="text-center">{{$item12->sum_price}}</td>  
                                        <td class="text-center">{{$item12->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าทำหัตถการ และวิสัญญี</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_hut as $item13)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item13->income}}</td> 
                                        <td>{{$item13->name}}</td> 
                                        <td>{{$item13->sqty}}</td> 
                                        <td class="text-center">{{$item13->sum_price}}</td>  
                                        <td class="text-center">{{$item13->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าบริการทางพยาบาล</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_nurs as $item14)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item14->income}}</td> 
                                        <td>{{$item14->name}}</td> 
                                        <td>{{$item14->sqty}}</td> 
                                        <td class="text-center">{{$item14->sum_price}}</td>  
                                        <td class="text-center">{{$item14->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าบริการทางกายภาพบำบัดและเวชกรรมฟื้นฟู</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_wet as $item15)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item15->income}}</td> 
                                        <td>{{$item15->name}}</td> 
                                        <td>{{$item15->sqty}}</td> 
                                        <td class="text-center">{{$item15->sum_price}}</td>  
                                        <td class="text-center">{{$item15->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่ารถส่งตัว</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_refer as $item16)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item16->income}}</td> 
                                        <td>{{$item16->name}}</td> 
                                        <td>{{$item16->sqty}}</td> 
                                        <td class="text-center">{{$item16->sum_price}}</td>  
                                        <td class="text-center">{{$item16->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">ค่าอื่นๆที่ไม่เกี่ยวข้องกับการรักษาพยาบาล</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_nurstother as $item17)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item17->income}}</td> 
                                        <td>{{$item17->name}}</td> 
                                        <td>{{$item17->sqty}}</td> 
                                        <td class="text-center">{{$item17->sum_price}}</td>  
                                        <td class="text-center">{{$item17->sopaidst}}</td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <h5 class="mb-sm-0">รายการ COVID</h5>
        <div class="col-xl-12">
            <div class="card mt-3">
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
                                @foreach ($data_detail_covid as $item18)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{$item18->income}}</td> 
                                        <td>{{$item18->name}}</td> 
                                        <td>{{$item18->sqty}}</td> 
                                        <td class="text-center">{{$item18->sum_price}}</td>  
                                        <td class="text-center">{{$item18->sopaidst}}</td>   
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

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           
        });
    </script>


@endsection
