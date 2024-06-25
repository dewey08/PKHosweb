@extends('layouts.upstm')
@section('title', 'PK-OFFICER || Stm')
 
@section('content')

 <br> <br> <br> <br> <br>
    <div class="container mt-5">
      {{-- <form action="{{ route('s.import_stm_aipn') }}" method="POST" id="Upstm_aipn" enctype="multipart/form-data"> --}}
        <form action="{{ route('s.import_stm_aipn') }}" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="row">
              <div class="col"></div>          
              
                <div class="col-lg-7 align-self-center">
                  <div class="mb-3">
                    <label for="formFileLg" class="form-label">Import STM AIPN ผู้ป่วยใน(ทีละคน)</label>
                    <input class="form-control form-control-lg" id="formFileLg" name="file_" type="file" required>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </div>
                
                  <button type="submit" class="btn btn-danger"><i class="fa-solid fa-file-import text-white me-2"></i>
                    <label for="" class="text-white">UP STM</label>
                    </button> 
                </div>
                    
              <div class="col mb-4"></div>
          </div>
      </form> 
      <hr class="mt-5">
      <form action="{{ route('s.import_stm_aipnmax') }}" method="POST" enctype="multipart/form-data">
        @csrf

          <div class="row mt-5">
              <div class="col"></div>          
              
                <div class="col-lg-7 align-self-center">
                  <div class="mb-3">
                    <label for="formFileLg" class="form-label">Import STM AIPN ผู้ป่วยใน(มากกว่า 1 คน)</label>
                    <input class="form-control form-control-lg" id="formFileLg" name="file_" type="file" required>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </div>
                
                  <button type="submit" class="btn btn-info"><i class="fa-solid fa-file-import text-white me-2"></i>
                    <label for="" class="text-white">UP STM</label>
                    </button> 
                </div>
                    
              <div class="col"></div>
          </div>
      </form> 
    </div>
   

 
 
     
 
@endsection
@section('footer')

<script>
    $(document).ready(function() {
      $('#Upstm_aipn').on('submit',function(e){
              e.preventDefault();
          
              var form = this;
              // alert('OJJJJOL');
              $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                  $(form).find('span.error-text').text('');
                },
                success:function(data){
                  if (data.status == 0 ) {
                    
                  } else {          
                    Swal.fire({
                      title: 'UP STM สำเร็จ',
                      text: "You UP Statment Success",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177',
                      // cancelButtonColor: '#d33',
                      confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                      if (result.isConfirmed) {      
                        window.location.reload();             
                        // window.location="{{url('building/building_index')}}";
                      }
                    })      
                  }
                }
              });
            });
    });
</script>
@endsection
