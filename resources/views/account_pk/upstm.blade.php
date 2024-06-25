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
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
         
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body shadow-lg"> 
                 
                        <h4 class="card-title">UP STATMENT</h4>
                        <p class="card-title-desc">นำเข้า STM.
                        </p>

                        <div>
                            <form action="{{ route('acc.upstm_save') }}" method="post" class="dropzone" enctype="multipart/form-data">
                                {{-- <form action="{{ route('acc.upstm_save') }}" method="post" class="dropzone" enctype="multipart/form-data" id="dropzone_stm"> --}}
                                @csrf
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple">
                                </div>
                                <div class="dz-message needsclick text-center mt-4">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                    </div>
                                    
                                    <h4 class="text-center">Drop files here or click to upload.</h4>
                                </div>
                            
                        </div>

                        {{-- <div class="text-center mt-4">
                            <button type="button" class="btn btn-outline-info waves-effect waves-light">
                                <i class="fa-solid fa-file-waveform me-2"></i>
                                นำเข้า STM
                            </button>
                        </div> --}}
                    </form>
                       
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    </div>
    {{-- @include("partials/right-sidebar.html")

    @include("partials/vendor-scripts.html") --}}

    @endsection
    @section('footer')
     <!-- Plugins js -->
     <script src="assets/libs/dropzone/min/dropzone.min.js"></script>
     <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
             
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
                                                            // window.location="{{url('warehouse/warehouse_index')}}";
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
              
            $("#spinner-div").hide(); //Request is complete so hide spinner

            // Dropzone.autoDiscover = false;
  
            // var dropzone = new Dropzone('#dropzone_stm', {
            //     thumbnailWidth: 200,
            //     maxFilesize: 1,
            //     acceptedFiles: ".jpeg,.jpg,.png,.gif"
            //     });
    
            });
    </script>
    <script type="text/javascript">
       
        Dropzone.autoDiscover = false;
  
        var dropzone = new Dropzone('#dropzone_stm', {
              thumbnailWidth: 200,
              maxFilesize: 30,
              maxFiles: 20,
              acceptedFiles: ".jpeg,.jpg,.png,.gif,.xls,.pdf,.xlsx"
            });
           
</script>
    @endsection
