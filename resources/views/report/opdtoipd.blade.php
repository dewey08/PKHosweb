{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.pkclaim')
@section('title','PK-OFFICER || OPIP')
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
   <div class="tabs-animation">
    <form action="{{ route('op.opdtoipd') }}" method="GET">
        @csrf

        <div class="row"> 
            <div class="col"></div>
            {{-- <div class="col-md-1 text-end">สิทธิ์</div>
            <div class="col-md-2 text-center">
                <select name="pttype" id="pttype" class="form-control" required> 
                    <option value=""></option>
                    @foreach ($pttype as $type)
                    @if ($pttype_ == $type->pttype)
                    <option value="{{$type->pttype}}" selected>{{$type->pttype}} => {{$type->name}}</option>
                    @else
                    <option value="{{$type->pttype}}">{{$type->pttype}} => {{$type->name}}</option>
                    @endif
                        
                    @endforeach
                </select>
            </div> --}}
            <div class="col-md-1 text-end">วันที่</div>
            <div class="col-md-4 text-center">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                        data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $enddate }}"/>
                    <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        ค้นหา
                    </button>  
                </div>
            </div>
            <div class="col"></div>
        </div>

    </form>

        <div class="row mt-4">
            {{-- <div class="col-xl-4">
            
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-4 ms-2 me-2 mb-2">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title"> รายงานจำนวนผู้ป่วยใน ที่ไม่โอนค่ารักษา จาก OPD</h4>
                                 
                            </div>
                            <div class="col"></div>
                            
                        </div>
                        <div class="table-responsive mt-2">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">year</th> 
                                        <th class="text-center">month</th> 
                                        <th class="text-center">an</th> 
                                        <th class="text-center">income</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->year }}</td> 
                                            <td>{{ $item->month }}</td> 
                                            <td> 
                                                <a href="{{url('opdtoipd_sub/'.$item->month.'/'.$item->year)}}" target="_blank">{{ $item->an }}</a>
                                            </td> 
                                            <td> 
                                               
                                                    {{ $item->income }}
                                              
                                            </td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div> --}}

            <div class="col-xl-12">
            
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-4 ms-2 me-2 mb-2">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title"> รายงานจำนวนผู้ป่วยใน ที่ไม่โอนค่ารักษา จาก OPD</h4>
                                 
                            </div>
                            <div class="col"></div>
                            
                        </div>
                        <div class="table-responsive mt-2">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            {{-- <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">vn</th> 
                                        <th class="text-center">hn</th> 
                                        <th class="text-center">an</th> 
                                        <th class="text-center">cid</th> 
                                        <th class="text-center">ptname</th> 
                                        <th class="text-center">pttype</th> 
                                        <th class="text-center">วัน Admit</th> 
                                        <th class="text-center">เวลา</th> 
                                        <th class="text-center">วันจำหน่าย</th> 
                                        <th class="text-center">ค่ารักษาผู้ป่วยนอก</th> 
                                        <th class="text-center">ค่ารักษาผู้ป่วยใน</th> 
                                        <th class="text-center">ชำระเงิน</th> 
                                        <th class="text-center">เจ้าหน้าที่</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow2 as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item2->vn }}</td> 
                                            <td>{{ $item2->hn }}</td> 
                                            <td>{{ $item2->an }}</td> 
                                            <td> {{ $item2->cid }} </td> 
                                            <td class="p-2"> {{ $item2->ptname }} </td> 
                                            <td> {{ $item2->pttype }} </td> 
                                            <td> {{ $item2->regdate }} </td> 
                                            <td> {{ $item2->regtime }} </td> 
                                            <td> {{ $item2->dchdate }} </td>  
                                            <td class="text-end"><a href="{{url('opdtoipd_sub/'.$item2->vn)}}" target="_blank">{{ $item2->v_income }}</a></td> 
                                            <td class="text-end"> {{ $item2->a_income }} </td> 
                                            <td> {{ $item2->bill_amount }} </td> 
                                            <td> {{ $item2->staff }} </td> 
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
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#ex_1').DataTable();
            $('#ex_2').DataTable();
            $('#ex_3').DataTable();
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('#pttype').select2({
                placeholder: "== เลือกสิทธิ์ต้องการ ==",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
        });
    </script>
@endsection
