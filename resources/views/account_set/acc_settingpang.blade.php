@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT-SET')

@section('content')

<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }

    // function acc_settingpang_destroy(acc_setpang_id) {
    //     Swal.fire({
    //         title: 'ต้องการลบใช่ไหม?',
    //         text: "ข้อมูลนี้จะถูกลบไปเลย !!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
    //         cancelButtonText: 'ไม่, ยกเลิก'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: "{{ url('acc_settingpang_destroy') }}" + '/' + acc_setpang_id,
    //                 type: 'POST',
    //                 data: {
    //                     _token: $("input[name=_token]").val()
    //                 },
    //                 success: function(response) {
    //                         if (response.status == 200) {
    //                             Swal.fire({
    //                             title: 'ลบข้อมูล!',
    //                             text: "You Delet data success",
    //                             icon: 'success',
    //                             showCancelButton: false,
    //                             confirmButtonColor: '#06D177',
    //                             // cancelButtonColor: '#d33',
    //                             confirmButtonText: 'เรียบร้อย'
    //                         }).then((result) => {
    //                             if (result.isConfirmed) {
    //                                 $("#sid" + acc_setpang_id).remove();
    //                                 window.location.reload();
    //                                 //   window.location = "/person/person_index"; //     
    //                             }
    //                         })
    //                     } else {
                            
    //                     }
                        
    //                 }
    //             })
    //         }
    //     })
    // }

    function sub_destroy(acc_setpang_type_id) {
        // alert(acc_setpang_type_id);
        Swal.fire({
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('sub_destroy') }}" + '/' + acc_setpang_type_id,
                    type: 'POST',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + acc_setpang_type_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        } else {
                            
                        }
                        
                    }
                })
            }
        })
    }
    function subicode_destroy(acc_setpang_type_id) {
        // alert(acc_setpang_type_id);
        Swal.fire({
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('subicode_destroy') }}" + '/' + acc_setpang_type_id,
                    type: 'POST',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + acc_setpang_type_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        } else {
                            
                        }
                        
                    }
                })
            }
        })
    }

    function hospmain_destroy(acc_setpang_type_id) {
        // alert(acc_setpang_type_id);
        Swal.fire({
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('hospmain_destroy') }}" + '/' + acc_setpang_type_id,
                    type: 'POST',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + acc_setpang_type_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        } else {
                            
                        }
                        
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

