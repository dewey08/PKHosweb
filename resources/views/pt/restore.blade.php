@extends('layouts.report_font')
@section('title', 'PK-OFFICER || งานจิตเวชและยาเสพติด')
@section('content')
    
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('pt.restore') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-1 text-end">  </div>
                        {{-- <div class="col-md-3 text-center">
                            <select id="pang_id" name="pang_id" class="form-control" style="width: 100%" required>
                                <option value="">--เลือกผังบัญชี--</option>
                                @foreach ($pang as $p)
                                    @if ($pang_id == $p->pang_id)
                                        <option value="{{ $p->pang_id }}" selected>{{ $p->pang_fullname }}</option>
                                    @else
                                        <option value="{{ $p->pang_id }}">{{ $p->pang_fullname }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div> --}}
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
            <h5>รายงานจำนวนผู้ป่วยนอกที่ได้รับให้บริการฟื้นฟู</h5>
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">แผนก</th>
                                    <th class="text-center">ครั้ง</th>
                                    <th class="text-center">ข้อมูลการคีย์ เบิก สปสช</th>
                                    <th class="text-center">ค่ารักษา HOSxP</th>
                                    <th class="text-center">ชดเชย</th>
                                    <th class="text-center">ร้อยละ</th> 

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($dataptrestore_type as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center">{{ $item->pt_restore_type_name}}</td>

                                        @if ($item->pt_restore_type_code == 'KA01')
                                            @foreach ($kayapap as $item01)
                                                <td> 
                                                    <a href="{{url('kayapap_vs/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item01->VS}}</a>  
                                                </td>
                                                <td>
                                                    {{-- <a href="{{url('kayapap_vs/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item01->Keyspsch}}</a>--}}
                                                    {{$item01->Keyspsch}}
                                                </td>
                                                <td class="text-center">{{$item01->sumhos}}</td>
                                                <td class="text-center">{{$item01->chod}} </td>
                                                <td> {{$item01->percen}}</td>
                                            @endforeach
                                        @elseif($item->pt_restore_type_code == 'KA02')
                                            @foreach ($hoocojmok as $item02)
                                                <td>  
                                                    <a href="{{url('kayapap_hoocojmokvs/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item02->VS}}</a>  
                                                </td>
                                                <td>{{$item02->Keyspsch}} </td>
                                                <td class="text-center"> {{$item02->sumhos}}</td>
                                                <td class="text-center">{{$item02->chod}} </td>
                                                <td>  {{$item02->percen}}</td>
                                            @endforeach
                                        @elseif($item->pt_restore_type_code == 'KA03')
                                            @foreach ($ta as $item03)
                                                <td>
                                                    <a href="{{url('kayapap_tavs/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item03->VS}}</a> 
                                                </td>
                                                <td>{{$item03->Keyspsch}} </td>
                                                <td class="text-center"> {{$item03->sumhos}}</td>
                                                <td class="text-center">{{$item03->chod}} </td>
                                                <td>  {{$item03->percen}}</td>
                                            @endforeach
                                        @elseif($item->pt_restore_type_code == 'KA04')
                                            @foreach ($jitdaycare as $item04)
                                                <td>
                                                    <a href="{{url('kayapap_jitvs/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item04->VS}}</a>  
                                                </td>
                                                <td>{{$item04->Keyspsch}} </td>
                                                <td class="text-center"> {{$item04->sumhos}}</td>
                                                <td class="text-center">{{$item04->chod}} </td>
                                                <td>  {{$item04->percen}}</td>
                                            @endforeach
                                        @else
                                            @foreach ($kratoon as $item05)
                                                <td>
                                                    <a href="{{url('kayapap_kratoonvs/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item05->VS}}</a> 
                                                </td>
                                                <td>{{$item05->Keyspsch}} </td>
                                                <td class="text-center"> {{$item05->sumhos}}</td>
                                                <td class="text-center">{{$item05->chod}} </td>
                                                <td>  {{$item05->percen}}</td>
                                            @endforeach
                                        @endif 
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
