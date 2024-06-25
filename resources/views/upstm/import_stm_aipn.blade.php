@extends('layouts.upstm')
@section('title', 'PK-OFFICER || Stm')
 
@section('content')

 <br> <br> <br> <br> <br>
    <div class="container mt-5">
      <form action="{{ route('s.import_stm_save') }}" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="row">
              <div class="col"></div>          
              
                    <div class="col-lg-7 align-self-center">
                      <div class="mb-3">
                        <label for="formFileLg" class="form-label">Import STM AIPN</label>
                        <input class="form-control form-control-lg" id="formFileLg" name="file_" type="file" required>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </div>
                    
                      <button type="submit" class="btn btn-danger"><i class="fa-solid fa-file-import text-white me-2"></i>
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
       
    });
</script>
@endsection
