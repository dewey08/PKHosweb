@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')

   


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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
    ?>
     
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
               border-top: 10px #fd6812 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(360deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
     
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>                   
                   
        <div class="row"> 
            <div class="col-md-12"> 
                    <div class="main-card mb-3 card shadow-lg">
                    <div class="card-header">
                        <h4 class="card-title">Mapping Pttype</h4>   
                        <div class="btn-actions-pane-right">
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th> 
                                        <th>pttype_acc_code</th>
                                        <th>ptname</th>
                                        {{-- <th>pcode</th>  --}}
                                        {{-- <th>pttype_acc_eclaimid</th>  --}}
                                        {{-- <th>hipdata_code</th>  --}}
                                        {{-- <th>max_debt_money</th>  --}}
                                        {{-- <th>nhso_code</th>  --}}
                                        <th>ar_opd</th>
                                        <th>ชื่อผังบัญชี</th>
                                        <th>ar_ipd</th>
                                        {{-- <th>pttype_eclaim_id</th>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)  
                                        
                                        <tr id="{{$item->pttype_acc_id}}">
                                            <td>{{ $i++ }}</td> 
                                            <td>{{ $item->pttype_acc_code }}</td> 
                                            <td>{{ $item->ptname }}</td>   
                                            {{-- <td>{{ $item->pcode }}</td>   --}}
                                            {{-- <td>{{ $item->pttype_acc_eclaimid }}</td>   --}}
                                            {{-- <td>{{ $item->hipdata_code }}</td>    --}}
                                            {{-- <td>{{ $item->max_debt_money }}</td>  --}}
                                            {{-- <td>{{ $item->nhso_code }}</td>  --}}
                                            <td style="width: 15%"> 
                                                @if ($item->pttype_acc_eclaimid == '')
                                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success insert_data" value="{{ $item->pttype_acc_id }}">                                                      
                                                    <i class="fa-regular fa-square-plus me-2"></i>
                                                    ตั้งค่าผังบัญชี
                                                </button>
                                                @else      
                                                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning" data-bs-toggle="modal" data-bs-target=".EditModal{{ $item->pttype_acc_id }}">    
                                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                                        {{ $item->ar_opd }}
                                                    </button> 
                                                @endif      
                                            </td> 
                                            <td>{{ $item->eclaimname }}</td> 
                                            <td>
                                                @if ($item->pttype_acc_eclaimid == '')
                                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success insert_data" value="{{ $item->pttype_acc_id }}">                                                      
                                                    <i class="fa-regular fa-square-plus me-2"></i>
                                                    ตั้งค่าผังบัญชี
                                                </button>
                                                @else      
                                                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning" data-bs-toggle="modal" data-bs-target=".EditModalIPD{{ $item->pttype_acc_id }}">    
                                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                                        {{ $item->ar_ipd }}
                                                    </button> 
                                                @endif     
                                            </td> 
                                           
                                        </tr>    

                                         <!--  Modal content EditModal Update -->
                                         <div class="modal fade EditModal{{ $item->pttype_acc_id }}" id="EditModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header"> 
                                                        <h5 class="modal-title" id="invenModalLabel">กำหนดผังบัญชี</h5> 
                                                    </div>
                                                    <div class="modal-body"> 
                                                        <input id="pttype_acc_id" name="pttype_acc_id" type="hidden" class="form-control form-control-sm" value="{{ $item->pttype_acc_id }}">
                                                        
                                                        <div class="row">  
                                                            <div class="col-md-12">
                                                                <label for="">รหัสผังบัญชี (OPD)</label>
                                                                <div class="form-group"> 
                                                                    <select id="editsar_opd" name="ar_opd" class="form-select form-select-lg show_opd" style="width: 100%">  
                                                                        <option value="">--เลือก--</option>
                                                                        @foreach ($aropd as $items)  
                                                                        @if ($item->ar_opd == $items->ar_opd)
                                                                        <option value="{{ $items->code }}" selected> {{ $items->ar_opd }} {{ $items->name }}</option> 
                                                                        @else
                                                                        <option value="{{ $items->code }}"> {{ $items->ar_opd }} {{ $items->name }}</option> 
                                                                        @endif
                                                                           
                                                                        @endforeach    
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                       
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-end">
                                                            <div class="form-group">
                                                                <button type="button" id="UPSdateBtn" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                    กำหนดผังบัญชี
                                                                </button>
                                                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark me-2"></i>
                                                                        Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                
                    </div>
                </div>
            </div>   
        </div>
                                    
                
    </div>
  

     <!--  Modal content InsertModal -->
     <div class="modal fade" id="InsertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"> 
                    <h5 class="modal-title" id="invenModalLabel">กำหนดผังบัญชี</h5> 
                </div>
                <div class="modal-body"> 
                    <input id="insertpttype" name="insertpttype" type="hidden" class="form-control form-control-sm">
                    <div class="row">    
                        {{-- <div class="col-md-4">
                        </div>                       --}}
                        <div class="col-md-6">
                            <label for="">รหัสผังบัญชี (OPD)</label>
                            <div class="form-group"> 
                                <select id="insertar_opd" name="insertar_opd" class="form-select form-select-lg show_opd" style="width: 100%">  
                                    <option value="">--เลือก--</option>
                                    @foreach ($aropd as $items)  
                                        <option value="{{ $items->code }}"> {{ $items->ar_opd }} {{ $items->name }}</option> 
                                    @endforeach    
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <label for="">ชื่อผังบัญชี</label>
                            <div class="form-group">
                                <input id="CODE_NAME" name="CODE_NAME" type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="">ถ้าไม่มีให้เพิ่ม ***(รหัสผังบัญชี OPD)</label>
                            <div class="form-group">
                                <input id="ADDOPD" name="ADDOPD" type="text" class="form-control form-control-sm">                               
                            </div>
                        </div>
                        <div class="col-md-1">
                            <br>
                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success" onclick="Addopd();">
                                <i class="fa-regular fa-square-plus"></i>
                            </button>
                        </div>   --}}
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="InsertBtn" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                กำหนดผังบัญชี
                            </button>
                            <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>
                                    Close
                            </button>
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
            $('#editar_opd').select2({
                    dropdownParent: $('#EditModals')
            });
           
            $('#insertar_opd').select2({
                    dropdownParent: $('#InsertModal')
            });
            $('#ar_ipd').select2({
                    dropdownParent: $('#InsertModal')
            });
            $(document).on('click', '.insert_data', function() { 
                
                var pt = $(this).val();
                // alert(pt);
                $('#InsertModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('acc_setting_edit') }}" + '/' + pt,
                    success: function(data) {
                        // console.log(data.type.name);
                        // $('#editname').val(data.type.name)
                        // $('#editaropd').val(data.type.ar_opd)
                        // $('#editaripd').val(data.type.ar_ipd)
                        $('#insertpttype').val(data.type.pttype_acc_id)
                        // $('#editcode').val(data.type.code)
                    },
                });
            });
            $('#UPSdateBtn').click(function() {
                var ar_opd = $('#editsar_opd').val(); 
                var acc_id = $('#pttype_acc_id').val();
                alert(ar_opd);
                $.ajax({
                    url: "{{ route('acc.acc_setting_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        ar_opd,acc_id 
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'กำหนดผังบัญชีสำเร็จ',
                                text: "You Setting data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            $('#InsertBtn').click(function() {
                var insertpttype = $('#insertpttype').val(); 
                var insertar_opd = $('#insertar_opd').val();
                // alert(insertar_opd);
                $.ajax({
                    url: "{{ route('acc.acc_setting_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        insertpttype,insertar_opd 
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'กำหนดผังบัญชีสำเร็จ',
                                text: "You Setting data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });
            
              
        });
    </script>
    @endsection
