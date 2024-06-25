
$(document).ready(function(){
    $('#insert_personForm').on('submit',function(e){
      e.preventDefault();
    //   alert('Person');
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
            Swal.fire({
              icon: 'error',
              title: 'Username...!!',
              text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
            }).then((result) => {
              if (result.isConfirmed) {                  
                // window.location.reload(); 
              }
            })   
          } else {                         
            Swal.fire({
              title: 'บันทึกข้อมูลสำเร็จ',
              text: "You Insert data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177', 
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                window.location="{{route('person.person_index')}}"; //
              }
            })      
          }
        }
      });
    }); 

    $(document).on('click','.edit_type',function(e){
 
      e.preventDefault();        
      var id = $(this).val();     
      // alert(id);
      $('#editexampleModal').modal('show');
      console.log(id);
      // console.log(type);
      $.ajax({
        type:"GET",
        url:"/person/person_index_edittype/"+id,
        success: function(response){
          // console.log(response.data.type);  
          $('#edittype_name').val(response.data.type);
          $('#edittype_id').val(response.data.id);
        }
      })
    });

    $('#update_type').on('submit',function(e){
      e.preventDefault();
      var type = $("#type").val();
      // console.log(unit_name); 
        $.ajax({
        type:"POST",
        url:"/person/person_typeupdate",
        data:$('#update_type').serialize(),
        success:function(response){
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
                  window.location.reload(); 
                }
              })      
        },
        error:function(error){
          console.log(error)
          Swal.fire(
              'บันทึกข้อมูลไม่สำเร็จ!',
              'You clicked the OK!',
              'warning'
            )
        }
      })    
    })

});

$(document).ready(function(){
    $('#update_personForm').on('submit',function(e){
        e.preventDefault();
      alert('Person');
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
                Swal.fire({
                  icon: 'error',
                  title: 'Username...!!',
                  text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
                }).then((result) => {
                  if (result.isConfirmed) {                  
                    // window.location.reload(); 
                  }
                })          
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
                window.location="{{route('person.person_index')}}"; //
                }
            })      
            }
        }
        });
    }); 

});

 

function person_destroy(id)
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
          url:'/person/person_destroy/'+id,
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
                  $("#sid"+id).remove();     
                  window.location.reload(); 
                //   window.location = "/person/person_index"; //     
                }
              }) 
          }
          })        
        }
        })
    }


    function fetchAllEmployees() {
      $.ajax({        
        url:"{{route('person.person_index')}}",
        method: 'get',
        success: function(response) {
          $("#show_all_employees").html(response);
          $("table").DataTable({
            order: [0, 'desc']
          });
        }
      });
    }

  
    function addpic(input) {
      var fileInput = document.getElementById('img');
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
  function editpic(input) {
    var fileInput = document.getElementById('img');
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
     

  