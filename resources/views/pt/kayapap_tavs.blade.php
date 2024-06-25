@extends('layouts.user')
@section('title', 'PK-OFFICER || งานจิตเวชและยาเสพติด')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    {{-- <style>
        .table thead tr th {
            font-family: sans-serif;
            font-size: 12px;
            background-color: #2cbec9;
            color: #ffffff;
            text-align: center;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
      
            .myTable th .myTable td{
                padding: 3px 3px;
            }
            .myTable tbody tr{
                border-bottom: 1px solid #f3760f;
            }
            .myTable tbody tr:nth-of-type(even){
                background-color: #c7eff5;
            }
            .myTable tbody tr:last-of-type{
                border-bottom: 1px solid #08d1a9;
            }
            .myTable tbody tr .active-row{
                color: #08d1a9;
            }
    </style> --}}
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
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('pt.restore') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-1 text-end">  </div> 
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                    id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $startdate }}">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                    id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $enddate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                            
                        </div>
                        <div class="col"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-12">
            <h5>รายงานจำนวนผู้ป่วยนอกที่ได้รับให้บริการฟื้นฟู(จักษุ)</h5>
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">ครั้ง</th>
                                    <th class="text-center">ข้อมูลการคีย์ เบิก สปสช</th>
                                    <th class="text-center">ยังไม่คีย์ เบิก สปสช</th>
                                    <th class="text-center">ค่ารักษา HOSxP</th> 
                                    <th class="text-center">ชดเชยจาก สปสช</th> 
                                    <th class="text-center">ร้อยละ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($kayapap_tavs as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{ $item->year}}</td>
                                        @if ($item->months == '1')
                                                <td width="15%" class="text-center">มกราคม</td>
                                            @elseif ($item->months == '2')
                                                <td width="15%" class="text-center">กุมภาพันธ์</td>
                                            @elseif ($item->months == '3')
                                                <td width="15%" class="text-center">มีนาคม</td>
                                            @elseif ($item->months == '4')
                                                <td width="15%" class="text-center">เมษายน</td>
                                            @elseif ($item->months == '5')
                                                <td width="15%" class="text-center">พฤษภาคม</td>
                                            @elseif ($item->months == '6')
                                                <td width="15%" class="text-center">มิถุนายน</td>
                                            @elseif ($item->months == '7')
                                                <td width="15%" class="text-center">กรกฎาคม</td>
                                            @elseif ($item->months == '8')
                                                <td width="15%" class="text-center">สิงหาคม</td>
                                            @elseif ($item->months == '9')
                                                <td width="15%" class="text-center">กันยายน</td>
                                            @elseif ($item->months == '10')
                                                <td width="15%" class="text-center">ตุลาคม</td>
                                            @elseif ($item->months == '11')
                                                <td width="15%" class="text-center">พฤษจิกายน</td>
                                            @else
                                                <td width="15%" class="text-center">ธันวาคม</td>
                                            @endif  
                                       
                                        <td class="text-center">
                                            <a href="{{url('kayapap_tavs_subvn/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item->VN}}</a>  
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('kayapap_tavs_subspsch/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item->spsch}}</a>  
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('kayapap_tavs_subnokey/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item->nokey}}</a> 
                                        </td>
                                        <td class="text-center">{{ $item->incomhos}}</td>
                                        <td class="text-center">{{ $item->chod}}</td>
                                        <td class="text-center">{{ $item->percen}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                                @foreach ($total as $item2)
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-end">รวมทั้งหมด</td>
                                        <td class="text-center">{{$item2->VNN}}</td>
                                        <td class="text-center">{{$item2->spschh}}</td>
                                        <td class="text-center">{{$item2->nokeyy}}</td>
                                        <td class="text-center">{{$item2->incomhoss}}</td>
                                        <td class="text-center">{{$item2->chodd}}</td>
                                        <td class="text-center">{{$item2->percenn}}</td>
                                    </tr>
                                @endforeach
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

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#checkBtn').click(function() {

                var pang_id = $('#pang_id').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();
                // alert(enddate);
                $.ajax({
                    url: "{{ route('acc.checksit_admit_spsch') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        pang_id,
                        startdate,
                        enddate
                    },
                    success: function(data) {
                        // if (data.status == 200) { 
                        //     Swal.fire({
                        //         title: 'บันทึกข้อมูลสำเร็จ',
                        //         text: "You Insert data success",
                        //         icon: 'success',
                        //         showCancelButton: false,
                        //         confirmButtonColor: '#06D177',
                        //         confirmButtonText: 'เรียบร้อย'
                        //     }).then((result) => {
                        //         if (result
                        //             .isConfirmed) {
                        //             console.log(
                        //                 data);

                        //             window.location
                        //                 .reload();
                        //         }
                        //     })
                        // } else {

                        // }

                    },
                });
            });

        });
    </script>

@endsection
