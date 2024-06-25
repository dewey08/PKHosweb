
$.ajaxSetup({
  headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  }
})


 //**********User Product  ********************//
//  function supplies_dataadd_sub(product_id)
 function supplies_dataadd_sub(id,product_id)
 {
        // alert(id);
        Swal.fire({
        title: 'ต้องการเพิ่ม',
        //  text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ยกเลิก'
        }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        //  url:'/user/supplies_data_add_subsave/'+ product_id,
        url:'/user/supplies_data_add_subsave/'+id +'/'+ product_id,
        type:'POST',
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
                $("#sid"+product_id).remove();     
                // window.location.reload(); 
                //  window.location = "/user/supplies_data_add_sub/"+ product_id; //  
                window.location = "/user/supplies_data_add_sub/"+id +'/'+ product_id; //    
              }
            }) 
        }
        })        
      }
      })
 }
 $(document).ready(function(){
    $('#insert_usersuppliesForm').on('submit',function(e){
      e.preventDefault();
      var id = $("#user_id").val();
      var form = this;
      // alert(id);
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
              title: 'ต่อไป เพิ่มรายการวัสดุที่ต้องการขอซื้อ-ขอจ้าง',
              text: "Next Step",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'ต่อไป'
            }).then((result) => {
              if (result.isConfirmed) {  
                // alert(id);                
                window.location="/user/supplies_data_add/" + id; //
              }
            })      
          }
        }
      });
    });
  
    $('#update_usersuppliesForm').on('submit',function(e){
      e.preventDefault();
      var id = $("#user_id").val();
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
                window.location="/user/supplies_data_add/" + id; //
              }
            })      
          }
        }
      });
    });

    $('#insert_addsubsupplies').on('submit',function(e){
      e.preventDefault();
      var id = $("#user_id").val();
      var form = this;
      alert(id);
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
              title: 'ต่อไป ',
              text: "Next Step",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'ต่อไป'
            }).then((result) => {
              if (result.isConfirmed) {  
                // alert(id);                
                window.location="/user/supplies_data_add/" + id; //
              }
            })      
          }
        }
      });
    });

   
  });

  //********** แก้ไข ดึงข้อมูลขึ้นโชว์ Modal เพื่อทำการ Update ********************//
  $(document).on('click','.edit_suprep',function(e){
    e.preventDefault();        
        let request_id = $(this).data('request_id');
        let request_code = $(this).data('request_code');
        let request_year = $(this).data('request_year');
        let request_date = $(this).data('request_date');
        let request_debsubsub_name = $(this).data('request_debsubsub_name');
        let request_user_name = $(this).data('request_user_name');
        let user_id = $(this).data('user_id');
        let request_because = $(this).data('request_because');
        let request_hn_id = $(this).data('request_hn_id');
        let request_hn_name = $(this).data('request_hn_name'); 
        $('#up_request_id').val(request_id);
        $('#up_request_code').val(request_code);
        $('#request_year3').val(request_year);
        $('#up_request_date').val(request_date);
        $('#up_request_debsubsub_name').val(request_debsubsub_name);
        $('#up_request_user_name').val(request_user_name);
        $('#up_user_id').val(user_id);
        $('#up_request_because').val(request_because);
        $('#up_request_hn_id').val(request_hn_id);
        $('#request_hn_name').val(request_hn_name);
        console.log(request_id); 
        // console.log(request_code); 
        console.log(request_year); 
        console.log(request_date); 
        console.log(request_debsubsub_name);
    // $.ajax({
    //   type:"GET",
    //   url:"/user/supplies_data_edit/"+id + request_id,
    //   success: function(response){
        
    //     console.log(response.data.request_code);       
    //     $('#request_code').val(response.data.request_code);
        // $('#memlname').val(response.data.lname);
        // $('#mememail').val(response.data.email);
        // $('#memtel').val(response.data.tel);
        // $('#memusername').val(response.data.username);
        // $('#img').val(response.data.img);
        // $('#memtype').val(response.data.type);               
      //   $('#request_id').val(response.data.request_id);       
      //   $('#user_id').val(response.data.id);
      // }
    // })
  });

  $('#update_upplies_repForm').on('submit',function(e){
    e.preventDefault();
    var id = $("#user_id").val();
    var up_request_id = $("#up_request_id").val();
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
              window.location="/user/supplies_data_add/" + id; //
            }
          })      
        }
      }
    });
  });

function supplies_destroy(product_id)
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
          url:'/supplies/supplies_destroy/'+product_id,
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
                  $("#sid"+product_id).remove();     
                  // window.location.reload(); 
                  window.location = "/supplies/supplies_index"; //     
                }
              }) 
          }
          })        
        }
        })
}

function repsupplies_destroy(request_id)
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
          url:'/user/supplies_data_add_destroy/'+request_id,
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
                  $("#sid"+request_id).remove();     
                  window.location.reload(); 
                  // window.location = "/supplies/supplies_index"; //     
                }
              }) 
          }
          })        
        }
    })
}
function repsubsupplies_destroy(request_sub_id)
// alert(request_id);   
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
          url:'/user/supplies_data_add_subdestroy/'+ request_sub_id,
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
                  $("#sid"+request_sub_id).remove();     
                  window.location.reload(); 
                  // window.location = "/supplies/supplies_index"; //     
                }
              }) 
          }
          })        
        }
    })
}
function addproducts(input) {
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
function editproducts(input) {
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