@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || ประกันสังคม')
@section('content')
{{-- <script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }    
</script> --}}
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
               border-top: 10px rgb(212, 106, 124) solid;
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
   
   <div class="tabs-animation mb-5">

<div class="row text-center">
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div> 
</div>
 
<div class="row ms-3 me-3">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
              <h4 class="mt-2">  รายการค่าอวัยวะเทียมและอุปกรณ์บำบัด-ปกส.</h4>
                <div class="btn-actions-pane-right"> 
                </div>
            </div>
            <div class="card-body"> 
                <div class="row">
                    <div class="col-md-12">
                          {{-- @if($dataedit->bookrep_file == '' || $dataedit->bookrep_file == null)
                                ไม่มีข้อมูลไฟล์อัปโหลด 
                          @else
                          <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedit->bookrep_file) }}" height="900px" width="100%"></iframe>
                          @endif   --}}
                          <iframe src="{{ asset('storage/instrument/ins_sss.pdf' ) }}" height="900px" width="100%"></iframe>
                    </div>
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

        });
    </script>

@endsection
