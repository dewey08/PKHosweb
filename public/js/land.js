// jQuery(document).ready(function($){
//     //you can now use $ as your jQuery object here
//   });
 //********** Land  ********************//

 $(document).ready(function(){
    $('#insert_landForm').on('submit',function(e){
        e.preventDefault();  
        var form = this; 
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
                title: 'บันทึกข้อมูลสำเร็จ',
                text: "You Insert data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  window.location="/land/land_index"; //
                }
              })      
            }
          }
        });
    });
  
    $('#update_landForm').on('submit',function(e){
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
              title: 'แก้ไขข้อมูลสำเร็จ',
              text: "You edit data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                window.location = "/land/land_index"; // กรณี add page new  
              }
            })      
          }
        }
      });
    });
    
    
  });

  function land_destroy(land_id)
  {
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
        url:'/land/land_destroy/'+land_id,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {          
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
                $("#sid"+land_id).remove();     
                // window.location.reload(); 
                window.location = "/land/land_index"; //     
              }
            }) 
        }
        })        
      }
      })
  }

  function addland(input) {
    var fileInput = document.getElementById('land_img');
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();    
            reader.onload = function (e) {
                $('#add_upload_preview').attr('src', e.target.result);
            }    
            reader.readAsDataURL(input.files[0]);
        }else{    
            alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
            fileInput.value = '';
            return false;
            }
}
function editland(input) {
  var fileInput = document.getElementById('land_img');
  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
          var reader = new FileReader();    
          reader.onload = function (e) {
              $('#edit_upload_preview').attr('src', e.target.result);
          }    
          reader.readAsDataURL(input.files[0]);
      }else{    
          alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
          fileInput.value = '';
          return false;
          }
}

function selectfsn(id){  
  var _token=$('input[name="_token"]').val();
  // alert(prop_id);
       $.ajax({
              // url:"{{route('art.selectfsn')}}",
               url:'/article/selectfsn/',
               method:"GET",
               data:{id:id,_token:_token},
               success:function(result){
                $('.detali_fsn').html(result);
                // $('.article_name').html(result);
               }
       })
       $('#saexampleModal').modal('hide');
}


$(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
});


$('.provice').change(function(){
      if($(this).val()!=''){
      var select=$(this).val();
      var _token=$('input[name="_token"]').val();
      $.ajax({
              // url:"{{route('fect.province_fect')}}",
              url:'/province_fect/',
              method:"GET",
              data:{select:select,_token:_token},
              success:function(result){
                 $('.amphures').html(result);
              }
      })
      }        
});

$('.amphures').change(function(){
      if($(this).val()!=''){
      var select=$(this).val();
      var _token=$('input[name="_token"]').val();
      $.ajax({
              // url:"{{route('fect.district_fect')}}",
              url:'/district_fect/',
              method:"GET",
              data:{select:select,_token:_token},
              success:function(result){
                 $('.tumbon').html(result);
              }
      })
      }        
});