<div class="container-fluid mb-5">
    <div id="preloader">
        <div id="status">
            <div class="spinner">

            </div>
        </div>
    </div>
 
    <div class="row">  
        <div class="col-md-3">
            <h4 class="card-title">Detail ACCOUNT PANG</h4>
            <p class="card-title-desc">รายละเอียดั้งค่าผังบัญชี</p>
        </div>
        <div class="col"></div> 
        <div class="col-md-2 text-start"> 
            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>
                เพิ่มผังบัญชี
            </button>
        </div> 
    </div>

    <div class="row"> 
        <div class="col-xl-12 col-md-6">
            <div class="main-card card p-3"> 
                <table class="table table-sm" id="example" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th> 
                            <th class="text-center">รหัส</th>
                            <th class="text-center">ชื่อผัง</th>
                            <th class="text-center">pttype</th>
                            <th class="text-center">icode</th> 
                            <th class="text-center">icode ที่ยกเว้น</th>  
                            <th class="text-center">hospmain</th>
                            <th class="text-center">icd9</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 0;
                        $total1 = 0; ?>
                        @foreach ($datashow as $item)
                            <?php $number++; ?> 
                            <tr id="#sid{{ $item->acc_setpang_type_id }}">
                                <td class="text-center" width="5%">{{ $number }}</td> 
                                <td class="text-center" width="10%" >
                                    <button type="button"class="btn-icon btn-shadow btn-dashed btn btn-outline-danger editModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                        {{ $item->pang }}
                                    </button>
                                    {{-- <button type="button"class="btn-icon btn-shadow btn-dashed btn btn-outline-danger editModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                        {{ $item->icode }}
                                    </button>
                                    <button type="button"class="btn-icon btn-shadow btn-dashed btn btn-outline-danger editModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                        {{ $item->hospmain }}
                                    </button> --}}
                                </td> 
                                <td >   
                                    <?php 
                                        $data_sub_ = DB::connection('mysql')->select('
                                            SELECT * from acc_setpang_type a
                                            LEFT JOIN pttype p ON p.pttype = a.pttype 
                                            WHERE acc_setpang_id = "'.$item->acc_setpang_id.'"');

                                        $data_subcount_ = DB::connection('mysql')->select('SELECT COUNT(acc_setpang_id) as acc_setpang_id from acc_setpang_type WHERE acc_setpang_id = "'.$item->acc_setpang_id.'"');
                                        foreach ($data_subcount_ as $key => $value) {
                                            $data_subcount = $value->acc_setpang_id;
                                        }
                                    ?>
                                    <div id="headingTwo" class="b-radius-0 card-header">
                                        @if ($data_subcount == '0')
                                            <button type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne2{{ $item->acc_setpang_id }}" aria-expanded="false"
                                                aria-controls="collapseTwo" class="text-start m-0 p-0 btn btn-link btn-block">
                                                <h5 style="color: rgb(207, 204, 204)">{{ $item->pangname }} <label for="" style="color: red"> !! รายละเอียด คลิก !!</label></h5> 
                                            </button>
                                        @else
                                            <button type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne2{{ $item->acc_setpang_id }}" aria-expanded="false"
                                                aria-controls="collapseTwo" class="text-start m-0 p-0 btn btn-link btn-block">
                                                <h5 >{{ $item->pangname }} <label for="" style="color: red"> !! รายละเอียด คลิก !!</label></h5> 
                                            </button>
                                                
                                        @endif
                                        
                                    </div>
                                    
                                    <div data-parent="#accordion" id="collapseOne2{{ $item->acc_setpang_id }}" class="collapse">
                                        <div class="card-body">
                                            <div class="row ms-3 me-3">
                                                @foreach ($data_sub_ as $itemsub)
                                                    <div class="col-md-4 mb-2">
                                                        @if ($itemsub->pttype != '')
                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" onclick="sub_destroy({{ $itemsub->acc_setpang_type_id }})">
                                                                {{$itemsub->pttype}} - {{$itemsub->name}} / {{$itemsub->opdipd}}
                                                            </button>
                                                        @else                                                                    
                                                        @endif

                                                        @if ($itemsub->icode != '')
                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary" onclick="subicode_destroy({{ $itemsub->acc_setpang_type_id }})">
                                                                ICODE - {{$itemsub->icode}}  
                                                            </button> 
                                                        @else                                                              
                                                        @endif

                                                        @if ($itemsub->no_icode != '')
                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" onclick="subicode_destroy({{ $itemsub->acc_setpang_type_id }})">
                                                               NO ICODE - {{$itemsub->no_icode}}  
                                                            </button> 
                                                        @else                                                              
                                                        @endif

                                                        @if ($itemsub->hospmain != '')
                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-warning" onclick="hospmain_destroy({{ $itemsub->acc_setpang_type_id }})">
                                                                Hospmain - {{$itemsub->hospmain}}  
                                                            </button> 
                                                        @else                                                                    
                                                        @endif
                                                        
                                                    </div>
                                                    
                                                @endforeach                                                        
                                            </div>
                                        </div>
                                    </div> 
                                </td> 
                                {{-- <a href="#collapseOne{{ $item->acc_setpang_id }}" class="text-dark" data-bs-toggle="collapse"
                                                aria-expanded="true"
                                                aria-controls="collapseOne">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">                                                 
                                            {{ $item->pangname }}  
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseOne{{ $item->acc_setpang_id }}" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                    <div class="card-body"> 
                                        <div class="row"> 
                                            bb
                                        </div> 
                                    </div>
                                </div> --}}
                                {{-- </div> --}}                                   
                                {{-- <td class="p-2"> <a href="{{url('acc_settingpang_detail/'.$item->acc_setpang_id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="ข้อมูลที่กำหนด">{{ $item->pangname }}</a> </td>  --}}
                                <td class="text-center" width="7%"> 
                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addpttypeModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="เพิ่ม pttype">
                                        <i class="fa-solid fa-plus text-success"></i>
                                        pttype
                                    </button>
                                </td>
                                <td class="text-center" width="7%">
                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addicodeModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่ม icode">
                                        <i class="fa-solid fa-plus text-success"></i>
                                        icode
                                    </button>
                                </td> 
                                <td class="text-center" width="7%">
                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addnoicodeModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่ม icode">
                                        <i class="fa-solid fa-plus text-success"></i>
                                        icode
                                    </button>
                                </td> 
                                <td class="text-center" width="7%">
                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addhospmainModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่ม hipdata_code">
                                        <i class="fa-solid fa-plus text-success"></i>
                                        hospmain
                                    </button>
                                </td> 
                                <td class="text-center" width="7%">
                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addicd9Modal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่ม hipdata_code">
                                        <i class="fa-solid fa-plus text-success"></i>
                                        icd9
                                    </button>
                                </td> 
                                {{-- <td class="p-2" width="30%" > {{ $item->pttype }}</td>  --}}
                                {{-- <td class="text-center" width="30%"> {{ $item->icode }}</td>  --}}
                                {{-- <td class="text-center" width="5%">  
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">ทำรายการ</button>
                                        <ul class="dropdown-menu">
                                            <button type="button"class="dropdown-item menu editModal" value="{{ $item->acc_setpang_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                <label for="" style="font-size:12px;color: rgb(255, 185, 34)">แก้ไข</label>
                                            </button> 
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                                <a class="dropdown-item menu text-danger" href="javascript:void(0)"
                                                    onclick="book_inside_manage_destroy({{ $item->acc_setpang_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can ms-2 me-2 mb-1"></i>
                                                    <label for=""
                                                        style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                </a>
                                        </ul>
                                        </div>
                                </td> --}}
                            </tr> 
                        @endforeach

                    </tbody>
                </table> 
            </div>
        </div> 
    </div>
        
</div>

<!-- Insert Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ตั้งค่าผังบัญชี</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <label for="pang" class="form-label">รหัสผังบัญชี</label>
                        <div class="input-group input-group-sm"> 
                            <input type="text" class="form-control" id="pang" name="pang">  
                        </div>
                    </div>  
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="pangname" class="form-label">ชื่อผังบัญชี</label>
                        <div class="input-group input-group-sm"> 
                            <input type="text" class="form-control" id="pangname" name="pangname">  
                        </div>
                    </div>  
                </div> 
                {{-- <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="pttype" class="form-label">สิทธิ์การรักษา</label>
                        <div class="input-group input-group-sm"> 
                            <input type="text" class="form-control" id="pttype" name="pttype">  
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <label for="icode" class="form-label">icode</label>
                        <div class="input-group input-group-sm"> 
                            <input type="text" class="form-control" id="icode" name="icode">  
                        </div>
                    </div> 
                </div> --}}
                
                <input type="hidden" name="user_id" id="user_id" value="{{$iduser}}"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Savedata">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="editModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">แก้ไขผังบัญชี</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body"> 

                    <div class="row">
                        <div class="col-md-12">
                            <label for="pang" class="form-label">รหัสผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editpang" name="pang">  
                            </div>
                        </div>  
                    </div>
    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="pangname" class="form-label">ชื่อผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editpangname" name="pangname">  
                            </div>
                        </div>  
                    </div> 

                    {{-- <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="pttype" class="form-label">สิทธิ์การรักษา</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editpttype" name="pttype">  
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <label for="icode" class="form-label">icode</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editicode" name="icode">  
                            </div>
                        </div> 
                    </div>  --}}
                
                <input type="hidden" name="user_id" id="edituser_id"> 
                <input type="hidden" name="editacc_setpang_id" id="editacc_setpang_id"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatedata">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- addpttypeModal Modal -->
<div class="modal fade" id="addpttypeModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">เพิ่มสิทธิ์การรักษา</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body"> 

                    <div class="row">
                        <div class="col-md-4">
                            <label for="addtypepang" class="form-label">รหัสผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addtypepang" name="pang" readonly>  
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <label for="addtypepangname" class="form-label">ชื่อผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addtypepangname" name="pangname" readonly>  
                            </div>
                        </div> 
                    </div>
    

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="pttype" class="form-label">OPD-IPD</label>
                            <div class="input-group input-group-sm"> 
                                <select name="opdipd" id="opdipd" class="form-control" style="width: 100%">
                                    <option value="OPD">- OPD -</option>
                                    <option value="IPD">- IPD -</option>
                                </select>                                 
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <label for="addpttype" class="form-label">เพิ่มสิทธิ์การรักษา</label>
                            <div class="input-group input-group-sm">  
                                <select name="addpttype" id="addpttype" class="form-control" style="width: 100%">
                                    <option value="">-Choose-</option>
                                    @foreach ($data_sit as $item1)
                                    <option value="{{$item1->pttype}}">{{$item1->pttype}} {{$item1->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  
                        
                    </div> 
                
                <input type="hidden" name="user_id" id="adduser_id"> 
                <input type="hidden" name="addtypeacc_setpang_id" id="addtypeacc_setpang_id"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatetype">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- addicodeModal Modal -->
<div class="modal fade" id="addicodeModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">เพิ่มรหัส icode ตามเงื่อนไข</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-4">
                            <label for="pang" class="form-label">รหัสผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addpangcode" name="addpangcode" readonly>  
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <label for="pangname" class="form-label">ชื่อผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addicodepangname" name="addicodepangname" readonly>  
                            </div>
                        </div> 
                    </div>
    

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="pttype" class="form-label">icode</label>
                            <div class="input-group input-group-sm">  
                                <input type="text" class="form-control" id="addicodepang" name="addicodepang">  
                            </div>
                        </div>  
                        
                    </div> 
                
                <input type="hidden" name="user_id" id="adduser_id"> 
                <input type="hidden" name="addicodeacc_setpang_id" id="addicodeacc_setpang_id"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updateicode">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- addnoicodeModal Modal -->
<div class="modal fade" id="addnoicodeModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">เพิ่มรหัส icode ที่ยกเว้น</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-4">
                            <label for="pang" class="form-label">รหัสผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addnopangcode" name="addnopangcode" readonly>  
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <label for="pangname" class="form-label">ชื่อผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addnoicodepangname" name="addnoicodepangname" readonly>  
                            </div>
                        </div> 
                    </div>
    

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="pttype" class="form-label">icode</label>
                            <div class="input-group input-group-sm">  
                                <input type="text" class="form-control" id="addnoicodepang" name="addnoicodepang">  
                            </div>
                        </div>  
                        
                    </div> 
                
                <input type="hidden" name="addnouser_id" id="addnouser_id"> 
                <input type="hidden" name="addnoicodeacc_setpang_id" id="addnoicodeacc_setpang_id"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="UpdateNoicode">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div>
 
<!-- addhospmainModal Modal --> 
<div class="modal fade" id="addhospmainModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">เพิ่มรหัส hospmain ตามเงื่อนไข</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-4">
                            <label for="pang" class="form-label">รหัสผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addpanghospmain" name="addpanghospmain" readonly>  
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <label for="pangname" class="form-label">ชื่อผังบัญชี</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="addhospmainpangname" name="addhospmainpangname" readonly>  
                            </div>
                        </div> 
                    </div> 
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="pttype" class="form-label">Hospmain</label>
                            <div class="input-group input-group-sm">  
                                <input type="text" class="form-control" id="addhospmainpang" name="addhospmainpang">  
                            </div>
                        </div>                          
                    </div>                 
                <input type="hidden" name="user_id" id="adduser_id"> 
                <input type="hidden" name="addhospmainacc_setpang_id" id="addhospmainacc_setpang_id"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatehospmain">
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
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#datepicker3').datepicker({
            format: 'yyyy-mm-dd'
        }); 
        $('#addpttype').select2({
            dropdownParent: $('#addpttypeModal')
        });

        $('#opdipd').select2({
            dropdownParent: $('#addpttypeModal')
        });

        $('#Savedata').click(function() {
                var pang = $('#pang').val();
                var pangname = $('#pangname').val(); 
                var pttype = $('#pttype').val();
                var icode = $('#icode').val(); 

                $.ajax({
                    url: "{{ route('acc.acc_settingpang_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        pang,pangname,pttype,icode 
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
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
                                    // window.location="{{ url('warehouse/warehouse_index') }}";
                                }
                            })
                        } else {

                        }

                    },
                });
        }); 
        $('#Updatedata').click(function() {
                var pang = $('#editpang').val();
                var pangname = $('#editpangname').val(); 
                var pttype = $('#editpttype').val();
                var icode = $('#editicode').val(); 
                var acc_setpang_id = $('#editacc_setpang_id').val();
                $.ajax({
                    url: "{{ route('acc.acc_settingpang_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        pang,pangname,pttype,icode,acc_setpang_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Update data success",
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
                                }
                            })
                        } else {

                        }

                    },
                });
        }); 
        $('#Updatetype').click(function() { 
                var addtypepang = $('#addtypepang').val(); 
                var addpttype = $('#addpttype').val(); 
                var opdipd = $('#opdipd').val(); 
                var acc_setpang_id = $('#addtypeacc_setpang_id').val();
                $.ajax({
                    url: "{{ route('acc.acc_pang_addtypesave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        addpttype,acc_setpang_id,addtypepang,opdipd
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                text: "You Insert data success",
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
                                }
                            })
                        } else {

                        }

                    },
                });
        });
        $('#Updateicode').click(function() { 
                var addpangcode = $('#addpangcode').val(); 
                var addicodepang = $('#addicodepang').val(); 
                var acc_setpang_id = $('#addicodeacc_setpang_id').val();
                $.ajax({
                    url: "{{ route('acc.acc_pang_addicodesave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        addicodepang,acc_setpang_id,addpangcode
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                text: "You Insert data success",
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
                                }
                            })
                        } else {

                        }

                    },
                });
        });
        $('#UpdateNoicode').click(function() { 
                var addnopangcode = $('#addnopangcode').val(); 
                var addnoicodepang = $('#addnoicodepang').val(); 
                var acc_setpang_id = $('#addnoicodeacc_setpang_id').val();
                // alert(addnoicodepang);
                $.ajax({
                    url: "{{ route('acc.acc_pang_addnoicodesave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        addnoicodepang,acc_setpang_id,addnopangcode
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                text: "You Insert data success",
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
                                }
                            })
                        } else {

                        }

                    },
                });
        });
        $('#Updatehospmain').click(function() { 
                var pang = $('#addpanghospmain').val(); 
                var addhospmainpang = $('#addhospmainpang').val(); 
                var acc_setpang_id = $('#addhospmainacc_setpang_id').val();
                $.ajax({
                    url: "{{ route('acc.acc_pang_addhospmainsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        addhospmainpang,acc_setpang_id,pang
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                text: "You Insert data success",
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
                                }
                            })
                        } else {

                        }

                    },
                });
        });
    });

    $(document).on('click', '.editModal', function() {
        var acc_setpang_id = $(this).val(); 
        $('#editModal').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ url('acc_settingpang_edit') }}" + '/' + acc_setpang_id,
            success: function(data) {
                console.log(data.data_show.acc_setpang_id);
                $('#editpang').val(data.data_show.pang)
                $('#editpangname').val(data.data_show.pangname)
                $('#editpttype').val(data.data_show.pttype)
                $('#editicode').val(data.data_show.icode)  
                $('#editacc_setpang_id').val(data.data_show.acc_setpang_id)
            },
        });
    });

    $(document).on('click', '.addpttypeModal', function() {
        var acc_setpang_id = $(this).val(); 
        $('#addpttypeModal').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ url('acc_pang_addtype') }}" + '/' + acc_setpang_id,
            success: function(data) {
                console.log(data.data_type.acc_setpang_id); 
                $('#addtypepang').val(data.data_type.pang)
                $('#addtypepangname').val(data.data_type.pangname)
                $('#addpttype').val(data.data_type.pttype) 
                $('#addtypeacc_setpang_id').val(data.data_type.acc_setpang_id)
            },
        });
    });

    $(document).on('click', '.addicodeModal', function() {
        var acc_setpang_id = $(this).val(); 
        $('#addicodeModal').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ url('acc_pang_addicode') }}" + '/' + acc_setpang_id,
            success: function(data) {
                console.log(data.data_icode.acc_setpang_id); 
                $('#addpangcode').val(data.data_icode.pang)
                $('#addicodepangname').val(data.data_icode.pangname) 
                $('#addicodeacc_setpang_id').val(data.data_icode.acc_setpang_id)
            },
        });
    });
    $(document).on('click', '.addnoicodeModal', function() {
        var acc_setpang_id = $(this).val(); 
        $('#addnoicodeModal').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ url('acc_pang_addicode') }}" + '/' + acc_setpang_id,
            success: function(data) {
                console.log(data.data_icode.acc_setpang_id); 
                $('#addnopangcode').val(data.data_icode.pang)
                $('#addnoicodepangname').val(data.data_icode.pangname) 
                $('#addnoicodeacc_setpang_id').val(data.data_icode.acc_setpang_id)
            },
        });
    });

    $(document).on('click', '.addhospmainModal', function() {
        var acc_setpang_id = $(this).val(); 
        $('#addhospmainModal').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ url('acc_pang_addhospmain') }}" + '/' + acc_setpang_id,
            success: function(data) {
                console.log(data.data_hospmain.acc_setpang_id); 
                $('#addpanghospmain').val(data.data_hospmain.pang)
                $('#addhospmainpangname').val(data.data_hospmain.pangname) 
                $('#addhospmainacc_setpang_id').val(data.data_hospmain.acc_setpang_id)
            },
        });
    });
 
</script> 
@endsection
