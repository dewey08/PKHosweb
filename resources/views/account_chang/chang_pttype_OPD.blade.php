@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
 
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function pttypeopd_destroy(acc_debtor_id) {
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
                        url: "{{ url('pttypeopd_destroy') }}" + '/' + acc_debtor_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
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
                                    $("#sid" + acc_debtor_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
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
    $datenow = date('Y-m-d');
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
    
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        <form action="{{ url('chang_pttype_OPD') }}" method="GET">
            @csrf
            <div class="row"> 
                <div class="col"></div>
                <div class="col-md-2 text-end mt-2">กรอก HN ที่ต้องการเปลี่ยน</div>
                <div class="col-md-4 text-end">
                    @if ($hn == '')
                        <input type="text" class="form-control" name="HN" id="HN" placeholder="HN" required>
                    @else
                        <input type="text" class="form-control" name="HN" id="HN" value="{{$hn}}" placeholder="HN" required>
                    @endif
                    
                </div>
                <div class="col-md-2"> 
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                        <i class="fa-solid fa-magnifying-glass text-primary me-2"></i>
                        ค้นหา
                    </button>    
                    
                </div>
                {{-- <div class="col"></div> --}}
            </div>
        </form>  
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                       
                      
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail Account  ทะเบียนเปลี่ยนสิทธิ์</h4>
                                <p class="card-title-desc">รายละเอียดตั้งลูกหนี้</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info Savestamp" data-url="{{url('chang_pttype_opdstamp')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตั้งลูกหนี้
                                </button> --}}
                            </div>
                        </div>

                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                                style=" border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                          
                                            <th width="5%" class="text-center">ลำดับ</th> 
                                            {{-- <th width="5%" class="text-center"><input type="checkbox" name="stamp" id="stamp"> </th>  --}}
                                            <th class="text-center" width="5%">vn</th> 
                                            <th class="text-center">an</th>
                                            <th class="text-center" >hn</th>
                                            <th class="text-center" >cid</th>
                                            <th class="text-center">ptname</th>
                                            <th class="text-center">vstdate</th>  
                                            <th class="text-center">pttype</th> 
                                            <th class="text-center">ผัง</th> 
                                            <th class="text-center">spsch</th>  
                                            <th class="text-center">ลูกหนี้</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($acc_debtor as $item) 
                                            <tr id="sid{{ $item->acc_debtor_id }}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>   
                                                {{-- <td class="text-center" width="5%"><input type="checkbox" class="sub_chk" data-id="{{$item->acc_debtor_id}}"> </td>   --}}
                                                <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                                <td class="text-center" width="5%">{{ $item->an }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                                <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                <td class="p-2" >{{ $item->ptname }}</td> 
                                                <td class="text-center" width="10%">{{ $item->vstdate }}</td>   
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">
                                                    {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Searchdata">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                        ดึงข้อมูล
                                                    </button> --}}
                                                    
                                                    <a class="btn-icon btn-shadow btn-dashed btn btn-outline-danger btn-sm" href="javascript:void(0)"
                                                        onclick="pttypeopd_destroy({{ $item->acc_debtor_id }})"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        data-bs-custom-class="custom-tooltip" title="ลบ">
                                                        <i class="fa-solid fa-trash-can text-danger me-2"></i>
                                                        {{ $item->pttype }}
                                                    </a>
                                                 
                                                </td>  
                                                <td class="text-center" style="color:rgb(231, 138, 15)" width="10%">
                                                    {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning addicodeModal">
                                                        <i class="fa-regular fa-pen-to-square me-2"></i>
                                                        {{ $item->account_code }}
                                                    </button>  --}}
                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-warning addicodeModal" value="{{ $item->acc_debtor_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="ย้ายผังบัญชี">
                                                        <i class="fa-regular fa-pen-to-square me-2"></i>
                                                        {{ $item->account_code }}
                                                    </button>
                                                   
                                                </td> 
                                                <td class="text-center" style="color:rgb(216, 14, 176)" width="5%">{{ $item->subinscl }}</td>  
                                                <td class="text-center" width="10%">{{ number_format($item->debit_total, 2) }}</td> 
 
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
    </div>
  

    <!-- addicodeModal Modal -->
    <div class="modal fade" id="addicodeModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">รายการขอปรับเปลี่ยนผังบัญชี</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-3">
                                <label for="pang" class="form-label">รหัสผังบัญชี</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="add_account_code" name="account_code" readonly>  
                                </div>
                            </div>  
                            <div class="col-md-3">
                                <label for="pangname" class="form-label">vn</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="vn" name="vn" readonly>  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="pangname" class="form-label">an</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="an" name="an" readonly>  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="pangname" class="form-label">hn</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="hn" name="hn" readonly>  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="pangname" class="form-label">vstdate</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="date" class="form-control" id="vstdate" name="vstdate" readonly>  
                                </div>
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="pang" class="form-label">ชื่อ-นาสกุล</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="ptname" name="ptname" readonly>  
                                </div>
                            </div>  
                            <div class="col-md-3">
                                <label for="pang" class="form-label">cid</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="cid" name="cid" readonly>  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="pangname" class="form-label">pttype</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="pttype" name="pttype" readonly>  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="pangname" class="form-label">ลูกหนี้</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="debit_total" name="debit_total" readonly>  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="pangname" class="form-label">dchdate</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="date" class="form-control" id="dchdate" name="dchdate" readonly>  
                                </div>
                            </div>
                        </div> 
        
                        <hr style="color: red">

                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="pang" class="form-label" style="color: red">ผังบัญชีใหม่</label>
                                <div class="input-group input-group-sm">  
                                    <select name="account_code_new" id="account_code_new" class="form-control form-control-sm" style="width: 100%"> 
                                        <option value="">-เลือก-</option>
                                        @foreach ($pang as $item_p)
                                        <option value="{{$item_p->pang}}">{{$item_p->pang}}</option>
                                        @endforeach
                                    </select> 
                                </div>
                            </div>  
                            <div class="col-md-3">
                                <label for="pangname" class="form-label" style="color: red">สิทธิ์ใหม่</label>
                                <div class="input-group input-group-sm">  
                                    <select name="pttype_new" id="pttype_new" class="form-control form-control-sm" style="width: 100%"> 
                                        <option value="">-เลือก-</option>
                                        @foreach ($pttype as $item_pt)
                                        <option value="{{$item_pt->pttype}}">{{$item_pt->pttype}}</option>
                                        @endforeach
                                    </select> 
                                </div>
                            </div> 
                            <div class="col-md-3">
                                <label for="pangname" class="form-label" style="color: red">ลูกหนี้ใหม่</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="debit_total_new" name="debit_total_new" >  
                                </div>
                            </div> 
                            <div class="col-md-3">
                                <label for="pangname" class="form-label" style="color: red">วันที่ขอเปลี่ยน</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="date" class="form-control" id="date_req" name="date_req" value="{{$datenow}}">  
                                </div>
                            </div> 
                        </div> 
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="pang" class="form-label" style="color: red">หมายเหตุ</label>
                                <div class="input-group input-group-sm"> 
                                    <textarea id="comment" name="comment" cols="30" rows="3" class="form-control form-control-sm" ></textarea> 
                                </div>
                            </div>  
                        </div> 
                    <input type="hidden" name="user_id" id="adduser_id"> 
                    <input type="hidden" name="acc_debtor_id" id="acc_debtor_id"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatedata">
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
            $('#stamp').on('click', function(e) {
            if($(this).is(':checked',true))  
            {
                $(".sub_chk").prop('checked', true);  
            } else {  
                $(".sub_chk").prop('checked',false);  
            }  
            }); 
            $("#spinner-div").hide(); //Request is complete so hide spinner
            
            $('.Savestamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการตั้งลูกหนี้รายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Debtor it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = true;
                                if (check == true) {
                                    var join_selected_values = allValls.join(",");
                                    // alert(join_selected_values);
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 

                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success:function(data){ 
                                                if (data.status == 200) {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
                                                        title: 'ตั้งลูกหนี้สำเร็จ',
                                                        text: "You Debtor data success",
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
                                                

                                            // } else {
                                            //     alert("Whoops Something went worng all"); 
                                            // }
                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        }) 
                    // var check = confirm("Are you want ?");  
                }
            });             

           

            $(document).on('click', '.addicodeModal', function() {
                var acc_debtor_id = $(this).val(); 
                $('#addicodeModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('move_pang') }}" + '/' + acc_debtor_id,
                    success: function(data) {
                        console.log(data.data_pang.acc_debtor_id); 
                        $('#add_account_code').val(data.data_pang.account_code)
                        $('#vn').val(data.data_pang.vn) 
                        $('#an').val(data.data_pang.an) 
                        $('#hn').val(data.data_pang.hn)
                        $('#cid').val(data.data_pang.cid)
                        $('#vstdate').val(data.data_pang.vstdate) 
                        $('#dchdate').val(data.data_pang.dchdate) 
                        $('#ptname').val(data.data_pang.ptname) 
                        $('#debit_total').val(data.data_pang.debit_total)
                        $('#pttype').val(data.data_pang.pttype)
                        $('#acc_debtor_id').val(data.data_pang.acc_debtor_id)

                        $('#account_code_new').val(data.data_pang.account_code)
                        $('#pttype_new').val(data.data_pang.pttype)
                        $('#debit_total_new').val(data.data_pang.debit_total)
                    },
                });
            });

            $('#Updatedata').click(function() { 
                var account_code = $('#add_account_code').val(); 
                var vn = $('#vn').val(); 
                var an = $('#an').val();
                var hn = $('#hn').val();
                var cid = $('#cid').val();
                var vstdate = $('#vstdate').val();
                var dchdate = $('#dchdate').val();
                var comment = $('#comment').val();
                var ptname = $('#ptname').val(); 
                var account_code_new = $('#account_code_new').val();
                var pttype_new = $('#pttype_new').val();
                var debit_total_new = $('#debit_total_new').val();
                var date_req = $('#date_req').val();
                // alert(account_code_new);
                $.ajax({
                    url: "{{ route('acc.move_pang_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_code,vn,an,hn,cid,vstdate,account_code_new,ptname,pttype_new,debit_total_new,date_req,comment,dchdate
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'ปรับเปลี่ยนผังสำเร็จ',
                                text: "You Chang data success",
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
    </script>
    @endsection
