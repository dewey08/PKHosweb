@extends('layouts.report_font')
@section('title', 'PK-OFFICER || checksit')
@section('content')
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
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
           .is-hide{
           display:none;
           }
</style>

<div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                 <div class="main-card mb-3 card">
                    <div class="card-header">
                        IMPORT Authen และวันที่ Import Excel Authen
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                        {{--
                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-science btn-icon-wrapper"></i>Token
                                </button> --}}
                                <a href="{{url('https://authenservice.nhso.go.th/authencode/#/claimcode/create')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" target="_blank">
                                    <i class="pe-7s-check btn-icon-wrapper"></i>ดึงรายงาน Authen
                                </a>
                                {{-- <a href="{{url('check_sit_daysitauto')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning" target="_blank">
                                    <i class="pe-7s-check btn-icon-wrapper"></i>Checksit Auto
                                </a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col"></div>
                            <div class="col-xl-8 col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="grid-menu-col">
                                        <form action="{{ route('claim.check_authen_excel') }}" method="POST" id="Upstm"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                <div class="col"></div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 mt-3">
                                                        <label for="formFileLg" class="form-label">UP REPORT AUTHEN EXCEL</label>
                                                        <input class="form-control form-control-lg" id="formFileLg" name="uploaded_file"
                                                            type="file" required>
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    </div>
                                                    {{-- @if ($countc > 0)
                                                        <a href="{{ url('upstm_ti_importtotal') }}" class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                                            <i class="fa-solid fa-file-import me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งข้อมูล"></i>
                                                                ส่งข้อมูล
                                                        </a>
                                                    @else --}}
                                                        <button type="submit"
                                                            class="mb-3 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                            <i class="fa-solid fa-cloud-arrow-up me-2" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="UP STM"></i>
                                                            UP STM
                                                        </button>
                                                    {{-- @endif --}}


                                                </div>
                                                <div class="col"></div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                    </form>
                        {{-- <form action="{{ route('claim.check_authen') }}" method="POST">
                            @csrf
                            <div class="row mt-3">
                                <div class="col"></div>
                                <div class="col-md-1 text-end">วันที่</div>
                                <div class="col-md-4 text-center">
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $datestart }}" />
                                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $dateend }}" />
                                    </div>
                                </div>



                                <div class="col-md-1">
                                    <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                    </button>

                                </div>
                                 <div class="col"></div>
                            </div>

                        </form> --}}
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless" id="example">

                                <thead>
                                    <tr>
                                        <th>ลำดับ</th> 
                                        <th>vstdate</th> 
                                        {{-- <th>จัดการ</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data_show as $item) 
                                        <tr>
                                            <td>{{ $i++ }}</td> 
                                            <td>{{ $item->vstdate }}</td> 
                                            {{-- <td></td> --}}
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

<!-- Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Token</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="">@cid</span>
                    </div>
                    <input type="text" id="cid" name="cid" class="form-control">
                </div>
                <br>
                <div class="input-group input-group-sm">
                    <div class="input-group-text">
                        <span class="">@Token</span>
                    </div>
                    <input type="text" class="form-control" id="token" name="token">
                </div>
            </div>
            <div class="modal-footer">
                <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="TokenSave">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')

<script>
    //  window.setTimeout(function() {
    //         window.location.reload();
    //     },500000);
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#Upstm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                // alert('OJJJJOL');
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'Up REPORT EXCEL สำเร็จ',
                                text: "You Up REPORT EXCEL data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })

                        } else {
                            Swal.fire({
                                title: 'UP Statment ซ้ำ',
                                text: "You Up Statment data success",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            });
    });
</script>
@endsection

